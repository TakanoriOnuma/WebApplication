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
{if $room != ""}{$room|nl2br}
{/if}
<p>
<a href="">新しい部屋を作成する</a><br />
<a href="othello.php">コンピュータと対戦する</a>
</p>
</body>
</html>