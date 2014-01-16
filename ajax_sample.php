<?php
  // POSTを取得
  $filename = $_POST['filename'] ;
  // ファイルデータを読み込む
  $data = file_get_contents($filename);
  // 出力
  echo('<p>' . nl2br($data) . '</p>');
?>
