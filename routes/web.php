<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/unknown-words', [\App\Http\Controllers\UnknownWordController::class, 'managePage'])->name('unknown-words');

Route::get('/vocab-wallpaper', [\App\Http\Controllers\UnknownWordController::class, 'wallpaper'])->name('vocab-wallpaper');
Route::get('/unknown-words/all', [\App\Http\Controllers\UnknownWordController::class, 'all'])->name('unknown-words.all');

Route::get('/vocab/slides', [\App\Http\Controllers\UnknownWordController::class, 'slides'])->name('vocab.slides');

require __DIR__.'/packages.php';

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});