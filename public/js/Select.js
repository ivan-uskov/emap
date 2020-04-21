$(function () {
    $('tr').click(function() {
        let editAction = $(this).find(".open_action").attr("href");
        if(editAction) {
            window.location = editAction;
        }
    });
});