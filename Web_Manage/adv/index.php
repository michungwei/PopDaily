<?php 
include_once("_config.php");
include_once($inc_path."_getpage.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();
/*排序
$reind = trim(get("remove", 1));
if($reind != ""){
	$nid = get("nid", 0);
	if($nid > 0){
		getOrder($reind, $table_adv, $id_column, $ind_column, $nid, "");//$order, $table, $id, $field, $nid, $where
	}
}*/
/*刪除
if(get("isdel", 1) == 'y'){
	$did = get("did");
  	$db -> query("DELETE FROM $table_newstype WHERE $id_column = '$did'");
	script("刪除成功");
}*/

$count = 0;
$sql_str = "";

//篩選條件1
/*if($keyword != ""){
	$sql_str .= " AND (newsType_Ename LIKE '%$keyword%' OR newsType_Cname LIKE '%$keyword%')";
}*/

//篩選條件2
if($is_show != ""){
	$sql_str .= " AND adv_isshow = $is_show";
}

$sql = "SELECT * FROM $table_adv  WHERE 1 $sql_str  ORDER BY $id_column";	
		
getSql($sql, 10, $query_str);

/*$sql_group = "SELECT newsType_id , count(*)
              FROM $table_news
			  group by newsType_id";*/
?>
<!doctype html>
<html>
<head>
<title>Untitled Document</title>
<meta charset="utf-8" />
<link href="../css/admin_style_gray.css" rel="stylesheet" />
<script src="../../scripts/jquery-1.6.1rc1.min.js"></script>
</head>

<body>
<div id="mgbody-content">
    <div id="panel"> <br />
    </div>
    <!--<p class="slide"> <a href="add.php?<?php /*echo $query_str;*/ ?>" class="btn-slideNo">新增</a></p>-->
    <div id="adminlist">
        <h2> <img src="../images/admintitle.png" />&nbsp;&nbsp;<?php echo $mtitle; ?> >&nbsp;&nbsp;列表</h2>
        <br>
        <form method="get" action="index.php">
            <?php /*分類名稱:
            <input name="keyword" type="text" size="20" value="<?php echo $keyword; ?>">
            &nbsp;&nbsp;
			*/ ?>
            顯示:
            <select name="isshow" id="isshow">
                <option value="" <?php echo ($is_show == "") ? "selected" : ""; ?>>不限</option>
                <option value="1" <?php echo ($is_show == "1") ? "selected" : ""; ?>>顯示</option>
                <option value="0" <?php echo ($is_show == "0") ? "selected" : ""; ?>>隱藏</option>
            </select>
            &nbsp;&nbsp;
            <input name="" type="submit" value="搜尋" id="search_btn"/>
            &nbsp;&nbsp;共<?php echo $count; ?>筆資料
        </form>
        <div class="accordion">
            <table width="100%" cellspacing="0" class="list-table">
                <thead>
                    <tr>
                        <th width="130" align="left" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ID</th>
                        <th align="left" >廣告</th>
                        <th width="60" align="center">是否顯示</th>
                        <th width="120" align="center" >最後修改時間</th>
                        <th width="60" height="28" align="center" >修改</th>
                        
                    </tr>
                </thead>
                <tbody id="the-list" class="list:cat">
                    <?php
						$rows = $db -> fetch_all_array($sql);
						/*$rows_group = $db -> fetch_all_array($sql_group);*/
						foreach($rows as $row){
					?>
                    <tr>
                        <td align="left">
						   <?php
						     echo "&nbsp;&nbsp;&nbsp;&nbsp;".$row["adv_id"].".";
							 echo $ary_adv_type[$row["adv_id"]];
						   ?>
                        </td>
                        <td align="left"><?php echo hc($row["adv_link"]); ?></td>
                        <td align="center" ><?php echo $ary_yn[$row["adv_isshow"]]; ?></td>
                        <td align="center" ><?php echo $row["adv_createtime"]; ?></td>
                        <td align="center"><a href="edit.php?id=<?php echo $row["adv_id"].'&'.$query_str; ?>">修改</a></td>
                        
                    </tr>
                    <?php
						}
						$db -> close();
					?>
                </tbody>
                <tfoot>
                    <tr>
                        <th height="30" colspan="11" align="right"  class="tfoot" scope="col"><?php showPage(); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</body>
</html>