<!DOCTYPE html>
<html lang="ja">
<head>
<title>オセロ</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="stylesheet/style.css" type="text/css" />
<script language="JavaScript" src="../lib/javascript/ajax.js"></script>
<script language="JavaScript" src="server_file_process.js"></script>
<script language="JavaScript" src="player.js"></script>
<script language="JavaScript" src="othello_process.js"></script>
<script language="JavaScript">
//*******************************************************************
//**　グローバル変数定義（どの関数からも参照可能） **
//*******************************************************************
var game_speed = 1000;       // ゲームスピード

// 石の色データ（オセロ盤で使われる変数）
var black = 1;      // 黒
var white = 2;      // 白

var own_color = {$own_color};       // どっちが自分か（黒(0)、白(1)）

var use_server_flag = false;        // サーバーに通信を行うか否か
var filename = "{$share_filename|default: ''}";    // 共有するファイル名
var player1;        // プレイヤー1
var player2;        // プレイヤー2
var now_player = null;       // 今プレイするプレイヤー（石を置くプレイヤー）

var table = new Array(); 
for (i = 0; i < 64; i++) {
    table[i] = 0;
};
// 初期の配置
table[27] = table[36] = white;
table[28] = table[35] = black;
// 画像の設定
var images = new Array();
images[0] = new Image(); images[0].src = "images/background.gif";
images[1] = new Image(); images[1].src = "images/black.gif";
images[2] = new Image(); images[2].src = "images/white.gif";
images[3] = new Image(); images[3].src = "images/reverse.gif";

// どっちの手かを文字列で返す
function get_turn_str(turn) {
    return (turn == black - 1) ? "黒" : "白";
}

// オセロデータを文字列にして返す
function get_othello_data_str() {
    var othello_data_str = "";
    for (var i = 0; i < 8; i++) {
        for (var j = 0; j < 8; j++) {
            othello_data_str += table[i*8 + j];
        };
        othello_data_str += "\n";
    };
    return othello_data_str;
};

// 文字列を引数にプレイヤーを生成する
function create_player(player_name, color) {
    var player;
    if (player_name == "human") {
        player = new Human(color);
    }
    else if (player_name == "AI") {
        player = new AI1(color);
    }
    else if (player_name == "online_player") {
        player = new OnlinePlayer(color, filename);
    };

    return player;
};
//*******************************************************************
//** 開始(startは使えないため、g_startにした) **
//*******************************************************************
function g_start() {
    alert("start");

    player1 = create_player("{$black_player}", black - 1);
    player2 = create_player("{$white_player}", white - 1);

    document.form1.start_button.disabled = true;    // ボタンを使えなくする

    // オセロの最初の状態にセット
    for (var i = 0; i < 64; i++) {
        if (i == 27 || i == 36) {
            table[i] = white;
            document.images[i].src = images[white].src;
        }
        else if (i == 28 || i == 35) {
            table[i] = black;
            document.images[i].src = images[black].src;
        }
        else {
            table[i] = 0;
            document.images[i].src = images[0].src;
        };
    };
    now_player = player1;
    // サーバーと通信を行うかのフラグをチェック
    if (player1 instanceof OnlinePlayer || player2 instanceof OnlinePlayer) {
        use_server_flag = true;

        // 相手プレイヤーがオンラインプレイヤーの時だけ初期化を行う
        // (相手も初期化したらマズいことになる可能性が)
        if (player2 instanceof OnlinePlayer) {
            var othello_data_str = get_othello_data_str();
            // 一番後ろの改行を取り除く
            othello_data_str = othello_data_str.slice(0, -1);
            // サーバー上で使うファイルを初期化する(callbackはいらない)
            file_sender(filename, othello_data_str, null);
        };
    }
    else {
        use_server_flag = false;
    };
    main();            // メインへ飛ぶ
}

