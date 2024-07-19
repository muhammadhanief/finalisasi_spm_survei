<div>
    <x-slot:title>Manajemen Peran</x-slot:title>
    @include('livewire.includes.offline-alert')
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Manajemen Peran
        </h2>
        {{-- <input wire:model.live='test' type="text" id="fname" name="fname"><br><br>
        <x-button-small color='red' type='submit' wire:click='testing'>Test</x-button-small> --}}
        <div class="flex flex-col justify-between md:gap-2">
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 ">
                @include('livewire.role-management.components.search')
                @include('livewire.role-management.components.table')
            </div>
        </div>
    </div>
</div>
