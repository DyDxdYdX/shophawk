<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/forum', function () {
    return view('forum');
})->name('forum');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/search-products', [ProductSearchController::class, 'search'])->name('search.products');

Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/product/{shopId}/{productId}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/forum', [PostController::class, 'index'])->name('forum');
    Route::resource('posts', PostController::class);
    Route::post('/posts/{post}/vote', [PostController::class, 'vote'])->name('posts.vote');
});

Route::middleware('auth')->group(function () {
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');
});

require __DIR__.'/auth.php';
