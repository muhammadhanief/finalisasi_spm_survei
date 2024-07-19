<div>
    <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <label class="block text-sm">
            <span class="text-gray-700 dark:text-gray-400">Nama Jawaban</span>
            <p class="text-xs text-gray-700 dark:text-gray-400">*Contoh : Empat tingkat ordinal</p>
            <input wire:model.live='name' type="text" id="name"
                class="block w-full mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="Nama Opsi Jawbaan" />
            <x-error-display name="name" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">
                Tipe Jawaban
            </span>
            <select wire:model.live='type'
                class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="" selected>Pilih Tipe Jawaban</option>
                <option value="text">Teks</option>
                <option value="number">Angka</option>
                <option value="radio">Radio Button</option>
                <option value="checkbox">Check Box</option>
                <option value="dropdown">Dropdown</option>
            </select>
            <x-error-display name="type" />
        </label>
        @if ($type == 'text' || $type == 'number')
        @else
            <div class="p-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <span class="font-medium">Perhatikan!</span> Buat opsi sesuai urutan tingkatan, jangan terbalik. karena
                urutan
                menentukan nilai dari opsi.
            </div>
        @endif
        <x-error-display name="options" />
        @foreach ($options as $key => $option)
            @if (isset($option) && is_array($options))
                <div class="mt-2 text-sm">
                    <label for="question">Opsi ke- {{ $key + 1 }}:</label>
                    <x-button-small color="red" wire:click.prevent="deleteOption({{ $key }})">Hapus
                        Opsi</x-button-small>
                    <x-input-regular wire:model.live='options.{{ $key }}'
                        placeholder="Opsi ke"></x-input-regular>
                    <x-error-display name="options.{{ $key }}" />
                </div>
            @endif
        @endforeach
        @if ($type == 'text' || $type == 'number')
        @else
            <x-button-small color="blue" wire:click.prevent="addOption" type="button">Tambah Opsi
                Jawaban</x-button-small>
        @endif
    </div>
    <x-button-small color="green" wire:click.prevent='create'>Submit</x-button-small>

</div>
