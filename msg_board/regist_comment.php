<?php
    // テンプレート利用準備
    require_once '../smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // 入力内容チェック
    if ($_POST['key'] != 'abcd') {
        $smarty->assign('message', 'パスワードが違います。');
        $smarty->display('error.tpl');
        exit;
    }
    if ($_POST['name'] == '' or $_POST['comment'] == '') {
        $smarty->assign('message', '名前とコメントを入力してください。');
        $smarty->display('error.tpl');
        exit;
    }

    try {
        // データベース接続
        $pdo = new PDO('mysql:dbname=phpdb;host=127.0.0.1', 'root', 'ayashi', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $pdo->query('SET NAMES utf8');

        // データ登録
        $stmt = $pdo->prepare('INSERT INTO comments(news_id, name, comment, created) VALUES(:news_id, :name, :comment, :created)');
        $stmt->bindValue(':news_id', $_POST['news_id']);
        $stmt->bindValue(':name', $_POST['name']);
        $stmt->bindValue(':comment', $_POST['comment']);
        date_default_timezone_set('Asia/Tokyo');
        $stmt->bindValue(':created', date('Y-m-d H:i:s'));
        $stmt->execute();
    }
    catch (PDOException $e) {
        exit($e->getMessage());
    }

    // データベース接続終了
    $pdo = null;

    // 結果表示
    $smarty->display('complete.tpl');
?>
