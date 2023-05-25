<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Blog
        </h2>
    </x-slot>
    <x-slot name="content">
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white px-4 py-5 sm:px-6">
                    @livewire('edit-blog-livewire-component',['blog' => $blog])
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>