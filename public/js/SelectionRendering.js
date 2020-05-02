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
        },
        tooltips: {
            enabled: false,
            custom: function(tooltipModel) {
                // Tooltip Element
                var tooltipEl = document.getElementById('chartjs-tooltip');

                // Create element on first render
                if (!tooltipEl) {
                    tooltipEl = document.createElement('div');
                    tooltipEl.id = 'chartjs-tooltip';
                    tooltipEl.innerHTML = '<table></table>';
                    document.body.appendChild(tooltipEl);
                }

                // Hide if no tooltip
                if (tooltipModel.opacity === 0) {
                    tooltipEl.style.opacity = 0;
                    return;
                }

                // Set caret Position
                tooltipEl.classList.remove('above', 'below', 'no-transform');
                if (tooltipModel.yAlign) {
                    tooltipEl.classList.add(tooltipModel.yAlign);
                } else {
                    tooltipEl.classList.add('no-transform');
                }

                function getBody(bodyItem) {
                    return bodyItem.lines;
                }

                // Set Text
                if (tooltipModel.body) {
                    var titleLines = tooltipModel.body.length || 0;

                    var innerHtml = '<thead>';
                    innerHtml += '<tr><th>' + titleLines + '</th></tr>';
                    innerHtml += '</thead><tbody>';
                    innerHtml += '</tbody>';

                    var tableRoot = tooltipEl.querySelector('table');
                    tableRoot.innerHTML = innerHtml;
                }

                // `this` will be the overall tooltip
                var position = this._chart.canvas.getBoundingClientRect();

                // Display, position, and set styles for font
                tooltipEl.style.backgroundColor = "black";
                tooltipEl.style.color = "white";
                tooltipEl.style.opacity = 1;
                tooltipEl.style.position = 'absolute';
                tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
                tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                tooltipEl.style.fontFamily = tooltipModel._bodyFontFamily;
                tooltipEl.style.fontSize = tooltipModel.bodyFontSize + 'px';
                tooltipEl.style.fontStyle = tooltipModel._bodyFontStyle;
                tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
                tooltipEl.style.pointerEvents = 'none';
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