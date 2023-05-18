<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\UserBlogController;
use App\Http\Controllers\UserBlogLikeController;
use App\Models\Blog;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->controller(BlogController::class)->group(function () {
    Route::get('/blogs', 'index')->name('dashboard');
});

require __DIR__.'/auth.php';

//routes for the blog
require __DIR__.'/userblogcomment.php';

//routes for the user 
Route::controller(UserController::class)->group(function () {
  
   Route::get('/users', 'index');

   Route::get('/users/create', 'create');

   Route::post('/users/store', 'store');

   Route::get('/users/{email}', 'show');

   Route::get('/users/{id}/edit', 'edit')->whereNumber('id');

   Route::put('/users/{id}/update', 'update')->whereNumber('id');

   Route::delete('/users/{id}/delete', 'destroy')->whereNumber('id');
});

//routes for the user blog
Route::middleware(['auth', 'verified'])->scopeBindings()->controller(UserBlogController::class)->group(function () {
    Route::get('/user/{user}/blogs', 'index');
    //store method
    Route::post('/user/{user}/blog/store', 'store');
    //edit method
    Route::put('/user/{user}/blog/{blog}/update', 'update');
    //index method
    Route::get('/user/{user_id}/blogs', 'index')->whereNumber('id');
    //show method
    Route::get('/user/{user}/blog/{blog}', 'show');
    //edit method
    Route::get('/user/{user}/blog/{blog}/edit', 'edit');
    //create method
    Route::get('/user/{user}/blog-create', 'create');

    //destroy method
    Route::delete('/user/{user_id}/blog/{blog_id}/delete', 'destroy')->whereNumber(['blog_id', 'user_id']);
});

//routes for the blog
Route::middleware(['auth', 'verified'])->controller(UserBlogLikeController::class)->group(function () {
    //store method
    Route::post('/user/{user_id}/blog/{blog_id}/like/store', 'store')->whereNumber(['user_id', 'blog_id']);

    //update method 
    Route::put('/user/{user_id}/blog/{blog_id}/like/{like_id}/update', 'update')->whereNumber(['blog_id', 'user_id', 'like_id']);

    //index method
    Route::get('/user/{user_id}/blog/{blog_id}/likes', 'index')->whereNumber(['blog_id', 'user_id']);
});



