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
        if ($_GET['command'] == "create") {
            // 連番が記録してあるファイルを読み込んで1だけインクリメントする
            $no = file_get_contents($room_dir . 'serial_number.dat');
            file_put_contents($room_dir . 'serial_number.dat', $no + 1);

            try {
                $pdo = myDataBase::createPDO();
                $pdo->query('SET NAMES utf8');

                // ニックネームの読み込み
                $stmt = $pdo->prepare('SELECT * FROM accounts WHERE number = :number');
                $stmt->bindValue(':number', $_SESSION['number'], PDO::PARAM_INT);
                $stmt->execute();

                $account_data = $stmt->fetch(PDO::FETCH_ASSOC);
                $nickname = $account_data['nickname'];

                $player_str  = "黒：{$nickname}\n";
                $player_str .= "白：";

                file_put_contents($room_dir . "game_player_{$no}.dat", $player_str);

                $pdo = null;        // データベースとの接続を終了する
            }
            catch (PDOException $e) {
                exit($e->getMessage());
            }

            // 必要なデータをアサイン
            $smarty->assign('share_filename', $room_dir . "gamefield_{$no}.dat");
            $smarty->assign('own_color', '0');
            $smarty->assign('black_player', 'human');
            $smarty->assign('white_player', 'online_player');

            $smarty->display('othello.tpl');
            exit;            
        }
    }
?>