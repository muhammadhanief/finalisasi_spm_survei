<div class="container grid px-6 mx-auto">
</div>
<div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
    <!-- Modal -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal"
        @keydown.escape="closeModal"
        class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-3xl"
        role="dialog" id="modal">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
            <button
                class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                aria-label="close" @click="closeModal">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                    <path
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </button>
        </header>
        <!-- Modal body -->
        <div class="mt-4 mb-6">
            <!-- Modal title -->
            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                Dimensi yang ada di kategori dimensi "{{ $showingDimensionName }}"
            </p>
            <!-- Modal description -->
            <div class="container grid mx-auto">
                <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Nama Dimensi</th>
                                    <th class="px-4 py-3">Deskripsi Dimensi</th>
                                    {{-- <th class="px-4 py-3">Status</th> --}}
                                    <th class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($subdimensions as $subdimension)
                                    @if ($subdimension->dimension_id == $showingDimensionID)
                                        {{-- @if (true) --}}
                                        <tr wire:key='{{ $subdimension->id }}' class="text-gray-700 dark:text-gray-400">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center text-sm">
                                                    <div>
                                                        <p class="font-semibold">{{ $subdimension->name }}</p>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                                            Digunakan di
                                                            {{ $subdimension->questions()->count() }}
                                                            pertanyaan
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                @if ($editingDimensionID === $subdimension->id)
                                                    <textarea wire:model='editingDimensionDescription' placeholder="Deskripsi"
                                                        class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                                        rows="3"></textarea>
                                                    @error('editingDimensionDescription')
                                                        <span class="block text-xs text-red-500">{{ $message }}</span>
                                                    @enderror
                                                    <x-button-small color="green"
                                                        wire:click='update({{ $subdimension->id }})'>
                                                        Update</x-button-small>
                                                    <x-button-small color="red" wire:click='cancelEdit'>
                                                        Cancel</x-button-small>
                                                @else
                                                    @php
                                                        $truncatedDescription = Str::limit(
                                                            $subdimension->description,
                                                            15,
                                                        );
                                                    @endphp
                                                    <p class="font-semibold" title="{{ $subdimension->description }}">
                                                        {{ $truncatedDescription }}</p>
                                                @endif
                                                @if (session('successUpdate') && session('successUpdate')['dimensionID'] === $dimension->id)
                                                    <div class="mt-3 text-xs text-green-600 dark:text-green-400">
                                                        {{ session('successUpdate')['message'] }}</div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center space-x-4 text-sm">
                                                    <button
                                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                        aria-label="Delete"
                                                        wire:click='deleteSubdimension({{ $subdimension->id }})'
                                                        {{-- wire:confirm.prompt='Apakah Anda yakin ingin menghapus dimensi "{{ $dimension->name }}"?\n\nKetik DELETE untuk konfirmasi|DELETE' --}}>
                                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-2">
                            {{ $dimensions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
