<div class="pb-16 md:pb-32">
    <x-slot:title>Buat Survei</x-slot:title>

    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Buat Survei
        </h2>
        <h4 class="mb-4 text-lg font-semibold text-center text-gray-600 dark:text-gray-300">
            Bagaimana Anda akan membuat survei?
        </h4>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <a href="{{ route('survey.create') }}"
                class="min-w-0 p-4 transition duration-500 ease-in-out transform bg-white rounded-lg shadow-xs hover:bg-slate-100 hover:scale-105 dark:bg-gray-800 dark:hover:bg-gray-700">
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                    Mulai dari Awal
                </h4>
                <p class="text-gray-600 dark:text-gray-400">
                    Pilih menu ini jika belum pernah ada survei yang sama di tahun sebelumnya.
                </p>
                {{-- >Buat Survei Baru --}}
            </a>

            <a href="{{ route('survey.copy') }}"
                class="min-w-0 p-4 text-white transition duration-500 ease-in-out transform bg-purple-600 rounded-lg shadow-xs dark:hover:bg-purple-500 hover:bg-purple-700 hover:scale-105">
                <h4 class="mb-4 font-semibold">
                    Salin Survei yang Sudah Ada
                </h4>
                <p>
                    Pilih menu ini jika sudah ada survei yang sama di tahun sebelumnya.
                    Anda tetap bisa mengedit pertanyaan yang ada pada survei sebelumnya.
                </p>
            </a>
        </div>
    </div>
</div>
