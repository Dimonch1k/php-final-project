<button {{ $attributes->merge(['type' => 'submit', 'class' => 'action-btn']) }}>
    {{ $slot }}
</button>
