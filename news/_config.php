<?php
$inc_path = "../../inc/";
include_once("../_config.php");


$id_column = "news_id";
/*$ind_column = "news_ind";*/
$news_upday = "news_upday";
$newsTypeind_column= "newsType_ind";
$adminind_column= "admin_ind";

$file_path = $admin_path_news;
$file_path_newscontent = $admin_path_newscontent;

$mauth = $_SESSION["mauth"];//帳號權限
$news_aut_id = $_SESSION["userid"];//帳號id
$type = get("type", 1);
$keyword1 = get("keyword1", 1);//標題
$keyword2 = get("keyword2", 1);//作者
$keyword3 = get("keyword3", 1);//起始時間
$keyword4 = get("keyword4", 1);//結束時間
$is_show = get("isshow", 1);
$page = request_pag("page");
$query_str = "type=$type&isshow=$is_show&keyword1=$keyword1&keyword2=$keyword2&keyword3=".urlencode($keyword3)."&keyword4=".urlencode($keyword4)."&page=".$page;
$mtitle = "<a href='index.php?".$query_str."'> 新聞管理 </a>";

/*End PHP*/