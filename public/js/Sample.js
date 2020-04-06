$(document).ready(function () {
    var count = 0;
    $('#add_row_link').click(function() {
        var elem  = $('#empty_row').clone(true);
        $(elem).appendTo('tbody');
        ++count;
    });
    $('.remove_row_link').click(function () {
        if(count >= 1){
            var th = $(this).parent();
            var td = $(th).parent();
            td.remove();
            --count;
        }
    })
});