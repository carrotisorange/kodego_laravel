<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserBlogController extends Controller
{
    public function index($user_id){
        return User::find($user_id)->blogs;
    }

    public function create(){
        // blog form
    }

    public function edit(){
        // blog form
    }


    // As a user, I want to post a blog, so that I can express my feelings.
    public function store(Request $request){

        //validate
        $validated = $request->validate([
            'title' => 'required | max:255',
            'content' => 'required | min:10',
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'thumbnail' => 'nullable | mimes:jpg,bmp,png | max:10240', //10MB
            // 'user_id' => 'required',
        ]);

        //stop here

        //get the input from the form
        $title = $request->title;
        $content = $request->content;
        $user_id = 1; //auth()->user()->id;
        $category_id = $request->category_id;
        $thumbnail = '';
        

        $validated['user_id'] = 1;


        if($request->thumbnail){
            $thumbnail = request()->file('thumbnail')->store('thumbnails');
        }else{
            $thumbnail = 'thumbnail.jpg';
        }

        //store the data
        //  og code
        // Blog::create([
        //     'title' => $title,
        //     'content' => $content,
        //     'user_id' => $user_id,
        //     'category_id' => $category_id,
        //     'thumbnail' => $thumbnail
        // ]);

        //refactored
       $blog = Blog::create($validated);


        //show a message
        return $blog;

    }

    public function update(Request $request, $user_id, $blog_id){
       
        $blog_user_id = Blog::find($blog_id)->user->id;

       //restrict the update to the author of the blog
       if($user_id == $blog_user_id){
        //validate the inputs
        $validated = $request->validate([
            'title' => 'required | max:255',
            'content' => 'required | min:10',
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'thumbnail' => 'nullable | mimes:jpg,bmp,png | max:10240', //10MB
        ]);

         $thumbnail = '';

        //store thumbnail
         if($request->thumbnail){
            $thumbnail = request()->file('thumbnail')->store('thumbnails');
         }else{
            $thumbnail = 'thumbnail.jpg';
         }

         $blog = Blog::where('id', $blog_id)
         ->update($validated);

         return 'success';

        //
       }else{
           return abort(403);
       }
       
    }

    public function destroy($user_id, $blog_id){
        
        $blog_user_id = Blog::find($blog_id)->user->id;

        if($user_id == $blog_user_id){
            Blog::where('id', $blog_id)
            ->delete();

            return 'deleted!';
        }else{
            return abort(403);
        }

    }
}
