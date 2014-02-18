<?php
    require_once '../myDataBase.php';           // データベースアクセスクラスの読み込み

    // テンプレート利用準備
    require_once '../smarty/Smarty.class.php';
    
    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // セッションスタート
    session_start();

    // セッションにない時（まだログインしていない時)
    if (!isset($_SESSION['number'])) {
        exit("not login.");     // エラー
    }

    if (isset($_GET['play'])) {
        // コンピュータと戦うのなら
        if ($_GET['play'] == "computer") {
            // 必要なデータをアサイン
            $smarty->assign('own_color', '0');
            $smarty->assign('black_player', 'human');
            $smarty->assign('white_player', 'AI');

            $smarty->display('othello.tpl');
            exit;    
        }
    }

    $room_dir = "room/";
    if (isset($_GET['command'])) {
        // 新しく部屋を作るなら
        if ($_GET['command'] == "create") {
            // 連番が記録してあるファイルを読み込んで1だけインクリメントする
            $no = file_get_contents($room_dir . 'serial_number.dat');
            // 100を超えないように連番をつける
            file_put_contents($room_dir . 'serial_number.dat', ($no + 1) % 100);

            // プレイヤーの情報を書き込む
            $nickname = get_nickname($_SESSION['number']);
            $player_str  = "黒：{$nickname}\n";
            $player_str .= "白：";

            file_put_contents($room_dir . "game_player_{$no}.dat", $player_str);

            // 必要なデータをアサイン
            $smarty->assign('share_filename', $room_dir . "gamefield_{$no}.dat");
            $smarty->assign('own_color', '0');
            $smarty->assign('black_player', 'human');
            $smarty->assign('white_player', 'online_player');

            $smarty->display('othello.tpl');
            exit;            
        }
    }

    // 部屋番号があるなら
    if (isset($_GET['room_no'])) {
        $no = $_GET['room_no'];
        $nickname = get_nickname($_SESSION['number']);

        // プレイヤーの書き込み
        $fp = fopen($room_dir . "game_player_{$no}.dat", "a");
        fwrite($fp, $nickname);
        fclose($fp);

        // 必要なデータをアサイン
        $smarty->assign('share_filename', $room_dir . "gamefield_{$no}.dat");
        $smarty->assign('own_color', '1');
        $smarty->assign('black_player', 'online_player');
        $smarty->assign('white_player', 'human');

        $smarty->display('othello.tpl');
        exit;
    }
?>