<?php
$inc_path = "../inc/";
include_once($inc_path."_config.php");

$username = post('uid', 1);
$password = md5(post('pwd',1));

if($username != "" && $password != ""){
	$db = new Database($HS, $ID, $PW, $DB);
	$db -> connect();
	$sql = "SELECT * 
			FROM $table_admin 
			WHERE admin_username = '$username' AND admin_password = '$password'";
	$row = $db -> query_first($sql);
	if($row){
		if($row["admin_isshow"]==1){
		  $lifetime = 20 * 60 * 3600;
		  setcookie(session_name(), session_id(), time() + $lifetime, "/");
		  $_SESSION["madmin"] = $row["admin_username"];
		  $_SESSION["userid"] = $row["admin_id"];
		  $_SESSION["mlevel"] = $row["admin_level"];
		  $_SESSION["mauth"]  = $row["admin_auth"];
		  redirect("index.php");
		}else{
		  script("未開放登入!");
	    }
	}else{
		  script("登入失敗,帳號或密碼不正確!");
	}
	$db -> close();
}else{
	script("帳號或密碼不能為空!");
} 
/*End PHP*/
