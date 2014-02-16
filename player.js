//************************************************
//** オセロのプレイヤーをクラス化する **
//************************************************
var game_speed = 500;		// ゲームスピード

// --- Playerクラス ---//
function Player(color) {
	this.color = color;		// どっちの石か（黒(0)か白(1)か）
}

// inputメソッドの空定義
Player.prototype.input = function() {
	alert("This is player class.\n" + "color:" + this.color);
};

// --- Humanクラス（人がプレイヤー） --- //
function Human(color) {
	// 親クラスPlayerのコンストラクタを呼ぶ
	Player.call(this, color);
}

// Playerのメソッドを継承する
Human.prototype = new Player();
// コンストラクタのポインタを修正
Human.prototype.constructor = Human;
// inputメソッドのオーバーライド
Human.prototype.input = function() {
	alert("This is Human class.\n" + "color:" + this.color);
}
// 自分でinputする（入力イベントが来て初めて入力なため、普通の入力とは少し違う）
Human.prototype.self_input = function(i) {
    var x, y;
    x = i % 8;
    y = Math.floor(i / 8);
    var rev_num = get_rev_num(x, y, this.color + 1);
    alert("self_input:" + "(" + x + ", " + y + ")\n" + "rev_num:" + rev_num);
    // 反転できるなら
    if (rev_num > 0) {
    	// そこに石を置く
	    document.images[i].src = images[this.color + 1].src;
	    table[i] = this.color + 1;
	    inp_index = i;		// 石を置く場所を入れておく（反転処理で使う）
	    setTimeout(rev_motion(), game_speed);   	
    }
}