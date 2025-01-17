<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/search-products', [ProductSearchController::class, 'search'])->name('search.products');
Route::get('/product/{shopId}/{productId}', [ProductController::class, 'show'])->name('product.show');

// Authentication required routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');
    
    // Profile routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Admin only routes
    Route::middleware(['can:manage,App\Models\Product'])->group(function () {
        Route::resource('products', ProductController::class)->except(['index', 'show']);
    });

    // Product routes
    Route::resource('products', ProductController::class);

    // Budget & Transaction routes
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::put('/budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
    Route::delete('/budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');

    // Feedback routes
    Route::get('feedback', [FeedbackController::class, 'index'])
        ->middleware('can:viewFeedback,App\Models\User')
        ->name('feedback.index');
        
    // Posts routes with authorization
    Route::resource('posts', PostController::class);

    // Forum routes
    Route::controller(PostController::class)->group(function () {
        Route::get('/forum', 'index')->name('forum');
    });
    Route::resource('threads', ThreadController::class)->only(['store', 'update', 'destroy']);

    // Feedback routes
    Route::controller(FeedbackController::class)->group(function () {
        Route::get('/about', 'index')->name('about');
        Route::post('/feedback', 'store')->name('feedback.store');
        Route::put('/feedback/{feedback}', 'update')->name('feedback.update');
        Route::delete('/feedback/{feedback}', 'destroy')->name('feedback.destroy');
    });

    // Wishlist routes
    Route::controller(WishlistController::class)->group(function () {
        Route::post('/wishlist', 'store')->name('wishlist.store');
        Route::put('/wishlist/{wishlist}', 'update')->name('wishlist.update');
        Route::patch('/wishlist/{wishlist}/toggle', 'toggleComplete')->name('wishlist.toggle');
        Route::delete('/wishlist/{wishlist}', 'destroy')->name('wishlist.destroy');
    });

    // Admin news routes
    Route::middleware(['can:create,App\Models\News'])->group(function () {
        Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/news', [NewsController::class, 'store'])->name('news.store');
        Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    });

    // Chat routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/messages/{user}', [ChatController::class, 'getMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    
    // New routes for edit and delete
    Route::put('/chat/messages/{message}', [ChatController::class, 'updateMessage'])->name('chat.update');
    Route::delete('/chat/messages/{message}', [ChatController::class, 'deleteMessage'])->name('chat.delete');

    Route::get('/feedback/export', [FeedbackController::class, 'export'])->name('feedback.export');

    Route::post('/notifications/{notification}/mark-as-read', function ($notification) {
        auth()->user()->notifications()->findOrFail($notification)->markAsRead();
        return back();
    })->name('notifications.mark-as-read');
});

// Public news routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

require __DIR__.'/auth.php';
