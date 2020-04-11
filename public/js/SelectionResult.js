const OPTIONS = {
    backend: "svg",
    drawFromMeasureNumber: 1,
    drawUpToMeasureNumber: Number.MAX_SAFE_INTEGER // draw all measures, up to the end of the sample
};

$(function () {
    $('.source_file').each(function () {
        let fileHolder = $(this);
        let containerId = fileHolder.attr('id') + 'Container';
        $('#graphContainer').append('<div id="' + containerId + '"></div>');

        let openSheetMusicDisplay = new opensheetmusicdisplay.OpenSheetMusicDisplay(containerId, OPTIONS);
        openSheetMusicDisplay.load(fileHolder.val()).then(() => {
            window.osmd = openSheetMusicDisplay; // give access to osmd object in Browser console, e.g. for osmd.setOptions()
            //console.log("e.target.result: " + e.target.result);
            openSheetMusicDisplay.render();
        });
    });
});