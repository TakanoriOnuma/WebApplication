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
    $smarty->display('edit_form.tpl');
?>
