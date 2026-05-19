<?php

namespace App\Console\Commands;

use App\Models\PortfolioEmbedding;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Laravel\Ai\Embeddings;

class EmbedPortfolio extends Command
{
    protected $signature = 'ai:embed-portfolio
                            {--path=storage/test/portfolio.csv : CSV path relative to the project base path}
                            {--fresh : Delete existing portfolio embedding rows before importing}';

    protected $description = 'Chunk portfolio CSV rows, generate embeddings, and store them for similarity search (PostgreSQL + pgvector required)';

    public function handle(): int
    {
        if (DB::getDriverName() !== 'pgsql') {
            $this->error('Portfolio vector search requires PostgreSQL with pgvector. Set DB_CONNECTION=pgsql in .env and run migrations.');

            return self::FAILURE;
        }

        if (! Schema::hasTable('portfolio_embeddings')) {
            $this->error('Table portfolio_embeddings is missing. Run: php artisan migrate');

            return self::FAILURE;
        }

        $fullPath = base_path($this->option('path'));

        if (! File::isFile($fullPath)) {
            $this->error("File not found: {$fullPath}");

            return self::FAILURE;
        }

        $handle = fopen($fullPath, 'r');
        if ($handle === false) {
            $this->error('Could not open CSV file.');

            return self::FAILURE;
        }

        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            $this->error('CSV is empty.');

            return self::FAILURE;
        }

        $rows = [];
        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) < 5) {
                continue;
            }
            $rows[] = [
                'symbol'   => trim($data[0], " \t\n\r\0\x0B\""),
                'quantity' => (int) $data[1],
                'date'     => trim($data[2], '"'),
                'price'    => (float) $data[3],
                'type'     => trim($data[4], " \t\n\r\0\x0B\""),
            ];
        }
        fclose($handle);

        if ($this->option('fresh')) {
            PortfolioEmbedding::query()->delete();
            $this->info('Cleared existing portfolio_embeddings rows.');
        }

        $total = count($rows);
        $this->info("Embedding {$total} portfolio lines…");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($rows as $index => $row) {
            $priceLabel = fmod($row['price'], 1.0) === 0.0
                ? (string) (int) $row['price']
                : (string) $row['price'];

            $content = sprintf(
                'Nepal stock portfolio holding: %s — %d units at NPR %s per unit, trade date %s, transaction type %s (NEPSE).',
                $row['symbol'],
                $row['quantity'],
                $priceLabel,
                $row['date'],
                $row['type'],
            );

            try {
                $response = Embeddings::for([$content])->generate();

                // ✅ Debug: Check response structure
                if (empty($response->embeddings) || empty($response->embeddings[0])) {
                    $this->error("\n[Row {$index}] Empty embedding response: " . json_encode($response->embeddings));
                    $bar->advance();
                    continue;
                }

                $embedding = $response->embeddings[0];

                // ✅ Debug: Check if embedding is iterable
                if (!is_array($embedding) && !is_iterable($embedding)) {
                    $this->error("\n[Row {$index}] Embedding is not iterable: " . gettype($embedding));
                    $bar->advance();
                    continue;
                }

                $embeddingArray = is_array($embedding) ? $embedding : iterator_to_array($embedding);

                if (empty($embeddingArray)) {
                    $this->error("\n[Row {$index}] Embedding array is empty");
                    $bar->advance();
                    continue;
                }

                $embeddingVector = $this->arrayToVector($embeddingArray);

                $parsed = strtotime($row['date']);

                PortfolioEmbedding::create([
                    'symbol'           => $row['symbol'],
                    'quantity'         => $row['quantity'],
                    'traded_at'        => $parsed ? date('Y-m-d H:i:s', $parsed) : null,
                    'price'            => $row['price'],
                    'transaction_type' => $row['type'],
                    'content'          => $content,
                    'embedding'        => DB::raw("'{$embeddingVector}'::vector"),
                ]);

            } catch (\Exception $e) {
                $this->error("\n[Row {$index}] Error: {$e->getMessage()}");
            }

            $bar->advance();
            usleep(200000);
        }

        $bar->finish();
        $this->newLine();

        $this->info('Done. Run `php artisan ai:play` to chat with your portfolio (agent uses similarity search on embeddings).');

        return self::SUCCESS;
    }

    /**
     * Convert PHP array to PostgreSQL vector format.
     * Example: [0.123, -0.456] becomes "[0.123,-0.456]"
     */
    private function arrayToVector(array $embedding): string
    {
        return '[' . implode(',', array_map(fn ($val) => (float) $val, $embedding)) . ']';
    }
}
