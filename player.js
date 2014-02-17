//************************************************
//** オセロのプレイヤーをクラス化する **
//************************************************

// --- Playerクラス ---//
function Player(color) {
	this.color = color;		// どっちの石か（黒(0)か白(1)か）
}

// inputメソッドの空定義
Player.prototype.input = function() {
};

// --- Humanクラス（人がプレイヤー） --- //
function Human(color) {
	// 親クラスPlayerのコンストラクタを呼ぶ
	Player.call(this, color);
    this.input_flag = false;        // 入力を受け付けるか
}

// Playerのメソッドを継承する
Human.prototype = new Player();
// コンストラクタのポインタを修正
Human.prototype.constructor = Human;
// inputメソッドのオーバーライド
Human.prototype.input = function() {
    this.input_flag = true;         // 入力を受け付ける
}
// 自分でinputする（入力イベントが来て初めて入力なため、普通の入力とは少し違う）
Human.prototype.self_input = function(i) {
    if (this.input_flag) {
        var x, y;
        x = i % 8;
        y = Math.floor(i / 8);
        var rev_num = get_rev_num(x, y, this.color + 1);
        // 反転できるなら
        if (rev_num > 0) {
            // そこに石を置く
            document.images[i].src = images[this.color + 1].src;
            table[i] = this.color + 1;
            inp_index = i;              // 石を置く場所を入れておく（反転処理で使う）
            this.input_flag = false;    // 入力を受け付けない
            setTimeout('rev_motion()', rev_motion_speed);
        }
    }
}

// --- AI1クラス（コンピュータがプレイヤー） --- //
function AI1(color) {
	// 親クラスPlayerのコンストラクタを呼ぶ
	Player.call(this, color);
};
// Playerのメソッドを継承する
AI1.prototype = new Player();
// コンストラクタのポインタを修正
AI1.prototype.constructor = AI1;
// inputメソッドのオーバーライド
AI1.prototype.input = function() {
    // thisオブジェクトを無名関数の引数に渡して実行できるようにした
	setTimeout(function(e){ e.auto_input(); }, game_speed, this);
};
// データを定義する
AI1.priority = new Array(2);
AI1.priority[0] = new Array(60);	// 黒のデータ
AI1.priority[1] = new Array(60);	// 白のデータ

// 黒の優先順位
AI1.priority[0][0]  = 56; AI1.priority[0][1]  = 63; AI1.priority[0][2]  =  7;
AI1.priority[0][3]  =  0; AI1.priority[0][4]  = 43; AI1.priority[0][5]  = 44;
AI1.priority[0][6]  = 37; AI1.priority[0][7]  = 29; AI1.priority[0][8]  = 20;
AI1.priority[0][9]  = 19; AI1.priority[0][10] = 26; AI1.priority[0][11] = 34;
AI1.priority[0][12] = 45; AI1.priority[0][13] = 21; AI1.priority[0][14] = 18;
AI1.priority[0][15] = 42; AI1.priority[0][16] = 59; AI1.priority[0][17] = 60;
AI1.priority[0][18] = 39; AI1.priority[0][19] = 31; AI1.priority[0][20] =  4;
AI1.priority[0][21] =  3; AI1.priority[0][22] = 24; AI1.priority[0][23] = 32;
AI1.priority[0][24] = 58; AI1.priority[0][25] = 61; AI1.priority[0][26] = 47;
AI1.priority[0][27] = 23; AI1.priority[0][28] =  5; AI1.priority[0][29] =  2;
AI1.priority[0][30] = 16; AI1.priority[0][31] = 40; AI1.priority[0][32] = 51;
AI1.priority[0][33] = 52; AI1.priority[0][34] = 38; AI1.priority[0][35] = 30;
AI1.priority[0][36] = 12; AI1.priority[0][37] = 11; AI1.priority[0][38] = 25;
AI1.priority[0][39] = 33; AI1.priority[0][40] = 53; AI1.priority[0][41] = 46;
AI1.priority[0][42] = 22; AI1.priority[0][43] = 13; AI1.priority[0][44] = 10;
AI1.priority[0][45] = 17; AI1.priority[0][46] = 41; AI1.priority[0][47] = 50;
AI1.priority[0][48] = 57; AI1.priority[0][49] = 62; AI1.priority[0][50] = 55;
AI1.priority[0][51] = 15; AI1.priority[0][52] =  6; AI1.priority[0][53] =  1;
AI1.priority[0][54] =  8; AI1.priority[0][55] = 48; AI1.priority[0][56] = 49;
AI1.priority[0][57] = 54; AI1.priority[0][58] = 14; AI1.priority[0][59] =  9;
// 白の優先順位
AI1.priority[1][0]  =  0; AI1.priority[1][1]  =  7; AI1.priority[1][2]  = 63;
AI1.priority[1][3]  = 56; AI1.priority[1][4]  = 19; AI1.priority[1][5]  = 20;
AI1.priority[1][6]  = 29; AI1.priority[1][7]  = 37; AI1.priority[1][8]  = 44;
AI1.priority[1][9]  = 43; AI1.priority[1][10] = 34; AI1.priority[1][11] = 26;
AI1.priority[1][12] = 21; AI1.priority[1][13] = 45; AI1.priority[1][14] = 42;
AI1.priority[1][15] = 18; AI1.priority[1][16] = 11; AI1.priority[1][17] = 12;
AI1.priority[1][18] = 30; AI1.priority[1][19] = 38; AI1.priority[1][20] = 52;
AI1.priority[1][21] = 51; AI1.priority[1][22] = 33; AI1.priority[1][23] = 25;
AI1.priority[1][24] =  3; AI1.priority[1][25] =  4; AI1.priority[1][26] = 31;
AI1.priority[1][27] = 39; AI1.priority[1][28] = 60; AI1.priority[1][29] = 59;
AI1.priority[1][30] = 32; AI1.priority[1][31] = 24; AI1.priority[1][32] = 17;
AI1.priority[1][33] = 10; AI1.priority[1][34] = 13; AI1.priority[1][35] = 22;
AI1.priority[1][36] = 46; AI1.priority[1][37] = 53; AI1.priority[1][38] = 50;
AI1.priority[1][39] = 41; AI1.priority[1][40] =  2; AI1.priority[1][41] =  5;
AI1.priority[1][42] = 23; AI1.priority[1][43] = 47; AI1.priority[1][44] = 61;
AI1.priority[1][45] = 58; AI1.priority[1][46] = 40; AI1.priority[1][47] = 16;
AI1.priority[1][48] =  1; AI1.priority[1][49] =  6; AI1.priority[1][50] = 15;
AI1.priority[1][51] = 55; AI1.priority[1][52] = 62; AI1.priority[1][53] = 57;
AI1.priority[1][54] = 48; AI1.priority[1][55] =  8; AI1.priority[1][56] =  9;
AI1.priority[1][57] = 14; AI1.priority[1][58] = 54; AI1.priority[1][59] = 49;
// 自動入力する（inputメソッドでいきなり入力してしまうとwaitが全くないため、
// 別な関数で入力処理を行う
AI1.prototype.auto_input = function() {
    for (var i = 0; i < 60; i++) {
        inp_index = AI1.priority[this.color][i];
        var x = inp_index % 8;
        var y = Math.floor(inp_index / 8);
        var rev_num = get_rev_num(x, y, this.color + 1);
        // 反転できるなら
        if (rev_num != 0) {
            table[inp_index] = this.color + 1;
            document.images[inp_index].src = images[this.color + 1].src;
            setTimeout('rev_motion()', rev_motion_speed);
            return;
        };
    };
};


