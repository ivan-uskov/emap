const STAVE_OPTIONS = {
    backend: "svg",
    drawFromMeasureNumber: 1,
    drawUpToMeasureNumber: Number.MAX_SAFE_INTEGER
};

const BORDER_WIDTH = 2;

const BORDER_COLOR = [
    'rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
];

const BACKGROUND_COLOR = [
    'rgba(255,255,255,0)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)'
];

function createDataset(uid, values)
{
    return {
        label: uid,
        steppedLine: true,
        data: values,
        backgroundColor: BACKGROUND_COLOR,
        borderColor: BORDER_COLOR,
        borderWidth: BORDER_WIDTH
    };
}

function createOptions(notes)
{
    return {
        responsive: true,
        scales: {
            yAxes: [{
                type: 'category',
                labels: notes
            }],
                xAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    };
}

function drawChart(containerId, uid, values, yAxis)
{
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

$(() => {
    $('.source_file').each(function () {
        const fileHolder = $(this);

        const staveContainerId = fileHolder.attr('id') + 'StaveContainer';
        $('#stavesContainer').append('<div id="' + staveContainerId + '"></div>');
        let openSheetMusicDisplay = new opensheetmusicdisplay.OpenSheetMusicDisplay(staveContainerId, STAVE_OPTIONS);
        openSheetMusicDisplay.load(fileHolder.val()).then(() => {
            window.osmd = openSheetMusicDisplay;
            openSheetMusicDisplay.render();
        });

        const melogramContainerId = fileHolder.attr('id') + 'StaveContainer';
        console.log(fileHolder.data('melogram'));
        const data = fileHolder.data('melogram');
        drawChart(melogramContainerId, fileHolder.data('uid'), data['notes'], data['yAxis']);
    });
});