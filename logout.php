<?php
    // セッション開始
    session_start();

    unset($_SESSION['number']);     // 会員番号を破棄する

    echo <<<EOM
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>ログアウト</title>
</head>
<body>
<p>ログアウトしました。</p>
<p><a href="index.php">トップページに戻る</a></p>
</body>
</html>
EOM;
?>