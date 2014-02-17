//************************************************
//** サーバー上にあるファイルの処理を書く **
//************************************************
// サーバーにあるファイルを受け取る処理
function file_receive(filename, callback) {
    var data = "filename=" + filename;
    sendRequest("POST", "./file_receiver.php", data, false, callback);
};