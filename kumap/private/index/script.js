var map;
var marker;
function getPosition(){
    // 現在地を取得
    navigator.geolocation.getCurrentPosition(
      // 取得成功した場合
      function show_location(position) {
        x = position.coords.latitude;
        y = position.coords.longitude;
        map = L.map('application').setView([x,y], 13);
          L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
          attribution: "<a href='https://maps.gsi.go.jp/development/ichiran.html' target='_blank'>地理院タイル</a>"
        }).addTo(map);
        fetch('../server/database.txt') // (1) リクエスト送信
              .then(response => response.text()) // (2) レスポンスデータを取得
              .then(data => { // (3)レスポンスデータを処理
          var datas = data.split(",");
          const dataup =  datas.length-1;
          for(var i=0;i<dataup/4;i++){
            marker = L.marker([datas[i*4+1],datas[i*4+2]]).bindPopup(L.popup({ maxWidth: 550 }).setContent(datas[i*4].replace('T',' '))).addTo(map);
            ii=0;
          }
              });
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
            alert("現在位置が取得できませんでした");
            break;
          case 3: //TIMEOUT
            alert("タイムアウトになりました");
            break;
          default:
            alert("エラー(コード:"+error.code+")");
            break;
        }
      }
    );
}
function requestlocate(){
    // Geolocation APIに対応している
    if (navigator.geolocation) {
        console.log("位置情報取得可能");
        getPosition()
      } else {
        alert("この端末では位置情報が取得できません。");
    }
}

window.onload = function(){
  requestlocate();
}