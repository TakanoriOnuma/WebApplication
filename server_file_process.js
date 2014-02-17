//************************************************
//** サーバー上にあるファイルの処理を書く **
//************************************************
// サーバーにあるファイルを受け取る処理
// objはクラスのオブジェクト（this.~）を使うため
function file_receive(filename, callback, obj) {
    var data = "filename=" + filename;
    sendRequest("POST", "./file_receiver.php", data, false, callback, obj);
};