<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnknownWord extends Model
{
    protected $fillable = ['word', 'meaning', 'sentence', 'np_word', 'enabled', 'is_familiar'];

    protected $casts = ['enabled' => 'boolean', 'is_familiar' => 'boolean'];
}
