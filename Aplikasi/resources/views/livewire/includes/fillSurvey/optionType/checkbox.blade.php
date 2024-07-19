<div class="flex flex-row gap-x-2">
    @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
        <div>
            <Label check>
                <input wire:model='answers.{{ $question->id }}.value.{{ $answeroptionvalue->value }}' type="checkbox"
                    class="text-purple-600 form-checkbox focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray focus:border-purple-400 dark:border-gray-600 focus:shadow-outline-purple dark:focus:border-gray-600 dark:focus:shadow-outline-gray dark:bg-gray-700">
                <span className="ml-2">{{ $answeroptionvalue->name }}</span>
            </Label>
        </div>
    @endforeach
</div>
<x-error-display name='answers.{{ $question->id }}.value' />