// --- OnlinePlayerクラス（オンライン上の相手がプレイヤー） --- //
function OnlinePlayer(color, filename) {
    // 親クラスPlayerのコンストラクタを呼ぶ
    Player.call(this, color);
    this.filename = filename;       // ゲーム上で共有するファイル名を保持する
};
// Playerのメソッドを継承する
OnlinePlayer.prototype = new Player();
// コンストラクタのポインタを修正
OnlinePlayer.prototype.constructor = OnlinePlayer;
// inputメソッドのオーバーライド
OnlinePlayer.prototype.input = function() {
    // thisオブジェクトを無名関数の引数に渡して実行できるようにした
    setTimeout(function(e){ e.waiting_input(); }, game_speed, this);
};
// 入力待ちをする（サーバーから入力が来るまで待つ）
OnlinePlayer.prototype.waiting_input = function() {
    // サーバーにあるファイルデータを貰う
    file_receive(this.filename, this.file_receive, this);
};
// コールバック関数（サーバーにあるファイルデータを貰った結果）
OnlinePlayer.prototype.file_receive = function(xmlhttp) {
    // 末尾データを見る
    var othello_data_strs = xmlhttp.responseText.split("\n");
    var tail_data_str = othello_data_strs[othello_data_strs.length - 1];

    // 入力しているデータがあるなら
    if (tail_data_str.indexOf(":") != -1) {
        var split_str = tail_data_str.split(":");
        var color = Number(split_str[0]);
        var x = Number(split_str[1].split(",")[0]);
        var y = Number(split_str[1].split(",")[1]);
        // OnlinePlayerのデータの入力があったら
        if (color == this.color) {
            // 石を置く場所に入れておく（反転処理に使う）
            inp_index = x + 8 * y;

            // 念のため確認（get_rev_numをしないと次のrev_motionが出来ない）
            var rev_num = get_rev_num(x, y, this.color + 1);
            // 反転できないなら
            if (rev_num == 0) {
                alert("error");     // エラー
                return;             // 取りあえず処理を終了する
            };

            // そこに石を置く
            document.images[inp_index].src = images[this.color + 1].src;
            table[inp_index] = this.color + 1;
            setTimeout('rev_motion()', rev_motion_speed);

            return;     // 処理を終了する
        };
    };

    // thisオブジェクトを無名関数の引数に渡して実行できるようにした
    setTimeout(function(e){ e.waiting_input(); }, game_speed, this);    
};

// とりあえず
function callback(xmlhttp) {
    alert(xmlhttp.responseText);
};