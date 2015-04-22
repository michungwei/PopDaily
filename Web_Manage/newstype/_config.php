<?php
$inc_path="../../inc/";
include_once("../_config.php");

$id_column = "newsType_id";//id欄位
$ind_column = "newsType_ind";//排序欄位

$file_path = $admin_path_newstype;
$file_c_path = $admin_path_newstypec;
$news_path_index = "../news/index.php";//連結到news首頁


$page = request_pag("page");
$keyword = get("keyword", 1);
$is_show = get("isshow", 1);

$query_str = "isshow=$is_show&keyword=$keyword&page=".$page;
$mtitle = "<a href='index.php?".$query_str."'> 新聞分類管理 </a>";

/*End PHP*/