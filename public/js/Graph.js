window.onload = function () {
    var data = $('#noteInput').val();
    var chart = new CanvasJS.Chart("chartContainer", {
        title: {
            text: "Melogramm"
        },
        subtitles: [{
            text: "(Text about melogramm)"
        }],
        axisY: {
            title: "Note",
            includeZero: true,
            valueFormatString:"Note №#",
        },
        axisX: {
            title: "Note duration",
            valueFormatString: "00.##",
        },
        data: [{
            type: "stepLine",
            dataPoints: JSON.parse(data)
        }]
    });

    chart.render();
};