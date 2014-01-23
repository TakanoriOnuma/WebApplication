function setData(filename)
{
    var data = "";
    data += "filename=" + filename;
    sendRequest("POST", "./ajax_sample.php", data, false, callback);
}

function requestData(filename)
{
	var data = "";
	data += "filename=" + filename;
	sendRequest("POST", "./out_filedata.php", data, true, callback);
}

function sendData(str, callback)
{
	var data = "";
	data += "othello_data=" + str;
	sendRequest("POST", "./write_data.php", data, false, callback);
}

// コールバック関数
function callback(xmlhttp)
{
    var result = document.getElementById("result");
    result.innerHTML = xmlhttp.responseText;
} 
