<?php
include_once("_config.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$id = post("cid");


$data["contact_status"] = post("c_status");
$data["contact_Etime"] = request_cd();

$db -> query_update($table_contact, $data, "$id_column = $id");
$db -> close();

script("修改完成!", "edit.php?id=".$id);

/*End PHP*/



