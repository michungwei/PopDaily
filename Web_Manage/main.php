<?php 
$manage_path = "";
$inc_path = "../inc/";
include_once('_config.php')
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Untitled Document</title>
<link href="css/admin_style_gray.css" rel="stylesheet"/>
<script src="../scripts/jquery-1.6.1rc1.min.js"></script>
<script src="../scripts/function.js"></script>
</head>

<body>
<div id="mgbody-content">
    <div id="panel"> 溫馨提示：請在左邊的功能列表中,用滑鼠左鍵點選您需要操作的功能<br />
    </div>
    <p class="slide"> <a href="#" class="btn-slide">Help</a></p>
    <div id="adminlist">
        <h2> <img src="images/admintitle.png" />&nbsp;&nbsp;首頁管理</h2>
        <div class="accordion ">
            <div class="tableheader">
                <div class="handlediv"></div>
                <p>&nbsp;</p>
            </div>
            <div class="listshow">
                <P>&nbsp;&nbsp;歡迎登入<?php echo $web_name; ?>網站管理系統</P>
                <P>&nbsp;&nbsp;</P>
            </div>
        </div>
    </div>
</div>
</body>
</html>
