<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Nama Survei</span>
        <input wire:model.live='name' type="text" id="name"
            class="block w-full mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Nama Survei" />
        <x-error-display name="name" />
    </label>
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Deskripsi</span>
        <textarea wire:model.live='description' id='description'
            class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
            rows="3" placeholder="Tulis deskripsi Disini. Biasanya tentang pengantar dari survei. "></textarea>
        <x-error-display name="description" />
    </label>
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">
            Kategori dimensi di survei ini
        </span>
        <select wire:model.live='DimensionType'
            class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
            <option value="" selected>Pilih kategori dimensi</option>
            @foreach ($dimensions as $dimension)
                <option value="{{ $dimension->id }}">{{ $dimension->name }}</option>
            @endforeach
        </select>
        <x-error-display name="DimensionType" />
    </label>
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Tahun</span>
        <input wire:model.live='year' type="text" id="year"
            class="block w-full mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Tahun" />
        <x-error-display name="year" />
    </label>
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Jumlah Expected Responden</span>
        <input wire:model.live='expectedRespondents' type="text" id="expectedRespondents"
            class="block w-full mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Expected Responden" />
        <x-error-display name="expectedRespondents" />
    </label>
    <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">
            Kategori Responden
        </span>
        @foreach ($roles as $role)
            <div>
                <Label check>
                    <input wire:model='roleIdParticipant.{{ $role->id }}' type="checkbox"
                        class="text-purple-600 form-checkbox focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray focus:border-purple-400 dark:border-gray-600 dark:focus:border-gray-600 dark:bg-gray-700">
                    <span className="ml-2">{{ $role->name }}</span>
                </Label>
            </div>
        @endforeach
        <x-error-display name="roleIdParticipant" />
    </label>
    {{-- <label class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Batasan Pengisian Per Pengguna</span>
        <input wire:model.live='limitPerParticipant' type="text"
            class="block w-full mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Batasan Pengisian Per Pengguna" />
        <x-error-display name="limitPerParticipant" />
    </label> --}}
    <div class="flex flex-col md:flex-row gap-x-4">
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">
                Waktu Mulai
            </span>
            <input wire:model.live='startAt'
                class="block mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                type="datetime-local">
            <x-error-display name="startAt" />
        </label>
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">
                Waktu Berakhir
            </span>
            <input wire:model.live='endAt'
                class="block mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                type="datetime-local">
            <x-error-display name="endAt" />
        </label>
    </div>

</div>
