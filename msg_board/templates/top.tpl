<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8"/>
<!-- ファイル階層は読み込んでいるPHP視点から -->
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>掲示板</title>
</head>
<body>
<h1>掲示板一覧</h1>
<ul>
    {foreach $articles as $article}
    <li><a href="view.php?id={$article.id}">No.{$article.id}{$article.title|escape}</a></li>
    {/foreach}
</ul>
<ul>
    <li><a href="regist_form.php">新規登録</a></li>
    <li><a href="../index.php">TOPに戻る</a></li>
</ul>
</body>
</html>
