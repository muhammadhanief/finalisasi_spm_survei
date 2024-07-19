<div class="pb-16 md:pb-32">

    <x-slot:title>Monitoring Survei</x-slot:title>
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Monitoring Survei
        </h2>
        <table class="pt-2 text-xl">
            <tr>
                <td class="align-top">
                    Judul Survei
                </td>
                <td>
                    :{{ $survey->name }}
                </td>
            </tr>
            <tr>
                <td class="align-top">Tahun </td>
                <td>:{{ $survey->year }}</td>
            </tr>
        </table>
        <div class="flex flex-row items-center gap-2 py-2">
            <x-button-small-0 color='blue' wire:click='updateAll'>Klik untuk perbarui</x-button-small-0>
            <p class="text-sm text-gray-700 dark:text-gray-400">Terakhir diperbarui pukul {{ $lastUpdatedTime }}</p>
        </div>
        <div class="flex flex-col gap-6 mb-8 md:flex-row">
            <div class="p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Progres Pengisian
                </h4>
                {{-- <div class="chart-container"> --}}
                <div class="chart-container">
                    <canvas wire:ignore id="monitoringChart"></canvas>
                </div>
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
                <!-- Card -->
                <div class="flex items-center w-full h-full p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <svg fill="currentColor" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4a1 1 0 1 0-2 0v4c0 .3.1.5.3.7l3 3a1 1 0 0 0 1.4-1.4L13 11.6V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Tanggal Dimulai
                        </p>
                        {{-- <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($survey->started_at)->translatedFormat('d F Y H:i') }}
                        </p> --}}
                        <input wire:model.live='startAt'
                            class="block mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            type="datetime-local">
                        <x-error-display name="startAt" />
                        <div>
                            <x-button-small-0 color='blue' class="my-1 mt-2"
                                wire:click='updateStartAt'>Perbarui</x-button-small-0>
                        </div>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center w-full h-full p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                        <svg fill="currentColor" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4a1 1 0 1 0-2 0v4c0 .3.1.5.3.7l3 3a1 1 0 0 0 1.4-1.4L13 11.6V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Tanggal Berakhir
                        </p>
                        {{-- <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($survey->ended_at)->translatedFormat('d F Y H:i') }}
                        </p> --}}
                        <input wire:model.live='endAt'
                            class="block mt-1 text-sm text-black dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            type="datetime-local">
                        <x-error-display name="endAt" />
                        <x-button-small-0 color='blue' class="my-1 mt-2"
                            wire:click='updateEndAt'>Perbarui</x-button-small-0>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center w-full h-full p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div
                        class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Harapan Total Responden
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            <input wire:model.live='expectedRespondents'
                                class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                placeholder="Masukkan angka" value={{ $expectedRespondents }} />
                            <x-error-display name="expectedRespondents" />
                        <div class="flex flex-col">
                            <div>
                                <x-button-small-0 color='blue' class="my-1 mt-2"
                                    wire:click='updateExpectedResponden'>Perbarui</x-button-small-0>
                            </div>
                            <div>
                                <x-button-small-0 color='green' class="my-1" wire:click='downloadAnswers'>Unduh
                                    Fail Respon</x-button-small-0>
                                <div wire:loading role="status"
                                    class="flex items-center justify-center pt-2 text-blue-500">
                                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                        role="alert">
                                        <span class="font-medium">Sedang memuat data!</span> Mohon tunggu beberapa saat.
                                    </div>
                                </div>
                            </div>
                        </div>
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center w-full h-full p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <svg fill="currentColor" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4a1 1 0 1 0-2 0v4c0 .3.1.5.3.7l3 3a1 1 0 0 0 1.4-1.4L13 11.6V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Tautan Survei
                        </p>
                        {{-- <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            <a id="linkSurvey"
                                href="{{ route('survey.fill', ['surveyID' => $surveyID, 'uniqueCode' => $surveyID]) }}">
                                {{ route('survey.fill', ['surveyID' => $surveyID, 'uniqueCode' => $surveyID]) }}
                            </a>
                            <input type="text" value="Hello World" id="myInput">
                        </p> --}}
                        <label class="block text-sm">

                            <input disabled value="{{ route('survey.fill', ['uuid' => $uuid]) }}" type="text"
                                id="linkSurvey"
                                class="w-full pr-20 my-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input">
                        </label>

                        <div class="flex flex-col gap-2">
                            <div>
                                <x-button-small-0 wire:click="copyLink" color='blue'>Salin
                                    Tautan</x-button-small-0>
                            </div>

                            {{-- <div @click="openModal('reminderModal')">
                                <x-button-small-0 color='green'>Kirim Email
                                    pengingat</x-button-small-0>
                            </div> --}}
                            <!-- Tampilkan QR Code jika sudah di-generate -->
                            <div @click="openModal('qrModal')">
                                <x-button-small-0 color='green'>Qr-Code</x-button-small-0>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="gap-6 mb-8 ">
            <div class="p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Resampling
                </h4>
                <label class="block pb-2 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Progress Pengisian Saat ini</span>
                    <p
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                        {{ $currentRespondentsPercent }}%</p>
                </label>
                <label class="block pb-2 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Perkiraan Progress Pengisian Setelah data
                        dibangkitkan</span>
                    <p
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                        {{ $afterRespondentsPercent }}%</p>
                </label>
                <label class="block pb-2 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Jumlah data yang akan dibangkitkan. Saran agar data
                        menjadi 100% : {{ $fullyData }}</span>
                    <input wire:model.live='resamplingData'
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Masukkan angka banyak data" />
                    <x-error-display-mt1 name="resamplingData" />
                </label>
                <x-button-small class=""
                    wire:confirm='Anda yakin ingin resampling? tindakan ini tidak bisa diurungkan'
                    wire:click='generateResampling' type="submit" color="red">Bangkitkan
                    data
                </x-button-small>

            </div>
        </div> --}}

        {{-- @include('livewire.includes.monitoring.table') --}}
        @script
            {{-- @push('js') --}}
            <script>
                const data = {
                    labels: @json(array_keys($dataChartIndividual)),
                    datasets: [{
                        data: @json(array_values($dataChartIndividual)),
                        // backgroundColor: ["#0694a2", "#1c64f2", "#7e3af2"],
                        label: "Dataset 1",
                        borderWidth: 1,
                    }]

                }

                // Hitung total
                const total = data.datasets[0].data.reduce((acc, curr) => acc + curr);

                // Tetapkan persentase yang tepat
                const percentage = Math.round((data.datasets[0].data[0] / total) * 100);
                const text = `${percentage}% Telah Mengisi`;

                // config
                const config = {
                    type: 'doughnut',
                    data,
                    // plugins: [doughnutLabel],
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text,
                                font: {
                                    size: 20,
                                }
                            },

                        }
                    }

                }

                // render init block
                var ctx = document.getElementById('monitoringChart'); // node
                var ctx = document.getElementById('monitoringChart').getContext('2d'); // 2d context
                // ctx.canvas.width = 700; // Sesuaikan dengan lebar yang diinginkan
                // ctx.canvas.height = 400; // Sesuaikan dengan tinggi yang diinginkan
                var monitoringChart = new Chart(
                    ctx, config
                );

                var canvas = monitoringChart.canvas;

                // realtime update
                $wire.on('chartUpdated', (dataChartIndividual) => {
                    // Ambil label dan data dari objek
                    const dataObject = dataChartIndividual[0];
                    const labels = Object.keys(dataObject);
                    const data = Object.values(dataObject);

                    monitoringChart.data.labels = labels;
                    monitoringChart.data.datasets[0].data = data;
                    monitoringChart.options.plugins.title.text =
                        `${Math.round((data[0] / data.reduce((acc, curr) => acc + curr)) * 100)}% Telah Mengisi`;
                    monitoringChart.update();
                });

                $wire.on('copyLink', (link) => {
                    var copyText = document.getElementById("linkSurvey");
                    copyText.focus();
                    copyText.select();
                    console.log(copyText.value);
                    copyText.setSelectionRange(0, 99999); // For mobile devices
                    navigator.clipboard.writeText(copyText.value);
                    $wire.$dispatch('alert_copied')
                });
            </script>
            {{-- @endpush --}}
        @endscript
    </div>
    @include('livewire.includes.qr-code-modal')
    @include('livewire.includes.send-email-modal')
</div>
