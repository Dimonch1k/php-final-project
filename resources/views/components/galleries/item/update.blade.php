<form method="POST" action="{{ route('galleries.img.update', $gallery->id) }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="image_index" value="{{ $index }}">
    <x-text-input id="title" name="title" type="text" :value="old('title', $image->title)" required autofocus autocomplete="name" />
    <hr class='my-2'>
    <x-primary-button class='update-btn w-full'>{{ __('Update') }}</x-primary-button>
</form>
