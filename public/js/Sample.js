$(function () {
    $('#add_row_link').click(function() {
        var elem  = $('#empty_row').clone();
        $(elem).appendTo('tbody');
    });
});