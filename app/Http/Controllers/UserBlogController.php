<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Validation\Rule;

class UserBlogController extends Controller
{
    public function create(){
        // blog form
    }

    // As a user, I want to post a blog, so that I can express my feelings.
    public function store(Request $request){

        //validate
        $validated = $request->validate([
            'title' => 'required | max:255',
            'content' => 'required | min:10',
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'thumbnail' => 'nullable | mimes:jpg,bmp,png | max:10240',
        ]);

        //stop here

        //get the input from the form
        $title = $request->title;
        $content = $request->content;
        $user_id = 1;
        $category_id = $request->category_id;
        $thumbnail = '';

        if($request->thumbnail){
            $thumbnail = request()->file('thumbnail')->store('thumbnails');
        }else{
            $thumbnail = 'thumbnail.jpg';
        }

        //store the data
        Blog::create([
            'title' => $title,
            'content' => $content,
            'user_id' => $user_id,
            'category_id' => $category_id,
            'thumbnail' => $thumbnail
        ]);

        //show a message
        return 'success';

    }
}
