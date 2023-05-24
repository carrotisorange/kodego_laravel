<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Models\Blog;
use Livewire\WithFileUploads;

class BlogCreateLivewireComponent extends Component
{
    use WithFileUploads;

    //input fields;
    public $title;
    public $category_id;
    public $content;
    public $thumbnail;

    protected function rules(){
       return [
             'title' => 'required | max:255',
             'content' => 'required | min:10',
             'category_id' => ['required', Rule::exists('categories', 'id')],
             'thumbnail' => 'required | mimes:jpg,bmp,png | max:10240', //10MB
       ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function storeBlog(){
        sleep(2);

        $validated = $this->validate();

        $thumbnail = $this->thumbnail->store('thumbnails');
    
        $validated['user_id'] = auth()->user()->id;
        $validated['thumbnail'] = $thumbnail;

        $blog = Blog::create($validated);

        return redirect('/user/'.auth()->user()->id.'/blog/'.$blog->id)->with('success', 'Success!');
      
    }

    public function render()
    {   
        $categories = Category::all();

        return view('livewire.blog-create-livewire-component',[
            'categories' => $categories
        ]);
    }
}
