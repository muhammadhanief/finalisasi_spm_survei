<div class="pb-16 md:pb-32">
    <x-slot:title>Buat Survei - Manual</x-slot:title>
    @include('livewire.includes.offline-alert')
    @include('livewire.includes.copySurvey.preview-modal')
    <!-- resources/views/livewire/add-question.blade.php -->
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Buat Survei - Salin
        </h2>
        <div class="flex flex-col justify-between md:gap-2">
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 ">
                <div id="search-box" class="flex flex-col items-start justify-center px-2 my-4">
                    <!-- Search input -->
                    <div class="w-full p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                        role="alert">
                        <span class="font-medium"></span> Pilih salah satu dari survei di bawah untuk disalin!
                    </div>
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
                                wire:model.live.debounce.500ms="search" type="text" placeholder="Cari Survei..." />
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
                                        <th class="px-4 py-3">Nama Survei</th>
                                        <th class="px-4 py-3">Tahun</th>
                                        <th class="px-4 py-3">Berakhir Tanggal</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                    @foreach ($surveys as $survey)
                                        <tr wire:key='{{ $survey->id }}' class="text-gray-700 dark:text-gray-400">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center text-sm">
                                                    <div>
                                                        @php
                                                            $truncatedDescription = Str::limit($survey->name, 20);
                                                        @endphp
                                                        <p class="font-semibold">{{ $truncatedDescription }}</p>
                                                        {{-- <p class="text-xs text-gray-600 dark:text-gray-400">
                                                            Digunakan di

                                                            {{ $dimension->subdimensions->flatMap->questions->count() }}
                                                            pertanyaan
                                                        </p> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{ $survey->year }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{-- {{ $dimension->created_at }} --}}
                                                {{ \Carbon\Carbon::parse($survey->ended_at)->translatedFormat('d F Y H:i') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                @php
                                                    $started_at = \Carbon\Carbon::parse($survey->started_at);
                                                    $ended_at = \Carbon\Carbon::parse($survey->ended_at);
                                                @endphp
                                                @if (!$started_at->isPast())
                                                    <span
                                                        class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                                        Belum Dimulai
                                                    </span>
                                                @else
                                                    @if (!$ended_at->isPast())
                                                        <span
                                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                            Sedang Berjalan
                                                        </span>
                                                    @else
                                                        <span
                                                            class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-700">
                                                            Selesai
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center space-x-4 text-sm">
                                                    <x-button-small @click="openModal('modal')"
                                                        wire:click='detailPreview({{ $survey->id }})'
                                                        color="purple">Tinjau </x-button-small>
                                                    {{-- <button
                                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                        aria-label="Edit" wire:click='detail({{ $survey->id }})'>
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                    </button> --}}
                                                    {{-- <button
                                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                        aria-label="Delete" wire:click='delete({{ $survey->id }})'
                                                        wire:confirm="Apakah kamu yakin akan menghapus survei ini?">
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button> --}}
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="p-2">
                                {{ $surveys->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
