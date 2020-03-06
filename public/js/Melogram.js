$(function () {
    $('#melogramFamily').change(function() {
        var val = $(this).val();
        $('#melogramColony').val(val);
        $('#melogramPopulation').val(val);
        $('#melogramSpecie').val(val);
    });
});