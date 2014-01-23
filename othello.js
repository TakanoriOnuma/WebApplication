//*******************************************************************
//**　グローバル変数定義（どの関数からも参照可能） **
//*******************************************************************
var count_kuro; var count_siro; // 盤上のそれぞれの石数
var siro_pass;  var kuro_pass;  // パスフラグ
var tysen = 1;      // デモ：１、　対人間：２
var gspeed;         // wait時間（処理速度）
var hspeed = 200;   // 反転スピード
var yusen = new Array(60);  // 白の優先順の場所
yusen[0]  =  0; yusen[1]  =  7; yusen[2]  = 63; yusen[3]  = 56; yusen[4]  = 19;
yusen[5]  = 20; yusen[6]  = 29; yusen[7]  = 37; yusen[8]  = 44; yusen[9]  = 43;
yusen[10] = 34; yusen[11] = 26; yusen[12] = 21; yusen[13] = 45; yusen[14] = 42;
yusen[15] = 18; yusen[16] = 11; yusen[17] = 12; yusen[18] = 30; yusen[19] = 38;
yusen[20] = 52; yusen[21] = 51; yusen[22] = 33; yusen[23] = 25; yusen[24] =  3;
yusen[25] =  4; yusen[26] = 31; yusen[27] = 39; yusen[28] = 60; yusen[29] = 59;
yusen[30] = 32; yusen[31] = 24; yusen[32] = 17; yusen[33] = 10; yusen[34] = 13;
yusen[35] = 22; yusen[36] = 46; yusen[37] = 53; yusen[38] = 50; yusen[39] = 41;
yusen[40] =  2; yusen[41] =  5; yusen[42] = 23; yusen[43] = 47; yusen[44] = 61;
yusen[45] = 58; yusen[46] = 40; yusen[47] = 16; yusen[48] =  1; yusen[49] =  6;
yusen[50] = 15; yusen[51] = 55; yusen[52] = 62; yusen[53] = 57; yusen[54] = 48;
yusen[55] =  8; yusen[56] =  9; yusen[57] = 14; yusen[58] = 54; yusen[59] = 49;
var ikuro = new Array(60);  // 黒の優先順の場所
ikuro[0]  = 56; ikuro[1]  = 63; ikuro[2]  =  7; ikuro[3]  =  0; ikuro[4]  = 43;
ikuro[5]  = 44; ikuro[6]  = 37; ikuro[7]  = 29; ikuro[8]  = 20; ikuro[9]  = 19;
ikuro[10] = 26; ikuro[11] = 34; ikuro[12] = 45; ikuro[13] = 21; ikuro[14] = 18;
ikuro[15] = 42; ikuro[16] = 59; ikuro[17] = 60; ikuro[18] = 39; ikuro[19] = 31;
ikuro[20] =  4; ikuro[21] =  3; ikuro[22] = 24; ikuro[23] = 32; ikuro[24] = 58;
ikuro[25] = 61; ikuro[26] = 47; ikuro[27] = 23; ikuro[28] =  5; ikuro[29] =  2;
ikuro[30] = 16; ikuro[31] = 40; ikuro[32] = 51; ikuro[33] = 52; ikuro[34] = 38;
ikuro[35] = 30; ikuro[36] = 12; ikuro[37] = 11; ikuro[38] = 25; ikuro[39] = 33;
ikuro[40] = 53; ikuro[41] = 46; ikuro[42] = 22; ikuro[43] = 13; ikuro[44] = 10;
ikuro[45] = 17; ikuro[46] = 41; ikuro[47] = 50; ikuro[48] = 57; ikuro[49] = 62;
ikuro[50] = 55; ikuro[51] = 15; ikuro[52] =  6; ikuro[53] =  1; ikuro[54] =  8;
ikuro[55] = 48; ikuro[56] = 49; ikuro[57] = 54; ikuro[58] = 14; ikuro[59] =  9;
var siro = 1; var kuro = 2;     // 白か黒かの値を定義
var color_num;                  // 今どっちの手かを持つ
var clickok; var x; var y; var ino; 
var up_left; var upp; var down; var left; var rgt; var up_rgt;
var down_left; var down_rgt;
var table = new Array(); 
for (i = 0; i < 64; i++) {
    table[i] = 0;
};
// 初期の配置
table[27] = table[36] = siro;
table[28] = table[35] = kuro;
// 画像の設定
images = new Array();
images[0] = new Image(); images[0].src = "images/haikei.gif";
images[1] = new Image(); images[1].src = "images/siro.gif";
images[2] = new Image(); images[2].src = "images/kuro.gif";
images[3] = new Image(); images[3].src = "images/hanten.gif";

