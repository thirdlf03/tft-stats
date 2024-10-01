<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\BookmarkContentController;

use Illuminate\Support\Facades\Route;

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

    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');

    Route::group(['prefix' => 'results'], function() {
        Route::get('/', [ResultController::class, 'index'])->name('results.index');
        Route::post('/', [ResultController::class, 'store'])->name('results.store');
        Route::get('/history', [ResultController::class, 'api'])->name('results.api');
        Route::patch('/{userid}', [ResultController::class, 'update'])->name('results.update');
    });

    Route::resource('posts', PostController::class);
    Route::group(['prefix'=> 'posts/{postid}'], function() {
        Route::resource('comments', CommentController::class);
    });

    Route::resource('bookmarks', BookmarkController::class);
    Route::post('/bookmarks/{bookmarkid}/content', [BookmarkContentController::class, 'store'])->name('bookmarkcontents.store');
    Route::delete('/bookmarks/{bookmarkid}/content', [BookmarkContentController::class, 'destroy'])->name('bookmarkcontents.destroy');

});


require __DIR__.'/auth.php';
