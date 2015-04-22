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
<script>
$(function(){
	$(".mg-menu-toggle").toggle(function(){
		$(this).parent().parent().find("li").slideDown("fast");
	},function(){
		$(this).parent().parent().find("li").slideUp("fast");
	});

	$("ul li").hide();

	$(".menu-top").find("a").click(function(){
		$(".menutitle-on").removeClass("menutitle-on");
		$(".menu-open").removeClass().addClass("menu-close");
		$(this).parent().parent().removeClass().addClass("menu-open");
		$(this).parent().parent().find("li").slideDown("fast");
	});

	$("#adminmenu li a").click(function(){
		$(".menutitle-on").removeClass("menutitle-on");
		$(".menu-open").removeClass().addClass("menu-close");
		$(this).parent().parent().removeClass().addClass("menu-open");
		$("#adminmenu li").removeClass();
		$(this).parent().addClass("current");
	});
});
</script>
</head>

<body>
<div id="adminmenu">
    <div id="adminmenu_title"  class="menutitle-on"><a href="index.php" target="_top"><img src="images/menutitle.png" /></a>&nbsp;&nbsp;功能列表</div>
<?php
if(isAuth(1)){
?>
    <ul>
        <div class="menu-close">
        <div class="menu-top">
            <div class="mg-menu-toggle"><br />
            </div>
            <span>新聞資訊管理</span></div>
        <li><a href="news/index.php" target="main" onFocus="this.blur()"><span>新聞列表</span></a></li>
        <li><a href="newstype/index.php" target="main" onFocus="this.blur()"><span>新聞分類列表</span></a></li>
        <div class="clear"></div>
    </ul>
    <ul>
        <div class="menu-close">
            <div class="menu-top">
                <div class="mg-menu-toggle"><br />
                </div>
                <span>BANNER管理</span></div>
            <li><a href="banner/index.php" target="main" onFocus="this.blur()"><span>BANNER列表</span></a></li>
        </div>
        <div class="clear"></div>
    </ul>
    <!-- <ul>
        <div class="menu-close">
            <div class="menu-top">
                <div class="mg-menu-toggle"><br />
                </div>
                <span>聯絡訊息管理</span></div>
            <li><a href="contact/index.php" target="main" onFocus="this.blur()"><span>聯絡訊息列表</span></a></li>
        </div>
        <div class="clear"></div>
    </ul> -->
    
    <ul>
        <div class="menu-close">
            <div class="menu-top">
                <div class="mg-menu-toggle"><br />
                </div>
                <span>廣告管理</span></div>
            <li><a href="adv/index.php" target="main" onFocus="this.blur()"><span>廣告管理列表</span></a></li>
        </div>
        <div class="clear"></div>
    </ul>
    <ul>
        <div class="menu-close">
            <div class="menu-top ">
                <div class="mg-menu-toggle"><br />
                </div>
                <span>管理者管理</span></div>
            <li><a href="admin/index.php" target="main" onFocus="this.blur()"><span>管理者列表</span></a></li>
            <li><a href="logout.php" target="main" onFocus="this.blur()"><span>退出系統</span></a></li>
        </div>
        <div class="clear"></div>
    </ul>
<?php
}
?>    

<?php
if(isAuth(2)){
?>
    <ul>
        <div class="menu-close">
        <div class="menu-top">
            <div class="mg-menu-toggle"><br />
            </div>
            <span>新聞資訊管理</span></div>
        <li><a href="news/index.php" target="main" onFocus="this.blur()"><span>新聞列表</span></a></li>
        <div class="clear"></div>
    </ul>

<?php
}
?>    
 
</div>
</body>
</html>
