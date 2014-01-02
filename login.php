<?php
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