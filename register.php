<?php
    echo <<<EOM
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>test</title>
</head>
<body>
<p>ID:{$_POST['id']}</p>
<p>ニックネーム:{$_POST['nickname']}</p>
<p>パスワード:{$_POST['password']}</p>
<p>確認用パスワード:{$_POST['check_pass']}</p>
</body>
</html>
EOM;
?>