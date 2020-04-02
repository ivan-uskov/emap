$(function () {
    document.getElementById('inputGroupFile01').onchange = function () {
        var file = document.getElementById('inputGroupFile01').value.replace(/.*[\\\/]/, "");
        var placeFile = document.getElementById('inputGroupFile01').nextElementSibling;
        placeFile.innerHTML = file;
    }
})