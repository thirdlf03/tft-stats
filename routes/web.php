<?php

use App\Http\Controllers\BookmarkContentController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

if (env('APP_ENV') == 'production') {
    \Illuminate\Support\Facades\URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'results'], function () {
        Route::get('/', [ResultController::class, 'index'])->name('results.index');
        Route::post('/', [ResultController::class, 'store'])->name('results.store');
        Route::post('/history', [ResultController::class, 'api'])->name('results.api');
        Route::patch('/{userid}', [ResultController::class, 'update'])->name('results.update');
    });

    Route::resource('posts', PostController::class);

    Route::resource('bookmarks', BookmarkController::class);
    Route::get('/bookmarks/{bookmarkid}/content', [BookmarkContentController::class, 'index'])->name('bookmarkcontents.index');
    Route::post('/bookmarks/{bookmarkid}/content', [BookmarkContentController::class, 'store'])->name('bookmarkcontents.store');
    Route::delete('/bookmarks/{bookmarkid}/content', [BookmarkContentController::class, 'destroy'])->name('bookmarkcontents.destroy');

});

require __DIR__.'/auth.php';
