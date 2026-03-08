<?php

namespace App\Packages\SamplePackage\Models;

use Illuminate\Database\Eloquent\Model;

class SampleModel extends Model
{
    protected $table = 'sample_models';
    protected $fillable = ['name'];
}
