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