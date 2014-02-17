<?php
    // POST取得
    $filename     = $_POST['filename'];
    $othello_data = $_POST['othello_data'];
    $stone_color  = $_POST['stone_color'];
    $inp_index    = $_POST['inp_index'];
    echo <<<EOM
filename:{$filename}
othello_data:{$othello_data}
stone_color:{$stone_color}
inp_index:{$inp_index}
EOM;
?>