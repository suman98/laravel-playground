<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OllamaController extends Controller
{
    private $ollamaUrl = 'http://localhost:11434';

    /**
     * Generate completion from Ollama
     */
    public function generate(Request $request)
    {
      
        $request->validate([
            'prompt' => 'required|string',
            'model' => 'string',
            'stream' => 'boolean'
        ]);

        $model = $request->input('model', 'gemini-3-flash-preview:latest');
        $prompt = $request->input('prompt');
        $stream = $request->input('stream', false);

        try {
            $response = Http::timeout(120)->post("{$this->ollamaUrl}/api/generate", [
                'model' => $model,
                'prompt' => $prompt,
                'stream' => $stream
            ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Chat completion (for conversational models)
     */
    public function chat(Request $request)
    {
      
        $request->validate([
            'messages' => 'required|array',
            'model' => 'string'
        ]);

        $model = $request->input('model', 'gemini-3-flash-preview:latest');
        $messages = $request->input('messages');

        try {
            // Ensure each message contains 'role' and 'content'
            $formattedMessages = collect($messages)->map(function ($message) {
                return [
                    'role' => $message['role'] ?? 'user',
                    'content' => $message,
                ];
            })->toArray();

            $response = Http::timeout(120)->post("{$this->ollamaUrl}/api/chat", [
                'model' => $model,
                'messages' => $formattedMessages,
                'stream' => false
            ]);
          
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List available models
     */
    public function models()
    {
        try {
            $response = Http::get("{$this->ollamaUrl}/api/tags");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Stream response (Server-Sent Events)
     */
    public function generateStream(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
            'model' => 'string'
        ]);

        $model = $request->input('model', 'codellama');
        $prompt = $request->input('prompt');

        return response()->stream(function () use ($model, $prompt) {
            $ch = curl_init("{$this->ollamaUrl}/api/generate");
            
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode([
                    'model' => $model,
                    'prompt' => $prompt,
                    'stream' => true
                ]),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_WRITEFUNCTION => function($curl, $data) {
                    echo "data: " . $data . "\n\n";
                    ob_flush();
                    flush();
                    return strlen($data);
                }
            ]);

            curl_exec($ch);
            curl_close($ch);
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no'
        ]);
    }
}
