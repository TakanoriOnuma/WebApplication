<?php
    // POST取得
    $filename     = $_POST['filename'];
    $othello_data = $_POST['othello_data'];
    $color        = $_POST['color'];
    $inp_index    = $_POST['inp_index'];
    $x = $inp_index % 8;
    $y = (int)($inp_index / 8);

    // pass情報を入力しろときたら
    if ($inp_index == "pass") {
        $fp = fopen($filename, "a");
        fwrite($fp, "\n{$color}:pass");
        fclose($fp);
        exit();         // 終了する
    }

    // 今現在のファイルデータを読み込む
    $past_data = file_get_contents($filename);
    $past_dats = explode("\n", $past_data);

    // 新しく書き込む
    $fp = fopen($filename, "w");
    // オセロデータを書き込む
    fwrite($fp, $othello_data);

    // 過去の入力データを書き込む
    $length = count($past_dats);
    // オセロデータはいらないためそれ以降のデータを書き込む
    for ($i = 8; $i < $length; $i++) {
        fwrite($fp, $past_dats[$i] . "\n");
    };
    
    // 現在の入力データを書き込む
    fwrite($fp, "{$color}:{$x},{$y}");

    fclose($fp);
?>