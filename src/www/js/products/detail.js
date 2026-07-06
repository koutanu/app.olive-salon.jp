$(function () {
    $('.save').click(function () {
        if ($('input[name="name"]').val() === '') {
            alert('名前きえてるよ？');
            return false;
        }
        var $c = confirm("更新するけど大丈夫？");
        if ($c === false) {
            return false;
        }
        let myForm = $('#form');
        var url = $('#form').attr('action');
        var $id = $("#id").val();
        var form = new FormData(myForm[0]);
        if ($('#image').val() !== '') {
            form.append("file", $("#image").prop("files")[0]);
        }
        form.append("token", $("#token").val());
        form.append("method", $("#method").val());
        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            dataType: 'text',
            data: form,
            url: url,
        }).done((result) => {
            result = JSON.parse(result);
            if (result['result'] === 'success') {
                alert('更新したよー！');
                window.location.href = getBaseURL() + 'products/detail/' + $id;
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
    $('.delete').click(function () {
        var $c = confirm("削除してもいいの？ほんとに消しちゃうよ？");
        if ($c === false) {
            return false;
        }
        var $form = $('#form');
        var $url = getBaseURL() + 'products/delete';
        var $token = $("#token").val();
        var $method = $("#method").val();
        var $id = $("#id").val();
        var $data = $form.serialize() + '&method=' + $method + '&token=' + $token;
        $.post({
            type: 'POST',
            data: $data,
            url: $url
        }).done((result) => {
            result = JSON.parse(result);
            if (result['result'] === 'success') {
                alert('削除完了！(｀･ω･´)');
                window.location.href = getBaseURL() + 'products';
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