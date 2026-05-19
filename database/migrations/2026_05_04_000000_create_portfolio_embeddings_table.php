<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Vector similarity search requires PostgreSQL with the pgvector extension.
     * Embedding dimensions must match your embeddings provider (Gemini default: 3072).
     *
     * @see https://laravel.com/docs/ai-sdk#querying-embeddings
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'pgsql') {
            return;
        }

        Schema::ensureVectorExtensionExists();

        Schema::create('portfolio_embeddings', function (Blueprint $table) {
            $table->id();
            $table->string('symbol', 32);
            $table->unsignedInteger('quantity');
            $table->timestampTz('traded_at')->nullable();
            $table->decimal('price', 14, 4);
            $table->string('transaction_type', 32);
            $table->text('content');
            $table->vector('embedding', dimensions: 1536)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'pgsql') {
            return;
        }

        Schema::dropIfExists('portfolio_embeddings');
    }
};
