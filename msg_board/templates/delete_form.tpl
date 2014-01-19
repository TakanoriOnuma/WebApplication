<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>掲示板</title>
</head>
<body>
<h1>掲示板削除</h1>
<form action="delete.php" method="post">
    <input type="hidden" name="id" value="{$article.id}" />
    パスワード：<br />
    <input type="password" name="key" size="10" value="" /><br />
    <br />
    <input type="submit" value="削除する" />
</form>
<ul>
    <li><a href="view.php?id={$article.id}">記事へ戻る</a></li>
</ul>
</body>
</html>
