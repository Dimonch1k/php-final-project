<form method="POST" action="{{ route('galleries.update', $gallery->id) }}">
    @csrf
    @method('PUT')
    <x-text-input id="title" name="title" type="text" :value="old('title', $gallery->title)" required autofocus autocomplete="name" />
    <x-primary-button class='update-btn'>{{ __('Update') }}</x-primary-button>
</form>
