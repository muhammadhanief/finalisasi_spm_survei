<div class="w-full">
    <!-- Tambah Dimensi -->
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        Tambah Dimensi
    </h4>
    <div class="px-4 py-3 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form>
            <div class="mb-2">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                        Pilih Kategori Dimensi
                    </span>
                    <div class="py-2" wire:ignore>
                        <select wire:model.live='dimensionID' id="dimensionID"
                            class="block w-full mt-1 text-sm text-black select2 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="" selected>Pilih Kategori Dimensi</option>
                            @foreach ($dimensionsNotPaginate as $dimension)
                                <option value="{{ $dimension->id }}">{{ $dimension->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-error-display name="dimensionID" />
                    @script
                        <script>
                            $(document).ready(function() {
                                var selectElement = $('#dimensionID');
                                selectElement.select2();
                                // Fungsi untuk mereset Select2 ke keadaan default
                                function resetSelect2() {
                                    selectElement.val(null).trigger('change');
                                }
                                // Mendengarkan Livewire untuk mereset dimensionID
                                $wire.on('resetDimensionID', function() {
                                    resetSelect2();
                                });
                                selectElement.on('change', function() {
                                    var data = $('#dimensionID').select2("val");
                                    $wire.set('dimensionID', data);
                                });
                            });
                        </script>
                    @endscript
                </label>
                <label class="block mt-2 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Nama Dimensi</span>
                    <input wire:model.live="subdimensionName" type="text" id="subdimensionName"
                        placeholder="Nama Dimensi"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('subdimensionName')
                        <div class="mt-3 text-xs text-red-600 dark:text-red-400">{{ $message }}</div>
                    @enderror
                </label>
                <label class="block mt-2 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Deskripsi Dimensi</span>
                    <input wire:model.live="subdimensionDescription" type="text" id="subdimensionDescription"
                        placeholder="Deskripsi Dimensi"
                        class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                    @error('subdimensionDescription')
                        <div class="mt-3 text-xs text-red-600 dark:text-red-400">{{ $message }}</div>
                    @enderror
                </label>
                @if (session('success'))
                    <span class="mt-3 text-xs text-green-600 dark:text-green-400">{{ session('success') }}</span>
                @endif
                <x-button-small class="mt-4" wire:click.prevent='createSubdimension' type="submit"
                    color="purple">Tambah Dimensi
                    +</x-button-small>
            </div>

        </form>
    </div>
</div>
