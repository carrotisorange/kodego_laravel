<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Models\Blog;
use Livewire\WithFileUploads;

class EditBlogLivewireComponent extends Component
{
    use WithFileUploads;

    public $blog;

    public $title;
    public $category_id;
    public $content;
    public $thumbnail;

    public function mount($blog){
        $this->title = $blog->title;
        $this->category_id = $blog->category_id;
        $this->content = $blog->content;
    }

    protected function rules(){
       return [
             'title' => 'required | max:255',
             'content' => 'required | min:10',
             'category_id' => ['required', Rule::exists('categories', 'id')],
             'thumbnail' => 'nullable | mimes:jpg,bmp,png | max:10240', //10MB
       ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function updateBlog(){
        sleep(2);

        $validated = $this->validate();

        if($this->thumbnail){
            $thumbnail = $this->thumbnail->store('thumbnails');
        }else{
            $thumbnail = $this->blog->thumbnail;
        }
    
        $validated['thumbnail'] = $thumbnail;

        Blog::where('id', $this->blog->id)
        ->update($validated);

        return redirect('/user/'.auth()->user()->id.'/blog/'.$this->blog->id)->with('success', 'Success!');
    }

    public function render()
    {        
        $categories = Category::all();
        
        return view('livewire.edit-blog-livewire-component',[
            'categories' => $categories
        ]);
    }
}
