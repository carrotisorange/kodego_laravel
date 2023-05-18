<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(Request $request){

       $blogs = Blog::
       where('title','like', '%'.$request->title.'%')->paginate(10);
        
        return view('blogs.index',[
            'blogs' => $blogs
        ]);
    }
}
