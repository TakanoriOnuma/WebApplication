<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>ログイン</title>
</head>
<body>
<h1>ログイン</h1>
{if isset($error_message)}<h2 class="error">{$error_message|nl2br}</h2>
{/if}
<form action="login.php" method="post">
<p>
    ID：<input type="text" name="id" value="{$id|default:''}"><br />
    パスワード：<input type="password" name="password" value="{$password|default:''}"><br />
    <input type="submit" value="送信">
</p>
</form>
</body>
</html>