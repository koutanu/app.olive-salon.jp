$('.menu_select').on('click', function () {
    if ($(this).hasClass('checked')) {
        // 初期化
        $('.menu_first_discount').val(0);
        //予約割引額取得
        $('.menu_reservation_discount').val($('.menu_reservation_discount').val());
        $('.menu_other_discount').val(0);
        $('.menu_total_discount').val(0);
        $('.menu_sales').val(0);
        // 隠しinput
        $('.original_sales').val(0);
        $('.first_time_discount').val(0);
        $('.menu_id').val(0);
        // 初回チェックを解除
        $('.first_time_check').prop('checked', false);
        $(this).removeClass('checked');
        $('.option_select').removeClass('checked');
    } else {
        let id = $(this).data('id');
        let price = $(this).data('price');
        let first_time_discount = $(this).data('discount');
        // 初期化
        $('.menu_first_discount').val(0);
        //予約割引額取得
        $('.menu_reservation_discount').val($('.menu_reservation_discount').val());
        $('.menu_other_discount').val(0);
        $('.menu_total_discount').val($('.menu_reservation_discount').val());
        // 施術合計
        let menu_sales = Number(price) - $('.menu_reservation_discount').val();
        $('.menu_sales').val(menu_sales);
        // 隠しinput
        $('.original_sales').val(price);
        $('.first_time_discount').val(first_time_discount);
        $('.menu_id').val(id);
        // 初回チェックを解除
        $('.first_time_check').prop('checked', false);
        $('.menu_select').removeClass('checked');
        $(this).addClass('checked');
        $('.option_select').removeClass('checked');
    }
});

$('.option_select').on('click', function () {
    if ($(this).hasClass('checked')) {
        let option_price = $(this).data('price');
        let menu_sales = $('.menu_sales').val();
        $('.menu_sales').val(Number(menu_sales) - Number(option_price));
        $(this).removeClass('checked');
        $(this).parent().find('.menu_option').prop('checked', false);
    } else {
        let option_price = $(this).data('price');
        let menu_sales = $('.menu_sales').val();
        $('.menu_sales').val(Number(menu_sales) + Number(option_price));
        $(this).addClass('checked');
        $(this).parent().find('.menu_option').prop('checked', true);
    }
});

$('.menu_input').on('change', function () {
    // 金額取得
    let price = $('.original_sales').val();
    let first = $('.menu_first_discount').val();
    let reservation = $('.menu_reservation_discount').val();
    let other = $('.menu_other_discount').val();
    // 計算
    let total_discount = Number(first) + Number(reservation) + Number(other);
    let menu_sales = Number(price) - Number(total_discount);
    $('.menu_total_discount').val(total_discount);
    $('.menu_sales').val(menu_sales);
});

$('.first_time_check').on('change', function () {
    if ($(this).prop('checked')) {
        // 初回割引額取得
        let first = $('.first_time_discount').val();
        $('.menu_first_discount').val(Number(first));
        // 割引金額取得
        let price = $('.original_sales').val();
        let reservation = $('.menu_reservation_discount').val();
        let other = $('.menu_other_discount').val();
        // 計算
        let total_discount = Number(first) + Number(reservation) + Number(other);
        let menu_sales = Number(price) - Number(total_discount);
        $('.menu_total_discount').val(total_discount);
        $('.menu_sales').val(menu_sales);
    } else {
        // 初回割引額0に
        let first = $('.first_time_discount').val();
        $('.menu_first_discount').val(0);
        // 割引金額取得
        let price = $('.original_sales').val();
        let reservation = $('.menu_reservation_discount').val();
        let other = $('.menu_other_discount').val();
        // 計算
        let total_discount = Number(reservation) + Number(other);
        let menu_sales = Number(price) - Number(total_discount);
        $('.menu_total_discount').val(total_discount);
        $('.menu_sales').val(menu_sales);
    }
});

$('.select_products').on('click', function () {
    let products_id = $(this).children('.products_id').val();
    let price = $(this).children('.price').val();
    let name = $(this).children('.stock_name').text();
    let tax_id = $(this).children('.tax_id').val();
    let stock_id = $(this).children('.stock_id').val();
    let stock_lot = $(this).children('.stock_lot').val();
    let stock_unit = $(this).children('.stock_unit').val();
    let max_unit = $(this).children('.max_unit').val();
    let tax_rate = JSON.parse($('.tax_rate').val());
    let html = '<div class="products-item">';
    html += '<div><span class="btn-minus"></span>';
    html += '<span>' + name + '</span>';
    html += '</div>';
    html += '<div class="price-wrap">';
    html += '<span> 売値</span>'
    html += '<input type="text" name="products_price[]" class="products_price" value="' + price + '">';
    html += '<span> 税率</span>';
    html += '<select name="tax_id[]" class="tax_id">';
    tax_rate.forEach(function (tax) {
        if (tax_id == tax.id) {
            html += '<option value="' + tax.id + '" data-rate="' + tax.tax_rate + '" selected>' + tax.name + '</option>';
        } else {
            html += '<option value="' + tax.id + '" data-rate="' + tax.tax_rate + '">' + tax.name + '</option>';
        }
    });
    html += '</select>';
    html += '<span> 販売個数</span>';
    html += '<select name="lot[]" class="lot">';
    for (let i = 0; i <= stock_lot; i++) {
        html += '<option value="' + i + '">' + i + '</option>';
    }
    html += '</select>';
    if (max_unit > 1) {
        html += '<span> (バラ)</span>';
        html += '<select name="unit[]" class="unit">';
        if (stock_lot > 0) {
            for (let i = 0; i <= max_unit - 1; i++) {
                html += '<option value="' + i + '">' + i + '</option>';
            }
        } else {
            for (let i = 0; i <= stock_unit; i++) {
                html += '<option value="' + i + '">' + i + '</option>';
            }
        }
        html += '</select>';
    } else {
        html += '<input type="hidden" name="unit[]" class="unit" value="0">';
    }
    html += '<input type="hidden" name="products_id[]" value="' + products_id + '">';
    html += '<input type="hidden" name="stock_id[]" class="stock_id" value="' + stock_id + '">';
    html += '<input type="hidden" class="max_lot" value="' + stock_lot + '">';
    html += '<input type="hidden" name="max_unit[]" class="max_unit" value="' + max_unit + '">';
    html += '<input type="hidden" name="stock_unit[]" class="stock_unit" value="' + stock_unit + '">';
    tax_rate.forEach(function (tax) {
        if (tax_id == tax.id) {
            html += '<input type="hidden" name="products_sales[]" data-tax="' + tax.tax_rate + '" class="products_sales" value="">';
        }
    });
    html += '</div>';
    html += '</div>';
    $('#products_item_wrap').append(html);
    $(this).addClass('disabled');
});

