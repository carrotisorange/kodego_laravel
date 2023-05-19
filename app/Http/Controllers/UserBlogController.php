<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Category;
use App\Models\Like;

class UserBlogController extends Controller
{
    public function index(Request $request, $user_id){
        $blogs = Blog::join('users', 'blogs.user_id', 'users.id')
        ->select('*', 'blogs.id as blog_id')
        ->where('blogs.user_id', auth()->user()->id)
        ->where('blogs.title','like', '%'.$request->title.'%')
        ->paginate(10);

        return view('users.blogs.index',[
            'blogs' => $blogs
        ]);
    }

    public function create(User $user){
        $categories = Category::all();

       return view('users.blogs.create',[
        'categories' => $categories
       ]);
    }

    public function edit(User $user, Blog $blog){
        // $this->authorize('edit-blog', [$user->id, $blog->user_id]);

        $categories = Category::all();

        return view('users.blogs.edit',[
            'blog' => $blog,
            'categories' => $categories
        ]);
    }

    // As a user, I want to post a blog, so that I can express my feelings.
    public function store(Request $request, User $user){

         $validated = $request->validate([
            'title' => 'required | max:255',
            'content' => 'required | min:10',
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'thumbnail' => 'nullable | mimes:jpg,bmp,png | max:10240', //10MB
         ]);

        try{
           
            if($request->thumbnail){
                $thumbnail = $request->file('thumbnail')->store('thumbnails');
            }else{
                $thumbnail = 'thumbnails/thumbnail.jpg';
            }

            $validated['user_id'] = $user->id;
            $validated['thumbnail'] = $thumbnail;

            $blog = Blog::create($validated);
            
            }catch(\Exception $e){
                ddd($e);
            }

        return redirect('/blogs')->with('success', 'The blog has been posted!');

    }

    public function update(Request $request, User $user, Blog $blog){

        $validated = $request->validate([
            'title' => 'required | max:255',
            'content' => 'required | min:10',
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'thumbnail' => 'nullable | mimes:jpg,bmp,png | max:10240', //10MB
         ]);

        try{
           
            if($request->thumbnail){
                $thumbnail = $request->file('thumbnail')->store('thumbnails');
            }else{
                $thumbnail = $blog->thumbnail;
            }

            $validated['thumbnail'] = $thumbnail;

            $blog = Blog::where('id', $blog->id)
            ->update($validated);
            
            }catch(\Exception $e){
                ddd($e);
            }

        return back()->with('success', 'The blog has been updated!');
       
       
    }

    public function destroy(User $user, Blog $blog){
        
        $blog_user_id = Blog::find($blog->id)->user->id;

        if($user->id == $blog_user_id){
            Blog::where('id', $blog->id)
            ->delete();

            //delete 
        }else{
            return abort(403);
        }

        return redirect('/user/'.$user->id.'/blogs')->with('success', 'The blog has been deleted!');

    }

    public function show(User $user, Blog $blog){

        $user_likes_count = Like::where('blog_id', $blog->id)->where('user_id', auth()->user()->id)->count();

        $is_blog_liked = Like::where('blog_id', $blog->id)->where('user_id', auth()->user()->id)->pluck('is_liked')->first();
        
        return view('users.blogs.show',[
            'blog' => $blog,
            'is_blog_liked' => $is_blog_liked,
            'user_likes_count' => $user_likes_count
        ]);
    }
}
