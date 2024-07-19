// {{-- untuk select2 --}}
$(document).ready(function () {
    $("#surveyID").select2();
    $("#surveyID").on("change", function () {
        var data = $("#surveyID").select2("val");
        $wire.surveyID = data;
    });
});

// BEGINNING radar chart
const data = {
    labels: [],
    datasets: [
        {
            label: "My First Dataset",
        },
        {
            label: "My Second Dataset",
        },
    ],
};
const config = {
    type: "radar",
    data: data,
    options: {
        responsive: true,
        // maintainAspectRatio: false,
        plugins: {
            legend: {
                position: "bottom",
            },
            title: {
                display: true,
                text: "Radar Chart",
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
    datasets: [
        {
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
            },
            title: {
                display: true,
                font: {
                    size: 20,
                },
                text: "Stacked Bar Chart",
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
};
var ctx3 = document.getElementById("chart3").getContext("2d");
var stackedGapChart = new Chart(ctx3, config2);
// END of stacked bar chart

// BEGINING QUADRANTS CHART
const quadrantsData2 = {
    datasets: [
        {
            label: "Dataset 1",
            data: [
                {
                    x: 0,
                    y: 0,
                },
                {
                    x: 100,
                    y: 100,
                },
            ],
            borderColor: "red", // 'rgb(255, 99, 132)
            backgroundColor: "red", // 'rgb(255, 99, 132)
        },
    ],
};

const quadrants = {
    id: "quadrants",
    beforeDraw(chart, args, options) {
        const {
            ctx,
            chartArea: { left, top, right, bottom },
            scales: { x, y },
        } = chart;
        const midX = x.getPixelForValue(0);
        const midY = y.getPixelForValue(0);
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

const quadrantsConfig = {
    type: "scatter",
    data: quadrantsData2,
    options: {
        plugins: {
            quadrants: {
                topLeft: "red",
                bottomRight: "green",
                bottomLeft: "yellow",
                topRight: "blue",
            },
        },
    },
    plugins: [quadrants],
};
var quadrantsCtx = document.getElementById("quadrantsChart").getContext("2d");
var quadrantsChart = new Chart(quadrantsCtx, quadrantsConfig);
// END of QUADRANTS CHART

// START OF PIE CHART
// pie chart harapan
const data3 = {
    labels: ["Label 1", "Label 2", "Label 3"],
    datasets: [
        {
            label: "Jumlah Responden",
            data: [],
            backgroundColor: [
                "rgb(255, 99, 132)",
                "rgb(54, 162, 235)",
                "rgb(255, 205, 86)",
            ],
            hoverOffset: 4,
        },
    ],
};
const config3 = {
    type: "doughnut",
    data: data3,
    options: {
        plugins: {
            legend: {
                position: "bottom",
            },
            title: {
                display: true,
                font: {
                    size: 20,
                },
                text: "Pie Chart Harapan",
            },
        },
    },
};
var ctx4 = document.getElementById("pieChartHarapan").getContext("2d");
var pieChartHarapan = new Chart(ctx4, config3);

// pie chart kenyataan
const data4 = {
    labels: ["Label 1", "Label 2", "Label 3"],
    datasets: [
        {
            label: "Jumlah Responden",
            data: [],
            hoverOffset: 4,
        },
    ],
};
const config4 = {
    type: "doughnut",
    data: data3,
    options: {
        plugins: {
            legend: {
                position: "bottom",
            },
            title: {
                display: true,
                font: {
                    size: 20,
                },
                text: "Pie Chart Kenyataan",
            },
        },
    },
};
var ctx5 = document.getElementById("pieChartKenyataan").getContext("2d");
var pieChartKenyataan = new Chart(ctx5, config4);
// END OF PIE CHART

// FOR LIVEWIRE UPDATE
// for analisis gap
$wire.on("chartUpdated", (dataGap) => {
    dataObject = dataGap[0]["radar"];
    const datanya = dataObject;
    radarChart.data = datanya;
    radarChart.update();
    dataStackedObject = dataGap[0]["stackedBarGap"];
    const datanyaStacked = dataStackedObject;
    stackedGapChart.data.datasets[0].data = datanyaStacked[0]; // ini untuk data asli
    stackedGapChart.data.datasets[1].data = datanyaStacked[1]; // ini untuk data gap
    xScalesAxisMax = datanyaStacked[0][1] + datanyaStacked[1][1];
    stackedGapChart.options.scales.x.max = xScalesAxisMax;
    stackedGapChart.update();
});
// For dimension chart
$wire.on("chartPieUpdated", (dataPie) => {
    console.log(dataPie);
    dataHarapanObject = dataPie[0]["Harapan"];
    console.log(dataPie[0]);
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
    pieChartKenyataan.data.datasets[0].backgroundColor = backgroundColors;

    pieChartHarapan.update();

    dataKenyataanObject = dataPie[0]["Kenyataan"];
    const labels2 = Object.keys(dataKenyataanObject);
    const data2 = Object.values(dataKenyataanObject);
    pieChartKenyataan.data.labels = labels2;
    pieChartKenyataan.data.datasets[0].data = data2;
    pieChartKenyataan.update();
});
