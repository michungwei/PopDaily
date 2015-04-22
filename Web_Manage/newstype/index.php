<?php 
include_once("_config.php");
include_once($inc_path."_getpage.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();
//排序
$reind = trim(get("remove", 1));
if($reind != ""){
	$nid = get("nid", 0);
	if($nid > 0){
		getOrder($reind, $table_newstype, $id_column, $ind_column, $nid, "");//$order, $table, $id, $field, $nid, $where
	}
}
//刪除
if(get("isdel", 1) == 'y'){
	$did = get("did");
  	if(($db -> query("DELETE FROM $table_newstype WHERE $id_column = '$did'"))!=0){
	script("刪除成功");}script("此類還有新聞，不可刪除!");
}

$count = 0;
$sql_str = "";

//篩選條件1
if($keyword != ""){
	$sql_str .= " AND (newsType_Ename LIKE '%$keyword%' OR newsType_Cname LIKE '%$keyword%')";
}

//篩選條件2
if($is_show != ""){
	$sql_str .= " AND newsType_isshow = $is_show";
}

$sql = "SELECT *,(SELECT count(*) FROM 1cm_news n Group by newsType_id having n.newsType_id=1cm_newstype.newsType_id) as freNum
        FROM 1cm_newstype ORDER BY $ind_column DESC";


/*"SELECT * FROM $table_newstype  WHERE 1 $sql_str  ORDER BY $ind_column DESC";*/		
		
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
    <p class="slide"> <a href="add.php?<?php echo $query_str; ?>" class="btn-slideNo">新增</a></p>
    <div id="adminlist">
        <h2> <img src="../images/admintitle.png" />&nbsp;&nbsp;<?php echo $mtitle; ?> >&nbsp;&nbsp;列表</h2>
        <br>
        <form method="get" action="index.php">
            分類名稱:
            <input name="keyword" type="text" size="20" value="<?php echo $keyword; ?>">
            &nbsp;&nbsp;
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
                        <th width="60" align="center" >ID</th>
                        <th width="140" align="center" >圖片</th>
                        <!-- <th width="120" align="left" >分類名稱(英)</th> -->
                        <th align="left" >分類名稱(中)</th>
                        <th width="60" align="center">筆數</th>
                        <th width="60" align="center">是否顯示</th>
                        <th width="120" align="center" >最後修改時間</th>
                        <th width="60" height="28" align="center" >上移</th>
                        <th width="60" height="28" align="center" >下移</th>
                        <th width="60" height="28" align="center" >修改</th>
                        <th width="60" align="center" >刪除</th>
                    </tr>
                </thead>
                <tbody id="the-list" class="list:cat">
                    <?php
						$rows = $db -> fetch_all_array($sql);
						/*$rows_group = $db -> fetch_all_array($sql_group);*/
						foreach($rows as $row){
					?>
                    <tr>
                        <td align="center"><?php echo $row["newsType_id"]; ?></td>
                        <td align="center"><a href=<?php echo $file_path.$row["newsType_pic"]; ?> ><img src="<?php echo $file_path.$row["newsType_pic"]; ?>" width="120" onerror="javascript:this.src='../images/nopic.jpg'"></a></td><!--onerror若圖片錯誤則...-->
                        <!-- <td align="left" ><?php echo $row["newsType_Ename"]; ?></td> -->
                        <td align="left" ><?php echo $row["newsType_Cname"]; ?></td>
                        <td align="center">
						   <?php
						      if(is_null($row["freNum"])){echo "0";}//is_null若空值傳回1 ture
						      echo '<a href="',$news_path_index,'?type=',$row["newsType_id"],'" >',$row["freNum"],"</a>";
							  
						      /*foreach($rows_group as $row_group){
								  if($row_group["newsType_id"]==$row["newsType_id"]){
							         echo $row_group["count(*)"];
									 
								  }
							  }*/
						   ?>
                        
                        </td>
                        <td align="center" ><?php echo $ary_yn[$row["newsType_isshow"]]; ?></td>
                        <td align="center" ><?php echo $row["newsType_createtime"]; ?></td>
                        <td align="center"><a href="?remove=up&nid=<?php echo $row["newsType_id"].'&'.$query_str; ?>">上移</a></td>
                        <td align="center"><a href="?remove=down&nid=<?php echo $row["newsType_id"].'&'.$query_str; ?>">下移</a></td>
                        <td align="center"><a href="edit.php?id=<?php echo $row["newsType_id"].'&'.$query_str; ?>">修改</a></td>
                        <td align="center" ><a href="index.php?isdel=y&did=<?php echo $row["newsType_id"].'&'.$query_str; ?>" onClick="return confirm('您確定要刪除這筆記錄?')">刪除</a></td>
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