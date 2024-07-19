<div class="container grid mx-auto">
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Nama Kategori Dimensi</th>
                        <th class="px-4 py-3">Deskripsi Kategori Dimensi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($dimensions as $dimension)
                        <tr wire:key='{{ $dimension->id }}' class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $dimension->name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            Digunakan di
                                            {{ $dimension->subdimensions->flatMap->questions->count() }}
                                            pertanyaan
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if ($editingDimensionID === $dimension->id)
                                    <textarea wire:model='editingDimensionDescription' placeholder="Deskripsi"
                                        class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        rows="3"></textarea>
                                    @error('editingDimensionDescription')
                                        <span class="block text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                    <x-button-small color="green" wire:click='update({{ $dimension->id }})'>
                                        Update</x-button-small>
                                    <x-button-small color="red" wire:click='cancelEdit'>
                                        Cancel</x-button-small>
                                @else
                                    @php
                                        $truncatedDescription = Str::limit($dimension->description, 15);
                                    @endphp

                                    <p class="font-semibold" title="{{ $dimension->description }}">
                                        {{ $truncatedDescription }}</p>
                                @endif
                                @if (session('successUpdate') && session('successUpdate')['dimensionID'] === $dimension->id)
                                    <div class="mt-3 text-xs text-green-600 dark:text-green-400">
                                        {{ session('successUpdate')['message'] }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs">
                                @if ($dimension->subdimensions()->count() > 0)
                                    @php $isUsed = 0; @endphp
                                    @foreach ($dimension->subdimensions as $subdimension)
                                        @if ($subdimension->questions()->count() > 0)
                                            @php $isUsed = 1; @endphp
                                        @endif
                                    @endforeach
                                    @if ($isUsed == 1)
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            Digunakan
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                            Tidak Digunakan
                                        </span>
                                    @endif
                                @else
                                    <span
                                        class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                        Tidak Digunakan
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <button wire:click='edit({{ $dimension->id }})'
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Edit">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Delete" wire:click='delete({{ $dimension->id }})'
                                        {{-- wire:confirm.prompt='Apakah Anda yakin ingin menghapus dimensi "{{ $dimension->name }}"?\n\nKetik DELETE untuk konfirmasi|DELETE' --}}>
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <div>
                                        <button @click="openModal('modal')"
                                            wire:click='showSubdimensionModal({{ $dimension->id }})'
                                            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                            Lihat Dimensi
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-2">
                {{ $dimensions->links() }}
            </div>
        </div>
    </div>
</div>
