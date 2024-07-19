<div id="targetDiv" class="pb-16 md:pb-32">
    <x-slot:title>Isi Survei</x-slot:title>
    <div class="container grid px-6 mx-auto">
        <div class="w-full max-w-3xl mx-auto" wire:key="{{ $currentSectionIndex }}">
            {{-- <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                <x-button-small wire:click.prevent='dd' color='red'>DD</x-button-small>
            </h2> --}}
            @if ($currentSectionIndex == -1)
                @include('livewire.includes.fillSurvey.overview-fill')
            @else
                @include('livewire.includes.fillSurvey.section', [
                    'section' => $survey->sections[$currentSectionIndex],
                ])
            @endif
            <!-- Tombol navigasi -->
            <div class="flex justify-start gap-4">
                <div wire:click="previousSection" style="cursor: pointer;"
                    class="{{ $currentSectionIndex < 0 ? 'hidden' : '' }} px-6 py-2 bg-white rounded-lg shadow-md dark:bg-gray-800 text-purple-900 dark:text-purple-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <button>
                        Kembali
                    </button>
                </div>
                <div @click="scrollTo('#targetDiv')" wire:click="nextSection" style="cursor: pointer;"
                    class="{{ $currentSectionIndex >= count($survey->sections) - 1 ? 'hidden' : '' }} px-6 py-2 bg-white rounded-lg shadow-md dark:bg-gray-800 text-purple-900 dark:text-purple-500 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <button>
                        Berikutnya
                    </button>
                </div>
                @if ($currentSectionIndex == count($survey->sections) - 1)
                    <div wire:click.prevent='create' type='submit' style="cursor: pointer;"
                        class="px-6 py-2 text-white bg-purple-900 rounded-lg shadow-md dark:text-gray-800 dark:bg-purple-500 hover:bg-purple-600 dark:hover:bg-purple-700">
                        <button>
                            Submit
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // window.addEventListener('beforeunload', function(event) {
    //     event.preventDefault();
    //     event.returnValue = "Apakah Anda yakin ingin meninggalkan halaman ini?";
    // });

    function scrollTo(targetSelector) {
        const targetElement = document.querySelector(targetSelector);
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }
</script>
