<?php
$inc_path = "inc/";
$cache_path = "cache/";


/*include_once("Web_Manage/_config.php");*/
include_once($inc_path."_config.php");
include_once($inc_path."_web_func.php");


//搜尋
$keyword = get("keyword", 1);

//常用欄位名
$isshow_newsType = "newsType_isshow";
$isshow_adv = "adv_isshow";
$isshow_news = "news_isshow";
$isrightshow_news = "news_inrightshow";
$isshow_banner_b = "banner_b_isshow";


$ind_news = "news_ind";
$ind_banner = "banner_b_ind";
$ind_nType = "newsType_ind";
$ind_column = "contact_ind";

$news_upday = "news_upday";

//$sameRec = "news_samerec";同類推薦

$NT_id = "newsType_id";//類別id

$N_id = "news_id";//新聞id

$nid= get("nid",1);
$ntid = get("ntid", 1);

//分頁
$page = request_pag("page");
$query_str = "ntid=".$ntid."&page=".$page."&keyword=".$keyword;

function getMaxInd($table, $field, $where){
	global $db;
	$row = $db -> query_first("SELECT max($field) AS max FROM $table $where","max");
	$maxind = intval($row["max"]);
	
	if($maxind == 0){
		$maxind = 1;
	}else{
		$maxind += 5;
	}
	return $maxind;
}
/*End PHP*/
