function setData(filename)
{
    var data = "";
    data += "filename=" + filename;
    sendRequest("POST", "./ajax_sample.php", data, false, callback);
}

function requestData(filename, callback)
{
	var data = "";
	data += "filename=" + filename;
	sendRequest("POST", "./out_filedata.php", data, true, callback);
}

function sendData(str)
{
	var data = "";
	data += "othello_data=" + str;
	sendRequest("POST", "./write_data.php", data, true, callback);
}

// コールバック関数
function callback(xmlhttp)
{
	alert('write');
    var result = document.getElementById("result");
    result.innerHTML = xmlhttp.responseText;
} 
