<?php 
include_once("_config.php");
include_once($inc_path."_getpage.php");
/*include_once($inc_path."excel/to_excel.php");*/

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();
//排序
/*$reind = trim(get("remove", 1));
if($reind != ""){
	$nid = get("nid", 0);
	if($nid > 0){
		getOrder($reind, $table_news, $id_column, $ind_column, $nid, "");
	}
}*/
//刪除
if(get("isdel", 1) == 'y'){
	$did = get("did");
	$db -> query("DELETE FROM $table_news WHERE $id_column = '$did'");
	script("刪除成功");
}
$count = 0;
$sql_str = "";

if($mauth == "2"){//若為限制權限
	$sql_str .= " AND n.news_aut_id = $news_aut_id";
}

if($type != ""){
	$sql_str .= " AND n.newsType_id = $type";
}
if($keyword1 != ""){
	$sql_str .= " AND n.news_title LIKE '%$keyword1%'";
}

if($is_show != ""){
	$sql_str .= " AND n.news_isshow = $is_show";
}
if($keyword2 != ""){
	$sql_str .= " AND a.admin_id = $keyword2";
}
if($keyword3 != ""){
	$k3 = UIdate_change($keyword3);
	$sql_str .= " AND n.news_upday >= '$k3'";
}
if($keyword4 != ""){
	$k4 = UIdate_change($keyword4);
	$sql_str .= " AND n.news_upday <= '$k4'";
}

/*SELECT * FROM $table_news n,$table_admin a WHERE 1 AND a.admin_id = n.news_aut_id $sql_str ORDER BY $news_upday DESC*/
$sql = "SELECT * FROM $table_news n,$table_admin a,$table_newstype nt WHERE 1 And nt.newsType_id = n.newsType_id AND a.admin_id = n.news_aut_id $sql_str ORDER BY $news_upday DESC";
getSql($sql, 100, $query_str);

/*excel匯出用sql*/
$sqlexcel = "SELECT * FROM $table_news n,$table_admin a,$table_newstype nt WHERE 1 And nt.newsType_id = n.newsType_id AND a.admin_id = n.news_aut_id $sql_str ORDER BY $news_upday DESC";

//類別下拉選單
$sql_type = "SELECT * 
			 FROM $table_newstype 
			 ORDER BY $newsTypeind_column DESC";
$rows_type = $db -> fetch_all_array($sql_type);
$ary_type = array();
foreach($rows_type as $row_type){
	$ary_type[$row_type["newsType_id"]]= $row_type["newsType_Ename"]."/".$row_type["newsType_Cname"];
}

//作者下拉選單
$sql_admin = "SELECT * 
			 FROM $table_admin 
			 ORDER BY $adminind_column DESC";
$rows_admin = $db -> fetch_all_array($sql_admin);
$ary_admin = array();
foreach($rows_admin as $row_admin){
	$ary_admin[$row_admin["admin_id"]]= $row_admin["admin_cname"];
}


?>
<!doctype html>

<html>
<head>
<meta charset="utf-8" />
<title>Untitled Document</title>
<link href="../css/admin_style_gray.css" rel="stylesheet" />
<script type="text/javascript" src="../../scripts/jquery-1.9.1.js"></script>

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
	$('.keyword_date').datetimepicker();
});
</script>
<script language="javascript">
$(function() {
 $("#toexcel").click(function(){
	window.location.href="savetoexcel.php?sql=<?php echo uc($sqlexcel);?>";  /*務必先轉碼*/     
 })
});

</script>

</head>

