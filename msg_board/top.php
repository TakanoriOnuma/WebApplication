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
        $stmt = $pdo->query('SELECT * FROM articles ORDER BY id DESC');

        // データ割り当て
        $articles = array();
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = $data;
        }
        $smarty->assign('articles', $articles);
    }
    catch (PDOException $e) {
        exit($e->getMessage());
    }

    // データベース接続終了
    $pdo = null;

    // 結果表示
    $smarty->display('top.tpl');
?>
