<div class="container grid px-6 mx-auto">
</div>

<!-- Modal Kirim Surel Pengingat -->
<div x-show="isModalOpen && currentModal === 'reminderModal'" x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
    <!-- Modal -->
    <div x-show="isModalOpen && currentModal === 'reminderModal'" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform translate-y-1/2" @click.away="closeModal"
        @keydown.escape="closeModal"
        class="w-full max-h-screen px-6 py-4 overflow-y-auto bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-lg"
        role="dialog" id="reminderModal">
        <!-- Modal content for reminderModal -->
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
                Kirim surel pengingat survei
                <br>
                Nama survei : {{ $surveyName }}
            </p>
            <p class="text-gray-600 text-md dark:text-gray-400">
                Preview Email
            </p>
            <div class="px-4 py-3 mb-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <p class="text-black break-words text-md dark:text-white">
                    Kepada Hanief dua
                    <br>
                    <br>
                    @if (empty($mailer_narration))
                        Untuk meningkatkan pelayanan Politeknik Statistika STIS, Bapak/Ibu/Saudara dimohon mengisi
                        survei kepuasan berikut ini
                    @else
                        {{ $mailer_narration }}
                    @endif
                    <br>
                    <br>
                    <span class="block text-center">
                        Isi survei
                    </span>

                    <br>
                    <br>
                    Jika tombol tidak berfungsi, klik pada laman berikut
                    <br>
                    <span>
                        <p class="break-words">https://survei-kepuasan.hanief.tech/survei/isi/5/haniefm807PBz</p>
                    </span>
                    <br>
                    Terima kasih,
                    Survei Kepuasan
                </p>
            </div>

            <label class="block mt-4 text-md">
                <span class="text-gray-700 dark:text-gray-400">Narasi Pesan Survei</span>
                <textarea wire:model.live='mailer_narration' id='mailer_narration'
                    class="block w-full mt-1 text-black text-md dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="3" placeholder=""></textarea>
                <x-error-display name="mailer_narration" />
            </label>
            <div class="text-md" wire:loading wire:target="sendEmailReminder">
                <div class="text-red-700 dark:text-red-400" id="progressAlert">
                    Mengirim Surel, mohon tunggu...
                </div>
            </div>
        </div>
        <footer
            class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
            <button @click="closeModal"
                class="w-full px-5 py-3 font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg text-md dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                Batal
            </button>
            <button wire:click="sendEmailReminder"
                wire:confirm="Apakah kamu yakin ingin mengirim email pengingat survei ini?"
                class="w-full px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg text-md sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Kirim
            </button>
        </footer>
    </div>
</div>
