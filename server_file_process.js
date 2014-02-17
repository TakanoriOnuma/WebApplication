//************************************************
//** サーバー上にあるファイルの処理を書く **
//************************************************
// サーバーにあるファイルを受け取る処理
// objはクラスのオブジェクト（this.~）を使うため
function file_receive(filename, callback, obj) {
    var data = "filename=" + filename;
    sendRequest("POST", "./file_receiver.php", data, false, callback, obj);
};
// サーバーにあるファイルに書き込みする処理
function file_sender(filename, data, callback) {
    var send_data = "filename=" + filename;
    send_data += "&data=" + data;
    sendRequest("POST", "./file_sender.php", send_data, false, callback);
};
// オセロデータを書き込む
function send_othello_data(filename, othello_data, stone_color, inp_index, callback) {
    var data = "filename=" + filename;
    data += "&othello_data=" + othello_data;
    data += "&stone_color=" + stone_color;
    data += "&inp_index=" + inp_index;
    sendRequest("POST", "./write_othello_data.php", data, false, callback);
};