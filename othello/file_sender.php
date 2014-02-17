<?php
    // POST取得
    $filename = $_POST['filename'];
    $data     = $_POST['data'];

    file_put_contents($filename, $data);

    echo("$data");
?>