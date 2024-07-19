<button
    {{ $attributes->merge(['type' => 'submit', 'class' => "inline-flex items-center px-4 py-2 bg-{$color}-800 dark:bg-{$color}-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-{$color}-800 uppercase tracking-widest hover:bg-{$color}-700 dark:hover:bg-white focus:bg-{$color}-700 dark:focus:bg-white active:bg-{$color}-900 dark:active:bg-{$color}-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-{$color}-800 transition ease-in-out duration-150"]) }}>
    {{ $slot }}
</button>
