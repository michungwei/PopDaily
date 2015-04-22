<?php
include_once("_config.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$data["admin_username"] = post("username", 1);
$data["admin_password"] = md5(post("password", 1));
$data["admin_createtime"] = request_cd();
$data["admin_ind"] = getMaxInd($table_admin, $ind_column, "");
$data["admin_auth"] = post("auth", 1);
$data["admin_cname"] = post("cname", 1);

$db -> query_insert($table_admin, $data);
$db -> close();

script("新增成功!", "index.php");
/*End PHP*/
