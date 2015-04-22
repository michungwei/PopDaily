<?php
$inc_path = "../inc/";
include_once("_config.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Untitled Document</title>
<link href="css/admin_style_gray.css" rel="stylesheet" />
<script src="../scripts/jquery-1.6.1rc1.min.js"></script>
</head>

<body>
<div id="mghead">
    <h1 id="site-heading" >
        <a href="index.php" target="_top" title="Visit Site" ><span id="site-title">網站管理系統</span> </a> 
        <a href="<?php echo $web_url; ?>" target="_blank"><em id="site-visit-button">前臺首頁</em></a>
    </h1>
    <div id="mguser">
        <p style=" width:180px;float:right;">您好,<?php echo $_SESSION["madmin"]; ?> <span class="turbo-nag hidden"> | <a href="passwd.php" target="main">修改密碼</a></span> | <a href="logout.php" title="Log Out">登出</a></p>
    </div>
    <div class="clear"></div>
</div>
</body>
</html>
