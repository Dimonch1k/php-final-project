<form method="POST" action="{{ route('galleries.access.delete', $access->id) }}">
    @csrf
    @method('DELETE')
    <x-primary-button class='delete-btn'>{{ __('Delete') }}</x-primary-button>
</form>