$(document).on('click', '.btn-minus', function () {
    $(this).parent().parent().remove();
    let id = $(this).parent().parent().find('.stock_id').val();
    $('#select_products_' + id).removeClass('disabled');
    calcProductsSales();
});

$(document).on('change', '.products_price', function () {
    calcProductPrice($(this));
    calcProductsSales();
});

$(document).on('change', '.tax_id', function () {
    $tax_rate = $("option:selected", $(this)).data('rate');
    $(this).parent().children('.products_sales').data('tax', $tax_rate);
    calcProductPrice($(this));
    calcProductsSales();
});

$(document).on('change', '.lot', function () {
    setUnit($(this));
    calcProductPrice($(this));
    calcProductsSales();
});

$(document).on('change', '.unit', function () {
    calcProductPrice($(this));
    calcProductsSales();
});

$(function () {
    $('.save').on('click', function () {
        let date = $('.next_reservation_date').val();
        let visit = $('.created_at').val();
        if ($('#next_reservation_flag').prop('checked') && date === '') {
            alert('予約日時入れて？');
            return false;
        }
        if (lowerThanDateFromVisitDay(date, visit)) {
            alert('予約日付が過去だよ？\nタイムリープするの？');
            return false;
        }
        let products_prices = document.getElementsByName("products_price[]");
        let price_empty = Array.from(products_prices).every(function (price) {
            return $(price).val() > 0;
        });
        if (price_empty == false) {
            alert('商品の値段をつけて？');
            return false;
        }
        let created_at = $(".created_at").val();
        let $c = confirm(created_at + "付で\n売上登録するよ!");
        if ($c === false) {
            return false;
        }
        let $form = $('#form');
        let $url = $form.attr('action');
        let $token = $("#token").val();
        let $method = $("#method").val();
        let id = $("#customer_id").val();
        let $data = $form.serialize() + '&method=' + $method + '&token=' + $token;
        $.post({
            type: 'POST',
            data: $data,
            url: $url
        }).done((result) => {
            result = JSON.parse(result);
            if (result['result'] === 'success') {
                alert('登録したよー！');
                window.location.href = getBaseURL() + 'sales/index/' + id;
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

$('.sales').on('click', function () {
    let id = $('#customer_id').val();
    window.location.href = getBaseURL() + 'sales/index/' + id;
});

$('.customer_detail').on('click', function () {
    let id = $('#customer_id').val();
    window.location.href = getBaseURL() + 'customer/detail/' + id;
});

$('#next_reservation_flag').on('change', function () {
    if ($(this).prop('checked')) {
        $('.next_reservation_date').prop('disabled', false);
    } else {
        $('.next_reservation_date').prop('disabled', true);
        $('.next_reservation_date').val('none');
    }
});

function calcProductsSales() {
    let sales8 = 0;//税金8%
    let sales10 = 0;//税金10%
    $.each($(".products_sales"), function (i, val) {
        if ($(val).data('tax') == 8) {
            sales8 += Number($(val).val());
        } else if ($(val).data('tax') == 10) {
            sales10 += Number($(val).val());
        }
    });
    sales = Math.floor(sales8 * 1.08) + Math.floor(sales10 * 1.1);
    $('#products_total_sales').val(sales);
}

function calcProductPrice($this) {
    let max_unit = $this.parent().children('.max_unit').val();
    let sales = $this.parent().children('.products_price').val();//定価
    //lot 売上
    let lot = $this.parent().children('.lot').val();
    let lot_sales = lot * sales;
    //unit 売上
    let unit = $this.parent().children('.unit').val();
    let unit_sales = (sales / max_unit) * unit;//ばら売りの定価
    $this.parent().parent().find('.products_sales').val(lot_sales + unit_sales);
}

function setUnit($this) {
    let lot = $this.val();
    let max_lot = $this.parent().children('.max_lot').val();
    let stock_unit = $this.parent().children('.stock_unit').val();
    let max_unit = $this.parent().children('.max_unit').val();
    let html = '';
    if (lot >= max_lot) {
        for (let i = 0; i <= stock_unit; i++) {
            html += '<option value="' + i + '">' + i + '</option>';
        }
        $this.parent().children('.unit').html(html);
    } else {
        for (let i = 0; i <= max_unit - 1; i++) {
            html += '<option value="' + i + '">' + i + '</option>';
        }
        $this.parent().children('.unit').html(html);
    }
}