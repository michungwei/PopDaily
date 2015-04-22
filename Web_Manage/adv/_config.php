<?php
$inc_path="../../inc/";
include_once("../_config.php");

$id_column = "adv_id";//id欄位
/*$ind_column = "adv_ind";排序欄位*/

/*$file_path = $admin_path_adv;*/


$page = request_pag("page");
/*$keyword = get("keyword", 1);*/
$is_show = get("isshow", 1);

$query_str = "isshow=$is_show&page=".$page;
$mtitle = "<a href='index.php?".$query_str."'> 廣告管理 </a>";

/*End PHP*/