$(document).on('click', '.select_customer', function () {
    var customer_id = $(this).data('customer-id');
    window.location.href = getBaseURL() + 'sales/index/' + customer_id;
});

$('#search').on('click', function () {
    var name = $(".name").val();
    var token = $("#token").val();
    var method = $("#method").val();
    var data = {
        "name": name.replace(/\s+/g, ""),
        "method": method,
        "token": token
    };
    var url = getBaseURL() + 'customer/search';
    $.post({
        type: 'POST',
        data: data,
        url: url
    }).done((results) => {
        results = JSON.parse(results);
        var html = '';
        results.forEach(function (result) {
            html += '<div><button type="button" class="select_customer btn btn-add" data-customer-id="' + result['id'] + '">' + result['name'] + '</button></div>';
        });
        $(".customer-wrap").html(html);
    }).fail((jqXHR, textStatus, errorThrown) => {
        alert('Ajax通信に失敗しました。');
        console.log("jqXHR          : " + jqXHR.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
    }).always((result) => {

    });
});

$(document).on('click', '.select_initial', function () {
    var initial = $(this).data('initial');
    var token = $("#token").val();
    var method = $("#method").val();
    var data = {
        "initial": initial,
        "method": method,
        "token": token
    };
    var url = getBaseURL() + 'customer/search_initial';
    $.post({
        type: 'POST',
        data: data,
        url: url
    }).done((results) => {
        results = JSON.parse(results);
        var html = '';
        results.forEach(function (result) {
            html += '<div><button type="button" class="select_customer btn btn-add" data-customer-id="' + result['id'] + '">' + result['name'] + '</button></div>';
        });
        $(".customer-wrap").html(html);
    }).fail((jqXHR, textStatus, errorThrown) => {
        alert('Ajax通信に失敗しました。');
        console.log("jqXHR          : " + jqXHR.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
    }).always((result) => {

    });
});