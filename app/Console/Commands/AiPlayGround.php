<?php

namespace App\Console\Commands;

use App\Ai\Agents\SalesCoach;
use App\Models\User;
use Illuminate\Console\Command;

class AiPlayGround extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactive AI playground with persisted conversation history';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = User::firstOrCreate(
            ['email' => 'ai-playground@localhost'],
            ['name' => 'AI Playground', 'password' => bcrypt(str()->random(32))]
        );

        $conversationId = null;

        $this->comment('Chatting as '.$user->email.'. Type exit or quit to leave.');

        while (true) {
            $question = $this->ask('>');

            if ($question === null) {
                break;
            }

            $trimmed = trim($question);

            if ($trimmed === '') {
                continue;
            }

            if (in_array(strtolower($trimmed), ['exit', 'quit', 'q'], true)) {
                break;
            }

            if ($conversationId === null) {
                $response = (new SalesCoach)->forUser($user)->prompt($trimmed);
                $conversationId = $response->conversationId;
            } else {
                $response = (new SalesCoach)
                    ->continue($conversationId, as: $user)
                    ->prompt($trimmed);
            }

            $this->info($response->text);
        }

        return self::SUCCESS;
    }
}
