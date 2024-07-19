<button
    {{ $attributes->merge(['type' => 'button', 'class' => "px-3 py-1 mt-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-{$color}-600 border border-transparent rounded-md active:bg-{$color}-600 hover:bg-{$color}-700 focus:outline-none focus:shadow-outline-{$color}"]) }}>
    {{ $slot }}
</button>

{{-- 'type' => 'submit', --}}
