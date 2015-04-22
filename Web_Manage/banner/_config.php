<?php
$inc_path = "../../inc/";
include_once("../_config.php");

$id_column = "banner_b_id";
$ind_column = "banner_b_ind";

$file_path = $admin_path_banner;

/*$type = get("type", 1);*/
$is_show = get("isshow", 1);
$page = request_pag("page");
$query_str = "isshow=$is_show&page=".$page;
$mtitle = "<a href='index.php?".$query_str."'> BANNER管理 </a>";

/*End PHP*/