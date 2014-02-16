//************************************************
//** オセロのプレイヤーをクラス化する **
//************************************************
// --- Playerクラス ---//
function Player() {
}

// inputメソッドの空定義
Player.prototype.input = function(i) {
	alert('This is player class.');
};

// --- Humanクラス（人がプレイヤー） --- //
function Human() {
	// 親クラスPlayerのコンストラクタを呼ぶ
	Player.call(this);
}

// Playerのメソッドを継承する
Human.prototype = new Player();
// コンストラクタのポインタを修正
Human.prototype.constructor = Human;
// inputメソッドのオーバーライド
Human.prototype.input = function(i) {
	alert("This is Human class.");
}