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
function get_rev_num(x, y, stone_color) {
    var rev_num;
    var up_left   = cnt_reverse_num(x, y, -1, -1, stone_color);     // 上左方向
    var left      = cnt_reverse_num(x, y, -1,  0, stone_color);     // 左方向
    var down_left = cnt_reverse_num(x, y, -1,  1, stone_color);     // 下左方向
    var down      = cnt_reverse_num(x, y,  0,  1, stone_color);     // 下方向
    var down_rgt  = cnt_reverse_num(x, y,  1,  1, stone_color);     // 下右方向
    var rgt       = cnt_reverse_num(x, y,  1,  0, stone_color);     // 右方向
    var up_rgt    = cnt_reverse_num(x, y,  1, -1, stone_color);     // 上右方向
    var upp       = cnt_reverse_num(x, y,  0, -1, stone_color);     // 上方向
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
