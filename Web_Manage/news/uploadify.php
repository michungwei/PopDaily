<?php
include_once('_config.php');
include_once($inc_path.'_imgupload.php');
$path_ckeditor=$web_url.$admin_path_newscontent;// Relative to the root

$url = '';
$file = new imgUploder($_FILES['Filedata']);



if($file -> file_name != ""){
	$cutname = explode('.', ($file -> file_name));
	$file -> set("file_name", time().generatorPassword().'.'.end($cutname));
	$file -> set("file_max", 1024*1024*3);
	$file -> set("file_dir", $file_path_newscontent);
	$file -> set("overwrite", "3");
	$file -> set("fstyle", "image");
	if($file -> upload() && $file -> file_name != ""){	
		//$url = $path_ckeditor.$file -> file_name;	
		$file -> createSmailImg($news_mostpic_w, $news_mostpic_h, 7);
		$url = $web_url.$admin_path_newscontent.$file -> file_name;	//上傳路徑
		
		echo $file -> file_name;
	}
}

/*$funcNum = $_GET['CKEditorFuncNum'] ;*/




/*End PHP*/
?>