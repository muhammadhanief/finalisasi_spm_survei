<div>
    <x-slot:title>Dimensi</x-slot:title>
    @include('livewire.includes.offline-alert')
    {{-- <x-button-small color='red' wire:click='dd'>
        dd
    </x-button-small> --}}
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dimensi
        </h2>

        {{-- <div><x-button-small color='red' wire:click='dd'>dd</x-button-small></div> --}}
        <div class="flex flex-col justify-between md:gap-2">
            <div class="flex flex-col gap-2 md:flex-row">
                <div class="mb-2 md:w-1/2 md:mb-0">
                    @include('livewire.includes.create-dimension-box')
                </div>
                <div class="mb-2 md:w-1/2 md:mb-0">
                    @include('livewire.includes.create-subdimension-box')
                </div>
            </div>
            @include('livewire.includes.search-box')
        </div>
    </div>
    @script
        <script>
            $wire.on("reloadDimension", (dataPie) => {
                setTimeout(function() {
                    window.location.href = "{{ route('dimensi') }}";
                }, 1500); // Timer harus sama dengan waktu yang digunakan di SweetAlert
            });
        </script>
    @endscript
</div>
