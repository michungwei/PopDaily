<?php
//=============================================//
//輸入

#request GET及POST值

function request_pag($name = "page"){
//取得頁數(最小為1)
	$page = request_num($name);/*檢查是否為數字並取得*/
	if($page == ""){//若$page等於空值或<1，回傳1
		return 1;
	}else if($page < 1){
		return 1;
	}else{
		return $page;//其餘傳回變數值
	}
}

function request_str($name){
//取得不含有反斜線字串
	$value = request($name);
    /*如果magie_qutes_gpc 為ON ，則去除反斜線*/
	if(get_magic_quotes_gpc()){
		/*get_magic_quotes_gpc取得PHP 環境配置變量magic_quotes_gpc (GPC, Get/Post/Cookie) 值。傳回0表示關閉;1表開啟。
		  當 magic_quotes_gpc 打開時，所有的 ' (單引號), " (雙引號), \ (反斜線) and 空字符會自動轉為含有反斜線的溢出字符。*/
    	$value = stripslashes($value);/*stripslashes刪除反斜線*/
	}
    return $value;
}

function request_num($name){
//取得數字，若無or非數字傳回""
	$value = request($name);
    /*如果magie_qutes_gpc 為ON ，則去除反斜線*/
    if(get_magic_quotes_gpc()){
    	$value = stripslashes($value);
    }
    if(is_numeric($value)){/*is_numeric判斷是否為數字or數字字串*/
    	return $value;
    }else{
    	return "0";
    }
}

function request_ary($name){
//取得陣列
	$data = request($name);
	if(gettype($data) == "array"){/*gettype判斷變數型態*/
		if(get_magic_quotes_gpc()){/*將陣列內容去除反斜線*/
			$d = array();
			foreach($data as $key => $value){
				$v = stripslashes($value);
				$d[$key] = $v;
			}
			return $d;
		}else{
			return $data;
		}
	}else{
		return array();
	}
}

function request_ip(){
//取得使用者ip
	return $_SERVER["REMOTE_ADDR"];
}

function request_cd(){
//取得系統時間
	return datetime();
}

