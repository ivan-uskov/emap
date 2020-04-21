$(() => {
    $('#stavesBtn').click(() => {
        $('#melogramsContainer').hide();
        $('#commonContainer').hide();
        $('#stavesContainer').show();
        return false;
    });
    $('#melogramsBtn').click(() => {
        $('#stavesContainer').hide();
        $('#commonContainer').hide();
        $('#melogramsContainer').show();
        return false;
    });
    $('#commonBtn').click(() => {
        $('#stavesContainer').hide();
        $('#melogramsContainer').hide();
        $('#commonContainer').show();
        return false;
    });

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
        const data = fileHolder.data('melogram');
        drawChart(melogramContainerId, fileHolder.data('uid'), data['notes'], data['yAxis']);
    });

    const data = $('#commonGraphData').data('data');
    new Chart(document.getElementById('commonContainerCanvas'), {
        type: 'line',
        data: {
            labels: [...Array(data.length).keys()],
            datasets: data.values.map((item) => createDataset(item.uid, item.notes))
        },
        options: createOptions(data.yAxis)
    });

    $('#saveBtn').click(() => {
        $('#saveSelectionForm').submit();
        return false;
    });
});