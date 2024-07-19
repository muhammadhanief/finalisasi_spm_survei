<div class="mb-4">
    @foreach ($sections as $key => $section)
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h3 class="text-sm text-gray-700 whitespace-pre-line dark:text-gray-400">
                Blok {{ $key + 1 }} : {{ $section['name'] }}
            </h3>
            @if (isset($section) && is_array($section))
                @foreach ($section as $qKey => $question)
                    @if (isset($question) && is_array($question))
                        <div class="mt-2">
                            <label class="text-sm text-gray-700 dark:text-gray-400" for="question">Pertanyaan
                                {{ $qKey + 1 }}:</label>
                            <x-button-small color="red"
                                wire:click.prevent="deleteQuestion({{ $key }}, {{ $qKey }})">Hapus
                                Pertanyaan</x-button-small>
                            <x-input-regular
                                wire:model.live='sections.{{ $key }}.{{ $qKey }}.questionName'
                                placeholder="Pertanyaan ke"></x-input-regular>
                            <x-error-display name="sections.{{ $key }}.{{ $qKey }}.questionName" />


                            @if ($section['sectionQuestionType'] == 'tunggal')
                                <select
                                    wire:model.live='sections.{{ $key }}.{{ $qKey }}.answerOptionID'
                                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    <option value="" selected>Pilih tipe pertanyaan</option>
                                    @foreach ($answerOptions as $answerOption)
                                        <option value="{{ $answerOption->id }}">{{ $answerOption->name }} :
                                            {{ implode(', ', $answerOption->answeroptionvalues->pluck('name')->all()) }}
                                            :
                                            {{ $answerOption->type }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-error-display
                                    name="sections.{{ $key }}.{{ $qKey }}.answerOptionID" />
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
            <x-button-small color="blue" wire:click.prevent="addQuestion({{ $key }})">Tambah
                Pertanyaan di Blok ini</x-button-small>
            <x-button-small color="red" wire:click.prevent="deleteSection({{ $key }})">Hapus
                Blok</x-button-small>
        </div>
    @endforeach
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        @if ($showAddSectionForm)
            <div class="mt-2">
                <label for="newSectionName" class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nama Blok</span>
                    <x-input-regular required wire:model.live="newSectionName"
                        placeholder="Nama Blok"></x-input-regular>
                </label>
                <x-error-display name="newSectionName" />
            </div>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Tipe pertanyaan di blok ini
                </span>
                <select wire:model.live='sectionQuestionType'
                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="" selected>Pilih tipe pertanyaan</option>
                    <option value="tunggal">Tipe Umum</option>
                    <option value="harapanDanKenyataan">Tipe Harapan dan Kenyataan</option>
                </select>
                <x-error-display name="sectionQuestionType" />
            </label>
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Tipe dimensi di blok ini
                </span>
                <select wire:model.live='sectionSubDimensionType'
                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="" selected>Pilih dimensi</option>
                    @foreach ($subdimensions as $subdimension)
                        @if ($subdimension->dimension_id == $DimensionType)
                            <option value="{{ $subdimension->id }}">{{ $subdimension->name }}</option>
                        @endif
                    @endforeach
                </select>
                <x-error-display name="sectionSubDimensionType" />
            </label>
            @if ($sectionQuestionType == 'harapanDanKenyataan')
                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Paket Opsi Jawaban
                    </span>
                    <select wire:model.live='sectionAnswerOption'
                        class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option value="" selected>Pilih tipe pertanyaan</option>
                        @foreach ($answerOptions as $answerOption)
                            @if ($answerOption->type == 'radio')
                                <option value="{{ $answerOption->id }}">{{ $answerOption->name }} :
                                    {{ implode(', ', $answerOption->answeroptionvalues->pluck('name')->all()) }}:
                                    {{ $answerOption->type }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-error-display name="sectionAnswerOption" />
                </label>
                @php
                    $sectionAnswerOptionVisible = true;
                @endphp
            @else
                @php
                    $sectionAnswerOptionVisible = false;
                @endphp
            @endif
            <x-button-small class="mt-4" wire:click.prevent="addSection" color="purple">
                Tambah Blok +
            </x-button-small>
            <x-button-small class="mt-4" wire:click.prevent="cancelSection" color="red">
                Cancel
            </x-button-small>
        @else
            <x-button-small wire:click.prevent="$toggle('showAddSectionForm')" color="blue">
                Buat Blok Baru
            </x-button-small>
            @if (session('successAddSection'))
                <span class="mt-3 text-xs text-green-600 dark:text-green-400">{{ session('successAddSection') }}</span>
            @endif
        @endif
    </div>
</div>
