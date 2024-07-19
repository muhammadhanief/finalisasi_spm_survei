<div class="px-4 py-3 my-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <p class="mb-4 text-3xl font-bold text-black dark:text-gray-400">
        {{ $survey->name }}
    </p>
    <p class="mb-4 text-black dark:text-gray-400">
        {!! nl2br(e($survey->description)) !!}
    </p>
    @if ($targetResponden != null)
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            Anda mengisi survei sebagai : {{ $targetResponden->name }}
        </div>
    @endif
</div>
