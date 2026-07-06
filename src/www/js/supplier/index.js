$(function () {
    $('.save').click(function () {
        if ($('input[name="name"]').val() === '') {
            alert('仕入先名いれてないよ？');
            return false;
        }
        var $c = confirm("登録してもいいー？");
        if ($c === false) {
            return false;
        }
        var $form = $('#form');
        var $url = $form.attr('action');
        var $token = $("#token").val();
        var $method = $("#method").val();
        var $data = $form.serialize() + '&method=' + $method + '&token=' + $token;
        $.post({
            type: 'POST',
            data: $data,
            url: $url
        }).done((result) => {
            result = JSON.parse(result);
            if (result['result'] === 'success') {
                alert('登録したよー！');
                window.location.href = getBaseURL() + 'supplier';
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