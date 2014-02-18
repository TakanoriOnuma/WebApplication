<?php
    require_once '../myDataBase.php';      // データベースアクセスクラスの読み込み

    // テンプレート利用準備
    require_once '../smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // セッションスタート
    session_start();

    // セッションにない時（まだログインしていない時)
    if (!isset($_SESSION['number'])) {
        $smarty->assign('message', 'ログインしてください。');
        $smarty->display('error.tpl');
        exit;
    }

    // 入力内容チェック
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
        $pdo = myDataBase::createPDO();
        $pdo->query('SET NAMES utf8');

        $nickname = get_nickname($_SESSION['number']);

        // データ登録
        $stmt = $pdo->prepare('INSERT INTO articles(title, author, detail, created) VALUES(:title, :nickname, :detail, :created)');
        $stmt->bindValue(':title', $_POST['title']);
        $stmt->bindValue(':nickname', $nickname);
        $stmt->bindValue(':detail', $_POST['detail']);
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
