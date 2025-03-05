<form method="POST" action="{{ route('galleries.img.delete', $gallery->id) }}">
    @csrf
    @method('DELETE')

    <input type="hidden" name="image_index" value="{{ $index }}">
    <x-primary-button class="delete-btn w-full">
        {{ __('Delete') }}
    </x-primary-button>
</form>
