<form method="POST" action="{{ route('galleries.destroy', $gallery->id) }}" class="inline">
    @csrf
    @method('DELETE')
    <x-primary-button class="delete-btn">{{ __('Delete') }}</x-primary-button>
</form>
