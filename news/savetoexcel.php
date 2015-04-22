<?php
include("_config.php");
ob_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>excel</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
	<th width="60" align="center" >編號</th>
	<th align="left" >標題</th>
    <th width="180" align="left" >類別</th>
    <th width="180" align="left">作者</th>
	<th width="120" align="center" >點擊數</th>
    <th width="100" align="center">新聞上架時間</th>
  </tr>
  
<?php
$db = new Database($HS, $ID, $PW, $DB);
$db->connect();
?>
<?php 
$sql = request("sql",1);/*傳入sql指令*/
//$sql = $_GET["sql"];
$sql = udc($sql);//解碼
$sql = stripslashes($sql);/*去除反斜線*/
//然後去把資料庫撈出來：
$rows_data = $db -> fetch_all_array($sql);
?>


<?php
$total=1;
foreach($rows_data as $row)
{
?>
    <tr>
	  <th align="center"><?php echo $total?></th>
	  <td style="word-break:break-all"><?php echo $row["news_title"]?></td>
      <td align="left" ><?php echo $row["newsType_Cname"]?></td>
      <td align="left" ><?php echo $row["admin_cname"]?></td>
      <td align="center"><?php echo $row["news_clicknum"]?></td>
      <td align="center"><?php echo $row["news_upday"]?></td>
	</tr>
 
<?php
$total++;
}
$db->close();
?>
</table>

</body>
</html>
<?php 
    $outStr=ob_get_contents(); 
    ob_end_clean(); 
     
header("Content-type:application/vnd.ms-excel");
        Header("Accept-Ranges: bytes"); 
        Header("Accept-Length: ".strlen($outStr)); 
		
        Header("Content-Disposition: attachment; filename="."NEWs".date("y-m-d")."_".date("Gis").".xls"); 
        // 輸出文件內容          
        echo $outStr; 
?> 