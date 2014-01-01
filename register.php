<?php
    // 文字コードの都合上先に宣言する
    echo <<<EOM
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>test</title>
</head>
EOM;

    // エラーチェック
    if ($_POST['id'] == '' or $_POST['nickname'] == '') {
        exit('IDかニックネームが記入していません。');
    }
    if ($_POST['password'] == '') {
        exit('パスワードが入力してありません。');
    }
    if ($_POST['password'] != $_POST['check_pass']) {
        exit('パスワードが一致していません。');
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