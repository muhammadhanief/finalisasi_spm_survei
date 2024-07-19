<div class="grid">
    <div class="w-full grid overflow-x-auto">
        <div class="w-full flex flex-col text-sm whitespace-no-wrap">
            <div class="w-full flex flex-row">
                @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
                    <div
                        class="flex flex-1 text-center items-center justify-center  p-2 text-black dark:text-gray-400 whitespace-normal">
                        {{ $answeroptionvalue->name }}</div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="w-full flex flex-row">
        @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
            <div
                class="flex-1 flex items-center justify-center  p-2 text-black dark:text-gray-400 bg-gray-100 dark:bg-gray-700">
                <label
                    class="cursor-pointer w-10 h-10 bg-transparent hover:bg-white dark:hover:bg-gray-600 rounded-full flex items-center justify-center">
                    <input wire:model='answers.{{ $question->id }}.value' type="radio"
                        class="cursor-pointer w-4 h-4 text-purple-600 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        name="accountType{{ $question->id }}" value="{{ $answeroptionvalue->value }}" />
                </label>
            </div>
        @endforeach
    </div>
</div>
<x-error-display class='coba_ini' name='answers.{{ $question->id }}.value' />
