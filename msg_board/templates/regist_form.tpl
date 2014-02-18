<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<title>掲示板</title>
</head>
<body>
<h1>掲示板登録</h1>
<form action="regist.php" method="post">
    タイトル：<br />
    <input type="text" name="title" size="30" value="" /><br />
    本文：<br />
    <textarea name="detail" id="" cols="30" rows="5"></textarea><br />
    <br />
    <input type="submit" value="登録する" />
</form>
<ul>
    <li><a href="top.php">一覧へ戻る</a></li>
</ul>
</body>
</html>
