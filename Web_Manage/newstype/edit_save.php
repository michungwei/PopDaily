<?php
include_once("_config.php");
include_once($inc_path."_imgupload.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$id = post("cid");

$pic_del = post("pic_del");
$pic_del2 = post("pic_del2");

$data["newsType_Ename"] = post("name_en", 1);
$data["newsType_Cname"] = post("name_tw", 1);
/*$data["producttype_isindex"] = post("isindex");*/
$data["newsType_isshow"] = post("isshow");
$data["newsType_createtime"] = request_cd();


if($pic_del == 1){
	$data["newsType_pic"] = "";
}
if($pic_del2 == 1){
	$data["newsType_pic_change"] = "";
}


$file = new imgUploder($_FILES['pic']);
if($file -> file_name != ""){		
	$rr = substr($file -> file_name, -4);
	$file -> set("file_name", "1".time().$rr);//設定檔名
	$file -> set("file_max", 1100*1000*3); //設定最大大小
	$file -> set("file_dir", $file_path); //設定路徑
	$file -> set("overwrite", "3"); //設定同名處理法(3為覆蓋)
	$file -> set("fstyle", "image"); //設定檔案種類

	if($file -> upload() && $file -> file_name != ""){
		$file -> file_sname = "m";//若同時上傳多張圖片，需區隔名子
		$file -> createSmailImg($newstype_mpic_w, $newstype_mpic_h, 6);	
		$data["newsType_pic"] = $file -> file_name;
	}
	if($file -> file_name != ""){
		$file -> file_sname = "b";//若同時上傳多張圖片，需區隔名子
		$file -> createSmailImg($newstype_bpic_w, $newstype_bpic_h, 6);	
		$data["newsType_pic"] = $file -> file_name;
	}	
}

$file = new imgUploder($_FILES['pic_c']);
if ($file -> file_name != ""){		
	$rr = substr($file -> file_name, -4);
	$file -> set("file_name", "1".time().$rr);
	$file -> set("file_max", 1100*1000*3); 
	$file -> set("file_dir", $file_c_path); 
	$file -> set("overwrite", "3"); 
	$file -> set("fstyle", "image"); 

	if ($file -> upload() && $file -> file_name != ""){
        /*$file -> file_sname = "m";*/
		$file -> createSmailImg($newstype_mpic_w, $newstype_mpic_h, 6);	
		$data["newsType_pic_change"] = $file -> file_name;
	}
}




$db -> query_update($table_newstype, $data, "$id_column = $id");
$db -> close();

script("修改完成!", "edit.php?id=".$id);

/*PHP END*/






