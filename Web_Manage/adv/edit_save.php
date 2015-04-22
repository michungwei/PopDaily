<?php
include_once("_config.php");
/*include_once($inc_path."_imgupload.php");*/

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$id = post("cid");

/*$pic_del = post("pic_del");*/

/*$data["adv_ind"] = getMaxInd($table_adv, $ind_column, "");*/
$data["adv_link"] = request_str("adv");
$data["adv_isshow"] = post("isshow");
$data["adv_createtime"] = request_cd();


$db -> query_update($table_adv, $data, "$id_column = $id");
$db -> close();

script("修改完成!", "edit.php?id=".$id);

/*PHP END*/






