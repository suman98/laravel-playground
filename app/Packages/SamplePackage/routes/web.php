<?php

use Illuminate\Support\Facades\Route;
use App\Packages\SamplePackage\Controllers\SampleController;

Route::prefix('sample')->group(function () {
    Route::get('/', [SampleController::class, 'index']);
});

