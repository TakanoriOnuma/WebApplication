<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>掲示板</title>
</head>
<body>
<h1>コメントする</h1>
<h2>No.{$article.id} {$article.title|escape}</h2>
<p>{$article.detail|escape|nl2br}</p>
<p>投稿日時：{$article.created}</p>
<h2>コメントする</h2>
<form action="regist_comment.php" method="post">
    名前：<br />
    <input type="text" name="name" size="30" value="" /><br />
    コメント：<br />
    <textarea name="comment" id="" cols="30" rows="5"></textarea><br />
    パスワード：<br />
    <input type="password" name="key" size="10" value="" /><br />
    <input type="hidden" name="news_id" value="{$article.id}" />
    <br />
    <input type="submit" value="コメントする" />
</form>
<ul>
    <li><a href="view.php?id={$article.id}">記事へ戻る</a></li>
</ul>
</body>
</html>
