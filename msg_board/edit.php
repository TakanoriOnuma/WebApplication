<?php
    // テンプレート利用準備
    require_once '../smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // 入力内容のチェック
    if ($_POST['key'] != 'abcd') {
        $smarty->assign('message', 'パスワードが違います。');
        $smarty->display('error.tpl');
        exit;
    }
    if ($_POST['title'] == '' or $_POST['detail'] == '') {
        $smarty->assign('message', 'タイトルと本文を入力してください。');
        $smarty->display('error.tpl');
        exit;
    }

    try {
        // データベース接続
        $pdo = new PDO('mysql:dbname=phpdb;host=127.0.0.1', 'root', 'ayashi', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $pdo->query('SET NAMES utf8');

        // データ登録
        $stmt = $pdo->prepare('UPDATE articles SET title = :title, detail = :detail WHERE id = :id');
        $stmt->bindValue(':title',  $_POST['title']);
        $stmt->bindValue(':detail', $_POST['detail']);
        $stmt->bindValue(':id',     $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
    }
    catch(PDOException $e) {
        exit($e->getMessage());
    }

    // データベース接続終了
    $pdo = null;

    // 結果表示
    $smarty->display('complete.tpl');
?>
