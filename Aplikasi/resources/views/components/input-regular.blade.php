{{-- <button
    {{ $attributes->merge(['type' => 'submit', 'class' => "px-3 py-1 mt-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-{$color}-600 border border-transparent rounded-md active:bg-{$color}-600 hover:bg-{$color}-700 focus:outline-none focus:shadow-outline-{$color}"]) }}>
    {{ $slot }}
</button> --}}

<input
    {{ $attributes->merge(['type' => 'text', 'class' => 'block w-full mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input']) }}>
