<form method="POST" action="{{ route('galleries.access.store', $gallery->id) }}" class="flex gap-4 mb-4">
    @csrf
    @method('POST')

    <fieldset>
        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <button type="button" id="dropdown-button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md dark:text-gray-200 text-gray-500 dark:bg-slate-700 bg-white dark:hover:text-gray-100 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div id="selected-user-text">
                        {{ __('Choose User') }}
                    </div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="relative">
                    <div class="grid grid-cols-1 gap-4">
                        @foreach (App\Models\User::all()->except(auth()->id())->filter(function ($user) {
            return $user->role !== 'admin';
        }) as $user)
                            <a href="#" class="dropdown-link select-user" data-user-id="{{ $user->id }}"
                                data-user-name="{{ $user->name }}">
                                {{ $user->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </x-slot>
        </x-dropdown>
    </fieldset>

    <input type="hidden" name="user_id" id="selected-user-id">

    <x-primary-button class="create-btn">{{ __('Create Access to this Gallery') }}</x-primary-button>
</form>

<script>
    document.querySelectorAll('.select-user').forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('selected-user-text').textContent = this.dataset.userName;
            document.getElementById('selected-user-id').value = this.dataset.userId;
        });
    });
</script>
