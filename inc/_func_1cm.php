<?php

//=============================================//
//日期時間
//strtotime文字轉為時間戳

//配合jquery ui的datepicker套件的時間轉換 (套件顯示格式為:月日年/時分)
function UIdate_change($cdate){
	if($cdate!=""){
	$php_unix_timestamp = strtotime($cdate);//先轉為時間戳記
	$mysqldate = date( 'Y-m-d H:i:s', $php_unix_timestamp );//再將時間戳記轉為正確格式
	}
	else{$mysqldate= date("Y-m-d H:i:s");}
	return $mysqldate ;
}
function UIdate_change_0($cdate){/**/
    if($cdate!=""){
	return date('m/d/Y H:i', strtotime($cdate));
	}
	
}

?>
