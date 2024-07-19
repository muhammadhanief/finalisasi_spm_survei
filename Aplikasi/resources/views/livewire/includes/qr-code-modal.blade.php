<div class="container grid px-6 mx-auto">
</div>

<!-- Modal Kirim Surel Pengingat -->
<div x-show="isModalOpen && currentModal === 'qrModal'" x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
    <!-- Modal -->
    <div x-show="isModalOpen && currentModal === 'qrModal'" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform translate-y-1/2" @click.away="closeModal"
        @keydown.escape="closeModal"
        class="w-full max-h-screen px-6 py-4 overflow-y-auto bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-lg"
        role="dialog" id="qrModal">
        <!-- Modal content for qrModal -->
        <header class="flex justify-end">
            <button
                class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700"
                aria-label="close" @click="closeModal">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                    <path
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </button>
        </header>
        <!-- Modal body -->
        <div class="mt-4 mb-6">
            <!-- Modal title -->
            <p class="mb-2 text-lg font-semibold text-center text-gray-700 dark:text-gray-300">
                Scan QR Code berikut untuk mengisi survei
                <br>
                Nama survei : {{ $surveyName }}
            </p>
            {{-- {!! QrCode::size(512)->format('png')->merge('/storage/app/logostis.png')->errorCorrection('M')->generate(route('survey.fill', ['surveyID' => $surveyID])) !!} --}}
            <!-- Modal description -->
            <div class="container grid mx-auto">
                <div class="w-full mb-8 overflow-hidden rounded-lg ">
                    <div class="flex items-center justify-center w-full overflow-x-auto">
                        <div class="relative">
                            <!-- QR Code -->
                            {!! QrCode::size(256)->generate(route('survey.fill', ['uuid' => $uuid])) !!}

                            <!-- Logo STIS -->
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <img class="z-10 w-15 h-15" src="{{ asset('img/logostis.png') }}" alt="Logo STIS">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
