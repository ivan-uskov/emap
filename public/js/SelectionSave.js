$(document).ready(function () {
    $(document).on('click', '#saveSelection', function() {
        let canvas = $(".chartjs-render-monitor");
        let zip = new JSZip();

        for(let i = 0; i < canvas.length; i++) {
            canvas[i].toBlob(function(blob) {
                zip.file(i + ".png", blob);
                if(i === canvas.length - 1)
                {
                    zip.generateAsync({type:"blob"})
                        .then(function(content) {
                            saveAs(content, "selection.zip");
                        });
                }
            });
        }
    } );
});