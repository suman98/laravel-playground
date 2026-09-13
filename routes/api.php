<?php

use App\Http\Controllers\ContactSubmissionController;
use App\Http\Controllers\UnknownWordController;
use Illuminate\Support\Facades\Route;

Route::post('/contact-submissions', [ContactSubmissionController::class, 'store'])
    ->middleware('throttle:60,1');

Route::get('/unknown_words', [UnknownWordController::class, 'index']);
Route::get('/unknown_words/random', [UnknownWordController::class, 'random'])
    ->middleware(\App\Http\Middleware\Cors::class);
Route::post('/save_unknown_words', [UnknownWordController::class, 'store']);
Route::post('/unknown_words/import', [UnknownWordController::class, 'import']);
Route::get('/unknown_words/{unknownWord}', [UnknownWordController::class, 'show']);
Route::put('/unknown_words/{unknownWord}', [UnknownWordController::class, 'update']);
Route::delete('/unknown_words/{unknownWord}', [UnknownWordController::class, 'destroy']);
Route::patch('/unknown_words/{unknownWord}/toggle', [UnknownWordController::class, 'toggle']);
Route::patch('/unknown-words/reset-familiar', [UnknownWordController::class, 'resetFamiliar']);
Route::patch('/unknown-words/familiar', [UnknownWordController::class, 'markFamiliar']);
Route::patch('/unknown-words/unfamiliar', [UnknownWordController::class, 'markUnfamiliar']);
