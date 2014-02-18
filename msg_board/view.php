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

        // データ検索
        $stmt = $pdo->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        // データ割り当て
        if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data['created'] = str_replace("-", "/", $data['created']);
            $smarty->assign('article', $data);
        }
        else {
            $smarty->assign('message', '指定された掲示板が見つかりません。');
            $smarty->display('error.tpl');
            exit;
        }

        // データ検索
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE news_id = :id');
        $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        $data_array = array();
        // データ割り当て
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data['created'] = str_replace("-", "/", $data['created']);
            $data_array[] = $data;
        }
        $smarty->assign('comments', $data_array);
    }
    catch (PDOException $e) {
        exit($e->getMessage());
    }

    // データベース接続終了
    $pdo = null;

    // 結果表示
    $smarty->display('view.tpl');
?>
