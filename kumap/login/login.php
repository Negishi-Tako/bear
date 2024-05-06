<?php
$ID = htmlspecialchars(filter_input(INPUT_POST, 'loginID'), ENT_QUOTES, 'UTF-8');
$Password = htmlspecialchars(filter_input(INPUT_POST, 'Password'), ENT_QUOTES, 'UTF-8');
$ID = password_hash($ID,PASSWORD_DEFAULT);
$Password = password_hash($Password,PASSWORD_DEFAULT);
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
    $stmt = $pdo->prepare('SELECT * FROM id WHERE LoginID = :id AND Password = :ps');
    // 値をセット
    $stmt->bindValue(':id', $ID);
    $stmt->bindValue(':ps', $Password);
    // SQL実行
    $stmt->execute();
 
} catch (PDOException $e) {
    echo('<script>document.getElementedByID("errormessage").innerHTML = "ログイン失敗"</script>');
} finally {
    //session ID をどうのこうの
    echo('ログイン成功');
    $pdo = null;
}
?>