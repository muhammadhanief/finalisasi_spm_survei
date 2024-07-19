<div>
    <!-- Cari, Hapus, Edit Dimensi -->
    <h4 class="mt-4 mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Cari atau Hapus Opsi Jawaban
    </h4>
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 ">
        <div id="search-box" class="flex flex-col items-start justify-center px-2 my-4">
            <!-- Search input -->
            <div id="kolom-pencarian" class="flex">
                <div class="relative w-full max-w-xl focus-within:text-purple-500 ">
                    <div class="absolute inset-y-0 flex items-center pl-2">
                        <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d=" M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </div>
                    <input
                        class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                        wire:model.live.debounce.500ms="search" type="text" placeholder="Cari Akar Dimensi.." />
                </div>
            </div>
            <div>
                @if (session('gagalSearch'))
                    <div class="pt-2 text-xs text-red-500">{{ session('gagalSearch') }}</div>
                @endif
                @if (session('successHapus'))
                    <div class="pt-2 text-xs text-green-500">{{ session('successHapus') }}</div>
                @else
                    <div class="pt-2 text-xs text-red-500">{{ session('errorHapus') }}</div>
                @endif
            </div>
        </div>
        <div class="container grid mx-auto">
            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Nama Opsi</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($answerOptions as $answerOption)
                                <tr wire:key='{{ $answerOption->id }}' class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <div>
                                                <p class="font-semibold">{{ $answerOption->name }}</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                                    Digunakan di
                                                    {{ $answerOption->questions->count() }}
                                                    pertanyaan
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $answerOption->type }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex items-center space-x-4 text-sm">
                                            <button
                                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Delete" wire:click='delete({{ $answerOption->id }})'
                                                {{-- wire:confirm.prompt='Apakah Anda yakin ingin menghapus dimensi "{{ $dimension->name }}"?\n\nKetik DELETE untuk konfirmasi|DELETE' --}}>
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                            <button @click="openModal('modal')"
                                                wire:click='showAnswerOptionValueModal({{ $answerOption->id }})'
                                                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                Lihat Opsi Jawaban
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-2 ">
                        {{ $answerOptions->links() }}
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.option.answer-option-modal')
    </div>

</div>
