<?php
include_once("_config.php");
/*include_once($inc_path."_imgupload.php");*/

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();




$data["contact_name"] = post("contact_name", 1);
$data["contact_ind"] = getMaxInd($table_contact, $ind_column, "");
$data["contact_tel"] = post("contact_tel");
$data["contact_email"] = request_str("contact_email");
//$data["contact_content"] = request_str("contact_content");
$contact_content = request_str("contact_content");
$para = str_replace("\n", '&nbsp;</p><p>', $contact_content); 
$data["contact_content"] = '<p>'.$para.'</p>';


$data["contact_time"] = request_cd();


$db -> query_insert($table_contact, $data);
$db -> close();

script("已送出訊息","index.php");
/*script("已成功送出", "index.php");*/

/*End PHP*/


