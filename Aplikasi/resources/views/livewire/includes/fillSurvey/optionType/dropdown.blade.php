<div class="flex flex-row gap-x-2">
    <select wire:model.live='answers.{{ $question->id }}.value'
        class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
        <option value="" selected>Pilih</option>
        @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
            <option value="{{ $answeroptionvalue->value }}">{{ $answeroptionvalue->name }}</option>
        @endforeach
    </select>
</div>
<x-error-display name='answers.{{ $question->id }}.value' />
