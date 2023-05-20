<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <nav class="flex" aria-label="Breadcrumb">
                <ol role="list" class="flex space-x-4 rounded-md bg-white px-6 shadow">
                    <li class="flex">
                        <div class="flex items-center">
                            <a href="/dashboard" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Home</span>
                            </a>
                        </div>
                    </li>
                    <li class="flex">
                        <div class="flex items-center">
                            <svg class="h-full w-6 flex-shrink-0 text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none"
                                fill="currentColor" aria-hidden="true">
                                <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                            </svg>
                            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $blog->title }}</a>
                        </div>
                    </li>
                  
                </ol>
            </nav>
        </h2>
    </x-slot>
<x-slot name="content">
    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white px-4 py-5 sm:px-6">
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <img class="h-20 w-20 rounded-full"
                          src="{{ asset('/storage/'.$blog->thumbnail) }}"
                            alt="">
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-900">
                            <a href="#" class="hover:underline">{{ $blog->user->name }}</a>
                        </p>
                        <p class="text-sm font-semibold text-gray-900">
                            <a href="#" class="hover:underline">{{ $blog->category->category }}</a>
                        </p>
                        <p class="text-sm text-gray-500">
                            <a href="#" class="hover:underline">{{
                                Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</a>
                        </p>
                        <br>
                        <p class="text-sm text-gray-500">
                           {{
                                $blog->content }}
                        </p>
                        <br>
                        <p class="text-sm">
                            @foreach($blog_user_likes as $blog_user_like) 
                            <?php $firstName= explode(' ', $blog_user_like->user->name); ?> 
                                <span class="text-xl">{{ $firstName[0] }}, </span> 
                            @endforeach
                            {{ Str::of('like')->plural($blog_user_likes->count()) }} this blog.
                        </p>
                    </div>
                    <div class="flex flex-shrink-0 self-center">
                        {{-- @if(auth()->user()->id == $blog->user_id) --}}
                        @if(auth()->user()->id === $blog->user_id)
                          <a href="/user/{{ $blog->user_id }}/blog/{{ $blog->id }}/edit" class="hover:underline text-blue-600">Edit</a>

                          <button data-modal-target="delete-blog-popup-modal" data-modal-toggle="delete-blog-popup-modal"
                                class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                type="button">
                            Delete
                            </button>
                        @endif
                       
                    </div>
                   
                    </div>
            </div>
<div class="mt-5">
    <p class="text-right">
        @if($user_likes_count == 1)
        <form action="/user/{{ auth()->user()->id }}/blog/{{ $blog->id }}/like/{{ $like_id }}/update" method="POST">
            @csrf
            @method('PUT')
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            @if($is_blog_liked == 1)
            Unlike 
            @else

                Like ({{ $total_likes_count }})
       
            @endif
            </button>
        </form>
        @else
<form action="/user/{{ auth()->user()->id }}/blog/{{ $blog->id }}/like/store" method="POST">
    @csrf
    <button type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Like ({{ $total_likes_count }})
    </button>
</form>
        @endif
      
    </p>
  </div>

  <form action="/user/{{ auth()->user()->id }}/blog/{{ $blog->id }}/comment/store" method="POST">
            @csrf
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
        
        
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        
                        <div class="col-span-full">
                            <label for="comments" class="block text-sm font-medium leading-6 text-gray-900">Add your comment here</label>
                            <div class="mt-2">
                                <textarea id="comments" name="comments" rows="3"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                          {{ old('comments') }}
                                            </textarea>
                            </div>
                            @error('comments')
                            <div class="text-red-600 alert alert-danger">{{ $message }}</div>
                            @enderror
                           
                        </div>
        
                    </div>
                </div>
        
            </div>
        
            <div class="mt-6 flex items-center justify-end gap-x-6">
               
                <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
            </div>
        </form>

        <p>Posted comments {{ $comments->count() }}</p>

@foreach ($comments as $comment )
    

<article class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-900">
            <footer class="flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white"><img
                            class="mr-2 w-6 h-6 rounded-full"
                            src="https://flowbite.com/docs/images/people/profile-picture-2.jpg" alt="Michael Gough">{{ $comment->user->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08"
                            title="February 8th, 2022">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</time></p>
                </div>
                <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    type="button">
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                        </path>
                    </svg>
                    <span class="sr-only">Comment settings</span>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownComment1"
                    class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownMenuIconHorizontalButton">
                        @if(auth()->user()->id == $comment->user_id)
                        <li>
                            <a href="#" data-modal-target="edit-comment-popup-modal" data-modal-toggle="edit-comment-popup-modal"
                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                        </li>
                        @endif
                        @if(auth()->user()->id == $blog->user_id || auth()->user()->id == $comment->user_id)
                        <li>
                            <a href="#" data-modal-target="delete-comment-popup-modal" data-modal-toggle="delete-comment-popup-modal"
                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                        </li>
                        @endif
                      
                    </ul>
                </div>
            </footer>
            <p class="text-gray-500 dark:text-gray-400">{{ $comment->comments }}</p>
            <?php $replies = App\Models\Comment::where('comment_id', $comment->id)->orderBy('created_at', 'desc')->get();?>
            <p>@foreach($replies as $reply)
               <article class="p-6 mb-6 text-base bg-white rounded-lg dark:bg-gray-900">
                <footer class="flex justify-between items-center mb-2">
                    <div class="flex items-center">
                        <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white"><img
                                class="mr-2 w-6 h-6 rounded-full"
                                src="https://flowbite.com/docs/images/people/profile-picture-2.jpg" alt="Michael Gough">{{
                            $reply->user->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08"
                                title="February 8th, 2022">{{ Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</time>
                        </p>
                    </div>
                    <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        type="button">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                            </path>
                        </svg>
                        <span class="sr-only">Comment settings</span>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownComment1"
                        class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownMenuIconHorizontalButton">
                            @if(auth()->user()->id == $reply->user_id)
                            <li>
                                <a href="#" data-modal-target="edit-comment-popup-modal"
                                    data-modal-toggle="edit-comment-popup-modal"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                            </li>
                            @endif
                            @if(auth()->user()->id == $blog->user_id || auth()->user()->id == $reply->user_id)
                            <li>
                                <a href="#" data-modal-target="delete-comment-popup-modal"
                                    data-modal-toggle="delete-comment-popup-modal"
                                    class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                            </li>
                            @endif
            
                        </ul>
                    </div>
                </footer>
                <p class="text-gray-500 dark:text-gray-400">{{ $reply->comments }}</p>
              
                <div class="flex items-center mt-4 space-x-4">
                    <button type="button" class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                        <svg aria-hidden="true" class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <a href="#" data-modal-target="reply-comment-popup-modal" data-modal-toggle="reply-comment-popup-modal"
                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
            
                    </button>
                </div>
            </article>
            @endforeach</p>
            <div class="flex items-center mt-4 space-x-4">
                <button type="button" class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400">
                    <svg aria-hidden="true" class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    <a href="#" data-modal-target="reply-comment-popup-modal" data-modal-toggle="reply-comment-popup-modal"
                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
               
                </button>
            </div>
        </article>
@include('modals.delete-comment-popup-modal')
@include('modals.edit-comment-popup-modal')
@include('modals.reply-comment-popup-modal')
@endforeach
    </div>

@include('modals.delete-blog-popup-modal')

</x-slot>
</x-app-layout>