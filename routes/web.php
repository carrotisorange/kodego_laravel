<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserBlogController;
use App\Http\Controllers\UserBlogLikeController;

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

Route::get('/', function () {
    return view('welcome');
});

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
Route::controller(UserBlogController::class)->group(function () {
    //store method
    Route::post('/user/{id}/blog/store', 'store')->whereNumber('id');
    //edit method
    Route::put('/user/{user_id}/blog/{blog_id}/update', 'update')->whereNumber(['blog_id', 'user_id']);
    //index method
    Route::get('/user/{user_id}/blogs', 'index')->whereNumber('id');
    //destroy method
    Route::delete('/user/{user_id}/blog/{blog_id}/delete', 'destroy')->whereNumber(['blog_id', 'user_id']);
});

//routes for the blog
Route::controller(UserBlogLikeController::class)->group(function () {
    //store method
    Route::post('/user/{user_id}/blog/{blog_id}/like/store', 'store')->whereNumber(['user_id', 'blog_id']);

    //update method 
    Route::put('/user/{user_id}/blog/{blog_id}/like/{like_id}/update', 'update')->whereNumber(['blog_id', 'user_id', 'like_id']);

    //index method
    Route::get('/user/{user_id}/blog/{blog_id}/likes', 'index')->whereNumber(['blog_id', 'user_id']);
});

//routes for the like
Route::controller(LikeController::class)->group(function () {
    //store method


    //
});

//routes for the comment
Route::controller(CommentController::class)->group(function () {
    //routes here
});