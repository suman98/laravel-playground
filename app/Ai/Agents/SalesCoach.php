<?php

namespace App\Ai\Agents;

use App\Models\PortfolioEmbedding;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Ai\Attributes\MaxSteps;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Promptable;
use Laravel\Ai\Tools\SimilaritySearch;
use Stringable;

#[MaxSteps(8)]
class SalesCoach implements Agent, Conversational, HasTools
{
    use Promptable;
    use RemembersConversations;

    public function instructions(): Stringable|string
    {
        if ($this->portfolioEmbeddingReady()) {
            return <<<'TXT'
You are a helpful assistant for Nepal's stock market (NEPSE) and the user's personal portfolio.

When the user asks about their holdings, trades, symbols, quantities, prices, or dates, use the portfolio similarity search tool first to retrieve relevant rows from their embedded portfolio data, then answer from those facts. If the tool returns no rows, say you could not find matching trades in the portfolio store.

You may also share general NEPSE context, but never invent specific portfolio numbers—only cite what appears in the tool results or the ongoing conversation.
TXT;
        }

        return <<<'TXT'
You are a helpful assistant for Nepal's stock market (NEPSE).

Portfolio-specific vector search is not available (needs PostgreSQL with pgvector, migrations, and `php artisan ai:embed-portfolio`). Discuss NEPSE generally and explain that you cannot look up their CSV-backed holdings until embeddings are configured.
TXT;
    }

    /**
     * @return \Laravel\Ai\Contracts\Tool[]
     */
    public function tools(): iterable
    {
        if (! $this->portfolioEmbeddingReady()) {
            return [];
        }

        return [
            SimilaritySearch::usingModel(
                model: PortfolioEmbedding::class,
                column: 'embedding',
                minSimilarity: 0.35,
                limit: 25,
            )->withDescription(
                'Search the user\'s embedded Nepal stock portfolio (CSV-derived holdings and trades). Use for questions about symbols, quantities, prices, dates, or transaction types.',
            ),
        ];
    }

    protected function portfolioEmbeddingReady(): bool
    {
        if (DB::getDriverName() !== 'pgsql') {
            return false;
        }

        if (! Schema::hasTable('portfolio_embeddings')) {
            return false;
        }

        return PortfolioEmbedding::query()->exists();
    }
}
