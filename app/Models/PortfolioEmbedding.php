<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioEmbedding extends Model
{
    protected $fillable = [
        'symbol',
        'quantity',
        'traded_at',
        'price',
        'transaction_type',
        'content',
        'embedding',
    ];

    protected function casts(): array
    {
        return [
            'traded_at' => 'datetime',
            'quantity' => 'integer',
            'price' => 'decimal:4',
            'embedding' => 'array',
        ];
    }
}
