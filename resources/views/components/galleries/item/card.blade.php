<div class="max-w-[250px] w-full flex flex-col">
    <figure class="text-center text-lg grid gap-4 bg-slate-900 rounded-md">
        <img src="{{ asset($image->path) }}" alt="{{ $image->title }}"
            class="w-full h-60 object-cover object-center rounded-t-md ">


        @if ($gallery->user_id === auth()->user()->id)
            <x-galleries.item.update :gallery="$gallery" :image="$image" :index="$index" />
            <x-galleries.item.delete :gallery="$gallery" :index="$index" />
        @elseif(auth()->user()->role === 'admin')
            {{ $image->title }}
            <x-galleries.item.delete :gallery="$gallery" :index="$index" />
        @else
            {{ $image->title }}
        @endif
    </figure>
</div>