//*******************************************************************
//*** 開始ボタン **
//*******************************************************************
function g_start() {
    var i; 
    siro_pass = kuro_pass = 0;
    gspeed = document.form1.tspeed.value;

    // スピードの範囲を0～9000に収める
    if (gspeed < 0) {
        gspeed = 0;
    };
    if (gspeed > 9000) {
        gspeed = 9000;
    };
    // オセロの最初の状態にセット
    for (i = 0; i < 64; i++) {
        if (i == 27 || i == 36) {
            table[i] = siro;
            document.images[i].src = images[siro].src;
        }
        else if (i == 28 || i == 35) {
                table[i] = kuro;
                document.images[i].src = images[kuro].src;
        }
        else {
            table[i] = 0;
            document.images[i].src = images[0].src;
        };
    };
    clickok = 2; 
    document.form1.info.value = "黒の番";
    if (tysen == 1) {
        settei_kuro(kuro);
    };
};

//*******************************************************************
//** メイン実行**
//*******************************************************************
function Main_Sub() {
    out_othelloData('gamefield.dat');
    var i1;
    count_kuro = count_siro = 0;
    for (i1 = 0; i1 <= 63; i1++) {
        if (table[i1] == kuro) {
            count_kuro++;
        };
        if (table[i1] == siro) {
            count_siro++;
        };
    };
    document.form1.kuro.value = count_kuro;
    document.form1.siro.value = count_siro;
    // パスのチェック
    siro_pass = 1;
    for (i1 = 0; i1 <= 63; i1++) {
        ino = i1; x = ino % 8; y = (ino - x) / 8;
        flg = getck(x, y, siro);
        if (flg != 0){
            siro_pass = 0;
            break;
        };
    };
    kuro_pass = 1;
    for (i1 = 0; i1 <= 63; i1++) {
        ino = i1; x = ino % 8; y = (ino - x) / 8;
        flg = getck(x, y, kuro);
        if (flg != 0) {
            kuro_pass = 0;
            break;
        }; 
    };
    //終了チェック
    if (kuro_pass == 1 && siro_pass == 1) {
        gamesett();
        return;
    }
    if (count_kuro + count_siro == 64 || count_kuro == 0 || count_siro == 0) {
        gamesett();
        return;
    }
    else {
        if (clickok == 1) {
            if (siro_pass == 0) {
                document.form1.info.value = "コンピュータの番（考え中）";
                setTimeout('settei(siro)', gspeed);
            }
            else {
                clickok = 2;
                document.form1.info.value = "白はパスです。黒の番";
                if (tysen == 1) {
                    setTimeout('settei_kuro(kuro)', gspeed);
                };
            };
        }
        else {
            if (kuro_pass == 0) {
                document.form1.info.value = "黒の番";
                if (tysen == 1) {
                    setTimeout('settei_kuro(kuro)', gspeed);
                };
            }
            else {
                clickok = 1;
                document.form1.info.value = "黒はパスです。白の番";
                setTimeout('settei(siro)', gspeed);
            };
        };
    };
};

