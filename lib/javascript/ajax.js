// XMLHttpRequestオブジェクト生成
function createHttpRequest()
{
    // 各ブラウザに合うXMLHttpRequestオブジェクトを生成
    var xmlhttp = null;
    if (window.ActiveXObject) {
        try {
            // MSXML2以降用
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) {
            try {
                // 旧MSXML用
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e2) {

            };
        };
    }
    else if(window.XMLHttpRequest){
        // Win Mac Linux m1,f1,o8 Mac s1 Linux k3用
        xmlhttp = new XMLHttpRequest();
    }
    else {

    };

    if (xmlhttp == null) {
        alert("Can not create an XMLHTTPRequest instance");
    };
    return xmlhttp;
};

// ファイルにアクセスし受信内容を確認します
function sendRequest (method, url, data, async, callback, obj)
{
    // XMLHttpRequestオブジェクト生成
    var xmlhttp = createHttpRequest();

    // 受信時に起動するイベント
    xmlhttp.onreadystatechange = function() { 
        // readyState値は4で受信完了
        if (xmlhttp.readyState == 4) {
            // callbackを求めてないなら
            if (callback == null) {
                return;     // 何もせずに終える
            };

            // objが入ってないなら
            if (obj == null) {
                // 通常のコールバック
                callback(xmlhttp);                
            }
            // もしあれば
            else {
                // クラスを使ったコールバック
                callback.call(obj, xmlhttp);
            };
        };
    };
    // open メソッド
    xmlhttp.open(method, url, async);
    // HTTPリクエストヘッダを設定
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // send メソッド
    xmlhttp.send(data);
};
