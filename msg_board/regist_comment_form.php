<?php
    // テンプレート利用準備
    require_once '../smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    try {
        // データベース接続
        $pdo = new PDO('mysql:dbname=phpdb;host=127.0.0.1', 'root', 'ayashi', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $pdo->query('SET NAMES utf8');

        // データ検索
        $stmt = $pdo->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        // データ割り当て
        if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $smarty->assign('article', $data);
        }
        else {
            $smarty->assign('message', '指定された掲示板が見つかりません。');
            $smarty->display('error.tpl');
            exit;
        }
    }
    catch (PDOException $e) {
        exit($e->getMessage());
    }

    // データベース接続終了
    $pdo = null;

    // 結果表示
    $smarty->display('regist_comment_form.tpl');
?>
