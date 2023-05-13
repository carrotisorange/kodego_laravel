<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Blog;
use App\Models\User;

class UserBlogCommentController extends Controller
{
    // As a user, I want to comment on a blog, so that I can express my opinion or support.

    public function store_comment(Request $request, User $user, Blog $blog){

        $validated = $request->validate([
            'comments' => 'required|min:1' 
        ]);

        $validated['user_id'] = $user->id;
        $validated['blog_id'] = $blog->id;

        $comment =  Comment::create($validated);

        return 'inserted id '. $comment->id;

    }

    // As a user, I want to reply to a comment posted on a blog, so that I can share my opinion.
    public function store_comment_with_comment_id(Request $request, User $user, Blog $blog, Comment $comment){
        $validated = $request->validate([
            'comments' => 'required|min:1' 
        ]);

        $validated['user_id'] = $user->id;
        $validated['blog_id'] = $blog->id;
        $validated['comment_id'] = $comment->id;

        $comment =  Comment::create($validated);

        return 'inserted id '. $comment->id;

    }
    // As a user, I want to delete a comment I posted, so that I can undo my action.
    // As a user, I want to delete a comment posted on my blog, so that I can get rid of unecessary comments.
    public function destroy(User $user, Blog $blog, Comment $comment){
        
        //delete a particular user from the users table
         $blog_user_id = $blog->user->id;
         $comment_user_id = $comment->user->id;

         if($user->id == $blog_user_id || $user->id == $comment_user_id){
            if(Comment::find($comment->id)){
              return Comment::where('id', $comment->id)
              ->delete();
            }

            return 'Not found!';
         }
      
    }
    // As a user, I want to edit a comment I posted, so that I can improve my thoughts.
    public function edit(){

    }

    public function update(Request $request, User $user, Blog $blog, Comment $comment){

        $validated = $request->validate([
           'comments' => 'required|min:1'
         ]);
           
        $blog_user_id = $blog->user->id;

         if($user->id == $blog_user_id){
            if(Comment::find($comment->id)){
              return Comment::where('id', $comment->id)
              ->update($validated);

              return 'success!';
            }

            return 'Not found!';
         }
    }

    public function index(User $user, Blog $blog){
        return Blog::find($blog->id)->comments()->withTrashed()->count();
    }
  

  
}
