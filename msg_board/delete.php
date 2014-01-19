<?php
    // テンプレート利用準備
    require_once '../smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // 入力内容チェック
    if($_POST['key'] != 'abcd') {
        $smarty->assign('message', 'パスワードが違います。');
        $smarty->assign('error.tpl');
        exit;
    }

    try {
        // データベース接続
        $pdo = new PDO('mysql:dbname=phpdb;host=127.0.0.1', 'root', 'ayashi', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $pdo->query('SET NAMES utf8');

        // データ削除
        $stmt = $pdo->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();

        // コメントデータも削除
        $stmt = $pdo->prepare('DELETE FROM comments WHERE news_id = :id');
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
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
