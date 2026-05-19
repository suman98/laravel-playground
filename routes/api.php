<?php

use App\Http\Controllers\UnknownWordController;
use Illuminate\Support\Facades\Route;

Route::get('/unknown_words', [UnknownWordController::class, 'index']);
Route::get('/unknown_words/random', [UnknownWordController::class, 'random'])
    ->middleware(\App\Http\Middleware\Cors::class);
Route::post('/save_unknown_words', [UnknownWordController::class, 'store']);
Route::get('/unknown_words/{unknownWord}', [UnknownWordController::class, 'show']);
Route::put('/unknown_words/{unknownWord}', [UnknownWordController::class, 'update']);
Route::delete('/unknown_words/{unknownWord}', [UnknownWordController::class, 'destroy']);
