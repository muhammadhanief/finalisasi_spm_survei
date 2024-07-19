<div class="px-4 py-3 mb-8 bg-purple-700 rounded-lg shadow-md dark:bg-purple-500 ">
    <h4 class="text-lg font-semibold text-gray-300 dark:text-gray-300">
        Blok {{ $currentSectionIndex + 1 }}.{{ $section->name }}
    </h4>
</div>
@php
    $index = 0;
@endphp
@foreach ($section->questions as $qkey => $question)
    <div wire:key='{{ $question->id }}'>
        @if ($question->questionType->name == 'Umum')
            <div class="p-4 my-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">{{ $index + 1 }}.
                        {{ $question->content }}</span>
                </label>
                @php
                    $index++;
                @endphp
                @include('livewire.includes.fillSurvey.optionType.' . $question->answeroption->type)
            </div>
        @else
            @if ($question->questionType->name == 'Harapan')
                <div class="p-4 my-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">{{ $index + 1 }}.
                            {{ $question->content }}</span>
                    </label>
                    @php
                        $index++;
                        $firstQuestionTypeWidth = strlen('Kenyataan') * 10;
                    @endphp
                    <div class="grid">
                        <div class="grid w-full overflow-x-auto">
                            <div class="flex flex-col w-full text-sm whitespace-no-wrap">
                                <div class="flex flex-row w-full">
                                    {{-- <p>{{ $firstQuestionTypeWidth }}</p> --}}
                                    <div
                                        class="flex items-center justify-center w-20 p-2 text-white sm:flex-1 dark:text-gray-800 ">
                                        Kenyataan
                                    </div>
                                    @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
                                        <div
                                            class="flex items-center justify-center flex-1 p-2 text-center text-black whitespace-normal dark:text-gray-400">
                                            {{ $answeroptionvalue->name }}</div>
                                    @endforeach
                                </div>
                                {{-- HARAPAN --}}
                                <div class="flex flex-row w-full">
                                    <div
                                        class="flex items-center justify-center w-20 p-2 text-black bg-gray-100 sm:flex-1 dark:text-gray-400 dark:bg-gray-700">
                                        {{ $question->questionType->name }}
                                    </div>
                                    @foreach ($question->answeroption->answeroptionvalues as $answeroptionvalue)
                                        <div
                                            class="flex items-center justify-center flex-1 p-2 text-black bg-gray-100 dark:text-gray-400 dark:bg-gray-700">
                                            <label
                                                class="flex items-center justify-center w-10 h-10 bg-transparent rounded-full cursor-pointer hover:bg-white dark:hover:bg-gray-600">
                                                <!-- Isi di dalam bulatan (opsional) -->
                                                <input wire:model='answers.{{ $question->id }}.value' type="radio"
                                                    class="w-4 h-4 text-purple-600 cursor-pointer focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                    name="accountType{{ $question->id }}"
                                                    value="{{ $answeroptionvalue->value }}" />
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <x-error-display name='answers.{{ $question->id }}.value' />
                                <div class="flex flex-row w-full">
                                    {{-- Akses pertanyaan pada iterasi selanjutnya, jika ada --}}
                                    {{-- INI UNTUK KENYATAAN --}}
                                    @if ($qkey + 1 < count($section->questions))
                                        <div
                                            class="flex items-center justify-center w-20 p-2 text-black bg-gray-100 sm:flex-1 dark:text-gray-400 dark:bg-gray-700">
                                            {{ $section->questions[$qkey + 1]->questionType->name }}
                                        </div>
                                        @foreach ($section->questions[$qkey + 1]->answeroption->answeroptionvalues as $answeroptionvalue)
                                            <div
                                                class="flex items-center justify-center flex-1 p-2 text-black bg-gray-100 dark:text-gray-400 dark:bg-gray-700">
                                                <label
                                                    class="flex items-center justify-center w-10 h-10 bg-transparent rounded-full cursor-pointer hover:bg-white dark:hover:bg-gray-600">
                                                    <input
                                                        wire:model='answers.{{ $section->questions[$qkey + 1]->id }}.value'
                                                        type="radio"
                                                        class="w-4 h-4 text-purple-600 cursor-pointer focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        name="accountType{{ $section->questions[$qkey + 1]->id }}"
                                                        value="{{ $answeroptionvalue->value }}" />
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <x-error-display name='answers.{{ $section->questions[$qkey + 1]->id }}.value' />
                            </div>
                        </div>
                    </div>
                </div>
            @else
            @endif
        @endif
    </div>
@endforeach
