<?php
include_once("_config.php");

$id = get("id");
if($id == 0){
	script("資料傳輸不正確", "index.php".$query_str);
}
$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();
$sql = "SELECT * 
		FROM $table_admin 
		WHERE $id_column = '$id'";
$row = $db -> query_first($sql);
if($row){
	$useid = $row["admin_id"];
	$username = $row["admin_username"];
	$password = $row["admin_password"];
	$is_show = $row["admin_isshow"];
	$createtime = $row["admin_createtime"];
	$admin_auth = $row["admin_auth"];
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
<script type="text/javascript" src="../../scripts/jquery-1.6.1rc1.min.js"></script>
<script src="../../scripts/public.js"></script>
<script src="../../scripts/function.js"></script>
<script>
$(document).ready(function(){
	$("form").submit(function(){
		var re = true;
		err_msg = '';
		if(re){re = isnull("username", "帳號", 0, 1, 35);}
		if(re){re = isexist($("#username").val(), "帳號", "check.php", <?php echo $id ?>);}
		if(re){re = isnull("cname", "作者名", 0, 1, 50);}
		/*if(re){re = isnull("new_password", "新密碼", 0, 1, 50);}
		if(re){re = isnull("new_password2", "確認新密碼", 0, 1, 50);}*/
		
		if(re){re = checkPassword("new_password", "new_password2");}//判斷新密碼是否一樣
			if(!re){
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
                <p align="left">修改管理者</p>
            </div>
            <div class="listshow">
                <form action="edit_save.php?<?php echo $query_str; ?>" method="post" enctype="multipart/form-data" name="form" id="form">
                    <input type="hidden" name="cid" value="<?php echo $id; ?>">
                    <table width="850" border="0" cellpadding="0" cellspacing="3">
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">最後修改時間</h4></td>
                            <td><?php echo $createtime; ?></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">是否停權</h4></td>
                            <td><?php /*if($useid != "2" and $useid != "1"){?><input type="checkbox" name="isshow" id="isshow" <?php echo ($is_show == 0) ? "checked" : ""; ?> value="0" />
                                停權 <?php }*/?>
                            <input type="checkbox" name="isshow" id="isshow" <?php echo ($is_show == 0) ? "checked" : ""; ?> value="0" <?php if($useid == "2"){echo "disabled";}?>/>    
                            </td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">作者名</h4></td>
                            <td><input type="text" name="cname" id="cname" size="50" maxlength="50" value=""/></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">帳號</h4></td>
                            <td><input type="text" name="username" id="username" size="50" maxlength="35" value="<?php echo $username; ?>"/></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">新密碼</h4></td>
                            <td><input type="password" name="new_password" id="new_password" size="50" maxlength="35"/></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">確認新密碼</h4></td>
                            <td><input type="password" name="new_password2" id="new_password2" size="50" maxlength="35" /></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">後端權限</h4></td>
                            <td>
                             <?php
			                   foreach($aryAdminAuth as $key=>$auth){
							 ?>
                              <label>
                               <input type="radio" name="auth" value="<?php echo $key ?>" id="auth_<?php echo $key ?>" <?php echo $key==$admin_auth ? 'checked' : '' ?>>
							   <?php echo $auth ?>&nbsp;&nbsp;
                              </label>
						     <?php
                               /*if($key%12==0) echo '<br />';*/
							   }
							 ?>
                            </td>
                            
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
