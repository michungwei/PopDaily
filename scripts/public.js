function ifocus(id){//i focus焦點
	document.getElementById(id).focus();
}

function isArray(o){   
	return Object.prototype.toString.call(o) === '[object Array]';    
} 

function antenterAddBookmark(pType, links, title){
 	var _locationHref = links;
	var _title = title;   
	var _href;	

	switch(pType){
		case 'FACEBOOK':
			_href = "http://www.facebook.com/sharer.php?u="+ _locationHref+"&t="+_title;
			break;
		case 'GOOGLE':
			_href = "http://www.google.com/bookmarks/mark?op=add&bkmk="+ _locationHref + "&title=" + _title;
			break;
		case 'PLURK':
			id = "";
			_locationHref = encodeURIComponent(_locationHref);
			_title = encodeURIComponent(_title);
			_href = "http://www.plurk.com/?qualifier=shares&status=".concat(_locationHref).concat(' ').concat('(').concat(_title).concat(')').concat(' ').concat('(').concat(id).concat(')');
			break;
		case 'TWITTER':
			id = "";
			locationHref = encodeURIComponent(_locationHref+"?media=twitter");
			id = encodeURIComponent(id);			
			_href = "http://twitter.com/home/?status=" + _title + " " + _locationHref + " " + id;
			break;
	}
	window.open(_href, "_blank");
}

var err_msg = '';
function isselect(id, key){
	var my_value = $.trim($('#'+id).val());
	if(my_value == ""){
		err_msg = '請選擇'+key+'!!';
		return false;
	}
	return true;
}

//欄位驗證
function isnull(id, txt, type, minlen, maxlen, errtxt, isfocus, defval){//欄位id、顯示文字、驗證種類、最短、最長、、、、、、
	type = arguments[2]||0; //arguments用來取得function傳入的實際變數Array
	minlen = arguments[3]||0;
	maxlen = arguments[4]||0;
	errtxt = arguments[5]||"";
	isfocus = arguments[6]||true;
	defval = arguments[7]||"";
	var my_value = $.trim($('#'+id).val());//trim去除前後的空白
	var result = true;
	my_value = my_value.replace(/(^[\s　]*)|([\s　]*$)/g, "");
	if(defval != "" && my_value == defval){
		err_msg = (errtxt != "") ? errtxt : '請填寫'+txt+'!!';
		ifocus(id);
		/*document.getElementById(id).focus();*/
		return false;		
	}
	if(result == true && my_value == "" && minlen > 0){
		err_msg = (errtxt != "") ? errtxt : '請填寫'+txt+'!!';
		ifocus(id);
		/*document.getElementById(id).focus();*/
		return false;
	}
	if(result == true && type == 1){
		if (isNaN(my_value)){
		    err_msg += txt+'必須為數字型態!!'
		    result = false
	    }
	}
	if(result == true && type == 2){
		var pattern = /^([\u4E00-\u9FA5]|[\uFE30-\uFFA0])*$/gi;   
		if(!pattern.test(my_value)){ 
			err_msg = txt+'必須為中文!!';
			result = false;
		}
	}
	if(result == true && type == 3){
		var pattern = /^([\u4E00-\u9FA5]|[\uFE30-\uFFA0])*$/gi;   
		if(pattern.test(my_value)){ 
			err_msg = txt+'不能為中文!!';
			result = false;
		}
	}		
    if(result == true && maxlen > 0 && minlen > 0){
		if(my_value.length > maxlen || my_value.length < minlen){
		  err_msg = txt+'必須為'+minlen+'~'+maxlen+'個字元!!';
		  result = false;
		}
	}	
	if(result == true && maxlen > 0){
		if(my_value.length > maxlen){
		  err_msg = txt+'只能小於'+maxlen+'個字元!!';
		  result = false;
		}
	}	
	if(result == true && minlen > 0){
		if(my_value.length < minlen){
		  err_msg = txt+'必須大於'+minlen+'個字元!!';
		  result = false;
		}
	}
	if(result == false && isfocus){
		ifocus(id);
	}
	return result;
}

function selectAll(name, chks){
	var obj = document.getElementsByName(name);
	for (i = 0; i < obj.length; i ++){
		obj[i].checked = chks;
	}
}

function ischecked(name, txt, maxnum){
	maxnum = arguments[2]||0;
	var obj = $("input[name="+name+"]");
	var num = 0;
	for(i = 0; i < obj.length; i ++){
		if(obj.get(i).checked){
			num ++;
		}
	}
	if(num == 0){
		err_msg='請選擇'+txt+'!!';
		return false;	
	}
	if(maxnum > 0){
		if(num > maxnum){
			err_msg = txt+'最多只能選中'+maxnum+'個選項!!';
			return false;	
	    }
	}
	return true;
}

function isemail(id){//E-mail格式檢查
	var my_value = $.trim($('#'+id).val());

	my_value = my_value.replace(/(^[\s　]*)|([\s　]*$)/g, "");
	if(my_value == ""){
		err_msg = '請輸入Email!!';
		ifocus(id);
		return false;
	}
	var re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,4})+$/;
	if (!re.test(my_value)){
		err_msg = "請輸入正確Email格式";
		ifocus(id);
		return false;
	}
	return true;		
}

