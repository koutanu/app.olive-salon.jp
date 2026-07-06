$(document).on('click', '.select_sales', function () {
    let id = $(this).data('id');
    window.location.href = getBaseURL() + 'sales/detail/' + id;
});

$('.select_calendar').on('change', function () {
    let month = $(this).val();
    window.location.href = getBaseURL() + 'sales/calendar/' + month.replace('-', '');
});