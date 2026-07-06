$(function () {
    $('.save').click(function () {
        if ($('input[name="name"]').val() === '') {
            alert('商品名いれて？');
            return false;
        }
        var $c = confirm("登録してもいいー？");
        if ($c === false) {
            return false;
        }
        let myForm = $('#form');
        var url = $('#form').attr('action');
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
                alert('登録したよー！');
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