function request_url(){
//取得當前網址(到當前文件名，不含get)
	return "http://".dirname($_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"])."/";
}

function request_weburl(){
//取得當前域名(ex.http://yahoo.com.tw)
	return "http://".$_SERVER["HTTP_HOST"]."/";
}

function request_ref(){
//取得上一頁的網址
	return $_SERVER["http_referer"];
}

function request_date($name, $default = ""){
//取得日期(若字元數達到8，則轉換為時間戳，若錯誤反為$default)
	$value = request($name);
    /*如果magie_qutes_gpc 為ON ，則去除反斜線*/
    if(get_magic_quotes_gpc()){
    	$value = stripslashes($value);
    }

	if(strlen($value) >= 8){/*strlen判斷字元長度*/
		$dat = strtotime($value);/*strtotime轉換為時間戳，錯誤返回false*/
		if($dat){
			return $value;
		}else{
		    return $default;
		}
	}else{
    	return $default;
	}

}


//-----------------3種接值法

function request($name){
//接get和post，若無傳回""
	$value = "";
	if(isset($_GET[$name])){
		$value = $_GET[$name];
	}else if(isset($_POST[$name])){
		$value = $_POST[$name];
	}else{
		$value = "";
	}
	return $value;
}

function get($str, $type = 0){
//接get值(可轉換型態)，若get不存在傳回""
	if(!isset($_GET[$str]))
		return "";
	$gstr = trim($_GET[$str]);/*trim刪除字串兩端的空白*/
	switch($type){
		case 0://預設:轉換為10進位
			return intval($gstr);
			break;
		case 1://特定字符轉換及加上跳脫字元
			$gstr = htmlspecialchars($gstr);/*將特定字符轉為html，例:<轉為&lt;*/
			if(!get_magic_quotes_gpc()){/*若ini檔無加跳脫字元*/
				$gstr = addslashes($gstr);/*加上跳脫字元*/
			}
			return $gstr;
			break;
		case 3://取得浮點數值
			return floatval($gstr);
			break;	 	 
	}
}

function post($str, $type = 0){
//接post值(可轉換型態)，若不存在傳回""
	if(!isset($_POST[$str]))
  	return "";	
    $gstr=trim($_POST[$str]);
	switch($type){
		case 0://預設:轉換為10進位
			return intval($gstr);
			break;
		case 1://特定字符轉換及加上跳脫字元
			$gstr = htmlspecialchars($gstr);
			if(!get_magic_quotes_gpc()){
				$gstr = addslashes($gstr);
			}
			return trim($gstr);
			break;
		case 2://加上跳脫字元
			if(!get_magic_quotes_gpc()){
				$gstr = addslashes($gstr);
			}
			return trim($gstr);
			break;
		case 3://取得浮點數值
			return floatval($gstr);
			break;	 
	}
}
//=============================================//
//取亂數
function generatorPassword()
{
    $password_len = 6;/*長度*/
    $password = '';

    // remove o,0,1,l
    $word = 'abcdefghijkmnpqrstuvwxyz0123456789';
    $len = strlen($word);

    for ($i = 0; $i < $password_len; $i++) {
        $password .= $word[rand() % $len];
    }

    return $password;
}



//=============================================//
//字串處理 輸出
function hc($str){
//輸出字串並將html字符編碼(將特定字符轉為html，例:<轉為&lt;)
	return htmlentities($str, ENT_QUOTES, "UTF-8");
}

function uc($str){
//對url進行字符編碼
	return urlencode($str);
}
function udc($str){
//對url進行字符編碼
	return urldecode($str);
}

function sc($str){
//特定字符替換
	$str = str_replace("\r", "\\r", $str);
	$str = str_replace("\n", "\\n", $str);
	$str = addslashes(str_replace("\"", "''", $str));
	return $str;
}

function br($str){
//轉化為br
	return preg_replace("/(\015\012)|(\015)|(\012)/", "<br/>", $str);
}

function removebr($str){
//br轉化
	return eregi_replace("<br[[:space:]]*/?[[:space:]]*>", "\015\012", $str);
}

function echobr($str){
//echo+br
	echo $str."<br>";
}

function bugout($str){
//退出並印出$str
    die($str);
}

function tc_left($s,$c){
//從左邊擷取一定字數字串(字串.長度)
	if(mb_strlen($s) > $c){
		return left($s, $c)."…";
	}else{
		return $s;
	}
}


function GBsubstr($string, $start, $length){
//擷取一定字元數字串(字串.起始點.長度)
	$beginIndex = $start;
	if (strlen($string) < $start){
		return "";
	}
	if(strlen($string) < $length){
		return substr($string, $beginIndex);//substr以[位元組]計算
	}
 
	$char = ord($string[$beginIndex + $length - 1]);/*ord取得第一個字的ASCII*/
	if($char >= 224 && $char <= 239){/*處理utf8亂碼問題。一個UTF-8的中文字符由3個ASCII字符組成*/
		$str = substr($string, $beginIndex, $length - 1)."...";
		return $str;
	}

	$char = ord($string[$beginIndex + $length - 2]);
	if($char >= 224 && $char <= 239){
		$str = substr($string, $beginIndex, $length - 2)."...";
		return $str;
	}
	return substr($string, $beginIndex, $length)."...";

}


//----------------------------
//輸出table
//傳入陣列,TABLE CSS STYLE,一列幾欄,輸出格式化後的table
function fillTable($ary, $style, $c){
	$iaryCount = count($ary);/*count計算陣列數量*/
	if($iaryCount > 0){
		$stemp = "<table style='$style'>";
		for($i = 0; $i < $iaryCount; $i++){
			if($i%$c == 0){
				$stemp .= ($i>0) ? "</tr><tr>" : "<tr>";
			}
			$stemp .= '<td >'.$ary[$i].'</td>';
		}
		if($i%$c > 0){
			for ($j = 0; $j < ($i%$c); $j++){
				$stemp .= '<td>&nbsp;</td>';
			}
			$stemp .= '</tr>';
		}		
		$stemp .= '</table>';
		return $stemp;
	}else{
		return "";
	}
}
//做unescape的處理(解碼or反轉譯)
function phpUnescape($escstr){   
	preg_match_all("/%u[0-9A-Za-z]{4}|%.{2}|[0-9a-zA-Z.+-_]+/", $escstr, $matches);   
    $ar = &$matches[0];   
    $c = "";   
    foreach($ar as $val){   
		if(substr($val, 0, 1) != "%"){   
			$c .= $val;   
		}else if(substr($val, 1, 1) != "u"){   
			$x = hexdec(substr($val, 1, 2));   
			$c .= chr($x);   
		}else{   
			$val = intval(substr($val, 2), 16);   
			if($val < 0x7F){ // 0000-007F   
				$c .= chr($val);   
			}else if($val < 0x800){ // 0080-0800   
				$c .= chr(0xC0 | ($val / 64));   
				$c .= chr(0x80 | ($val % 64));   
			}else{ // 0800-FFFF   
				$c .= chr(0xE0 | (($val / 64) / 64));   
				$c .= chr(0x80 | (($val / 64) % 64));   
				$c .= chr(0x80 | ($val % 64));   
			}    
		}    
	}    
    return $c;   
} 

//=============================================//
//格式檢查

//在url前面加上http://
function chkUrl($str){
	if(substr($str,0,7) != 'http://'){
		$str = 'http://'.$str;
	}
	return $str;
}

//=============================================//
//取特定字數字串
function right($value, $count){
  return mb_substr($value, ($count*-1));
}

function left($string, $count){
  return mb_substr($string, 0, $count);
}


//=============================================//
//SQL




//=============================================//
//Session

#取得session(檢查是否存在(""也是ture))
function session($name){
	if(isset($_SESSION[$name]) || !empty($_SESSION[$name])){
	 return $_SESSION[$name];
	}else{
	 return "";
	}
}
#取得session(呼叫上一個session函數)
function getSession($name){
    return session($name);
}

#設定session
function setSession($name, $value){
	$_SESSION[$name] = $value;
}

#清除session
function unSession($name){
	unset($_SESSION["$name"]);
}

//=============================================//
//cookie

#取得cookie
function cookie($name){
	if(isset($_COOKIE[$name]) || !empty($_COOKIE[$name])){
		return phpUnescape($_COOKIE[$name]);
	}else{
		return "";
	}
}
#取得cookie(cookie函數)
function getCookie($name){
	return cookie($name);
}

#清除cookie
function unCookie($name){
	setcookie($name, "", time()-1800);
}

#設定cookie(cookie名.值.有效期)
function saveCookieHour($name, $val, $h){
	$expire = time( )+$h*60*60;//$expire有效期
	unCookie($name);
	setcookie($name, urlencode($val), $expire);
}

function saveCookie($name, $val){
	global $iCookMainExpireDay;
	$expire = time( ) + $iCookMainExpireDay*24*60*60;
	unCookie($name);
	setcookie($name, urlencode($val), $expire);
}


//=============================================//
//日期時間
//strtotime文字轉為時間戳

//$d1和$d2相隔時間
function DateDiff($d1, $d2 = "now"){ 
	if(is_string($d1))$d1 = strtotime($d1); 
	if(is_string($d2))$d2 = strtotime($d2); 
	return  ($d2-$d1)/86400; 
} 

//傳回時間Y/m/d H:i:s(預設今天)
function datetime($form = "Y/m/d H:i:s", $value = "now"){
	//Y/m/d H:i:s
	return date($form, strtotime($value));
}

//傳回x分後(型態.時間起始點.x)
function datetime_addMin($form = "Y/m/d H:i:s", $value = "now", $second = 0){
	return datetime($form, $value." +{$second} minutes");
}
//傳回x天後(型態.時間起始點.x)
function datetime_addDay($form = "Y/m/d H:i:s", $value = "now", $second = 0){
	return datetime($form, $value." +{$second} days");
}
//傳回x月後(型態.時間起始點.x)
function datetime_addMonth($form = "Y/m/d H:i:s", $value = "now", $second = 0){
	return datetime($form, $value."+{$second} month");
}
//=============================================//
//分頁(第幾頁.總筆數.一頁幾筆.顯示幾頁)

function flip_page($page, $totalrows, $show_num = 10, $num_page = 10){
	if((int)$totalrows > 0){
		$pagecount = ceil($totalrows/$show_num);
	}else{
		$pagecount = 1;
		$totalrows = 0;
	}
	
	if((int)$page < 1){
		$page = 1;
	}else if($page > $pagecount){
		$page = $pagecount;
	}
	
	$sno=(int)($num_page/2)-1;
	$eno = $sno*2+1;
	$sec_start = $page-$sno;
	if($sec_start <1){
		$sec_start = 1;
	}
	
	$sec_end = $sec_start + $eno;
	if($sec_end > $pagecount){
		$sec_end = $pagecount;
	}
	
	$fpage = array();
	
	$fpage["page"]      =  $page;      //頁碼
	$fpage["pagecount"] =  $pagecount;  //總頁數
	$fpage["sec_start"] =  $sec_start;  //分頁起點
	$fpage["sec_end"]   =  $sec_end;    //分頁終點
	$fpage["rs_begin"]  =  ($page-1) * $show_num; //mysql limit 分頁起點
	$fpage["show_num"]  =  $show_num;  //每頁筆數
	
	return $fpage;

}

//=============================================//
//檔案
function filesize_check($file, $size = 1000){
//檔案大小測試
	if(isset($file)){
		if($file["size"] <= 1024 * $size){
			return true;
		}
	}
    return false;
}

function filename_check($filename, $ext){
//檢查檔案類型(檔案名,要比對的副檔名)
	if($filename > '') {
		/*strtolower(a):a轉小寫。*/
		/*explode(a,b):將b字串以a分割*/
		/*end(a):傳回a內最後一個元素*/
		/*in_array(a,b):檢查a是否在b陣列內*/
		if(in_array(end(explode(".", strtolower($filename))), $ext)){
			return true;
		}
	}
    return false;
}

function file_ext($file){
	//傳回副檔名
	$ext = explode('.',$file["name"]);
	$size = count($ext);
	return $ext[$size-1];
}

function file_open($file){
	//讀取檔案
	$handle = fopen($file, "r");
	$contents = fread($handle, filesize($file));
	fclose($handle);
	return $contents;
}

//JS輔助(alert($key)並跳轉至網址$url)
function script($key,$url = ""){
	if($key==""){
		echo "<script>window.location='$url'</script>";
		exit;
	}
	if($url != ""){
		echo "<script>alert('$key');window.location='$url'</script>";
		exit;
	}else{
		echo "<script>alert('$key');window.history.go(-1)</script>";
		exit;
	}
}
function redirect($url){
	echo "<script>window.location='$url'</script>";
	exit;
}

//資料驗證
$str_message = "";
function isNull($str, $name, $min, $max){
	global $str_message;
	if(mb_strlen($str) >= $min && mb_strlen($str) <= $max){
		return true;
	}else{
		$str_message = $name.'必須大於'.$min.'個字元和小於'.$max.'字元';
		return false;
	}
}

function isNum($str, $name, $min, $max){
	global $str_message;
	if(!is_numeric($str)){
		$str_message = $name.'必須是整數型態';
		return false;		
	}else{
		if(intval($str) >= $min && intval($str) <= $max){
			return true;
		}else{
			$str_message = $name.'必須大於'.$min.'個字元和小於'.$max.'字元';
			return false;
		}
	}
}

function isEmail2($str, $name){
	global $str_message;
	$result = preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $str); 
	if(!$result){
		$str_message = $name.'不是合法的Email格式';
	}
	return $result;
} 
/*End PHP*/
