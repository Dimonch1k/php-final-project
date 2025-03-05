<form method="POST" action="{{ route('galleries.store') }}">
    @csrf
    @method('POST')
    <fieldset class='inline-block'>
        <label for="title" class='text-lg'>Gallery Title:</label>
        <x-text-input id="title" name="title" type="text" required autofocus autocomplete="name" />
        <input type="hidden" name="images" value="[]">
    </fieldset>

    <x-primary-button class='create-btn'>{{ __('Create Gallery') }}</x-primary-button>
</form>
