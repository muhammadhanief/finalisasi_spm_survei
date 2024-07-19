<div class="my-4">
    <!-- Tambah Dimensi -->
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Tambah Target Responden (Manual)
    </h4>
    <div class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form>
            <div class="mb-6">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Pilih Role Responden
                    </span>
                    <select wire:model.live='manualRoleId'
                        class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option value="" selected>Pilih Role Responden</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <x-error-display name="manualRoleId" />
                </label>
                <label class="block mt-2 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Pilih Kategori Surel
                    </span>
                    <select wire:model.live='manualType'
                        class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option value="" selected>Pilih Kategori Surel</option>
                        <option value="individual">Surel Individual</option>
                        <option value="group">Surel Grup</option>
                    </select>
                    <x-error-display name="manualType" />
                </label>
                <label class="block mt-2 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nama</span>
                    <input wire:model.live="manualName" type="text" id="manualName" placeholder="Nama"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('manualName')
                        <div class="mt-3 text-xs text-red-600 dark:text-red-400">{{ $message }}</div>
                    @enderror
                </label>
                <label class="block mt-2 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Surel</span>
                    <input wire:model.live="manualEmail" type="text" id="manualEmail" placeholder="Email"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('manualEmail')
                        <div class="mt-3 text-xs text-red-600 dark:text-red-400">{{ $message }}</div>
                    @enderror
                </label>
                @if (session('success'))
                    <span class="mt-3 text-xs text-green-600 dark:text-green-400">{{ session('success') }}</span>
                @endif
            </div>
            <x-button-small wire:click.prevent='addManual' type="submit" color="purple">Submit Target
                Responden
                +</x-button-small>
        </form>
    </div>
</div>
