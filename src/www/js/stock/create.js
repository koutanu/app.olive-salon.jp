let supplier_data = [];
let before_supplier_select = '';

$(function () {
    getSupplierData();

    $('.supplier_select').on('change', function () {
        let l = $('.stock-item-wrap').children();
        if (l.length > 0) {
            var $c = confirm("商品が追加されています。\n追加した商品を空にして仕入先を変更しますか？");
            if ($c === false) {
                $(this).val(before_supplier_select);
                return false;
            }
        }
        $('.stock-item-wrap').html('');
        $('.postage').val(0);
        $('.total_price').val(0);
        getSupplierData();
    });

    $(document).on('click', '.select-products', function () {
        let tax_rate = JSON.parse($('.tax_rate').val());
        let key = $(this).data('key');
        let html = '<div class="stock-item">';
        html += '<div><span class="btn-minus"></span></div>';
        html += '<input value="' + $(this).text() + '" readonly>';
        html += '<p>仕入値</p>';
        html += '<input name="cost[]" class="cost" value="' + $(this).data('price') + '" size="4">';
        html += '<p>税率</p>';
        html += '<select name="tax_id[]" class="tax_id">';
        tax_rate.forEach(function (tax) {
            if (supplier_data[0][key]['tax_id'] == tax.id) {
                html += '<option value="' + tax.id + '" data-rate="' + tax.tax_rate + '" selected>' + tax.name + '</option>';
            } else {
                html += '<option value="' + tax.id + '" data-rate="' + tax.tax_rate + '">' + tax.name + '</option>';
            }
        });
        html += '</select>';
        html += '<p>個数</p>';
        html += '<select name="lot[]" class="lot">';
        for (var i = 1; i <= 50; i++) {
            html += '<option value="' + i + '">' + i + '</option>';
        }
        html += '</select>';
        html += '<p>入り数</p>';
        html += '<input name="max_unit[]" value="' + supplier_data[0][key]['unit'] + '" size="4">';
        html += '<input type="hidden" name="products_id[]" class="products_id" value="' + supplier_data[0][key]['id'] + '">';
        html += '<input type="hidden" class="cost_price">';
        html += '</div>';

        $('.stock-item-wrap').append(html);
        calcTotalCost();
        $(this).addClass('disabled');
    });

    $(document).on('change', '.cost', function () {
        calcCostPrice($(this));
        calcTotalCost();
    });

    $(document).on('change', '.tax_id', function () {
        calcCostPrice($(this));
        calcTotalCost();
    });

    $(document).on('change', '.lot', function () {
        calcCostPrice($(this));
        calcTotalCost();
    });

    $(document).on('click', '.btn-minus', function () {
        $(this).parent().parent().remove();
        let id = $(this).parent().parent().find('.products_id').val();
        $('#select_products' + id).removeClass('disabled');
        calcTotalCost();
    });
});

function getSupplierData() {
    supplier_data.length = 0;
    let supplier_id = $('.supplier_select').val();
    let url = getBaseURL() + 'stock/get_products_for_supplier';
    postWithToken(url, { id: supplier_id }).done(function (result) {
        var list = result.data || result;
        if (list && list.length !== undefined) {
            supplier_data.push(list);
            setProductsData();
        } else {
            showToast(result.result || '仕入先データを取得できませんでした。', true);
        }
    }).always(function () {
        before_supplier_select = supplier_id;
    });
};

function setProductsData() {
    let html = '';
    (supplier_data[0] || []).map(function (val, i) {
        html += '<div><button type="button" id="select_products' + escapeHtml(val['id']) +
            '" class="btn btn-add select-products" data-id="' + escapeHtml(val['id']) +
            '" data-key="' + i + '" data-price="' + escapeHtml(val['price']) + '">' +
            escapeHtml(val['name']) + '</button></div>';
    });
    $('.products-wrap').html(html);
}

function calcTotalCost() {
    var price = 0;
    $.each($(".cost_price"), function (i, val) {
        price = price + Number($(val).val());
    });
    $('.total_price').val(price);
};

function calcCostPrice($this) {
    let cost = $this.parent().find('.cost').val()
    let tax_rate = $this.parent().find('.tax_id option:selected').data('rate');
    let count = $this.parent().find('.lot').val();
    cost_price = (Number(cost) + ((cost / 100) * tax_rate)) * count;
    $this.parent().find('.cost_price').val(cost_price);
    calcTotalCost();
}


$(function () {
    $('.save').on('click', function () {
        let delivery_at = $(".delivery_at").val();
        let $c = confirm(delivery_at + "付で\n仕入登録するよ!");
        if ($c === false) {
            return false;
        }
        let $form = $('#form');
        let $url = $form.attr('action');
        let $token = $("#token").val();
        let $method = $("#method").val();
        let $data = $form.serialize() + '&method=' + $method + '&token=' + $token;
        $.post({
            type: 'POST',
            data: $data,
            url: $url
        }).done((result) => {
            result = JSON.parse(result);
            if (result['result'] === 'success') {
                alert('登録したよー！');
                window.location.href = getBaseURL() + 'stock';
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
});