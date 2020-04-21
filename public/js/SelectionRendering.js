const STAVE_OPTIONS = {
    backend: "svg",
    drawFromMeasureNumber: 1,
    drawUpToMeasureNumber: Number.MAX_SAFE_INTEGER
};

const BORDER_WIDTH = 2;
const COLORS = [
    'rgba(52,255,10, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(255, 159, 64, 1)',
    'rgba(0, 0, 0, 1)'
];

const Color = (() => {
    this._currentColor = 0;
    let that = this;
    this.get = () => COLORS[(() => {
        let val = that._currentColor++;
        (that._currentColor >= COLORS.length) && (that._currentColor = 0);
        return val;
    })()];

    return this;
})();

const BACKGROUND_COLOR = [
    'rgba(255,255,255,0)',
];

function createDataset(uid, values, color) {
    return {
        label: uid,
        steppedLine: true,
        data: values,
        backgroundColor: BACKGROUND_COLOR,
        borderColor: [color ? color : Color.get()],
        borderWidth: BORDER_WIDTH
    };
}

function createOptions(notes) {
    return {
        responsive: true,
        scales: {
            yAxes: [{
                type: 'category',
                labels: notes,
                ticks: {
                    min: notes[0],
                    max: notes[notes.length - 1]
                }
            }],
            xAxes: [{ticks: {beginAtZero: true}}]
        },
        plugins: {
            zoom: {
                pan: {
                    enabled: true,
                    mode: 'x'
                },
                zoom: {
                    enabled: true,
                    mode: 'x',
                    speed: 1000
                }
            }
        }
    };
}

function drawChart(containerId, uid, values, yAxis) {
    $('#melogramsContainer').append('<canvas id="' + containerId + '" style="height:300px"></canvas>');
    new Chart(document.getElementById(containerId), {
        type: 'line',
        data: {
            labels: [...Array(values.length).keys()],
            datasets: [createDataset(uid, values)]
        },
        options: createOptions(yAxis)
    });
}