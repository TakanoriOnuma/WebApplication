<?php
    require_once '../myDataBase.php';       // データベースアクセスクラスの読み込み

    // セッションスタート
    session_start();

    // セッションにない時（まだログインしていない時)
    if (!isset($_SESSION['number'])) {
        exit("not login.");     // エラー
    }

    $result_str = $_POST['result_str'];

    try {
        $pdo = myDataBase::createPDO();
        $pdo->query('SET NAMES utf8');

        // 対戦数を1つ増やす
        $stmt = $pdo->prepare('UPDATE game_scores SET game_num = game_num + 1 WHERE number = :number');
        $stmt->bindValue(':number', $_SESSION['number']);
        $stmt->execute();

        // もし勝ったのなら
        if ($result_str == "win") {
            $stmt = $pdo->prepare('UPDATE game_scores SET winning_num = winning_num + 1 WHERE number = :number');
            $stmt->bindValue(':number', $_SESSION['number']);
            $stmt->execute();
        }

        $pdo = null;        // データベースとの接続を終了する
    }
    catch (PDOException $e) {
        exit($e->getMessage());
    }
?>