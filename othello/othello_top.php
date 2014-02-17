<?php
    require_once '../myDataBase.php';       // データベースアクセスクラスの読み込み

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

    try {
        $pdo = myDataBase::createPDO();
        $pdo->query('SET NAMES utf8');

        // ニックネームの読み込み
        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE number = :number');
        $stmt->bindValue(':number', $_SESSION['number'], PDO::PARAM_INT);
        $stmt->execute();

        $account_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $nickname = $account_data['nickname'];

        // ゲームスコアの読み込み
        $stmt = $pdo->prepare('SELECT * FROM game_scores WHERE number = :number');
        $stmt->bindValue(':number', $_SESSION['number'], PDO::PARAM_INT);
        $stmt->execute();

        $game_score = $stmt->fetch(PDO::FETCH_ASSOC);

        $winning_rate = "";
        // まだ対戦をしたことないなら
        if ($game_score['game_num'] == 0) {
            $winning_rate = "-";
        }
        else {
            $winning_rate = ($game_score['winning_num'] / $game_score['game_num']) * 100;
        }

        $game_data_str = <<< EOM
{$nickname}さん
ゲーム数：{$game_score['game_num']}
勝数：{$game_score['winning_num']}
勝率：{$winning_rate}%
EOM;
        // 自分の情報をアサインする
        $smarty->assign('game_data', $game_data_str);

        $pdo = null;        // データベースとの接続を終了する
    }
    catch (PDOException $e) {
        exit($e->getMessage());
    }

    // 0～99までのファイルをチェックする
    $base_file_format = "room/game_player_%d.dat";
    $room_str = "";
    for ($i = 0; $i < 100; $i++) {
        $filename = sprintf($base_file_format, $i);
        if (file_exists($filename)) {
            // ファイルの読み込み
            $fp = fopen($filename, "r");

            // プレイヤーの情報を読み取る
            list($black, $black_name) = explode("：", fgets($fp));
            list($white, $white_name) = explode("：", fgets($fp));

            // ファイルを閉じる
            fclose($fp);

            $black_name = mb_substr($black_name, 0, -2);
            $room_name = $black_name . "さんの部屋";
            // 相手がいないなら
            if ($white_name == "") {
                $room_str .= "<a href=\"othello.php?room_no={$i}\">{$room_name}</a>\n";                
            }
            // 相手がいたら
            else {
                 $room_str .= "{$room_name}（対戦中）\n";
            }
        }
    }
    // 部屋の情報をアサインする
    $smarty->assign('room', $room_str);
    // 結果を表示する
    $smarty->display('othello_top.tpl');
?>