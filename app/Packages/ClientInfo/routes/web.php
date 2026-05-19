<?php

use Illuminate\Support\Facades\Route;
use App\Packages\ClientInfo\Controllers\ClientInfoController;

Route::prefix('clientinfo')->group(function () {
    Route::get('/', [ClientInfoController::class, 'index']);
});
