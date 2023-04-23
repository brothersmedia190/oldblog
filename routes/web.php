<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FavoriteController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\TagController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\fPostController;
use App\Http\Controllers\fAuthorController;
use App\Http\Controllers\fFavoriteController;
use App\Http\Controllers\fSubscriberController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\fCommentController;


Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('posts', [fPostController::class, 'index'])->name('post.index');
Route::get('post/{slug}', [fPostController::class, 'details'])->name('post.details');
Route::get('/category/{slug}', [fPostController::class, 'postByCategory'])->name('category.posts');
Route::get('/tag/{slug}', [fPostController::class, 'postByTag'])->name('tag.posts');
Route::get('profile/{username}', [fAuthorController::class, 'profile'])->name('author.profile');
Route::post('subscriber', [fSubscriberController::class, 'store'])->name('subscriber.store');
Route::post('/search', [SearchController::class, 'search'])->name('search');
 
 
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware'=>['auth']], function (){
    Route::post('favorite/{post}/add', [fFavoriteController::class, 'add'])->name('post.favorite');
    Route::post('comment/{post}', [fCommentController::class, 'store'])->name('comment.store');
  });


Route::group(['as'=>'admin.','prefix'=>'admin' ,'middleware'=>['auth']], function (){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('profile-update', [SettingsController::class, 'updateProfile'])->name('profile.update');
    Route::put('password-update', [SettingsController::class, 'updatePassword'])->name('password.update');
    Route::resource('tag', TagController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('post', PostController::class);
    Route::get('/pending/post', [PostController::class, 'pending'])->name('post.pending');
    Route::put('/post/{id}/approve', [PostController::class, 'approval'])->name('post.approve');
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::get('authors', [AuthorController::class, 'index'])->name('author.index');
    Route::delete('authors/{id}', [AuthorController::class, 'destroy'])->name('author.destroy');
    Route::get('comments', [CommentController::class, 'index'])->name('comment.index');
    Route::delete('comments/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::get('/subscriber', [SubscriberController::class, 'index'])->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscriber.destroy');
});

View::composer('layouts.frontend.partial.footer',function ($view) {
    $categories = App\Models\Category::all();
    $view->with('categories',$categories);
});