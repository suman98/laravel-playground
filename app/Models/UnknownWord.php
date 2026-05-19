<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnknownWord extends Model
{
    protected $fillable = ['word', 'meaning', 'sentence', 'np_word'];
}
