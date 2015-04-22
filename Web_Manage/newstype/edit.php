<?php
include_once("_config.php");

$id = get("id");
if($id == 0){
	script("資料傳輸不正確", "index.php");
}

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$sql = "SELECT *
		FROM $table_newstype 
		WHERE $id_column = '$id'";
$row = $db -> query_first($sql);

if($row){
    $newsType_Cname = $row["newsType_Cname"];
    //$newsType_Ename = $row["newsType_Ename"];
    $newsType_pic = $row["newsType_pic"];
	$newsType_pic_c = $row["newsType_pic_change"];
    $newsType_isshow = $row["newsType_isshow"];
    $newsType_createtime = $row["newsType_createtime"];
}else{
 	script("資料不存在");
}

$db -> close();
?>
<!doctype html>
<html>
<head>
<title>Untitled Document</title>
<meta charset="utf-8" />
<link href="../css/admin_style_gray.css" rel="stylesheet" />
<script src="../../scripts/jquery-1.6.1rc1.min.js"></script>
<script src="../../scripts/public.js"></script>
<script src="../../scripts/function.js"></script>
<script>
$(document).ready(function(){
	$("form").submit(function(){
		var re = true;
		err_msg = '';
		if(re){re = isnull("name_en", "名稱(英)", 0, 1, 50);}
		if(re){re = isnull("name_tw", "名稱(中)", 0, 1, 50);}
		//if(re){re = isnull("pic", "圖片", 0, 1, 9999);}
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
                <p align="left">修改新聞分類</p>
            </div>
            <div class="listshow">
                <form action="edit_save.php?<?php echo $query_str; ?>" method="post" enctype="multipart/form-data" name="form" id="form">
                    <input type="hidden" name="cid" value="<?php echo $id; ?>">
                    <table width="850" border="0" cellpadding="0" cellspacing="3">
                        <tr>
                            <td width="150" valign="center"><h4 class="input-text-title">最後修改時間</h4></td>
                            <td><?php echo $newsType_createtime; ?></td>
                            <td rowspan="6" valign="center"><br />
                                <?php if($newsType_pic != ""){echo '<a href="'.$file_path.$newsType_pic.'" target="_blank"><img src="'.$file_path.$newsType_pic.'" width="150"></a>(原)';} ?>
                                <br />
                                <br />
                                <?php if($newsType_pic_c != ""){echo '<a href="'.$file_c_path.$newsType_pic_c.'" target="_blank"><img src="'.$file_c_path.$newsType_pic_c.'" width="150"></a>(替換)';} ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="150" valign="center"><h4 class="input-text-title">是否顯示</h4></td>
                            <td><input type="checkbox" name="isshow" id="isshow" <?php echo ($newsType_isshow == 1) ? "checked" : ""; ?> value="1" />
                                顯示 </td>
                        </tr>
                        <!-- <tr>
                            <td width="150" valign="center"><h4 class="input-text-title">名稱(英)</h4></td>
                            <td><input type="text" name="name_en" id="name_en" size="50" value="<?php echo $newsType_Ename; ?>"/></td>
                        </tr> -->
                        <tr>
                            <td width="150" valign="center"><h4 class="input-text-title">名稱(中)</h4></td>
                            <td><input type="text" name="name_tw" id="name_tw" size="50" value="<?php echo $newsType_Cname; ?>"/></td>
                        </tr>
                        <tr>
                            <td width="150" valign="center"><h4 class="input-text-title">圖片</h4></td>
                            <td><p>
                                    <input type="file" name="pic" id="pic" value="<?php echo $newsType_pic; ?>" />
                                    <br />
                            (請上傳符合 <?php echo $newstype_bpic_w; ?> x <?php echo $newstype_bpic_h; ?> 尺寸的圖片)&nbsp;&nbsp;&nbsp;&nbsp;<input name="pic_del" type="checkbox" id="pic_del" value="1">&nbsp;刪除圖片</p></td>
                        </tr>
                        <tr>
                            <td width="150" valign="center"><h4 class="input-text-title">動態圖片</h4></td>
                            <td><p>
                                    <input type="file" name="pic_c" id="pic_c" />
                                    <br />
                                    (請上傳符合 <?php echo $newstype_mpic_w; ?> x <?php echo $newstype_mpic_h; ?> 尺寸的圖片)&nbsp;&nbsp;&nbsp;&nbsp;<input name="pic_del2" type="checkbox" id="pic_del2" value="1">&nbsp;刪除圖片</p></td>
                        </tr>
                        <tr>
                            <td width="150"></td>
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
