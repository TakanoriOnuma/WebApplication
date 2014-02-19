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
<table border=1>
<tr><th>No.</th><th>タイトル</th><th>作成者</th><th>作成日</th><tr>
{foreach $articles as $article}
<tr>
<td>{$article.id}</td>
<td><a href="view.php?id={$article.id}">{$article.title|escape}</a></td>
<td>{$article.author}</td>
<td>{$article.created}</td>
</tr>
{/foreach}
</table>
<ul>
    <li><a href="regist_form.php">新規登録</a></li>
    <li><a href="../index.php">トップページに戻る</a></li>
</ul>
</body>
</html>
