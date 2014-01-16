function setData(filename)
{
    var data = "";
    data += "filename=" + filename;
    sendRequest("POST", "./ajax_sample.php", data, false, callback);
}

// コールバック関数
function callback(xmlhttp)
{
    var result = document.getElementById("result");
    result.innerHTML = xmlhttp.responseText;
} 
