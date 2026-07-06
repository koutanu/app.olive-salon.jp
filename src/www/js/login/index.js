
$(function () {
    $('#login').click(function () {
        sessionStorage.clear();
        $('#form').submit();
    });
});
