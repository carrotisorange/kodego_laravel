<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Blog;

class UserBlogLikeController extends Controller
{
    public function store($user_id, $blog_id){
       
        $blog_user_id = Blog::find($blog_id)->user->id;

        if($user_id != $blog_user_id){
            Like::updateOrCreate(
                [   
                    'user_id' => $user_id,
                    'blog_id' => $blog_id
                ],
                [
                    'user_id' => $user_id,
                    'blog_id' => $blog_id,
                ]
            );

              return 'success';
        }else{
            return abort(403);
        }
    }

    public function update($user_id, $blog_id, $like_id){
        $blog_user_id = Blog::find($blog_id)->user->id;
        $like = Like::find($like_id);

        if($user_id != $blog_user_id){
            Like::where('id', $like_id)
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
