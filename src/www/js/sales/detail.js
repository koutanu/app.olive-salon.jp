$('.sales').on('click', function () {
    history.back();
});

$('.sales').on('click', function () {
    let id = $('#customer_id').val();
    window.location.href = getBaseURL() + 'sales/index/' + id;
});

$(function () {
    $('.delete').click(function () {
        var $c = confirm("削除してもいいの？\n売上商品もあったら一緒に削除するからね？");
        if ($c === false) {
            return false;
        }
        var customer_id = $("#customer_id").val();
        var url = getBaseURL() + 'sales/delete';
        var data = {
            "method": $("#method").val(),
            "token": $("#token").val(),
            "id": $("#id").val()
        };
        $.post({
            type: 'POST',
            data: data,
            url: url
        }).done((result) => {
            result = JSON.parse(result);
            if (result['result'] === 'success') {
                alert('削除完了！(｀･ω･´)');
                window.location.href = getBaseURL() + 'sales/index/' + customer_id;
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
$(function () {
    $('.cancel').click(function () {
        var id = $("#id").val();
        var flag = $(this).data('flag');
        var url = getBaseURL() + 'sales/cancel';
        var data = {
            "id": id,
            "flag": flag
        };
        $.post({
            type: 'POST',
            data: data,
            url: url
        }).done((result) => {
            result = JSON.parse(result);
            if (result[0] === true) {
                if (flag == 1) {
                    $(this).data('flag', 0);
                    $(this).text('キャンセル');
                } else {
                    $(this).data('flag', 1);
                    $(this).text('キャンセルを取り消す');
                }
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

$('.change_reservation').on('click', function () {
    var $c = confirm("予約日付を変更しますか？");
    if ($c === false) {
        return false;
    }
    var id = $("#id").val();
    var url = getBaseURL() + 'sales/change_reservation';
    var data = {
        "id": id,
        "reservation_date": $('.reservation_date').val()
    };
    $.post({
        type: 'POST',
        data: data,
        url: url
    }).done((result) => {
        result = JSON.parse(result);
        if (result[0] === true) {
            alert('変更しました。');
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