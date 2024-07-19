<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 ">
    <h4 class="mt-4 mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Cari Responden
    </h4>
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
                    wire:model.live.debounce.500ms="search" type="text" placeholder="Cari Responden" />
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
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3">Tipe</th>
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
                                    @if ($targetResponden->submitted >= 1)
                                        @if ($targetResponden->type == 'group')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                Minimal 1x Mengisi
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                Telah Mengisi
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                            Belum Mengisi
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $targetResponden->role->name }}
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    {{ $targetResponden->type }}

                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-2">
                    {{ $targetRespondens->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
