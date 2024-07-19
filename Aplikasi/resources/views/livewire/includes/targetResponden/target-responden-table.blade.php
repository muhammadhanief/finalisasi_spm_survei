<!-- Cari, Hapus, Edit Dimensi -->
<h4 class="mt-4 mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
    Cari atau Hapus Target Responden
</h4>
<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 ">
    <div id="search-box" class="flex flex-col px-2 my-4 ">
        <!-- Search input -->
        <div class="flex flex-col items-center justify-between md:flex-row">
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
                        wire:model.live.debounce.500ms="search" type="text" placeholder="Cari Target Responden.." />
                </div>
            </div>
            <div class="flex flex-row justify-end gap-2 ">
                <button wire:click='export'
                    class="px-3 py-1 my-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-md active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">Ekspor</button>
                <div class="relative">
                    <button @click="toggleDropdownMenu" @keydown.escape="closeDropdownMenu"
                        @click.outside="closeDropdownMenu" id="filterDropdownButton"
                        data-dropdown-toggle="filterDropdown"
                        class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-black focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400"
                            viewbox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                clip-rule="evenodd" />
                        </svg>
                        Filter
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                    <template x-if="isDropdownFilterOpen">
                        <div id="filterDropdown" @click.stop="stopClickPropagation"
                            class="absolute right-0 w-56 p-2 mt-2 bg-white rounded-lg shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Pilih Grup</h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                <li class="flex items-center">
                                    <input id="selectAll" type="checkbox" wire:model.live="selectAllRoles"
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    <label for="selectAll"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Pilih
                                        semua</label>
                                </li>
                                @foreach ($roles as $role)
                                    <li class="flex items-center">
                                        <input id="apple" type="checkbox" value={{ $role->id }}
                                            wire:model.live='selectedRoleId.{{ $role->id }}'
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="apple"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $role->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </template>
                </div>
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
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Surel</th>
                            <th class="px-4 py-3">Grup</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($targetRespondens as $targetResponden)
                            <tr wire:key='{{ $targetResponden->id }}' class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">{{ $targetResponden->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $targetResponden->email }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $targetResponden->role->name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $targetResponden->type }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        {{-- <button wire:click='edit({{ $dimension->id }})'
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </button> --}}
                                        <button
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Delete" wire:click='delete({{ $targetResponden->id }})'
                                            {{-- wire:confirm.prompt='Apakah Anda yakin ingin menghapus dimensi "{{ $dimension->name }}"?\n\nKetik DELETE untuk konfirmasi|DELETE' --}}>
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                        {{-- <div>
                                            <button @click="openModal('modal')"
                                                wire:click='showSubdimensionModal({{ $dimension->id }})'
                                                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                Lihat Subdimensi
                                            </button>
                                        </div> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-2 ">
                    {{ $targetRespondens->links() }}
                </div>
            </div>
        </div>
    </div>
    {{-- @include('livewire.includes.subdimensions-modal') --}}
</div>
