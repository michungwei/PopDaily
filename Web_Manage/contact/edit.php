<?php
include_once("_config.php");
$id = get("id");

if($id == 0){
	script("資料傳輸不正確", "index.php".$query_str);
}

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$sql = "SELECT * 
		FROM $table_contact 
		WHERE $id_column = '$id'";
$row = $db -> query_first($sql);
if($row){
	$contact_name = $row["contact_name"];
    $contact_tel = $row["contact_tel"];
    $contact_email = $row["contact_email"];
    $contact_content = $row["contact_content"];
    $contact_time = $row["contact_time"];
    $contact_status = $row["contact_status"];
	$contact_Etime = $row["contact_Etime"];
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
<link href="../css/admin_style_gray.css" rel="stylesheet" />
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
		
		/*var re = true;
		err_msg = '';
		if(re){re = isnull("title", "標題", 0, 1, 200);}
		if(re){re = isnull("content", "內容", 0, 1, 99999999);}
		if (!re){
			alert(err_msg)
			return false;
		}
		return true;*/
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
                <p align="left">確認聯絡訊息</p>
            </div>
            <div class="listshow">
                <form action="edit_save.php?<?php echo $query_str; ?>" method="post" enctype="multipart/form-data" name="form" id="form">
                    <input type="hidden" name="cid" value="<?php echo $id; ?>">
                    <table width="850" border="0" cellpadding="0" cellspacing="3">
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">發訊時間</h4></td>
                            <td><?php echo $contact_time; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">最後處理時間</h4></td>
                            <td><?php echo $contact_Etime; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">姓名</h4></td>
                            <td><?php echo $contact_name; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">電話</h4></td>
                            <td><?php echo $contact_tel; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">E-mail</h4></td>
                            <td><?php echo $contact_email; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">內容</h4></td>
                            <td><?php echo $contact_content; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">處理狀況</h4></td>
                            <td><input type="radio" name="c_status" value="0" <?php echo ($contact_status == 0) ? "checked" : ""; ?>>
                                未處理
                                <input type="radio" name="c_status" value="1" <?php echo ($contact_status == 1) ? "checked" : ""; ?>>
                                已處理
                            </td>
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
