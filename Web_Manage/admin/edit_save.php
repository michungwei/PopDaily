<?php
include_once("_config.php");
include_once($inc_path."_imgupload.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();


$id = post("cid");
$isshow = post("isshow", 1);
$data["admin_username"] = post("username", 1);
$data["admin_password"] = md5(post("new_password", 1));
if($isshow!=""){
$data["admin_isshow"] = $isshow;
}
$data["admin_createtime"] = request_cd();
$data["admin_auth"] = post("auth", 1);
$data["admin_cname"] = post("cname", 1);


$db -> query_update($table_admin, $data, "$id_column = $id");
$db -> close();

script("修改完成!", "edit.php?id=".$id."&".$query_str);
/*End PHP*/

