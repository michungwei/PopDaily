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
		getOrder($reind, $table_contact, $id_column, $ind_column, $nid, "");
	}
} 
//刪除
if(get("isdel", 1) == 'y'){
$did = get("did");
  	$db -> query("DELETE FROM $table_contact WHERE $id_column = '$did'");
	script("刪除成功");
}

$count = 0;
$sql_str = "";
if($replay != ""){
	$sql_str .= " AND contact_status = $replay";
}
$sql = "SELECT * 
		FROM $table_contact
		WHERE 1 $sql_str
		ORDER BY $ind_column DESC";
getsql($sql, 10, $query_str);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Untitled Document</title>
<link href="../css/admin_style_gray.css" rel="stylesheet" />
<script src="../../scripts/jquery-1.6.1rc1.min.js"></script>
</head>

<body>
<div id="mgbody-content">
    <div id="panel"> </div>
    <p class="slide">
        <?php /*?><a href="add.php?<?php echo $query_str; ?>" class="btn-slideNo">新增</a><?php */?>
    </p>
    <div id="adminlist">
        <h2> <img src="../images/admintitle.png" />&nbsp;&nbsp;<?php echo $mtitle; ?> >&nbsp;&nbsp;列表</h2>
        <br>
        <form method="get" action="index.php">
            <?php /*?>聯絡人:
            <input name="keyword" type="text" size="20" value="<?php echo $keyword; ?>">
            &nbsp;&nbsp;
            <?php */?>
            處理狀況:
            <select name="replay" id="replay">
                <option value="" <?php echo ($replay == "") ? "selected" : ""; ?>>不限</option>
                <option value="1" <?php echo ($replay == "1") ? "selected" : ""; ?>>已處理</option>
                <option value="0" <?php echo ($replay == "0") ? "selected" : ""; ?>>未處理</option>
            </select>
            <input name="lang" type="hidden" id="lang" value="<?php echo $lang; ?>">
            &nbsp;&nbsp;
            <input name="" type="submit" value="搜尋" id="search_btn"/>
            &nbsp;&nbsp;共<?php echo $count; ?>筆資料
        </form>
        <div class="accordion">
            <table width="100%" cellspacing="0" class="list-table">
                <thead>
                    <tr>
                        <th width="60" align="center" >ID</th>
                        <th width="60" align="center" >姓名</th>
                        <th width="120" align="center" >電話</th>
                        <th width="120" align="center" >信箱</th>
                        <th align="left" >內容</th>
                        <th width="120" align="center" >發訊時間</th>
                        
                        <th width="60" height="28" align="center" >上移</th>
                        <th width="60" height="28" align="center" >下移</th>
                        <th width="60" height="28" align="center">處理狀況</th>
                        <th width="60" height="28" align="center" >修改</th>
                        <!--<th width="60" align="center" >刪除</th>-->
                    </tr>
                </thead>
                <tbody id="the-list" class="list:cat">
                    <?php
						$rows = $db -> fetch_all_array($sql);
						foreach($rows as $row){
					?>
                    <tr>
                        <td align="center"><?php echo $row["contact_id"]; ?></td>
                        <td align="center"><?php echo $row["contact_name"]; ?></td>
                        <td align="center"><?php echo $row["contact_tel"]; ?></td>
                        <td align="center"><?php echo $row["contact_email"]; ?></td>
                        <td align="left"><?php echo  GBsubstr(strip_tags($row["contact_content"]), 0, 100); ?></td><!--strip_tags去除HTML、XML 以及 PHP標籤-->
                        <td align="center"><?php echo $row["contact_time"]; ?></td>
                    
                        <td align="center"><a href="?remove=up&nid=<?php echo $row["contact_id"].'&'.$query_str; ?>">上移</a></td>
                        <td align="center"><a href="?remove=down&nid=<?php echo $row["contact_id"].'&'.$query_str; ?>">下移</a></td>
                        <th width="60" height="28" align="center"><?php echo $ary_pro_status[$row["contact_status"]]; ?></th>
                        <td align="center"><a href="edit.php?id=<?php echo $row["contact_id"].'&'.$query_str; ?>">修改</a></td>
                        <?php /*?><td align="center" ><a href="index.php?isdel=y&did=<?php echo $row["contact_id"].'&'.$query_str; ?>" onClick="return confirm('您確定要刪除這筆記錄?')">刪除</a></td><?php */?>
                    </tr>
                    <?php
						}
						$db -> close();
					?>
                </tbody>
                <tfoot>
                    <tr>
                        <th height="30" colspan="10" align="right"  class="tfoot" scope="col"><?php showPage(); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</body>
</html>