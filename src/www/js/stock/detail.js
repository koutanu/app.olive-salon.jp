$('.save').on('click', function () {
    let $price = $('.price').val();
    let $products_id = $('.products_id').val();
    var $c = confirm("基本売値を登録するよ？");
    if ($c === false) {
        return false;
    }
    var url = getBaseURL() + 'stock/save_stock_price';
    var data = {
        "products_id": $products_id,
        "price": $price
    };
    $.post({
        type: 'POST',
        data: data,
        url: url
    }).done((result) => {
        result = JSON.parse(result);
        if (result['result'] === 'success') {
            alert('登録完了したよ');
            window.location.href = getBaseURL() + 'stock/detail/' + $products_id;
        } else {
            alert(result['result']);
        }
    }).fail((jqXHR, textStatus, errorThrown) => {
        alert('Ajax通信に失敗しました。');
        console.log("jqXHR          : " + jqXHR.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
    }).always((result) => {

    });
});