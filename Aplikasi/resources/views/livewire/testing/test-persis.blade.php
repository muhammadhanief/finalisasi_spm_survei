<div class="pb-16 md:pb-32">
    <x-slot:title>Isi Survei</x-slot:title>
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Isi Survei
        </h2>
        <input wire:model.live='apani'
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-black dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="tes livewire" />
        {{-- @foreach ($survey->sections as $key => $section)
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                    Blok {{ $key + 1 }}. {{ $section->name }}
                </h4>
                @php
                    $index = 0;
                @endphp
                @foreach ($section->questions as $qkey => $question)
                    @if ($question->questionType->name == 'Tunggal')
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">{{ $index + 1 }}.
                                {{ $question->content }}</span>
                        </label>
                        @php
                            $index++;
                        @endphp
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple text-black dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="Jane Doe" />
                    @else
                        @if ($question->questionType->name == 'Harapan')
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">{{ $index + 1 }}.
                                    {{ $question->content }}</span>
                            </label>
                            @php
                                $index++;
                            @endphp
                        @endif
                        <div class="mt-2 text-sm">
                            <div class="flex flex-row">
                                <label class="inline-flex items-center text-black dark:text-gray-400">
                                    <input type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $qkey }}" value="Kurang Baik" />
                                    <span class="ml-2">Kurang Baik</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                    <input type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $qkey }}" value="Cukup Baik" />
                                    <span class="ml-2">Cukup Baik</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                    <input type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $qkey }}" value="Baik" />
                                    <span class="ml-2">Baik</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-black dark:text-gray-400">
                                    <input type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="accountType{{ $qkey }}" value="Sangat Baik" />
                                    <span class="ml-2">Sangat Baik</span>
                                </label>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach --}}
        <div>
            <x-button-small wire:click.prevent='store' color="green">Submit</x-button-small>
        </div>
    </div>
</div>
