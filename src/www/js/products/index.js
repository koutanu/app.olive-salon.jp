$('.select_products').click(function () {
    var products_id = $(this).data('products-id');
    window.location.href = getBaseURL() + 'products/detail/' + products_id;
});