//********************************************************************
//** 置ける場所チェック                 **
//** 反転数を8方向から得ているため、      **
//** 0だったらどこも反転できないという意味で  **
//** 置けるかどうかチェックする            **
//********************************************************************
function getck(x, y, irono) {
    var iflg;
    up_left   = cnt_reverse_num(x, y, -1, -1, irono);     // 上左方向
    left      = cnt_reverse_num(x, y, -1,  0, irono);     // 左方向
    down_left = cnt_reverse_num(x, y, -1,  1, irono);     // 下左方向
    down      = cnt_reverse_num(x, y,  0,  1, irono);     // 下方向
    down_rgt  = cnt_reverse_num(x, y,  1,  1, irono);     // 下右方向
    rgt       = cnt_reverse_num(x, y,  1,  0, irono);     // 右方向
    up_rgt    = cnt_reverse_num(x, y,  1, -1, irono);     // 上右方向
    upp       = cnt_reverse_num(x, y,  0, -1, irono);     // 上方向
    iflg = upp + down + left + rgt + up_left + up_rgt + down_left + down_rgt;
    return iflg;
};

//********************************************************************
//** 反転数を得る **
//********************************************************************
function cnt_reverse_num(x, y, xx, yy, irono) {
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
    while (table[x + y*8] == 3 - irono) {      // 相手の色(反転対象）
        num++; x = x + xx; y = y + yy;
        if(x < 0 || 7 < x || y < 0 || 7 < y) {
            return 0;
        };
    };
    // 自分で終わる（はさめるかチェック）
    if (table[x + y*8] != irono) {
        return 0;
    };
    return num;
};

//********************************************************************
//** 反転対象の色変え **
//********************************************************************
function Hanten_iti() {
    if (0 < upp) {
        i = 1;
        while (i < upp + 1) {
            document.images[ino - 8*i].src = images[3].src;
            i++;
        };
    };
    if (0 < down) { 
        i = 1;
        while (i < down + 1) {
            document.images[ino + 8*i].src = images[3].src;
            i++;
        };
    };
    if (0 < rgt) {
        i = 1;
        while (i < rgt + 1) {
            document.images[ino + i].src = images[3].src;
            i++;
        };
    };
    if (0 < left) {
        i = 1;
        while (i < left + 1) {
            document.images[ino - i].src = images[3].src;
            i++;
        };
    };
    if (0 < up_rgt) {
        i = 1;
        while (i < up_rgt + 1) {
            document.images[ino - 7*i].src = images[3].src;
            i++;
        };
    };
    if (0 < up_left) {
        i = 1;
        while (i < up_left + 1) {
            document.images[ino - 9*i].src = images[3].src;
            i++;
        };
    };
    if (0 < down_rgt) {
        i = 1;
        while (i < down_rgt + 1) {
            document.images[ino + 9*i].src = images[3].src;
            i++;
        };
    };
    if (0 < down_left) {
        i = 1;
        while (i < down_left + 1) {
            document.images[ino + 7*i].src = images[3].src;
            i++;
        };
    };
    setTimeout('Hanten()', hspeed); //反転石を0.2秒表示
};

//*******************************************************************
//** 反転の色替え **
//*******************************************************************
function Hanten() {
    if (0 < upp) {
        i　=　1;
        while　(i　<　upp　+　1)　{
            table[ino　-　8*i]　=　color_num;
            document.images[ino　-　8*i].src　=　images[color_num].src;
            i++;
        };
    };
    if (0 < down) {
        i = 1;
        while (i < down + 1) {
            table[ino + 8*i] = color_num;
            document.images[ino + 8*i].src = images[color_num].src;
            i++;
        };
    };
    if (0 < rgt) {
        i = 1;
        while (i < rgt + 1) {
            table[ino + i] = color_num;
            document.images[ino + i].src = images[color_num].src;
            i++;
        };
    };
    if (0 < left) {
        i = 1;
        while (i < left + 1) {
            table[ino - i] = color_num;
            document.images[ino - i].src = images[color_num].src;
            i++;
        };
    };
    if (0 < up_rgt) {
        i = 1;
        while (i < up_rgt + 1) {
            table[ino - 7*i] = color_num;
            document.images[ino - 7*i].src = images[color_num].src;
            i++;
        };
    };
    if (0 < up_left) {
        i = 1;
        while (i < up_left + 1) {
            table[ino - 9*i] = color_num;
            document.images[ino - 9*i].src = images[color_num].src;
            i++;
        };
    };
    if (0 < down_rgt) {
        i = 1;
        while (i < down_rgt + 1) {
            table[ino + 9*i] = color_num;
            document.images[ino + 9*i].src = images[color_num].src;
            i++;
        };
    };
    if (0 < down_left) {
        i = 1;
        while (i < down_left + 1) {
            table[ino + 7*i] = color_num;
            document.images[ino + 7*i].src = images[color_num].src;
            i++;
        };
    };
    Main_Sub();
};

