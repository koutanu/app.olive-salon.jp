$('.sales').on('click', function () {
    history.back();
});

$('.sales').on('click', function () {
    let id = $('#customer_id').val();
    window.location.href = getBaseURL() + 'sales/index/' + id;
});

$(function () {
    $('.delete').click(function () {
        if (!confirm("削除しますか？\n関連する売上商品も削除されます。")) {
            return false;
        }
        var customer_id = $("#customer_id").val();
        postWithToken(getBaseURL() + 'sales/delete', {
            id: $("#id").val()
        }, { $button: $(this) }).done(function (result) {
            if (result['result'] === 'success') {
                showToast('削除しました。');
                window.location.href = getBaseURL() + 'sales/index/' + customer_id;
            } else {
                showToast(result['result'] || '削除に失敗しました。', true);
            }
        });
    });

    $('.cancel').click(function () {
        var $btn = $(this);
        var flag = $btn.data('flag');
        postWithToken(getBaseURL() + 'sales/cancel', {
            id: $("#id").val(),
            flag: flag
        }, { $button: $btn }).done(function (result) {
            if (result[0] === true) {
                if (flag == 1) {
                    $btn.data('flag', 0);
                    $btn.text('キャンセル');
                } else {
                    $btn.data('flag', 1);
                    $btn.text('キャンセルを取り消す');
                }
                showToast('更新しました。');
            } else {
                showToast(result['result'] || '更新に失敗しました。', true);
            }
        });
    });

    $('.change_reservation').on('click', function () {
        if (!confirm("予約日付を変更しますか？")) {
            return false;
        }
        postWithToken(getBaseURL() + 'sales/change_reservation', {
            id: $("#id").val(),
            reservation_date: $('.reservation_date').val()
        }, { $button: $(this) }).done(function (result) {
            if (result[0] === true) {
                showToast('変更しました。');
            } else {
                showToast(result['result'] || '変更に失敗しました。', true);
            }
        });
    });
});
