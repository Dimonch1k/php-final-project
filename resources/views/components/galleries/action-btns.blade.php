<div class="flex justify-center gap-4">
    @if (auth()->id() === $gallery->user_id ||
            auth()->user()->role === 'admin' ||
            $accesses->contains(function ($value, $key) use ($gallery) {
                // check if gallery id cross and it is current user
                return $value->gallery_id === $gallery->id && $value->user_id === auth()->id();
            }))
        <x-galleries.show :gallery="$gallery" />
    @endif

    @if (auth()->id() === $gallery->user_id || auth()->user()->role === 'admin')
        <x-galleries.delete :gallery="$gallery" />
    @endif
</div>
