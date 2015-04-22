<?php
$inc_path="../../inc/";
include_once("../_config.php");

$id_column = "admin_id";
$ind_column = "admin_ind";
$check_field = "admin_username";

$keyword = get("keyword", 1);
$is_show = get("isshow", 1);
$searchauth = get("searchauth",1);
$page = request_pag("page");
$query_str = "isshow=$is_show&keyword=$keyword&searchauth=$searchauth&page=".$page;
$mtitle = "<a href='index.php?".$query_str."'> 管理者管理 </a>";
/*End PHP*/