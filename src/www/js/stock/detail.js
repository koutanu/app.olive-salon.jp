$('.save').on('click', function () {
    let $price = $('.price').val();
    let $products_id = $('.products_id').val();
    if (!confirm("基本売値を登録しますか？")) {
        return false;
    }
    postWithToken(getBaseURL() + 'stock/save_stock_price', {
        products_id: $products_id,
        price: $price
    }, { $button: $(this) }).done(function (result) {
        if (result['result'] === 'success') {
            showToast('登録しました。');
            window.location.href = getBaseURL() + 'stock/detail/' + $products_id;
        } else {
            showToast(result['result'] || '登録に失敗しました。', true);
        }
    });
});
