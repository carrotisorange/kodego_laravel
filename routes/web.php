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

Route::controller(BlogController::class)->group(function () {
    Route::get('/blogs', 'index')->name('dashboard');
});

require __DIR__.'/auth.php';

//routes for the blog
require __DIR__.'/userblogcomment.php';

//routes for the user 
Route::controller(UserController::class)->group(function () {

   Route::get('/user/{user:email}/edit', 'edit');

   Route::put('/user/{user}/update', 'update');
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
    Route::delete('/user/{user}/blog/{blog}/delete', 'destroy');
});

//routes for the blog
Route::middleware(['auth', 'verified'])->controller(UserBlogLikeController::class)->group(function () {
    //store method
    Route::post('/user/{user}/blog/{blog}/like/store', 'store');

    //update method 
    Route::put('/user/{user}/blog/{blog}/like/{like_id}/update', 'update');

    //index method
    Route::get('/user/{user_id}/blog/{blog_id}/likes', 'index')->whereNumber(['blog_id', 'user_id']);
});



