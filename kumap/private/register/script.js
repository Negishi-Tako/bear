var marker;
var map;
var xx;
var yy;
function requestlocate(){
    // Geolocation APIに対応している
    if (navigator.geolocation) {
        console.log("Geolocation API OK");
        getPosition();
      } else {
        alert("Geolocation API NG");
    }
}
function getPosition(){
    // 現在地を取得
    navigator.geolocation.getCurrentPosition(
      // 取得成功した場合
      function show_location(position) {
        map = L.map('kumaposition').setView([position.coords.latitude,position.coords.longitude], 13);
          L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
          attribution: "<a href='https://maps.gsi.go.jp/development/ichiran.html' target='_blank'>地理院タイル</a>"
        }).addTo(map);

        map.on('click', function(e) {
            //クリック位置経緯度取得
            xx = e.latlng.lat;
            yy = e.latlng.lng;
            if(marker){
                map.removeLayer(marker);
            }
            marker = L.marker([xx,yy]).bindPopup(L.popup({ maxWidth: 550 }).setContent("新規目撃・発見場所")).addTo(map);
            document.getElementById("x").value = xx;
            document.getElementById("y").value = yy;
        } );
      },
      // 取得失敗した場合
      function(error) {
        function please_retry(){
          document.getElementById("location").innerHTML
              = "位置情報の取得を許可してください。";
        }
        please_retry()
        switch(error.code) {
          case 1: //PERMISSION_DENIED
            alert("位置情報の利用が許可されていません");
            break;
          case 2: //POSITION_UNAVAILABLE
            alert("現在位置が取得できません");
            break;
          case 3: //TIMEOUT
            alert("タイムアウト");
            break;
          default:
            alert("エラー(コード:"+error.code+")");
            break;
        }
      }
    );
}

window.onload = function(){
    requestlocate();
}