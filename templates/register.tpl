<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>会員登録</title>
</head>
<body>
<h1>会員登録</h1>
{if isset($error_message)}<h2 class="error">{$error_message|nl2br}</h2>
{/if}
<form action="register.php" method="post">
<p>
    登録したいID：<input type="text" name="id" value="{$id|default:''}"><br />
    ニックネーム：<input type="text" name="nickname" value="{$nickname|default:''}"><br />
    パスワード：<input type="password" name="password" value="{$password|default:''}"><br />
    確認用パスワード：<input type="password" name="check_pass" value="{$check_pass|default:''}"><br /><br />
    <input type="submit" value="提出する">
    <input type="reset" value="リセット">
</p>
</form>
</body>
</html>