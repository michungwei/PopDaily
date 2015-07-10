<?php
include_once("_config.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

$sql_type = "SELECT * 
			FROM $table_newstype 
			ORDER BY newsType_ind";
$rows_type = $db -> fetch_all_array($sql_type);

$db -> close();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Untitled Document</title>
<link href="../css/admin_style_gray.css" rel="stylesheet" />
<link href="../../ui/uploadify/uploadify.css" rel="stylesheet"/>
<script src="../../scripts/jquery-1.6.1rc1.min.js"></script>
<script src="../../scripts/public.js"></script>
<script src="../../ui/ckeditor/ckeditor.js"></script>
<script src="../../scripts/function.js"></script>

<!--jquery ui-->
<script type="text/javascript" src="../../ui/jquery-ui-1.11.0/jquery-ui.min.js"></script>
<link href="../../ui/jquery-ui-1.11.0/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="../../ui/jquery-ui-1.11.0/jquery-ui.structure.min.css" rel="stylesheet" type="text/css">
<link href="../../ui/jquery-ui-1.11.0/jquery-ui.theme.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../ui/jquery-ui-1.11.0/timePlugin/jquery-ui-timepicker-addon.js"></script>
<link href="../../ui/jquery-ui-1.11.0/timePlugin/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css">
<script>
$(function() {
/*$( "#news_upday" ).datepicker();*/
	$('#news_upday').datetimepicker();
});
</script>


<script>
$(document).ready(function(){
	$("form").submit(function(){
		$('textarea.ckeditor').each(function () {
			var $textarea = $(this);
			$textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
        });
		
		var re = true;
		err_msg = '';
		if(re){re = isnull("title", "標題", 0, 1, 200);}
		if(re){re = isnull("content", "內容", 0, 1, 99999999);}
		if(re){re = isnull("pic", "代表圖", 0, 1, 999);}
		if(re){re = isnull("resource", "資料來源", 0, 1, 999);}
		
		if(!re){
			alert(err_msg)
			return false;
		}
		return true;
	});
});
</script>
<script>
/*$( document ).ready(function(){
  $("#showType").click(function() {
	  if($("#showType").prop("checked")){
        $(".banner_pic").css('display','block'); 
      }else{
        $(".banner_pic").css('display','none');          
      }
  })
})*/
</script>
</head>

<body>
<div id="mgbody-content">
    <div id="adminlist">
        <h2> <img src="../images/admintitle.png" />&nbsp;&nbsp;<?php echo $mtitle; ?> >&nbsp;&nbsp;新增</h2>
        <div class="accordion ">
            <div class="tableheader">
                <div class="handlediv"></div>
                <p align="left">新增新聞</p>
            </div>
            <!--<div class="listshow">-->
                <form action="save.php?<?php echo $query_str; ?>" method="post" enctype="multipart/form-data" name="form" id="form">
					<div class="listshow_L">
						<table width="1000" border="0" cellpadding="0" cellspacing="3">
							<tr>
								<td width="30" valign="top"><h4 class="input-text-title">標題</h4></td>
								<td><input style="width: 1000px;" type="text" name="title" id="title" size="100%" value=""/></td>
							</tr>
							<!--<tr>
								<td width="150" valign="top"><h4 class="input-text-title">作者</h4></td>
								<td><input type="text" name="news_author" id="news_author" size="50" value=""/></td>
							</tr>-->
							<tr>
								<td width="30" valign="top"><h4 class="input-text-title">內容</h4></td>
								<td><textarea name="content" id="content" class="ckeditor"></textarea></td>
							</tr>
							<tr>
                            <td width="30" valign="top"><h4 class="input-text-title">資料來源</h4></td>
								<td><input style="width: 98.5%;" type="text" name="resource" id="resource" size="100%" value=""/></td>
							</tr>
							<tr>
								<td width="30"></td>
								<td height="30"><input name="savenews" type="submit" id="savenews" value=" 上 架 " />
									&nbsp;&nbsp;&nbsp;<input name="savenews" type="submit" id="savenews" value=" 儲 存 並 預 覽 " formtarget="_blank" onclick='test()'/>
									&nbsp;&nbsp;&nbsp;
									<input name="" type="reset" value=" 重 設 " /></td>
							</tr>
						<!--</table>
						<div class="listshow_R">-->
						<!--<table width="100%" border="0" cellpadding="0" cellspacing="3">-->
							<tr>
								<td width="150" valign="top"><h4 class="input-text-title">預定上架時間</h4></td>
								<td width="762"><input name="news_upday" type="text" id="news_upday" maxlength="10" readonly size="39"/>&nbsp;&nbsp;(未填：現在)</td>
							</tr>
							<tr>
								<td width="150" valign="top"><h4 class="input-text-title">是否顯示</h4></td>
								<td><input type="checkbox" name="isshow" id="isshow" checked value="1"/>
									&nbsp;
									顯示 </td>
							</tr>
							<tr>
								<td width="150" valign="top"><h4 class="input-text-title">是否為18禁</h4></td>
								<td><input type="checkbox" name="is18up" id="is18up" value="1"/>
									&nbsp;
									</td>
							</tr>

							<tr>
								<td width="150" valign="top"><h4 class="input-text-title">是否右方顯示</h4></td>
								<td><input type="checkbox" name="inrightshow" id="inrightshow" value="1"/>
									&nbsp;
									右方顯示 </td>
							</tr>
							<tr>
								<td width="150" valign="top"><h4 class="input-text-title">是否大圖顯示</h4></td>
								<td><input type="checkbox" name="showType" id="showType" value="1"/>
									&nbsp;
									是  
								</td>
							</tr>
							<tr height="44">
								<td width="150" valign="top"><h4 class="input-text-title">代表圖</h4></td>
								<td><div class="banner_pic">
										<input type="file" name="pic" id="pic" />
										(請上傳符合 <?php echo $news_bannerpic_w; ?> x <?php echo $news_bannerpic_h; ?> 尺寸的圖片)
									</div>  
								</td>
							</tr>
							<tr>
								<td width="150" valign="top"><h4 class="input-text-title">新聞類別</h4></td>
								<td><select name="type" id="type">
								<?php
									foreach($rows_type as $row_type){
								?>
									<option value="<?php echo $row_type["newsType_id"]; ?>"><?php echo $row_type["newsType_Ename"]."/".$row_type["newsType_Cname"]; ?></option>
								<?php
									}
								?>
									</select>
								</td>
							</tr>
						</table>
					<!--</div>-->
					</div>
                </form>
            <!--</div>-->
        </div>
    </div>
</div>
</body>
</html>
