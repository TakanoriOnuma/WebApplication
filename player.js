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