//*******************************************************************
// ゲーム終了 **
//*******************************************************************
function gamesett() {
    clickok = 0;
    if (count_kuro == count_siro) {
        document.form1.info.value = "引き分けです";
    }
    else if (count_kuro > count_siro) {
        document.form1.info.value = "まいりました、黒の勝ちです";
    }
    else {
        document.form1.info.value = "黒の負けです。";
    };
};

//*******************************************************************
//** 黒の番です **
//*******************************************************************
function input_kuro(i) {
    var flg;
    var i0;

    if (clickok != 2 || table[i] != 0) {
        return;
    };
    x = i % 8; y = (i - x) / 8; ino = i; color_num = kuro; clickok = 1;
    flg = getck(x, y, kuro);
    if (flg != 0) {
        table[ino] = color_num;
        document.images[ino].src = images[color_num].src;
        setTimeout('Hanten_iti()', gspeed);
    }
    else {
        document.form1.info.value = "そこには置けません";
        clickok = 2;
    };
};

//*******************************************************************
//** デモ用黒の入力 **
//*******************************************************************
function settei_kuro(kuro) {
    var i;
    var flg;
    color_num = kuro; clickok = 1; // 初期設定
    for (i = 0; i < 60; i++) {
        x = ikuro[i] % 8; y = (ikuro[i] - x) / 8; ino = ikuro[i];
        flg = getck(x, y, kuro);
        if (flg != 0) {
            table[ino] = color_num;
            document.images[ino].src = images[color_num].src;
            setTimeout('Hanten_iti()', hspeed);
            return;
        };
    };
    document.form1.info.value = "黒はパスです。白の番です。";
    Main_Sub();
};

//*******************************************************************
//** 白入力用 **
//*******************************************************************
function settei(siro) {
    var i;
    var flg; 
    color_num = siro; clickok = 2; // 初期化設定
    for (i = 0; i < 60; i++) {
        x = yusen[i] % 8; y = (yusen[i] - x) / 8; ino = yusen[i];
        flg = getck(x, y, siro);
        if (flg != 0) {
            table[ino] = color_num;
            document.images[ino].src = images[color_num].src; 
            setTimeout('Hanten_iti()', hspeed);     // 反転処理
            return;
        }
    };
    document.form1.info.value = "白はパスです。黒の番です。";
    Main_Sub();
};

//*******************************************************************
//** オセロデータ出力 **
//*******************************************************************
function out_othelloData(filename) {
    var othello_str = "";
    othello_str += color_num + "\n";
    for (var i = 0; i < 8; i++) {
        for (var j = 0; j < 8; j++) {
            othello_str += table[i*8 + j];
        }
        othello_str += "\n";
    }
    sendData(othello_str);
}

//*******************************************************************
//** ロジック終了 **
//*******************************************************************

//*******************************************************************
//** オセロのフィールドのセッティング **
//*******************************************************************
function setting() {
    var i; var i1;
    for (i = 0; i < 64; i++) {
        i1 = i + 1;
        document.write('<a href="JavaScript:input_kuro(',i,')"><img src="images/haikei.gif" width=38 height=38 border=0></a>');
        if(i1 % 8 == 0) {
            document.write('<br />');
        };
    };
    document.images[27].src = images[siro].src;
    document.images[28].src = images[kuro].src;
    document.images[35].src = images[kuro].src;
    document.images[36].src = images[siro].src;    
}