<body>
<div id="mgbody-content">
    <div id="panel"> <br />
    </div>
    <p class="slide"> <a href="add.php?<?php echo $query_str; ?>" class="btn-slideNo">新增</a></p>
    <div id="adminlist">
        <h2> <img src="../images/admintitle.png" />&nbsp;&nbsp;<?php echo $mtitle; ?> >&nbsp;&nbsp;列表</h2>
        <br>
        <form method="get" action="index.php">
            標題:
            <input name="keyword1" type="text" size="20" value="<?php echo $keyword1; ?>">
            &nbsp;&nbsp;
            作者:
            <select name="keyword2" id="keyword2">
              <option value="" <?php echo ($keyword2 == "") ? "selected" : ""; ?>>不限</option>
              <?php
			  foreach($rows_admin as $row_admin){
			  ?>
              <option value="<?php echo $row_admin["admin_id"]; ?>" <?php echo($keyword2 == $row_admin["admin_id"])?"selected" : ""; ?>><?php echo $row_admin["admin_cname"]; ?></option>
              <?php
			  }
			  ?>
            </select>
          <!--<input name="keyword2" type="text" size="20" value="<?php /*echo $keyword2; */?>">-->
            &nbsp;&nbsp;&nbsp;
            新聞上架時間:
            <input class="keyword_date" name="keyword3" type="text" size="20" value="<?php echo $keyword3; ?>" maxlength="20" readonly>
            ~
            <input class="keyword_date" name="keyword4" type="text" size="20" value="<?php echo $keyword4; ?>" maxlength="20" readonly>
            &nbsp;&nbsp;
            顯示:
            <select name="isshow" id="isshow">
                <option value="" <?php echo ($is_show == "") ? "selected" : ""; ?>>不限</option>
                <option value="1" <?php echo ($is_show == "1") ? "selected" : ""; ?>>顯示</option>
                <option value="0" <?php echo ($is_show == "0") ? "selected" : ""; ?>>隱藏</option>
            </select>
            &nbsp;&nbsp;
            類別:
            <select name="type" id="type">
                <option value="" <?php echo ($type == "") ? "selected" : ""; ?>>不限</option>
                <?php
				   foreach($rows_type as $row_type){
				?>
                <option value="<?php echo $row_type["newsType_id"]; ?>" <?php echo ($type == $row_type["newsType_id"]) ? "selected" : ""; ?>><?php echo $row_type["newsType_Ename"]."/".$row_type["newsType_Cname"]; ?></option>
                <?php
				   }
				?>
            </select>
            &nbsp;&nbsp;
            
            <input name="" type="submit" value="搜尋" id="search_btn"/>
            &nbsp;&nbsp;共<?php echo $count; ?>筆資料&nbsp;&nbsp;&nbsp;<input type="button" value=" 匯出成excel " id="toexcel"/>
        </form>
       
        <div class="accordion">
            <table width="100%" cellspacing="0" class="list-table">
                <thead>
                    <tr>
                        <!--<th width="60" align="center">ID</th>-->
                        <th width="60" align="center">編號</th>
                        <th width="160" align="center">類別</th>
                        <th width="160" align="center">代表圖</th>
                        <th width="160" align="center">作者</th>
                        <th align="left">標題</th>
                        <th width="50" align="center">點擊數</th>
                        <th width="120" align="center">是否大圖顯示</th>
                        <th width="60" align="center">是否顯示</th>
                        <th width="100" align="center">是否右方顯示</th>
                        <th width="120" align="center">新聞上架時間</th>
                        <th width="120" align="center">建立時間</th>
                        <th width="120" align="center">最後修改時間</th>
                        <!--<th width="60" height="28" align="center" >上移</th>
                        <th width="60" height="28" align="center" >下移</th>-->
                        <th width="60" height="28" align="center" >修改</th>
                        <th width="60" align="center" >刪除</th>
                    </tr>
                </thead>
                <tbody id="the-list" class="list:cat">
                    <?php
						$rows = $db -> fetch_all_array($sql);
						$i=($page-1)*10+1;
						foreach($rows as $row){
						
					?>
                    <tr>
                        <!--<td align="center"><?php /*echo $row["news_id"]; */?></td>-->
                        <td align="center"><?php echo $i; ?></td>
                        <td align="center"><?php echo $ary_type[$row["newsType_id"]]; ?></td>
                        <td align="center"><a href=<?php echo $file_path."s".$row["news_banner"]; ?> ><img src="<?php echo $file_path."s".$row["news_banner"]; ?>" height="68" onerror="javascript:this.src='../images/nopic.jpg'"></a></td>
                        <td align="center"><?php echo $row["admin_cname"]; ?></td>
                        <td align="left" style="word-wrap:break-word;overflow:hidden;"><a Target="_new" href="http://popadmin.popdaily.com.tw/news_detail.php?nid=<?php echo $row["news_id"] ?>" ><?php echo $row["news_title"]; ?></a></td>
                        <td align="center"><?php echo $row["news_clicknum"]; ?></td>
                        <td align="center"><?php echo $ary_yn[$row["news_showType"]]; ?></td>
                        <td align="center"><?php echo $ary_yn[$row["news_isshow"]]; ?></td>
                        <td align="center"><?php echo $ary_yn[$row["news_inrightshow"]]; ?></td>
                        <td align="center"><?php echo $row["news_upday"]; ?></td>
                        <td align="center"><?php echo $row["news_createtime"]; ?></td>
                        <td align="center"><?php echo $row["news_edittime"]; ?></td>
                        <!--<td align="center"><a href="?remove=up&nid=<?php /*echo $row["news_id"].'&'.$query_str; */?>">上移</a></td>
                        <td align="center"><a href="?remove=down&nid=<?php /* echo $row["news_id"].'&'.$query_str; */?>">下移</a></td>-->
                        <td align="center"><a href="edit.php?id=<?php echo $row["news_id"].'&'.$query_str; ?>">修改</a></td>
                        <td align="center" ><a href="index.php?isdel=y&did=<?php echo $row["news_id"].'&'.$query_str; ?>" onClick="return confirm('您確定要刪除這筆記錄?')">刪除</a></td>
                    </tr>
                    <?php
                        
					$i++;
						}
						$db -> close();
					?>
                </tbody>
                <tfoot>
                    <tr>
                    
                        <th height="30" colspan="14" align="right"  class="tfoot" scope="col"><?php showPage(); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</body>
</html>