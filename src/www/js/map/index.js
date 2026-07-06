var map;
var marker = [];
var infoWindow = [];
var markerData = [];

let customer_geo = JSON.parse($('#customer_geo').val());

markerData = customer_geo.map(function (e) {
    return { id: e.id, name: e.name, lat: Number(e.lat), lng: Number(e.lng) };
});

function initMap() {
    const home = { lat: 34.521051, lng: 135.829939 };
    map = new google.maps.Map(document.getElementById('gmap'), {
        center: home,
        zoom: 11,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // マーカー毎の処理
    for (var i = 0; i < markerData.length; i++) {
        markerLatLng = new google.maps.LatLng({ lat: markerData[i]['lat'], lng: markerData[i]['lng'] });
        marker[i] = new google.maps.Marker({ // マーカーの追加
            position: markerLatLng, // マーカーを立てる位置を指定
            map: map // マーカーを立てる地図を指定
        });

        infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
            content: '<a href="' + getBaseURL() + 'customer/detail/' + markerData[i]['id'] + '" class="marker-link">' + markerData[i]['name'] + '</a>' // 吹き出しに表示する内容
        });

        markerEvent(i); // マーカーにクリックイベントを追加
    }
}

// マーカーにクリックイベントを追加
function markerEvent(i) {
    marker[i].addListener('click', function () { // マーカーをクリックしたとき
        infoWindow[i].open(map, marker[i]); // 吹き出しの表示
    });
}

$(function () {
    //結局API Key見えるからどうしよう
    let script = document.createElement('script');
    let api = $('#api').val();
    script.src = "https://maps.googleapis.com/maps/api/js?key=" + api + "&callback=initMap";
    document.body.appendChild(script)
});

$('.btn-map').click(function () {
    let customer_geo = JSON.parse($('#customer_geo').val());

    markerData = customer_geo.map(function (e) {
        return { id: e.id, name: e.name, lat: Number(e.lat), lng: Number(e.lng) };
    });

    initMap();
});

$('.btn-map-recently').click(function () {
    let customer_geo = JSON.parse($('#customer_geo_recently').val());

    markerData = customer_geo.map(function (e) {
        return { id: e.id, name: e.name, lat: Number(e.lat), lng: Number(e.lng) };
    });

    initMap();
});