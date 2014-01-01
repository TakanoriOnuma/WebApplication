<?php
    // テンプレート利用準備
    require_once 'smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // フォーム送信でない時（登録するために来た時）
    if (!isset($_POST['id'])) {
        $smarty->assign('error_message', '');
        $smarty->display('register.html');
        exit;
    }

    // フォーム送信で来たとき


    // 文字コードの都合上先に宣言する
    echo <<<EOM
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>test</title>
</head>
EOM;

    $error_message = '';        // エラーなしと宣言しておく
    // エラーチェック
    if ($_POST['id'] == '' or $_POST['nickname'] == '') {
        $error_message = 'IDかニックネームが記入していません。';
    }
    else if ($_POST['password'] == '') {
        $error_message = 'パスワードが入力してありません。';
    }
    else if ($_POST['password'] != $_POST['check_pass']) {
        $error_message = 'パスワードが一致していません。';
    }

    // エラーがあったか見る
    if ($error_message != '') {
        $smarty->assign('error_message', '<h2>' . $error_message . '</h2>');
        $smarty->display('register.html');
        exit;
    }

    echo <<<EOM
<body>
<p>ID:{$_POST['id']}</p>
<p>ニックネーム:{$_POST['nickname']}</p>
<p>パスワード:{$_POST['password']}</p>
<p>確認用パスワード:{$_POST['check_pass']}</p>
</body>
</html>
EOM;
?>