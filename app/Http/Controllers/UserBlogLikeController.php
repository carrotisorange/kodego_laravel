<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Blog;
use App\Models\User;

class UserBlogLikeController extends Controller
{
    public function store(User $user, Blog $blog){
       
        $blog_user_id = Blog::find($blog->id)->user->id;

        if($user->id != $blog_user_id){
            Like::updateOrCreate(
                [   
                    'user_id' => $user->id,
                    'blog_id' => $blog->id
                ],
                [
                    'user_id' => $user->id,
                    'blog_id' => $blog->id,
                ]
            );

        }else{
            return abort(403);
        }

        return back()->with('success', 'You liked this blog!');
    }

    public function update(User $user, Blog $blog, Like $like){
        $blog_user_id = Blog::find($blog->id)->user->id;
        $like = Like::find($like->id);

        if($user->id != $blog_user_id){
            Like::where('id', $like->id)
            ->update([
                'is_liked' => !$like->is_liked,
            ]);

            return 'success';
        }else{
            return abort(403);
        }
    }

    public function index($user_id, $blog_id){
        // return Like::where('blog_id', $blog_id)->count();
        return Blog::find($blog_id)->likes;
    }
}
