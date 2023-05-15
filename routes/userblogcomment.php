<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserBlogCommentController;

Route::scopeBindings()->controller(UserBlogCommentController::class)->group(function () {
    //store comment method
    Route::post('/user/{user}/blog/{blog}/comment/store', 'store_comment');
    //store comment with comment id
    Route::post('/user/{user}/blog/{blog}/comment/{comment}/store', 'store_comment_with_comment_id');

    //delete a comment
    Route::delete('/user/{user}/blog/{blog}/comment/{comment}/delete', 'destroy');
    //index method
    Route::get('/user/{user}/blog/{blog}/comments', 'index');

    //update a comment
    Route::put('/user/{user}/blog/{blog}/comment/{comment}/update', 'update');
});