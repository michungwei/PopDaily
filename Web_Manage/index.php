<?php
$inc_path = "../inc/";
include_once("_config.php");
?>
<!doctype html>
<html>
<head>
<title><?php echo $manage_name; ?></title>
<meta charset="utf-8">
<link rel="icon" href="<?php echo $admin_icon?>" type="image/png" />
</head>
<frameset framespacing="0" id=frameset border="false" rows="46,*,40"  frameborder="0">
    <frame name="top" id="top"  scrolling="no" marginwidth="0" marginheight="0" src="top.php">
    <frameset name=mm id=mm cols="180,*" frameborder="NO" border="0" framespacing="0">
        <frame name="left" id="left"  scrolling="yes" marginwidth="0" marginheight="0" src="left.php">
        <frame name="main" id="main" scrolling="yes" marginwidth="0" marginheight="0" src="main.php">
    </frameset>
    <frame name="bottom" id="bottom"  scrolling="no" marginwidth="0" marginheight="0" src="bottom.php">
</frameset>
<noframes>
<body>
<p>This page uses frames, but your browser doesn't support them.</p>
</body>
</noframes>
</html>