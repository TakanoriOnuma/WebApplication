<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>オセロのトップページ</title>
</head>
<body>
<p>
{$game_data|nl2br}
</p>
<h2>部屋</h2>
{if $room != ""}
<p>
{$room|nl2br}
</p>
{/if}
<p>
<a href="othello.php?command=create">新しい部屋を作成する</a><br />
<a href="othello.php?play=computer">コンピュータと対戦する</a><br />
<a href="../index.php">トップページに戻る</a>
</p>
</body>
</html>