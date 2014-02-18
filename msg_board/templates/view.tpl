<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>コメント投稿</title>
</head>
<body>
<h1>掲示板詳細</h1>
<table border="1">
<tr><td>タイトル</td><td colspan="3">{$article.title}</td></tr>
<tr><td>作成者</td><td>{$article.author}</td><td>作成日</td><td>{$article.created}</td></tr>
<tr><td colspan="4">{$article.detail}</td></tr>
</table>
<ul>
    <li><a href="edit_form.php?id={$article.id}">編集</a></li>
    <li><a href="delete_form.php?id={$article.id}">削除</a></li>
</ul>
<h2>この記事へのコメント</h2>
<div class="coms">
    {foreach $comments as $comment}
    <h3>{$comment.name} ({$comment.created})</h3>
    <p>{$comment.comment}</p>
    {/foreach}
</div>
<ul>
    <li><a href="regist_comment_form.php?id={$article.id}">コメントする</a></li>
    <li><a href="top.php">一覧へ戻る</a></li>
</ul>
</body>
</html>
