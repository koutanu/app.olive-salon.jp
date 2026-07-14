function getBaseURL() {
    return $('#doc_root').val();
}

$(document).on('click', '.select_customer', function () {
    var customer_id = $(this).data('customer-id');
    window.location.href = getBaseURL() + 'sales/index/' + customer_id;
});

function renderCustomerButtons(list) {
    var html = '';
    (list || []).forEach(function (result) {
        html += '<button type="button" class="select_customer btn btn-add btn-customer" data-customer-id="' +
            escapeHtml(result['id']) + '">' + escapeHtml(result['name']) + '</button>';
    });
    $(".customer-wrap").html(html);
}

$('#search').on('click', function () {
    var name = $(".name").val();
    postWithToken(getBaseURL() + 'customer/search', {
        name: name.replace(/\s+/g, "")
    }, { $button: $(this) }).done(function (results) {
        if (results.result && !results.data) {
            showToast(results.result, true);
            return;
        }
        renderCustomerButtons(results.data || results);
    });
});

$(document).on('click', '.select_initial', function () {
    var initial = $(this).data('initial');
    postWithToken(getBaseURL() + 'customer/search_initial', {
        initial: initial
    }).done(function (results) {
        if (results.result && !results.data) {
            showToast(results.result, true);
            return;
        }
        renderCustomerButtons(results.data || results);
    });
});
