<?php
$inc_path = "../../inc/";
include_once('../_config.php');

$id_column = "contact_id";
$ind_column = "contact_ind";

$replay = get("replay", 1);
$page = request_pag("page");
$query_str = "replay=$replay&page=".$page;
$mtitle = "<a href='index.php?".$query_str."'> 聯絡訊息管理 </a>";

/*End PHP*/