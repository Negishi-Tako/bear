<?php
    $TIME = htmlspecialchars(filter_input(INPUT_POST, 'dateT'), ENT_QUOTES, 'UTF-8');
    $X = htmlspecialchars(filter_input(INPUT_POST, 'x'), ENT_QUOTES, 'UTF-8');
    $Y = htmlspecialchars(filter_input(INPUT_POST, 'y'), ENT_QUOTES, 'UTF-8');
    $NOW_TIME = new DateTime();
    $NOW = $NOW_TIME->format('Y-m-d H:i:s');

    try {
        // DB接続
        $pdo = new PDO(
            // ホスト名、データベース名
            'mysql:host={hostname};dbname={dbname};',
            // ユーザー名
            '{username}',
            // パスワード
            '{password}',
            // レコード列名をキーとして取得させる
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
     
        // SQL文をセット
        $stmt = $pdo->prepare('INSERT INTO data (dateT,x,y,regiTIME) VALUES(:time, :x, :y, :now)');
     
        // 値をセット
        $stmt->bindValue(':time', $TIME);
        $stmt->bindValue(':x', $X);
        $stmt->bindValue(':y',$Y);
        $stmt->bindValue(':now',$NOW);
     
        // SQL実行
        $stmt->execute();
     
    } catch (PDOException $e) {
        // エラー発生
        echo('エラーが発生しました。');
        echo $e->getMessage();
     
    } finally {
        // DB接続を閉じる
        $pdo = null;
	print "<p>データを登録しました</p>";
	print "<p>".$NOW."</p>";
	print "<a href='../'> kumapへもどる</a>";
	print "<style>body{background-color:white}</style>";
    }

    
?>
