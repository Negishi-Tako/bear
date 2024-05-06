<?php
    $TIME = htmlspecialchars(filter_input(INPUT_POST, 'dateT'), ENT_QUOTES, 'UTF-8');
    $X = htmlspecialchars(filter_input(INPUT_POST, 'x'), ENT_QUOTES, 'UTF-8');
    $Y = htmlspecialchars(filter_input(INPUT_POST, 'y'), ENT_QUOTES, 'UTF-8');
    $NOW_TIME = new DateTime();
    $NOW = $NOW_TIME->format('Y-m-d H:i:s');
    $file = fopen("database.txt", "a");
    fputs($file, $TIME.",".$X.",".$Y.",".$NOW);
    fclose($file);
    echo("データを登録しました。".$NOW);
    echo("<a href='../index/'>kumapへもどる</a>");
?>