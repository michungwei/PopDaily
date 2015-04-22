<?php
include_once("_config.php");
include_once($inc_path."_imgupload.php");
header('Content-type:text/html; charset=utf-8');
$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$id = post("cid");
$btnvalue = post("savenews", 1);

/*$spic_del = post("spic_del");*/


$data["news_title"] = post("title", 1);
$data["video_url"] = request_str("video_url");
$data["news_content"] = request_str("content");
/*$data["news_ind"] = getMaxInd($table_news, $ind_column, "");*/
$data["news_isshow"] = post("isshow");
$data["news_inrightshow"] =  post("inrightshow");
$data["news_slidershow"] =  post("slidershow");
$data["newsType_id"] = post("type");
$data["news_showType"] = post("showType");
$data["news_edittime"] = request_cd();
if(post("aut_id") != "")
	$data["news_aut_id"] = post("aut_id");
else
	$data["news_aut_id"] = $_SESSION["userid"];
/*$data["news_author"] =  post("news_author", 1);*/
$data["news_upday"] = UIdate_change(post("news_upday",1));

$file = new imgUploder($_FILES['pic']);
if($file -> file_name != ""){		
	$rr = substr($file -> file_name,-4);//取檔名後4個字(副檔名)
	$file -> set("file_name", time().$rr);
	$file -> set("file_max", 1100*1000*3); 
	$file -> set("file_dir", $file_path); 
	$file -> set("overwrite", "3"); 
	$file -> set("fstyle", "image"); 
	
	
	if($file -> upload() && $file -> file_name != ""){
		$file -> file_sname = "banner";
		$file -> createSmailImg($news_bannerpic_w, $news_bannerpic_h, 6);	
		$data["news_banner"] = $file -> file_name;
	}
	if( $file -> file_name != ""){
		$file -> file_sname = "s";
		$file -> createSmailImg($news_spic_w, $news_spic_h, 6);	
		$data["news_banner"] = $file -> file_name;
	}
	if( $file -> file_name != ""){
		$file -> file_sname = "m";
		$file -> createSmailImg($news_mpic_w, $news_mpic_h, 6);	
		$data["news_banner"] = $file -> file_name;
	}	
	if( $file -> file_name != ""){
		$file -> file_sname = "sl";
		$file -> createSmailImg($news_slpic_w, $news_slpic_h, 6);	
		$data["news_banner"] = $file -> file_name;
	}
}






$db -> query_update($table_news, $data, "$id_column = $id");
$db -> close();

if($btnvalue=="儲 存 並 預 覽" && $data["newsType_id"] == 10){
	script("修改完成!", "../../video_detail_view.php?nid=".$id);
}
else if($btnvalue=="儲 存 並 預 覽")
{
	script("修改完成!", "../../news_detail_view.php?nid=".$id);
}

script("修改完成!", "edit_test.php?id=".$id);


/*End PHP*/

?>



