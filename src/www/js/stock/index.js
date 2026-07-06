$(document).on('click', '.select_stock', function () {
    let id = $(this).data('id');
    window.location.href = getBaseURL() + 'stock/detail/' + id;
});