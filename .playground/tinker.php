<?php

use App\Ai\Agents\SalesCoach;
use Laravel\Ai\Audio;

$audio = Audio::of('I love coding with Laravel.')->generate();
dd($audio);

$response = (new SalesCoach)
    ->model('')
    ->prompt('Analyze this sales transcript...');

dd($response);
