<?php

$ID = htmlspecialchars(filter_input(INPUT_POST, 'loginID'), ENT_QUOTES, 'UTF-8');
$Password = password_hash(htmlspecialchars(filter_input(INPUT_POST, 'Password'), ENT_QUOTES, 'UTF-8'),PASSWORD_DEFAULT);
$NOW_TIME = new DateTime();
$NOW_TIME = $NOW_TIME->format('Y-m-d H:i:s');

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
    $stmt = $pdo->prepare('INSERT INTO id (LoginID,LastLogin,Password,SessionID) VALUES (:id,:dateT,:ps,:sid)');
 
    // 値をセット
    $stmt->bindValue(':id', $ID);
    $stmt->bindValue(':dateT',$NOW_TIME);
    $stmt->bindValue(':ps', $Password);
    $stmt->bindValue(':sid',"sid");
    // SQL実行
    $stmt->execute();
 
} catch (PDOException $e) {
    echo('<script>document.getElementedByID("errormessage").innerHTML = "このIDは使用できません。"</script>');
} finally {
    //session ID をどうのこうの
    echo('<script>document.getElementedByID("errormessage").innerHTML = "成功です。"</script>');
    $pdo = null;
}

?>