function istel(id){//電話格式檢查
	var my_value = $.trim($('#'+id).val());
	my_value = my_value.replace(/(^[\s　]*)|([\s　]*$)/g,"");
	if(my_value == ""){
		err_msg = '請輸入聯絡電話!!';
		ifocus(id);
		return false;
	}
	var re = /^([0-9]{2,3}-)?[0-9]{8,10}(#[0-9]{1,4})?$/;
	if (!re.test(my_value)){
		err_msg += "聯絡電話格式不正確";
		ifocus(id);
		return false;
	}	
	return true;	
}

function ismobile(id){//手機號碼格式檢查
	var my_value = $.trim($('#'+id).val());
	my_value = my_value.replace(/(^[\s　]*)|([\s　]*$)/g,"");
	if(my_value == ""){
		err_msg = '請輸入手機號碼!!';
		ifocus(id);
		return false;
	}
	var re = /^09[0-9]{8}$/;
	if (!re.test(my_value)){
		err_msg = "手機號碼格式不正確";
		ifocus(id);
		return false;
	}
	return true;	
}

function isennum(id, txt) {
	var my_value = $.trim($('#'+id).val());
	my_value = my_value.replace(/(^[\s　]*)|([\s　]*$)/g, "");
    var re = /^\w+$/;
    if (!re.test(my_value)){
        err_msg = txt+"只能輸入英數字大小寫和_";
		ifocus(id);
        return false;
    }
    return true;
}

function isVaildDate(id, txt){   
	var str = $.trim($('#'+id).val());
	var re = new RegExp("^([0-9]{4})[.-]{1}([0-9]{1,2})[.-]{1}([0-9]{1,2})$");   
    var strDataValue;   
	var infoValidation = true;   
          
	if ((strDataValue = re.exec(str)) != null){   
		var i;   
		i = parseFloat(strDataValue[1]);   
		if (i <= 0 || i > 9999){ // 年   
			infoValidation = false;   
		}   
		i = parseFloat(strDataValue[2]);   
		if (i <= 0 || i > 12){ // 月   
			infoValidation = false;   
		}   
		i = parseFloat(strDataValue[3]);   
		if (i <= 0 || i > 31){ // 日   
			infoValidation = false;   
		}   
	}else{   
		infoValidation = false;   
	}   

	if (!infoValidation){   
		err_msg = txt+' 必須為 YYYY-MM-DD 日期格式';   
	}   
	return infoValidation;   
}
 
function isdate(yy, mm, dd, txt) {
	var arg_intYear = $.trim($('#'+yy).val());
	var arg_intMonth = $.trim($('#'+mm).val());
	var arg_intDay = $.trim($('#' + dd).val());
	if (arg_intDay != "" && arg_intMonth != "" && arg_intDay != "") {
		//月數從0開始，所以要將參數減一
		var objDate = new Date(arg_intYear, arg_intMonth - 1, arg_intDay);
		//檢查月份是否小於12大於1
		if ((parseInt(arg_intMonth) > 12) || (parseInt(arg_intMonth) < 1)) {
			err_msg = arg_intYear + '/' + arg_intMonth + '/' + arg_intDay + txt + '月份不正確';
			return false;
		}else {
			//如果objDate日數進位不等於傳入的arg_intDay，代表天數格式錯誤，另外月份進位也代表日期格式錯誤
			if ((parseInt(arg_intDay) != parseInt(objDate.getDate())) || (parseInt(arg_intMonth) != parseInt((objDate.getMonth() + 1)))) {
				err_msg = arg_intYear + '/' + arg_intMonth + '/' + arg_intDay + txt + '天數不正確';
				return false;
			}else {
				err_msg = arg_intYear + '/' + arg_intMonth + '/' + arg_intDay + txt + '日期格式正確';
				return true;
			}
		}
	}
	return true;
}

function checkPassword(pw1, pw2){
	var my_value1 = $.trim($('#'+pw1).val());
	var my_value2 = $.trim($('#'+pw2).val());
	if(my_value1 != my_value2){
		err_msg = '確認密碼和密碼不一樣，請重新填入!!';
		return false;
	}
	return true;
}

function replaceAll(strOrg, strFind, strReplace){
	var index = 0;
	while(strOrg.indexOf(strFind, index) != -1){
		strOrg = strOrg.replace(strFind, strReplace);
		index = strOrg.indexOf(strFind, index);
	}
	return strOrg;
}

function isexist(name, key, url, id){//檢查資料庫是否有重複資料
	var success = false;
	id = arguments[3] || 0;
	$.ajax({
		url: url,
		type: 'POST',
		data:{
			id	 : id,
			name : name
		},
		async: false,
		error: function(){
			err_msg = "發生錯誤";
			success = false;
		},
		success: function(response){
			if(response == "1"){
				success = true;
			}else{
				err_msg = key+"名稱重複,已有此"+key+"名稱!";
				success = false;
			} 
		}
	});
	return success;
}