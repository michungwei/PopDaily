<?php
include_once("_config.php");

$id = get("id");
if($id == 0){
	script("資料傳輸不正確", "index.php".$query_str);
}

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$sql = "SELECT *
		FROM $table_banner_b 
		WHERE $id_column = '$id'";
		
$row = $db -> query_first($sql);

if($row){
	$href = $row["banner_b_href"];
	$pic = $row["banner_b_pic"];
	$is_show = $row["banner_b_isshow"];
	$createtime = $row["banner_createtime"];
	$hreftarget = $row["banner_hreftarget"];
}else{
 	script("資料不存在");
}
$db -> close();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Untitled Document</title>
<link href="../css/admin_style_gray.css" rel="stylesheet"/>
<script src="../../scripts/jquery-1.6.1rc1.min.js"></script>
<script src="../../scripts/public.js"></script>
<script src="../../scripts/function.js"></script>
<script>
$(document).ready(function(){
	$("form").submit(function(){
		/*$('textarea.ckeditor').each(function () {
			var $textarea = $(this);
			$textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
        });*/
		
		var re = true;
		err_msg = '';
		/*if(re){re = isnull("title", "標題", 0, 1, 999999999999);}檢查是否有填寫*/
		//if(re){re = isnull("link", "連結", 0, 1, 255);}
		if (!re){
			alert(err_msg)
			return false;
		}
		return true;
	});
});
</script>
</head>

<body>
<div id="mgbody-content">
    <div id="adminlist">
        <h2> <img src="../images/admintitle.png" />&nbsp;&nbsp;<?php echo $mtitle; ?> >&nbsp;&nbsp;修改</h2>
        <div class="accordion ">
            <div class="tableheader">
                <div class="handlediv"></div>
                <p align="left">修改BANNER</p>
            </div>
            <div class="listshow">
                <form action="edit_save.php?<?php echo $query_str; ?>" method="post" enctype="multipart/form-data" name="form" id="form">
                    <input type="hidden" name="cid" value="<?php echo $id; ?>">
                    <table width="850" border="0" cellpadding="0" cellspacing="3">
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">最後修改時間</h4></td>
                            <td><?php echo $createtime; ?></td>
                            <td rowspan="5" valign="top"><br />
                                <?php if($pic != ""){echo '<a href="'.$file_path.$pic.'" target="_blank"><img src="'.$file_path.$pic.'" width="150"></a>';} ?>
                                <br /></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">是否顯示</h4></td>
                            <td><input type="checkbox" name="isshow" id="isshow" <?php echo ($is_show == 1) ? "checked" : ""; ?> value="1" />
                                顯示 </td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">是否新開視窗</h4></td>
                            <td><input type="checkbox" name="hreftarget" id="hreftarget" <?php echo ($hreftarget == 1) ? "checked" : ""; ?> value="1" />
                                是 </td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">連結網址</h4></td>
                            <td><input type="text" name="href" id="href" size="50" value="<?php echo $href; ?>"/></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">圖片</h4></td>
                            <td><p>
                                    <input type="file" name="pic" id="pic" value="<?php echo $pic; ?>" />
                                    <br />
                                    <span class="banner1">(請上傳符合 <?php echo $banner_pic_w; ?> x <?php echo $banner_pic_h; ?> 尺寸的圖片)</span>
                                </p></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td height="30"><input name="savenews" type="submit" id="savenews" value=" 送 出 " />
                                &nbsp;&nbsp;&nbsp;
                                <input name="" type="reset" value=" 重 設 " /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
