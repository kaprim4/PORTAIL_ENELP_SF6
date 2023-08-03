import ApexCharts from 'apexcharts';

$(document).ready(function () {
    var options = {
        series: [
            {name: "Gain", type: "bar", data: [0, 0, 0, 0, 0, 0, 0, 8600, 66000, 56300, 53100, 0]}
        ],
        chart: {
            id: "chart2",
            height: 250,
            type: "line",
            toolbar: {autoSelected: "pan", show: !1}
        },
        stroke: {curve: "straight", dashArray: [0, 0, 8], width: [2, 0, 2.2]},
        fill: {opacity: [1]},
        markers: {size: [0], strokeWidth: 2, hover: {size: 4}},
        xaxis: {
            categories: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"],
            axisTicks: {show: !1},
            axisBorder: {show: !1}
        },
        dataLabels: {enabled: !1}
    };
    var chart = new ApexCharts(document.querySelector("#brushchart_line2"), options);
    chart.render();

    var optionsLine = {
        series: [
            {name: "Visites", type: "area", data: [0, 0, 0, 0, 0, 0, 0, 21, 153, 110, 117, 0]},
            {name: "Station", type: "line", data: [0, 0, 0, 0, 0, 0, 0, 21, 95, 88, 95, 0]}
        ],
        chart: {
            id: "chart1",
            height: 250,
            type: "line",
            toolbar: {show: !1}
        },
        fill: {opacity: [1, 1]},
        xaxis: {
            categories: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"],
            axisTicks: {show: !1},
            axisBorder: {show: !1}
        }
    };
    var chartLine = new ApexCharts(document.querySelector("#brushchart_line"), optionsLine);
    chartLine.render();


    var pie_options = {
        series: [179, 6, 5],
        labels: ["Bon 100 Dh", "Vélo", "Smartphone"],
        chart: {height: 333, type: "donut"},
        legend: {position: "bottom"},
        stroke: {show: !1},
        dataLabels: {dropShadow: {enabled: !1}}
    };
    var pieChart = new ApexCharts(document.querySelector("#store-source"), pie_options);
    pieChart.render();
});