<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>kumap</title>
        <meta name="description" content="熊情報をまとめたkumapです。" />
        <meta name="format-detection" content="telephone=no" />
        <link rel="icon" href="./all/kuma.jpg"  />
        <link rel="apple-touch-icon" href="./all/kuma.jpg" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="top">
            <div id="kumap"><a href="https://kumap.negishi-tako.com/" style="text-decoration:none; color:white;">Kumap</a></div>
        </div> 
        <div id="setting">
            <div id="bar">
                <div id="register">
                    <a href="./register/" class="btn_01">新規熊情報登録</a>
                </div>
                
            </div>
            <div id="register">

            </div>
        </div>  
        <div id="application">
        </div>
	<p>ver1.0</p>
         <div id="akumap"><a href="https://kumap.negishi-tako.com/about/" style="text-decoration:none; color:white;">Kumapについて</a></div>
    </body>
</html>


<?php
try {
    $JS_data = [];
	// DBへ接続
	$pdo = new PDO(
        // ホスト名、データベース名
        'mysql:host={hostname};dbname={dbname};',
        // ユーザー名
        '{username}',
        // パスワード
        '{password}',
    );
	// testテーブルの全データを取得
	$sql = 'SELECT dateT,x,y FROM data';
	$data = $pdo->query($sql);
} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
// 接続を閉じる
$pdo = null;
if( !empty($data) ) {
    foreach( $data as $value ) {
        array_push($JS_data,[$value[0],$value[1],$value[2]]);
    }
}
$JS_data = json_encode($JS_data);
?>


<script>
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
        var List_data = [<?php echo $JS_data;?>];
        for(i=0;i<List_data[0].length;i++){
            marker = L.marker([Number.parseFloat(List_data[0][i][1]),Number.parseFloat(List_data[0][i][2])]).bindPopup(L.popup({ maxWidth: 550 }).setContent(List_data[0][i][0].replace("T"," "))).addTo(map);
        }
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
window.onload = (event) => {
  requestlocate();
};
</script>
