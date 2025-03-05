@php
    use App\Models\User;
@endphp

<x-app-layout>
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md" role="alert">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Galleries') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg grid gap-4 p-4">
                @if (auth()->check() && auth()->user()->role !== 'admin')
                    <x-galleries.create />
                @endif

                <table>
                    <caption>Galleries</caption>
                    <thead>
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Gallery ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Images Qty</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($galleries as $gallery)
                            <tr>
                                <td>{{ $gallery->user->name ?? 'Unknown' }}</td>
                                <td>{{ $gallery->id }}</td>
                                <td>
                                    @if (auth()->id() === $gallery->user_id)
                                        <x-galleries.edit :gallery="$gallery" />
                                    @else
                                        {{ $gallery->title }}
                                    @endif
                                </td>
                                <td>
                                    {{ is_array(json_decode($gallery->images)) ? count(json_decode($gallery->images)) : 0 }}
                                </td>
                                <td>
                                    <x-galleries.action-btns :gallery="$gallery" :accesses="$accesses" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
