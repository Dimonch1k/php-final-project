<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'action-btn hover:bg-red-500 active:bg-red-700 focus:ring-red-500 dark:focus:ring-offset-gray-800']) }}>
    {{ $slot }}
</button>
