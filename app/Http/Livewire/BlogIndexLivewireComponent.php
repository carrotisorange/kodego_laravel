<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Blog;
use App\Models\Category;

class BlogIndexLivewireComponent extends Component
{
    public $search;
    public $filterCategory;

    public function render()
    {
        $categories = Category::all();
        $blogs = Blog::where('title','like', '%'.$this->search.'%')
         ->when($this->filterCategory, function($query){
         $query->where('category_id', $this->filterCategory);
         })
        ->paginate(10);

        return view('livewire.blog-index-livewire-component',[
            'blogs' => $blogs,
            'categories' => $categories
        ]);
    }
}
