const radioButtons = document.querySelectorAll('input[type="radio"]');

const clearRadioButton = (radioButton) => {
    setTimeout(func = () => {
        radioButton.checked = false;
    }, 100)
}

radioButtons.forEach(radioButton => {
    let queryStr = 'label[for="' + radioButton.id + '"]'
    let label = document.querySelector(queryStr)

    radioButton.addEventListener("mouseup", func = () => {
        if (radioButton.checked) {
            clearRadioButton(radioButton)
        }
    });

    if (label) {
        label.addEventListener("mouseup", func = () => {
            if (radioButton.checked) {
                clearRadioButton(radioButton)
            }
        });
    }
});

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
        var $form = $('#form');
        var $url = $form.attr('action');
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
                alert('更新したよー！');
                window.location.href = getBaseURL() + 'customer/detail/' + $id;
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

// 和暦追加
for (const el of document.querySelectorAll('select')) {
    if (('dataset' in el) == false) continue
    if (('yyyy' in el.dataset) == false) continue
    const yyyy = el.dataset.yyyy.split('-')
    const birthday_year = el.dataset.year
    if (yyyy.length != 2) continue

    let last = Number(yyyy[1])
    if (isNaN(last)) continue

    let start = Number(yyyy[0])
    if (isNaN(start)) {
        start = Number((new Date()).getFullYear())
        last = start - last
    }

    const a = (start > last ? -1 : 1)
    for (let y = start; y != last + a; y += a) {
        const opt = document.createElement('option')
        if (birthday_year - 0 === y) {
            opt.setAttribute('value', `${y}`)
            opt.selected = true;
        } else {
            opt.setAttribute('value', `${y}`)
        }
        opt.innerText = `${y}年`

        // 和暦を追加
        for (const w of [
            ['令和', 2019, 9999], // ←いまのところいつになるかわからないけど、書き換える必要があります
            ['平成', 1989, 2019], // 平成31年
            ['昭和', 1926, 1989], // 昭和64年
            ['大正', 1912, 1926], // 大正15年
            ['明治', 1868, 1912], // 明治45年
        ]) {
            if (w[1] <= y && y <= w[2])
                opt.innerText += ` (${w[0]} ${y - w[1] + 1}年)`
        }

        el.appendChild(opt)
    }
}

// 誕生日から年齢を自動生成
$('.birthday').on('change', function () {
    var year = $('.year').val();
    var month = $('.month').val();
    var day = $('.day').val();
    //今日
    var today = new Date();
    //今年の誕生日
    var thisYearsBirthday = new Date(today.getFullYear(), month - 1, day);
    //年齢
    var age = today.getFullYear() - year;
    if (today < thisYearsBirthday) {
        //今年まだ誕生日が来ていない
        age--;
    }
    $('.age').val(age);
});

// 郵便番号から自動取得
$(function () {
    $('#post').jpostal({
        postcode: [
            '#post'
        ],
        address: {
            '#prefecture': '%3',
            '#city': '%4',
            '#address': '%5'
        }
    });
});

$('.sales_create').on('click', function () {
    let id = $('#id').val();
    window.location.href = getBaseURL() + 'sales/create/' + id;
});

$('.sales').on('click', function () {
    let id = $('#id').val();
    window.location.href = getBaseURL() + 'sales/index/' + id;
});

$(function () {
    $('.delete').click(function () {
        var $c = confirm("削除してもいいの？ほんとに消しちゃうよ？");
        if ($c === false) {
            return false;
        }
        var $form = $('#form');
        var $url = getBaseURL() + 'customer/delete';
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
                window.location.href = getBaseURL() + 'customer';
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

$('.btn_map').on('click', function () {
    let id = $(this).data('id');
    let html = '<div class="mt-5px">';
    html += '<div id="gmap"></div>';
    html += '</div>';
    $('.modal').addClass('modal-customer-detail');
    modalShow(html);
    let h1 = $('.modal_header').height();
    let h2 = $('.modal').height();
    $('#gmap').css('height', (h2 - h1) + 'px');
    initMap();
});

$(document).on('click', '.modal_close', function () {
    $('.modal').removeClass('modal-customer-detail');
    modalHidden();
});

$(document).on('click', '.modal_overlay', function () {
    $('.modal').removeClass('modal-customer-detail');
    modalHidden();
});

function modalShow(html) {
    $('.modal_body').append(html);
    $('.modal-overlay').show();
    $('.modal').show();
}

function modalHidden() {
    $('.modal_body').html('');
    $('.modal-overlay').hide();
    $('.modal').hide();
}

var map;
var marker = [];
var infoWindow = [];

function initMap() {
    let lat = $('.lat').val();
    let lng = $('.lng').val();
    const home = { lat: parseFloat(lat), lng: parseFloat(lng) };
    map = new google.maps.Map(document.getElementById('gmap'), {
        center: home,
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // マーカー
    markerLatLng = new google.maps.LatLng({ lat: parseFloat(lat), lng: parseFloat(lng) });
    marker = new google.maps.Marker({ // マーカーの追加
        position: markerLatLng, // マーカーを立てる位置を指定
        map: map // マーカーを立てる地図を指定
    });

    marker.addListener('click', function () { // マーカーをクリックしたとき
        infoWindow.open(map, marker); // 吹き出しの表示
    });
}

$(function () {
    //結局API Key見えるからどうしよう
    let script = document.createElement('script');
    let api = $('#api').val();
    script.src = "https://maps.googleapis.com/maps/api/js?key=" + api + "&callback=initMap";
    document.body.appendChild(script)
});