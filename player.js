//************************************************
//** オセロのプレイヤーをクラス化する **
//************************************************
// --- Playerクラス ---//
function Player(color) {
	this.color = color;		// どっちの石か（黒(0)か白(1)か）
}

// inputメソッドの空定義
Player.prototype.input = function(i) {
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
Human.prototype.input = function(i) {
	alert("This is Human class.\n" + "color:" + this.color);
}
// 自分でinputする（入力イベントが来て初めて入力なため、普通の入力とは少し違う）
Human.prototype.self_input = function(i) {
    var x, y;
    x = i % 8;
    y = Math.floor(i / 8);
    alert("self_input:" + "(" + x + ", " + y + ")");
    document.images[i].src = images[this.color + 1].src;
}