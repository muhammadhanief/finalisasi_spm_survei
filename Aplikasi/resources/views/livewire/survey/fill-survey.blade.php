<div>
    <x-slot:title>Isi Survei</x-slot:title>
    @include('livewire.includes.offline-alert')
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Isi Survei
        </h2>
        {{-- <input wire:model.live='test' type="text" id="fname" name="fname"><br><br>
        <x-button-small color='red' type='submit' wire:click='testing'>Test</x-button-small> --}}
        <div class="flex flex-col  justify-between md:gap-2">
            @include('livewire.includes.fillSurvey.table')
        </div>
    </div>
</div>
