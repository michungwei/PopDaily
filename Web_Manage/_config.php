<?php
include_once($inc_path."_config.php");
require_once($inc_path."_func_1cm.php");
include_once($inc_path."_web_func.php");
$cache_path = "../../cache/";

/*$aryAdminAuth=array('1'=>'全部','2'=>'新聞列表');*/

$sid = session_id();
$manage_path = "";

if(!isset($_SESSION["madmin"]) || !isset($_SESSION["userid"])){
	echo "<script type='text/javascript'>window.open('".$manage_path."login.html','_top');</script>";
	exit;  
}

function isExist($table, $field, $val, $where){//$field欄位
	global $db;  //global全域變數
	$row = $db -> query_first("SELECT $field FROM $table WHERE $field = $val $where", $field); //query_first為database內function
	return ($row) ? true : false;
}
 								   
function reviewPic($reviewpic){
	global $managepath;
	echo (trim($reviewpic) == "") ? "" : "<a href='$managepath$reviewpic' target='_blank'>瀏覽</a>";
}

function getOrder($order, $table, $id, $field, $nid, $where){ //上移下移的function
	global $db;
	$sql = "";
	$row = $db -> query_first("SELECT $field FROM $table WHERE $id = ".$nid);

	if($row){
		$ind = $row[$field];

		if($order == "down"){
			$sql = "SELECT $id AS id, $field AS field 
					FROM $table 
					WHERE $field < $ind  $where 
					ORDER BY $field desc LIMIT 1 ";
		}else{
			$sql = "SELECT $id AS id, $field AS field 
					FROM $table 
					WHERE $field > $ind $where 
					ORDER BY $field LIMIT 1 ";
		}

		$row = $db -> query_first($sql);
		if($row){
			$new_nid = $row["id"];   //要換順序的id
			$new_ind = $row["field"];//新的順序
		
			$db -> query("UPDATE $table SET $field = $new_ind WHERE $id = $nid"); //將指定id換到新順序
			$db -> query("UPDATE $table SET $field = $ind WHERE $id = $new_nid"); //將要換順序的id換到舊順序
		}
	}
	
}

function getMaxInd($table, $field, $where){
	global $db;
	$row = $db -> query_first("SELECT max($field) AS max FROM $table $where","max");
	$maxind = intval($row["max"]);
	
	if($maxind == 0){
		$maxind = 1;
	}else{
		$maxind += 5;
	}
	return $maxind;
}

function isAuth($key){
	if($key==$_SESSION["mauth"]){
		return true;
	}
	return false;
}
/*End PHP*/