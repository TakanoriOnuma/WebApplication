//*******************************************************************
//**　オセロの処理を行う **
//*******************************************************************

//********************************************************************
//** 置ける場所チェック                 **
//** 反転数を8方向から得ているため、      **
//** 0だったらどこも反転できないという意味で  **
//** 置けるかどうかチェックする            **
//** ここでいうstone_colorは           **
//** 石の色（黒(1)か白(2)）となる        **
//********************************************************************
// これは反転処理でも使うため、グローバル変数にする（その方が便利）
var up_left, left, down_left, down, down_rgt, rgt, up_rgt, upp;
function get_rev_num(x, y, stone_color) {
    var rev_num;
    up_left   = cnt_reverse_num(x, y, -1, -1, stone_color);     // 上左方向
    left      = cnt_reverse_num(x, y, -1,  0, stone_color);     // 左方向
    down_left = cnt_reverse_num(x, y, -1,  1, stone_color);     // 下左方向
    down      = cnt_reverse_num(x, y,  0,  1, stone_color);     // 下方向
    down_rgt  = cnt_reverse_num(x, y,  1,  1, stone_color);     // 下右方向
    rgt       = cnt_reverse_num(x, y,  1,  0, stone_color);     // 右方向
    up_rgt    = cnt_reverse_num(x, y,  1, -1, stone_color);     // 上右方向
    upp       = cnt_reverse_num(x, y,  0, -1, stone_color);     // 上方向
    rev_num = upp + down + left + rgt + up_left + up_rgt + down_left + down_rgt;
    return rev_num;
};

//********************************************************************
//** 反転数を得る **
//********************************************************************
function cnt_reverse_num(x, y, xx, yy, stone_color) {
    var num = 0;
    // 空白でなければNG
    if (table[x + y*8] != 0) {
        return 0;
    };
    // 指定の方向に1つ進む
    x = x + xx; y = y + yy;
    // 盤外で終了
    if (x < 0 || 7 < x || y < 0 || 7 < y) {
        return 0;
    };
    while (table[x + y*8] == 3 - stone_color) {      // 相手の色(反転対象）
        num++; x = x + xx; y = y + yy;
        if(x < 0 || 7 < x || y < 0 || 7 < y) {
            return 0;
        };
    };
    // 自分で終わる（はさめるかチェック）
    if (table[x + y*8] != stone_color) {
        return 0;
    };
    return num;
};



//*******************************************************************
//**　反転処理を行う **
//*******************************************************************
var inp_index;					// 石を置く場所をセット
var rev_motion_speed = 200;		// 反転中の待機時間
// 反転中の処理
function rev_motion() {
    if (0 < upp) {
        i = 1;
        while (i < upp + 1) {
            document.images[inp_index - 8*i].src = images[3].src;
            i++;
        };
    };
    if (0 < down) { 
        i = 1;
        while (i < down + 1) {
            document.images[inp_index + 8*i].src = images[3].src;
            i++;
        };
    };
    if (0 < rgt) {
        i = 1;
        while (i < rgt + 1) {
            document.images[inp_index + i].src = images[3].src;
            i++;
        };
    };
    if (0 < left) {
        i = 1;
        while (i < left + 1) {
            document.images[inp_index - i].src = images[3].src;
            i++;
        };
    };
    if (0 < up_rgt) {
        i = 1;
        while (i < up_rgt + 1) {
            document.images[inp_index - 7*i].src = images[3].src;
            i++;
        };
    };
    if (0 < up_left) {
        i = 1;
        while (i < up_left + 1) {
            document.images[inp_index - 9*i].src = images[3].src;
            i++;
        };
    };
    if (0 < down_rgt) {
        i = 1;
        while (i < down_rgt + 1) {
            document.images[inp_index + 9*i].src = images[3].src;
            i++;
        };
    };
    if (0 < down_left) {
        i = 1;
        while (i < down_left + 1) {
            document.images[inp_index + 7*i].src = images[3].src;
            i++;
        };
    };
    setTimeout('reverse()', rev_motion_speed); //反転石を0.2秒表示
};

// 反転の色替え
function reverse() {
    if (0 < upp) {
        i　=　1;
        while　(i　<　upp　+　1)　{
            table[inp_index　-　8*i]　=　now_player.color + 1;
            document.images[inp_index　-　8*i].src　=　images[now_player.color + 1].src;
            i++;
        };
    };
    if (0 < down) {
        i = 1;
        while (i < down + 1) {
            table[inp_index + 8*i] = now_player.color + 1;
            document.images[inp_index + 8*i].src = images[now_player.color + 1].src;
            i++;
        };
    };
    if (0 < rgt) {
        i = 1;
        while (i < rgt + 1) {
            table[inp_index + i] = now_player.color + 1;
            document.images[inp_index + i].src = images[now_player.color + 1].src;
            i++;
        };
    };
    if (0 < left) {
        i = 1;
        while (i < left + 1) {
            table[inp_index - i] = now_player.color + 1;
            document.images[inp_index - i].src = images[now_player.color + 1].src;
            i++;
        };
    };
    if (0 < up_rgt) {
        i = 1;
        while (i < up_rgt + 1) {
            table[inp_index - 7*i] = now_player.color + 1;
            document.images[inp_index - 7*i].src = images[now_player.color + 1].src;
            i++;
        };
    };
    if (0 < up_left) {
        i = 1;
        while (i < up_left + 1) {
            table[inp_index - 9*i] = now_player.color + 1;
            document.images[inp_index - 9*i].src = images[now_player.color + 1].src;
            i++;
        };
    };
    if (0 < down_rgt) {
        i = 1;
        while (i < down_rgt + 1) {
            table[inp_index + 9*i] = now_player.color + 1;
            document.images[inp_index + 9*i].src = images[now_player.color + 1].src;
            i++;
        };
    };
    if(0 < down_left) {
        i = 1;
        while (i < down_left + 1) {
            table[inp_index + 7*i] = now_player.color + 1;
            document.images[inp_index + 7*i].src = images[now_player.color + 1].src;
            i++;
        };
    };
    // サーバーと通信する必要があって、自分がOnlinePlayerでなければ
    if (use_server_flag && !(now_player instanceof OnlinePlayer)) {
        // サーバーにオセロデータを送る
        var othello_data_str = get_othello_data_str();
        // オセロデータを送る
        send_othello_data(filename, othello_data_str, now_player.color + 1, inp_index);
    };
    next();		// 次へいく
};
