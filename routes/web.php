<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OllamaController;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('ollama')->group(function () {
    Route::post('/generate', [OllamaController::class, 'generate']);
    Route::post('/chat', [OllamaController::class, 'chat']);
    Route::get('/models', [OllamaController::class, 'models']);
    Route::post('/generate-stream', [OllamaController::class, 'generateStream']);
});
