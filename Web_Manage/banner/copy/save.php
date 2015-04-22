<?php
include_once("_config.php");
/*include_once($inc_path."_imgupload.php");*/

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();


$data["banner_b_isshow"] = post("isshow");
$data["banner_createtime"] = request_cd();
$data["banner_b_ind"] = getMaxInd($table_banner_b, $ind_column, "");

$file = new imgUploder($_FILES['pic']);
	if($file -> file_name != ""){		
		$rr = substr($file -> file_name,-4);
		$file -> set("file_name", time().$rr);
		$file -> set("file_max", 1024*1024*3); 
		$file -> set("file_dir", $file_path); 
		$file -> set("overwrite", "3"); 
		$file -> set("fstyle", "image"); 
		if($file -> upload() && $file -> file_name != ""){
			/*$file -> file_sname = "m";*/
			$file -> createSmailImg($banner_pic_w, $banner_pic_h, 6);	
			$data["banner_b_pic"] = $file -> file_name;
	}	
}

$db -> query_insert($table_banner_b, $data);
$db -> close();

script("新增成功!", "index.php");

/*End PHP*/

