<?php
    // テンプレート利用準備
    require_once 'smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // フォーム送信でない時（ログインするために来た時）
    if (!isset($_POST['id'])) {
        $smarty->assign('error_message', '');
        $smarty->display('login.html');
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
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data == null) {
            $error_message .= "このIDは使われていません。\n";
        }
        else {
            if ($_POST['password'] != $data['password']) {
                $error_message .= "パスワードが正しくありません。\n";
            }
        }

        // エラーがあったかを見る
        if ($error_message != '') {
            $smarty->assign('error_message', '<h2>' . nl2br($error_message) . '</h2>');
            $smarty->display('login.html');
            exit;
        }
    }
    catch(PDOException $e) {
        exit($e->getMessage());
    }

    // エラーがない時
    $auto_login_flag = (isset($_POST['auto_login'])) ? 'true' : 'false';

    echo <<<EOM
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>test</title>
</head>
<body>
<p>ID:{$_POST['id']}</p>
<p>PW:{$_POST['password']}</p>
<p>AutoLogin:{$auto_login_flag}</p>
</body>
</html>
EOM;
?>