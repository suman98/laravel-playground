<?php

use Illuminate\Support\Facades\Route;
use App\Packages\AnotherTest\Controllers\AnotherTestController;

Route::prefix('anothertest')->group(function () {
    Route::get('/', [AnotherTestController::class, 'index']);
});
