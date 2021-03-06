<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>コメント投稿</title>
<script language="JavaScript">
function check() {
    // 確認ダイアログを表示してその結果を返す
    return window.confirm('この掲示板を削除してもよろしいですか？');
};
</script>
</head>
<body>
<h1>掲示板詳細</h1>
<table border="1" class="table">
<tr><td>タイトル</td><td colspan="3">{$article.title}</td></tr>
<tr><td>作成者</td><td>{$article.author}</td><td>作成日</td><td>{$article.created}</td></tr>
<tr><td colspan="4">{$article.detail|nl2br}</td></tr>
</table>
{if ($edit_flag)}
<br />
<table>
<tr>
<td><form action="edit_form.php" method="get">
    <input type="hidden" name="id" value="{$article.id}" />
    <input type="submit" value="編集する" />
</form></td>
<td><form action="delete.php" method="post" onSubmit="return check()">
    <input type="hidden" name="id" value="{$article.id}" />
    <input type="submit" value="削除する" />
</form></td>
</tr>
</table>
{/if}
<h2>この記事へのコメント</h2>
<div class="coms">
    {foreach $comments as $comment}
    <h3>{$comment.name} ({$comment.created})</h3>
    <p>{$comment.comment|nl2br}</p>
    {/foreach}
</div>
<form action="regist_comment.php" method="post">
    コメント：<br />
    <textarea name="comment" id="" cols="30" rows="5"></textarea><br />
    <input type="hidden" name="news_id" value="{$article.id}" />
    <br />
    <input type="submit" value="コメントする" />
</form>
<ul>
    <li><a href="top.php">一覧へ戻る</a></li>
</ul>
</body>
</html>
