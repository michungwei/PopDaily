<?php
include_once("_config.php");
include_once($inc_path."_imgupload.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();


$data["adv_ind"] = getMaxInd($table_adv, $ind_column, "");
$data["adv_link"] = post("adv", 1);//檢查下接值法是否Ok
$data["adv_isshow"] = post("isshow");
$data["adv_createtime"] = request_cd();

/*$file = new imgUploder($_FILES['pic']);
if ($file -> file_name != ""){		
	$rr = substr($file -> file_name, -4);
	$file -> set("file_name", "1".time().$rr);
	$file -> set("file_max", 1024*1024*3); 
	$file -> set("file_dir", $file_path); 
	$file -> set("overwrite", "3"); 
	$file -> set("fstyle", "image"); 

	if ($file -> upload() && $file -> file_name != ""){
		$file -> file_sname = "m";
		$file -> createSmailImg($newstype_pic_w, $newstype_pic_h, 6);	
		$data["newsType_pic"] = $file -> file_name;
	}	
}*/


$db -> query_insert($table_adv, $data);

$db -> close();
script("新增成功!", "index.php");



/*End PHP*/



