<?php
    // POST取得
    $filename     = $_POST['filename'];
    $othello_data = $_POST['othello_data'];
    $stone_color  = $_POST['stone_color'];
    $inp_index    = $_POST['inp_index'];
    $x = $inp_index % 8;
    $y = (int)($inp_index / 8);
    echo <<<EOM
filename:{$filename}
othello_data:{$othello_data}
stone_color:{$stone_color}
inp_index:{$inp_index}
(x, y):({$x}, {$y})
EOM;

    $past_data = file_get_contents($filename);
    $past_dats = explode("\n", $past_data);
    $fp = fopen($filename, "w");

    // オセロデータを書き込む
    fwrite($fp, $othello_data);
    
    // 過去の入力データを書き込む
    $length = count($past_dats);

    // オセロデータはいらないためそれ以降のデータを書き込む
    for ($i = 8; $i < $length; $i++) {
        fwrite($fp, $past_dats[$i] . "\n");
    }
    // 現在の入力データを書き込む
    fwrite($fp, "{$stone_color}:{$x},{$y}");

    fclose($fp);
?>