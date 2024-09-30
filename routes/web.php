<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'results'], function() {
    Route::get('/', [ResultController::class, 'index'])->name('result.index');
    Route::post('/', [ResultController::class, 'store'])->name('result.store');
    Route::get('/history', [ResultController::class, 'api'])->name('result.api');
    Route::patch('/{userid}', [ResultController::class, 'update'])->name('result.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/follow/{user}', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');

    Route::resource('posts', PostController::class);
    Route::group(['prefix'=> 'posts/{postid}'], function() {
        Route::resource('comments', CommentController::class);
    });

    Route::resource('bookmarks', PostController::class);
    Route::group(['prefix'=>'bookmarks/{bookmarkid}'], function() {
        Route::resource('bookmarkcontents', BookmarkContentsController::class);
    });
});


require __DIR__.'/auth.php';
