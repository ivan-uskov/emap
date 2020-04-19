$(function () {
    $('tr').click(function() {
        let editAction = $(this).find(".edit_action").attr("href");
        if(editAction) {
            window.location = editAction;
        }
    });
});