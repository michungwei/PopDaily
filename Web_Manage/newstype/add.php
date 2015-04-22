<?php
include_once("_config.php");
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
		//if(re){re = isnull("name_en", "名稱(英)", 0, 1, 50);}
		if(re){re = isnull("name_tw", "名稱(中)", 0, 1, 50);}
		if(re){re = isnull("pic", "圖片", 0, 1, 9999);}
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
        <h2> <img src="../images/admintitle.png" />&nbsp;&nbsp;<?php echo $mtitle; ?> >&nbsp;&nbsp;新增</h2>
        <div class="accordion ">
            <div class="tableheader">
                <div class="handlediv"></div>
                <p align="left">新增商品分類</p>
            </div>
            <div class="listshow">
                <form action="save.php?<?php echo $query_str; ?>" method="post" enctype="multipart/form-data" name="form" id="form">
                    <table width="850" border="0" cellpadding="0" cellspacing="3">
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">是否顯示</h4></td>
                            <td><input type="checkbox" name="isshow" id="isshow" checked value="1"/>
                                &nbsp;
                                顯示 </td>
                        </tr>
                        <!-- <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">名稱(英)</h4></td>
                            <td><input type="text" name="name_en" id="name_en" size="50" value=""/></td>
                        </tr> -->
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">名稱(中)</h4></td>
                            <td><input type="text" name="name_tw" id="name_tw" size="50" value=""/></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">圖片</h4></td>
                            <td><p>
                                    <input type="file" name="pic" id="pic" />
                                    <br />
                                    (請上傳符合 <?php echo $newstype_bpic_w; ?> x <?php echo $newstype_bpic_h; ?> 尺寸的圖片)</p></td>
                        </tr>
                        <tr>
                            <td width="150" valign="top"><h4 class="input-text-title">動態圖片</h4></td>
                            <td><p>
                                    <input type="file" name="pic_c" id="pic_c" />
                                    <br />
                                    (請上傳符合 <?php echo $newstype_mpic_w; ?> x <?php echo $newstype_mpic_h; ?> 尺寸的圖片)</p></td>
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
