
//定义session
var session =window.localStorage || (window.UserDataStorage && new UserDataStorage()) || new cookieStroage();

session.setItem("uername", "test");

function webRoot(url) {
	var hash = new Date().getTime();
	
    /*var result = "index.php?r=";
    if (url.substring(0, 9) === "index.php") {
    	result = url;
    }
    else {
    	result = result + url;
    }*/
	var result = "/";
    if (url.indexOf('index.php')>=0) {
    	result = url;//result + url.substring(1);
    }
    else if (url.substring(0, 1) == '/') {
    	result = url;
    }
    else {
    	result = result + url;
    }
    if (result.indexOf('?')>=0) {
    	return result +'&hash=' + hash;
    }
    else {
    	return result +'?hash=' + hash;
    }
}

//获取url中的参数
function getUrlParam(param) {
    var reg = new RegExp("(\\\?|&)" + param + "=([^&]+)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var href = decodeURI(window.location.href);
    var r = href.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}

//判断字符串是否为空
function empty(value) {
	if (value == null || value == '' || value == 'undefined') {
		return true;
	}
	else {
		return false;
	}
}
