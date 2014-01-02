<?php
    // テンプレート利用準備
    require_once 'smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // フォーム送信でない時（登録するために来た時）
    if (!isset($_POST['id'])) {
        $smarty->assign('error_message', '');
        $smarty->assign('id', '');
        $smarty->assign('nickname', '');
        $smarty->assign('password', '');
        $smarty->assign('check_pass', '');
        $smarty->display('register.html');
        exit;
    }

    // フォーム送信で来たとき
    try {
        $pdo = new PDO('mysql:dbname=phpdb;host=127.0.0.1', 'root', 'ayashi', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $pdo->query('SET NAMES utf8');

        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = :id');
        $stmt->bindValue(':id', $_POST['id']);
        $stmt->execute();

        $error_message = '';        // エラーなしと宣言しておく
        // エラーチェック
        if($stmt->fetch(PDO::FETCH_ASSOC)) {
            $error_message .= "このIDは既に使われています。\n";
        }
        if ($_POST['id'] == '' or $_POST['nickname'] == '') {
            $error_message .= "IDかニックネームが記入していません。\n";
        }
        if ($_POST['password'] == '') {
            $error_message .= "パスワードが入力してありません。\n";
        }
        if ($_POST['password'] != $_POST['check_pass']) {
            $error_message .= "パスワードが一致していません。\n";
        }

        // エラーがあったか見る
        if ($error_message != '') {
            $smarty->assign('error_message', '<h2>' . nl2br($error_message) . '</h2>');
            $smarty->assign('id', $_POST['id']);
            $smarty->assign('nickname', $_POST['nickname']);
            $smarty->assign('password', $_POST['password']);
            $smarty->assign('check_pass', $_POST['check_pass']);
            $smarty->display('register.html');
            exit;
        }

        // エラーなしの処理
        $hash_pass = sha1($_POST['password']);
        $stmt = $pdo->prepare('INSERT INTO accounts(id, nickname, password) VALUES(:id, :nickname, :password)');
        $stmt->bindValue(':id', $_POST['id']);
        $stmt->bindValue(':nickname', $_POST['nickname']);
        $stmt->bindValue(':password', $hash_pass);
        $stmt->execute();

        $pdo = null;        // データベースとの接続を終了する
    }
    catch(PDOException $e) {
        exit($e->getMessage());
    }

    // 登録が成功したと表示する
    $smarty->display('complete.html');
?>