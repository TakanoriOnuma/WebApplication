<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>オセロのトップページ</title>
</head>
<body>
<h1>オセロのトップページ</h1>
<p>
{$game_data|nl2br}
</p>
<h2>部屋</h2>
{$room}
<h2>メニュー</h2>
<ul>
<li><a href="othello.php?command=create">新しい部屋を作成する</a></li>
<li><a href="othello.php?play=computer">コンピュータと対戦する</a></li>
<li><a href="../index.php">トップページに戻る</a></li>
</ul>
</body>
</html>