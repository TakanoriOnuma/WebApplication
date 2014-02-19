<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>オンラインオセロ</title>
</head>
<body>
<h1>オンラインオセロ</h1>
{if isset($account_data)}<p>{$account_data|nl2br}</p>
{/if}
<ul>
{if isset($account_having)}
<li><a href="othello/othello_top.php">ゲーム</a></li>
<li><a href="logout.php">ログアウト</a></li>
{else}
<li><a href="register.php">会員登録</a></li>
<li><a href="login.php">ログイン</a></li>
{/if}
<li><a href="guide.html">ガイド</a></li>
<li><a href="ranking.html">ランキング</a></li>
<li><a href="msg_board/top.php">掲示板へ</a></li>
</ul>
</body>
</html>
