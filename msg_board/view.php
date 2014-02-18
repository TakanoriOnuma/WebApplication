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
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $data['created'] = str_replace("-", "/", $data['created']);
            $smarty->assign('article', $data);
        }
        else {
            $smarty->assign('message', '指定された掲示板が見つかりません。');
            $smarty->display('error.tpl');
            exit;
        }

        $edit_flag = false;     // 掲示板の修正を認めるか
        // セッションスタート
        session_start();
        // セッションにある時（ログインしている時)
        if (isset($_SESSION['number'])) {
            // 作成者本人かの確認
            $nickname = get_nickname($_SESSION['number']);
            // 作成者本人なら
            if ($nickname == $data['author']) {
                $edit_flag = true;
            }
        }
        $smarty->assign('edit_flag', $edit_flag);

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