//*******************************************************************
//** メイン **
//*******************************************************************
function main() {
    document.form1.info.value = get_turn_str(now_player.color) + "の番";
    var black_stone_num = white_stone_num = 0;
    for (var i = 0; i <= 63; i++) {
        if (table[i] == black) {
            black_stone_num++;
        };
        if (table[i] == white) {
            white_stone_num++;
        };
    };
    document.form1.black.value = black_stone_num;
    document.form1.white.value = white_stone_num;

    // パスをしてしまうか
    if (pass_check(now_player.color + 1)) {
        // 相手のプレイヤーを取得
        var opp_player = (now_player == player1) ? player2 : player1;
        // 相手もパスなら
        if (pass_check(opp_player.color + 1)) {
            gameset();     // 終了
            return;
        }
        // 相手は出来るなら
        else {

            // 相手（player2）がOnlinePlayerならこのパス情報を記録する
            if (player2 instanceof OnlinePlayer) {
                send_othello_data(filename, "no change", now_player.color, "pass", alert_pass);
                return;
            };
            alert_pass();
            return;
        };
    };

    // 石の数をゲームを続けられるか判断（パスフラグだけでも判断できそう）
    if (black_stone_num + white_stone_num == 64 || black_stone_num == 0 || white_stone_num == 0) {
        gameset();
        return;
    };
    now_player.input();
};

// パスをすると伝える
function alert_pass() {
    alert(get_turn_str(now_player.color) + "はパス。");
    setTimeout(next(), game_speed);     // 次へ回す
};

// 石が置けずにパスをするかの確認
// stone_colorは石の色（黒(1)か白(2)）
function pass_check(stone_color) {
    var pass_flag = true;
    for (var i = 0; i <= 63; i++) {
        var x = i % 8;
        var y = Math.floor(i / 8);
        var rev_num = get_rev_num(x, y, stone_color);
        // 反転できる場所があるなら
        if (rev_num != 0){
            pass_flag = false;      // パスはしない
            break;
        };
    };
    return pass_flag;
}


//*******************************************************************
//** (i % 8, i / 8)に石を置く **
//*******************************************************************
function input(i) {
    // まだゲームを始めてないなら
    if (now_player == null) {
        return;         // 何もしない
    };
    // プレイヤーが人間か
    if (now_player instanceof Human) {
        now_player.self_input(i);
    };
};

// 次の処理（次のプレイヤーに移る）
function next() {
    // 次のプレイヤーへ移る
    now_player = (now_player == player1) ? player2 : player1;
    setTimeout('main()', game_speed);
}

// ゲーム終了
function gameset() {
    now_player = null;      // もうプレイヤーはいなくなる
    document.form1.start_button.disabled = false;       // ボタンが使えるようになる

    var black_stone_num = document.form1.black.value;
    var white_stone_num = document.form1.white.value;

    var info_str = "";
    var result_str = "";
    if (black_stone_num == white_stone_num) {
        info_str = "引き分けです";
        result_str = "draw";
    }
    else if (black_stone_num > white_stone_num) {
        info_str = "黒の勝ちです";
        // 自分が黒なら勝ち
        result_str = (own_color == 0) ? "win" : "lose";
    }
    else {
        info_str = "白の勝ちです。";
        // 自分が黒なら負け
        result_str = (own_color == 0) ? "lose" : "win";
    };

    alert("ゲーム終了\n" + info_str);
    document.form1.info.value = info_str;

    record_score(result_str);
}

// 結果をPHPを通してデータベースに記録する
function record_score(result_str) {
    var data = "result_str=" + result_str;
    sendRequest("POST", "./record_score.php", data, false, null);
};

//*******************************************************************
//** ロジック終了 **
//*******************************************************************
</script>

</head>

<body bgcolor="#eeffee" text="#111122">
<div align="center">
<form name="form1"><font size="3" font color="#000000">
<pre>
黒<input type="text" size="2" name="black" value="2">　　白<input type="text" size="2" name="white" value="2">
<input type="text" size="36" name="info" value="開始ボタンを押してください。"><br />
<input type="button" value="スタート" name="start_button" onClick="g_start()">
</pre>
</font>
</form>
</div>

<table align="center" border=3 bgcolor="#006633">
<tr><td>
<script language="JavaScript">
var i;
// オセロの画像を設置
for (i = 0; i < 64; i++) {
    document.write('<a href="JavaScript:input(',i,')"><img src="images/background.gif" width=38 height=38 border=0></a>');
    if(i % 8 == 7) {
        document.write('<br />');
    };
};
// 初期の白と黒の石を設置
document.images[27].src = images[white].src;
document.images[28].src = images[black].src;
document.images[35].src = images[black].src;
document.images[36].src = images[white].src;
</script>
</td></tr>
</table>
<p align="center"><a href="othello_top.php">オセロのトップページに戻る</a></p>
</body>
</html>