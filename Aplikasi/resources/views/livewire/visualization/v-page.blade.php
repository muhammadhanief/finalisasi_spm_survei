<div class="pb-16 md:pb-32">
    @php
        use Carbon\Carbon;
    @endphp
    <x-slot:title>Visualisasi</x-slot:title>
    @include('livewire.includes.offline-alert')
    {{-- <x-button-small-0 color='red' wire:click='dd'>DD</x-button-small-0> --}}

    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Visualisasi
        </h2>
        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Analisis Gap antara Harapan dengan Kenyataan
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                    Pilih Survei
                </span>
                <select wire:model.live='surveyID'
                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option value="" selected>Pilih Survei</option>
                    @foreach ($surveys as $survey)
                        <option value="{{ $survey->id }}">{{ $survey->name }}</option>
                    @endforeach
                </select>
                <x-error-display name="surveyID" />
                <div wire:loading wire:target='updatedsurveyID, perbaruisurveyIDLive' role="status"
                    class="flex items-center justify-center pt-2 text-blue-500">
                    <div class="flex flex-row items-center gap-4 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                        role="alert">
                        <div role="status">
                            <svg aria-hidden="true"
                                class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-purple-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="flex flex-col">
                            <div>
                                <span class="font-medium">Mengolah data survei</span>. Mohon tunggu
                                beberapa
                                saat...
                            </div>
                            <div>
                                Maaf yaa lama 🙏🏻, datanya ribuan 🫠
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mb-4 sm:gap-4 sm:flex-row" wire:loading.remove
                    wire:target='updatedsurveyID, perbaruisurveyIDLive'>
                    @if ($dateUpdatedSurveyData != null)
                        <div role="status" class="flex items-center justify-start pt-2 text-blue-500">
                            <div class="flex flex-row items-center gap-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                <div class="flex flex-col">
                                    <div>
                                        <span class="font-medium">Data terakhir kali diperbarui </span>
                                        @if ($dateUpdatedSurveyData)
                                            {{ Carbon::parse($dateUpdatedSurveyData)->translatedFormat('d F Y \P\u\k\u\l H.i') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="status" class="flex items-center justify-start pt-2 text-blue-500">
                            <div class="flex flex-row items-center gap-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                <div class="flex flex-col">
                                    <div class="flex flex-row gap-2">
                                        <span class="font-medium">Ingin data <span
                                                class="italic">realtime</span>?</span>
                                        <p class="underline hover:cursor-pointer" wire:click='perbaruisurveyIDLive'>Klik
                                            disini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>



                {{-- <div>
                    <div class="py-2" wire:ignore>
                        <select wire:model.live='surveyID' id="surveyID"
                            class="block w-full mt-1 text-sm text-black select2 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <option value="" selected>Pilih Survei</option>
                            @foreach ($surveys as $survey)
                                <option value="{{ $survey->id }}">{{ $survey->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-error-display name="surveyID" />
                    <x-button-small-0 class="mt-2" color='green'
                        wire:click='generateChart'>Generate</x-button-small-0>
                </div> --}}
                <div wire:loading.remove wire:target='updatedsurveyID, perbaruisurveyIDLive'
                    class="{{ $surveyID ? '' : 'hidden' }}">
                    <div class="flex flex-col justify-around py-2 my-2 md:flex-row gap-y-6">
                        <div wire:ignore class="border-2 rounded-lg border-slate-200 chart-container md:w-2/5">
                            <canvas id="monitoringChart"></canvas>
                        </div>
                        <div class="border-2 rounded-lg border-slate-200 md:w-2/5 " wire:ignore id="chartContainer">
                            <canvas id="chart3"></canvas>
                        </div>
                    </div>
                    {{-- <p>odading</p> --}}
                    <div class="flex flex-col justify-around py-2 my-2 md:px-14 md:flex-row">
                        <div class="border-2 rounded-lg border-slate-200 md:w-full" wire:ignore id="quadrantsContainer">
                            <canvas id="quadrantsChart"></canvas>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 pb-4 sm:flex-row md:px-14">
                        <div>
                            <x-button-small-0 class="mt-2" id="radar-download" color='green'>Download Diagram
                                Radar</x-button-small-0>
                        </div>
                        <div>
                            <x-button-small-0 class="mt-2" id="stacked-download" color='green'>Download Diagram
                                Batang</x-button-small-0>
                        </div>
                        <div>
                            <x-button-small-0 class="mt-2" id="ipa-download" color='green'>Download Grafik
                                IPA</x-button-small-0>
                        </div>
                    </div>

                    @if ($dataDeskripsi != null)
                        <div class="flex justify-center md:px-14 text-md">
                            <div
                                class="min-w-0 p-4 py-2 my-2 bg-white border-2 rounded-lg border-slate-200 md:w-full dark:bg-gray-800">
                                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                                    Deskripsi
                                </h4>
                                <p class="text-justify text-gray-600 indent-8 dark:text-gray-400">
                                    {{ $dataDeskripsi['surveyName'] }} dilakukan pada tahun
                                    {{ $dataDeskripsi['surveyYear'] }} dengan jumlah
                                    responden
                                    {{ $dataDeskripsi['respondenCount'] }} orang dan target
                                    jumlah responden
                                    {{ $dataDeskripsi['expectedRespondents'] }} orang. Berikut
                                    adalah hasil analisis gap antara harapan dengan kinerja.
                                </p>
                                <p class="text-justify text-gray-600 indent-8 dark:text-gray-400">
                                </p>
                                <ul class="ml-8 list-disc">
                                    @foreach ($dataDeskripsi['dimensionData']['labels'] as $key => $labels)
                                        <li class="text-justify text-gray-600 dark:text-gray-400">
                                            Dimensi {{ $labels }} memiliki nilai harapan sebesar
                                            {{ number_format($dataDeskripsi['dimensionData']['datasets'][0]['data'][$key], 2, ',', '.') }}
                                            sedangkan nilai kenyataan sebesar
                                            {{ number_format($dataDeskripsi['dimensionData']['datasets'][1]['data'][$key], 2, ',', '.') }}.
                                        </li>
                                    @endforeach
                                    <li class="text-justify text-gray-600 dark:text-gray-400">
                                        Gap tertinggi terdapat pada dimensi {{ $dataDeskripsi['maxGap']['label'] }}
                                        dengan
                                        nilai
                                        {{ number_format($dataDeskripsi['maxGap']['value'], 2, ',', '.') }}
                                        sedangkan
                                        gap
                                        terendah terdapat pada dimensi
                                        {{ $dataDeskripsi['minGap']['label'] }} dengan nilai
                                        {{ number_format($dataDeskripsi['minGap']['value'], 2, ',', '.') }}.
                                    </li>
                                    <li class="text-justify text-gray-600 dark:text-gray-400">
                                        Gap rata-rata sebesar
                                        {{ number_format(abs($dataDeskripsi['gapKeseluruhan']), 2, ',', '.') }}.
                                    </li>
                                </ul>
                            </div>

                        </div>
                    @endif
                </div>


        </div>


        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            Analisis Harapan dan Kepuasan pada masing-masing dimensi
        </h4>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="{{ $surveyID ? '' : 'hidden' }}">

                @if ($modelDimensionofSurvei != null)
                    <span class="text-gray-700 dark:text-gray-400">
                        Pilih dimensi
                    </span>
                    <select wire:model.live='subDimension'
                        class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <option value="" selected>Pilih Dimensi</option>
                        @foreach ($subdimensions as $subdimension)
                            @if ($subdimension->dimension_id == $modelDimensionofSurvei->id)
                                @if ($subdimension->name == 'Umum')
                                @else
                                    <option value="{{ $subdimension->id }}">{{ $subdimension->name }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                    <x-error-display name="subDimension" />
                    {{-- <x-button-small-0 class="mt-2" color='green'
                        wire:click='generatePieChartDimension'>Generate</x-button-small-0> --}}
                @endif
            </div>
            <div wire:loading.remove wire:target='updatedsubDimension'
                class="{{ $subDimension && $surveyID ? '' : 'hidden' }}">
                <div class="pt-4 text-center">
                    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                        Dimensi
                        @if ($judulsubDimension != null)
                            {{ $judulsubDimension }}
                        @endif
                    </h4>
                </div>

                <div class="flex flex-col justify-around py-2 my-2 md:flex-row">
                    <div class="chart-container md:w-2/5">
                        <canvas wire:ignore id="pieChartHarapan"></canvas>
                        <div class="flex items-center justify-center">
                            <x-button-small-0 class="mt-2" id="harapan-download" color='green'>Download Diagram
                                Harapan</x-button-small-0>
                        </div>
                    </div>
                    <div class="md:w-2/5" wire:ignore id="chartContainer">
                        <canvas id="pieChartKenyataan"></canvas>
                        <div class="flex items-center justify-center">
                            <x-button-small-0 class="mt-2" id="kenyataan-download" color='green'>Download Diagram
                                Kenyataan</x-button-small-0>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let status = @json(session('status'));
            if (status) {
                Swal.fire({
                    title: `Jawaban anda telah dikumpulkan`,
                    text: `Terima kasih telah mengisi survei`,
                    icon: 'info',
                    confirmButtonText: 'OK',
                });
            }
        });
    </script>

    @script
        <script>
            $(document).ready(function() {
                $("#surveyID").select2();
                $("#surveyID").on("change", function() {
                    var data = $("#surveyID").select2("val");
                    $wire.surveyID = data;
                });
            });

            // BEGINNING radar chart
            const data = {
                labels: [],
                datasets: [{
                        label: "My First Dataset",
                        backgroundColor: "rgba(255, 99, 132, 0)", // transparan
                        borderColor: "rgba(255, 99, 132, 1)", // warna garis
                        borderWidth: 2,
                    },
                    {
                        label: "My Second Dataset",
                        backgroundColor: "rgba(54, 162, 235, 0)", // transparan
                        borderColor: "rgba(54, 162, 235, 1)", // warna garis
                        borderWidth: 2,
                    },
                ],
            };

            const config = {
                type: "radar",
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "bottom",
                            onClick: null,
                        },
                        title: {
                            display: true,
                            text: "Diagram Radar",
                            font: {
                                size: 20,
                            },
                        },
                    },
                    scales: {
                        r: {
                            angleLines: {
                                display: false,
                            },
                            suggestedMin: 0,
                            suggestedMax: 4,
                        },
                    },
                },
            };
            var ctx = document.getElementById("monitoringChart"); // node
            var ctx = document.getElementById("monitoringChart").getContext("2d"); // 2d context
            // ctx.canvas.width = 700; // Sesuaikan dengan lebar yang diinginkan
            // ctx.canvas.height = 700; // Sesuaikan dengan tinggi yang diinginkan
            var radarChart = new Chart(ctx, config);
            var canvas = radarChart.canvas;
            // END of radar chart



            // BEGINING  stacKed bar chart
            const labels2 = ["Harapan", "Kenyataan"];
            const data2 = {
                labels: labels2,
                datasets: [{
                        label: "Nilai",
                    },
                    {
                        label: "Gap",
                    },
                ],
            };
            const config2 = {
                type: "bar",
                data: data2,
                options: {
                    indexAxis: "y",
                    plugins: {
                        legend: {
                            position: "bottom",
                            onClick: null,
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: ["Diagram Batang", "Harapan Kenyataan dan Gap"],
                            // fullSize: false,
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = ((value * 100) / sum).toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + "%";
                                return percentage;
                            },
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold',
                                        size: 12,
                                    }
                                },
                            },
                            color: 'black',
                        },
                    },
                    responsive: true,
                    // maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            min: 0,
                            max: 4,
                        },
                        y: {
                            stacked: true,
                        },
                    },
                },
                plugins: [ChartDataLabels],
            };
            var ctx3 = document.getElementById("chart3").getContext("2d");
            var stackedGapChart = new Chart(ctx3, config2);
            // END of stacked bar chart

            // BEGINING QUADRANTS CHART
            const quadrantsData2 = {
                datasets: [{
                    label: "Dataset 1",
                    data: [],
                    borderColor: "red", // 'rgb(255, 99, 132)
                    backgroundColor: "red", // 'rgb(255, 99, 132)
                }, ],
            };

            let dataQuadrantsAxisXObject = 0; // Misalnya, nilai awal
            let dataQuadrantsAxisYObject = -0;

            const quadrants = {
                id: "quadrants",
                beforeDraw(chart, args, options) {
                    const {
                        ctx,
                        chartArea: {
                            left,
                            top,
                            right,
                            bottom
                        },
                        scales: {
                            x,
                            y
                        },
                    } = chart;
                    const midX = x.getPixelForValue(dataQuadrantsAxisXObject);
                    const midY = y.getPixelForValue(dataQuadrantsAxisYObject);
                    ctx.save();
                    ctx.fillStyle = options.topLeft;
                    ctx.fillRect(left, top, midX - left, midY - top);
                    ctx.fillStyle = options.topRight;
                    ctx.fillRect(midX, top, right - midX, midY - top);
                    ctx.fillStyle = options.bottomRight;
                    ctx.fillRect(midX, midY, right - midX, bottom - midY);
                    ctx.fillStyle = options.bottomLeft;
                    ctx.fillRect(left, midY, midX - left, bottom - midY);
                    ctx.restore();
                },
            };

            const containerWidth = document.querySelector('#quadrantsChart').parentElement.offsetWidth;
            const paddingValue = containerWidth * 0.1;
            // console.log(containerWidth, paddingValue);


            const quadrantsConfig = {
                type: "scatter",
                data: quadrantsData2,
                options: {
                    layout: {
                        padding: {
                            left: paddingValue,
                            right: paddingValue,
                            // top: 50,
                            // bottom: 50
                        }
                    },
                    aspectRatio: 1, // Menentukan rasio aspek grafik
                    maintainAspectRatio: false, // Menonaktifkan pemeliharaan rasio aspek
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Kenyataan'
                            },
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Harapan'
                            },
                        }
                    },
                    plugins: {
                        subtitle: {
                            display: true,
                            text: '*Nilai yang tertera adalah gap',
                            position: 'bottom',
                            align: 'start',
                            // color: 'red',
                            padding: {
                                top: 0,
                                bottom: 10,
                            }
                        },
                        legend: {
                            position: "bottom",
                            display: false,
                            onClick: null,
                        },
                        quadrants: {
                            topLeft: `hsl(0, 100%, 50%)`, // Misalnya menggunakan hue 0 (merah), saturation 100%, lightness 50%
                            bottomRight: `hsl(120, 100%, 50%)`, // Misalnya menggunakan hue 120 (hijau), saturation 100%, lightness 50%
                            bottomLeft: `hsl(60, 100%, 50%)`, // Misalnya menggunakan hue 60 (kuning), saturation 100%, lightness 50%
                            topRight: `hsl(200, 100%, 50%)`, // Misalnya menggunakan hue 240 (biru), saturation 100%, lightness 50%
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: "Grafik Importance Performance Analysis (IPA)",
                        },
                        tooltip: {
                            enabled: true,
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                const dataArr = ctx.chart.data.datasets;
                                const dataIndex = ctx.dataIndex;
                                const xValue = dataArr[ctx.datasetIndex].data[dataIndex].x;
                                const yValue = dataArr[ctx.datasetIndex].data[dataIndex].y;
                                const dimensionName = dataArr[ctx.datasetIndex].label ||
                                    ""; // Mendapatkan nama dimensi dari label dataset atau mengatur default value ke string kosong jika tidak ada label
                                const absoluteDifference = Math.abs(xValue - yValue);
                                const formattedValue = absoluteDifference.toLocaleString('id-ID', {
                                    minimumFractionDigits: 2
                                });
                                return `${dimensionName}: ${formattedValue}`; // Menggabungkan nama dimensi dengan nilai yang diformat
                            },
                            backgroundColor: 'white', // Set background color of labels to create outline effect
                            borderColor: 'black', // Set border color to create outline effect
                            borderWidth: 1,
                            align: 'right',
                            rotation: 0,
                            // anchor: 'end',
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold',
                                        size: 12,
                                    }
                                },
                            },
                            color: 'black',
                        }
                    },
                },
                plugins: [ChartDataLabels, quadrants],
            };
            var quadrantsCtx = document.getElementById("quadrantsChart").getContext("2d");
            var quadrantsChart = new Chart(quadrantsCtx, quadrantsConfig);
            // END of QUADRANTS CHART

            // START OF PIE CHART
            // pie chart harapan

            const dataPieHarapan = {
                labels: ["Label 1", "Label 2", "Label 3"],
                datasets: [{
                    label: "Jumlah Responden",
                    data: [],
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(54, 162, 235)",
                        "rgb(255, 205, 86)",
                    ],
                    hoverOffset: 4,
                }, ],
            };

            const configPieHarapan = {
                type: "doughnut",
                data: dataPieHarapan,
                options: {
                    plugins: {
                        legend: {
                            position: "bottom",
                            onClick: null,
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: "Diagram Pie Harapan",
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = ((value * 100) / sum).toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + "%";
                                return percentage;
                            },
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold',
                                        size: 12,
                                    }
                                },
                            },
                            color: 'black',
                        }
                    },

                },
                plugins: [ChartDataLabels],
            };
            var ctxPieHarapan = document.getElementById("pieChartHarapan").getContext("2d");
            var pieChartHarapan = new Chart(ctxPieHarapan, configPieHarapan);

            // pie chart kenyataan
            const dataPieKenyataan = {
                labels: ["Label 1", "Label 2", "Label 3"],
                datasets: [{
                    label: "Jumlah Responden",
                    data: [],
                    hoverOffset: 4,
                }, ],
            };
            const configPieKenyataan = {
                type: "doughnut",
                data: dataPieKenyataan,
                options: {
                    plugins: {
                        legend: {
                            position: "bottom",
                            onClick: null,
                        },
                        title: {
                            display: true,
                            font: {
                                size: 20,
                            },
                            text: "Diagram Pie Kenyataan",
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += data;
                                });
                                let percentage = ((value * 100) / sum).toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + "%";
                                return percentage;
                            },
                            labels: {
                                title: {
                                    font: {
                                        weight: 'bold',
                                        size: 12,
                                    }
                                },
                            },
                            color: 'black',
                        }
                    },
                },
                plugins: [ChartDataLabels],
            };
            var ctxPieKenyataan = document.getElementById("pieChartKenyataan").getContext("2d");
            var pieChartKenyataan = new Chart(ctxPieKenyataan, configPieKenyataan);
            // END OF PIE CHART

            // FOR LIVEWIRE UPDATE
            // for analisis gap
            $wire.on("chartUpdated", (dataGap) => {
                // For radar chart
                // dataObject = dataGap[0]["radar"];
                // const datanya = dataObject;
                // radarChart.data = datanya;
                // radarChart.update();
                const dataObject = dataGap[0]["radar"];
                radarChart.data = {
                    labels: dataObject.labels,
                    datasets: [{
                            label: "Harapan",
                            backgroundColor: "rgba(0, 0, 0, 0)", // transparan
                            borderColor: "rgba(54, 162, 235, 1)", // warna garis
                            borderWidth: 2,
                            data: dataObject.datasets[0].data,
                        },
                        {
                            label: "Kenyataan",
                            backgroundColor: "rgba(0, 0, 0, 0)", // transparan
                            borderColor: "rgba(255, 99, 132, 1)", // warna garis
                            borderWidth: 2,
                            data: dataObject.datasets[1].data,
                        },
                    ],
                };
                radarChart.update();
                // For stacked bar chart
                dataStackedObject = dataGap[0]["stackedBarGap"];
                const datanyaStacked = dataStackedObject;
                stackedGapChart.data.datasets[0].data = datanyaStacked[0]; // ini untuk data asli
                stackedGapChart.data.datasets[1].data = datanyaStacked[1]; // ini untuk data gap
                xScalesAxisMax = datanyaStacked[0][1] + datanyaStacked[1][1];
                stackedGapChart.options.scales.x.max = xScalesAxisMax;
                stackedGapChart.update();
                // For quadrants chart
                dataQuadrantsObject = dataGap[0]["quadrants"]["data"];
                const datanyaQuadrants = dataQuadrantsObject;
                quadrantsChart.data = datanyaQuadrants;
                dataQuadrantsAxisXObject = dataGap[0]["quadrants"]["axis"]["midX"];
                dataQuadrantsAxisYObject = dataGap[0]["quadrants"]["axis"]["midY"];
                // Inisialisasi nilai minimum dan maksimum untuk skala x dan y
                let minX = Infinity;
                let maxX = -Infinity;
                let minY = Infinity;
                let maxY = -Infinity;
                // Iterasi melalui setiap dataset
                quadrantsChart.data.datasets.forEach(dataset => {
                    // Iterasi melalui setiap titik data dalam dataset
                    dataset.data.forEach(point => {
                        // Periksa dan update nilai minimum dan maksimum untuk sumbu x
                        if (point.x < minX) minX = point.x;
                        if (point.x > maxX) maxX = point.x;
                        // Periksa dan update nilai minimum dan maksimum untuk sumbu y
                        if (point.y < minY) minY = point.y;
                        if (point.y > maxY) maxY = point.y;
                    });
                });
                // Tambahkan atau kurangi 0.01 dari nilai minimum dan maksimum untuk skala x dan y
                minX -= 0.01;
                maxX += 0.01;
                minY -= 0.01;
                maxY += 0.01;
                // Bulatkan nilai minimum dan maksimum ke nilai terdekat yang lebih rendah atau lebih tinggi
                minX = Math.floor(minX / 0.05) * 0.05;
                maxX = Math.ceil(maxX / 0.05) * 0.05;
                minY = Math.floor(minY / 0.05) * 0.05;
                maxY = Math.ceil(maxY / 0.05) * 0.05;
                // Memperbarui skala x dan y dengan nilai minimum dan maksimum yang dihitung
                quadrantsChart.options.scales.x.min = minX;
                quadrantsChart.options.scales.x.max = maxX;
                quadrantsChart.options.scales.y.min = minY;
                quadrantsChart.options.scales.y.max = maxY;
                // Memperbarui warna latar belakang dan border untuk setiap dataset
                quadrantsChart.data.datasets.forEach(dataset => {
                    dataset.backgroundColor = 'black';
                    dataset.borderColor = 'white';
                });
                quadrantsChart.update();

            });
            // For dimension chart
            $wire.on("chartPieUpdated", (dataPie) => {
                // console.log(dataPie);
                dataHarapanObject = dataPie[0]["Harapan"];
                // console.log(dataPie[0]);
                const labels = Object.keys(dataHarapanObject);
                const data = Object.values(dataHarapanObject);
                pieChartHarapan.data.labels = labels;
                pieChartHarapan.data.datasets[0].data = data;
                const generateBrighterGradientColor = (index, total) => {
                    const hue = (index / total) * 120; // Hue range from 0 to 120 for green to red
                    const saturation = 100; // Full saturation
                    const lightness = 50 + (index / total) * 25; // Adjust lightness for brightness
                    return `hsl(${hue},${saturation}%,${lightness}%)`;
                };
                const totalLabels = labels.length;
                const backgroundColors = labels.map((label, index) =>
                    generateBrighterGradientColor(index, totalLabels),
                );
                pieChartHarapan.data.datasets[0].backgroundColor = backgroundColors;
                pieChartHarapan.update();
                pieChartKenyataan.data.datasets[0].backgroundColor = backgroundColors;
                dataKenyataanObject = dataPie[0]["Kenyataan"];
                const labels2 = Object.keys(dataKenyataanObject);
                const data2 = Object.values(dataKenyataanObject);
                pieChartKenyataan.data.labels = labels2;
                pieChartKenyataan.data.datasets[0].data = data2;
                pieChartKenyataan.update();
            });

            document.getElementById('radar-download').onclick = function() {
                // Trigger the download
                var a = document.createElement('a');
                a.href = radarChart.toBase64Image();
                a.download = 'diagram_radar.png';
                a.click();
            }

            document.getElementById('stacked-download').onclick = function() {
                // Trigger the download
                var a = document.createElement('a');
                a.href = stackedGapChart.toBase64Image();
                a.download = 'diagram_batang_gap.png';
                a.click();
            }

            document.getElementById('ipa-download').onclick = function() {
                // Trigger the download
                var a = document.createElement('a');
                a.href = quadrantsChart.toBase64Image();
                a.download = 'grafik_ipa.png';
                a.click();
            }

            document.getElementById('harapan-download').onclick = function() {
                // Trigger the download
                var a = document.createElement('a');
                a.href = pieChartHarapan.toBase64Image();
                a.download = 'grafik_harapan.png';
                a.click();
            }

            document.getElementById('kenyataan-download').onclick = function() {
                // Trigger the download
                var a = document.createElement('a');
                a.href = pieChartKenyataan.toBase64Image();
                a.download = 'grafik_kenyataan.png';
                a.click();
            }
        </script>
    @endscript
</div>
