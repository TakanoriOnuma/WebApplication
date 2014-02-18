<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>掲示板</title>
</head>
<body>
<h1>記事編集</h1>
<form action="edit.php" method="post">
    <input type="hidden" name="id" value="{$article.id}" />
    タイトル：<br />
    <input type="text" name="title" size="30" value="{$article.title|escape}" /><br />
    本文：<br />
    <textarea name="detail" id="" cols="30" rows="5">{$article.detail|escape}</textarea><br />
    <br />
    <input type="submit" value="編集する" />
</form>
<ul>
    <li><a href="view.php?id={$article.id}">記事へ戻る</a></li>
</ul>
</body>
</html>
