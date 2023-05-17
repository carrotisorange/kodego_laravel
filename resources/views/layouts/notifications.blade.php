@if(session()->has('success'))
<div x-data="{show: true}" x-init="setTimeout(()=> show=false, 4000)" x-show="show"
    class="fixed bg-purple-500 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-md">
    <p><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</p>
</div>
@endif