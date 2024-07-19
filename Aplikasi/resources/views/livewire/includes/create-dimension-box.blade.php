<div class="w-full">
    <!-- Tambah Dimensi -->
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Buat Kategori Dimensi
    </h4>
    <div class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form>
            <div class="mb-2">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nama Kategori Dimensi</span>
                    <input wire:model.live="name" type="text" id="name" placeholder="Nama Dimensi"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('name')
                        <div class="mt-3 text-xs text-red-600 dark:text-red-400">{{ $message }}</div>
                    @enderror
                </label>
                <label class="block mt-2 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Deskripsi Kategori Dimensi</span>
                    <input wire:model.live="description" type="text" id="description" placeholder="Deskripsi Dimensi"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('description')
                        <div class="mt-3 text-xs text-red-600 dark:text-red-400">{{ $message }}</div>
                    @enderror
                </label>

                @if (session('success'))
                    <span class="mt-3 text-xs text-green-600 dark:text-green-400">{{ session('success') }}</span>
                @endif

                <x-button-small class="mt-4" wire:click.prevent='create' type="submit" color="purple">Buat Kategori
                    Dimensi
                    +</x-button-small>
            </div>
        </form>
    </div>

</div>
