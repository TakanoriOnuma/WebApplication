<?php
    require_once '../myDataBase.php';      // データベースアクセスクラスの読み込み

    // テンプレート利用準備
    require_once '../smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    try {
        $pdo = myDataBase::createPDO();
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
