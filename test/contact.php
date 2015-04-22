<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

$db = new Database($HS, $ID, $PW, $DB);
$db -> connect();

//分類
$sql_newt = "SELECT * 
		    FROM $table_newstype
			WHERE $isshow_newsType=1
			ORDER BY $ind_nType DESC";

$rows_newt = $db -> fetch_all_array($sql_newt);
//廣告
$sql_adv = "SELECT * 
		    FROM $table_adv
			WHERE $isshow_adv=1";

$rows_adv = $db -> fetch_all_array($sql_adv);

foreach($rows_adv as $row_adv){
  $adv[$row_adv["adv_id"]]=$row_adv["adv_link"];
}
//手機下方廣告
$sql_adv = "SELECT * 
		    FROM $table_adv
			WHERE $isshow_adv=1 AND adv_id in(1,2)
			ORDER BY RAND()
			Limit 0,1";

$rowsp_adv = $db -> query_first($sql_adv);
//右方新聞
$sql_news = "SELECT * 
		    FROM $table_news
			WHERE $isshow_news=1 AND $isrightshow_news=1 AND $news_upday<=NOW()
			ORDER BY RAND() LIMIT 1";

$rows_news = $db -> query_first($sql_news);

/*foreach($rows_news as $row_news){
  $row_news=
}*/

$db -> close();
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="author" content="<?php echo $author; ?>" />
<meta name="copyright" content="<?php echo $copyright; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $web_name; ?></title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="ui/validate/css/cmxform.css">
    <link rel="icon" href="<?php echo $web_icon?>" type="image/png" />
	<link rel="stylesheet" href="scripts/fancybox/jquery.fancybox.css">
	<script type="text/javascript" src="scripts/jquery-1.9.1.js"></script>
    <script src="scripts/function.js"></script>
    <script src="ui/validate/js/jquery.js"></script>
    <script src="ui/validate/js/jquery.validate.js"></script>
	<script src="scripts/jquery.timeout.interval.idle.js"></script>
	<script src="scripts/idle.js"></script>
	<script src="scripts/all.js"></script>
    <script src="scripts/search.js"></script>
	<script src="scripts/fancybox/jquery.fancybox.js"></script>


<script>
$(document).ready(function(){
	$("#form1").validate();//掛載validate表單驗證
	$("#contact_submit").click(function() {
	  if($("#form1").valid()){//執行驗證
        $("#form1").submit();
	  }
    })
})
</script>
</head>
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	</div>
	<div id="wrapper">
		<ul class="mobile-list">
			<li class="mobileClose"><img src="images/mobileClose.png" height="31" width="31" alt=""></li>
			<?php
				foreach($rows_newt as $row_newt){
			?>
				<li>
					<a href="news.php?ntid=<?php echo $row_newt["newsType_id"];?>">
						<?php echo $row_newt["newsType_Cname"]; ?>
					</a>
				</li>
			<?php
				}
			?>
			<li>
				<a href="contact.php">聯絡我們</a>
			</li>
		</ul>
		<header id="header">
			<div class="headerC">
				<p><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagelogo','','images/logoover.png')"><img src="images/logo.png" alt="" name="imagelogo"></a></p>
			</div>
			<nav class="headerL hidden-mobile">
				<?php
					foreach($rows_newt as $row_newt){
				?>
					<span><a href="news.php?ntid=<?php echo $row_newt["newsType_id"];?>"><?php echo $row_newt["newsType_Cname"]; ?></a></span>
				<?php
					}
				?>
			</nav>
			<div class="headerR hidden-mobile">
				<div class="search">
					<input type="text" id="search" name="search" value="search">
					<p class="btn" id="search_btn" onClick="search()"><img src="images/search_btn.png" alt=""></p>
				</div>
				<span class="hidden-tablet"><a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagefb','','images/icon_fbover.png')"><img src="images/icon_fb.png" alt="" name="imagefb"></a></span>
				<span class="hidden-tablet"><a href="http://instagram.com/1cm.life" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imageinsta','','images/icon_instaover.png')"><img src="images/icon_insta.png" alt="" name="imageinsta"></a></span>
			</div>
			<div class="mobile-switch visible-mobile"></div>
			<div class="mobile-fb visible-mobile"><a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank"><img src="images/icon_fb.png" alt=""></a></div>
			<div class="mobile-insta visible-mobile"><a href="http://instagram.com/1cm.life" target="_blank"><img src="images/icon_insta.png" alt=""></a></div>
		</header>

		<section id="content">
			<div class="subtitle"><img src="images/subtitle.png" alt=""></div>
			<div class="subtitle-advtise">
				<div class="subtitle-advtiseL">
					<?php if(isset($adv["6"])){echo $adv["6"];}?>
				</div>
				<div class="subtitle-advtiseR hidden-mobile">
					<p class="title hidden-tablet">按下讚與我們一起探索知識的無窮！</p>
					<p class="title visible-tablet">按下讚探索知識的無窮！</p>
					<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>

					<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
			<div class="content_section">
				<div class="content_sectionL border_bottomNone">

					<!-- 內文 Start -->
					
                    <div class="beadcrumbs_img"><a href="index.php">首頁</a>
                        <img src="images/contact_beadcrumbs.png" alt="">
						<div class="fblike hidden-mobile hidden-tablet">
							<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:65px;" allowTransparency="true"></iframe>
							<div class="fb-share-button" data-href="https://www.facebook.com/pages/1cm/761735067202346" data-width="40" data-type="box_count"></div>
						</div>
					</div>
					<div class="contact_description">
						<form id="form1" name="form1" action="contact_save.php" method="POST">
							<div class="contact_block">
								<div class="contact_blockL">姓名</div>
								<div class="contact_blockR"><input type="text" name="contact_name" id="contact_name" size="50" value="" minlength="1" maxlength="12" class="required"/></div>
							</div>
							<div class="contact_block">
								<div class="contact_blockL">電話</div>
								<div class="contact_blockR"><input type="text" name="contact_tel" id="contact_tel" size="50" value=""  minlength="5" maxlength="20" class="required digits"/></div>
							</div>
							<div class="contact_block">
								<div class="contact_blockL">信箱</div>
								<div class="contact_blockR"><input type="text" name="contact_email" id="contact_email" size="50" value=""  minlength="1" maxlength="50" class="required email"/></div>
							</div>
							<div class="contact_block">
								<div class="contact_blockL">內容</div>
								<div class="contact_blockR"><textarea name="contact_content" id="contact_content" cols="30" rows="10" minlength="1" class="required"></textarea></div>
							</div>
							<div class="contact_submit">
								<a href="#" id="contact_submit" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image4','','images/contact_submitover.png')"><img src="images/contact_submit.png" alt="" name="image4"></a>
							</div>
						</form>
					</div>
					<!-- 內文 End -->

				</div>

				<!-- Sidebar Start -->
				<aside class="content_sectionR hidden-mobile">
					<?php
						if( isset($adv["3"]) ){
					?>
						<div class="content_blockAdv"><?php echo $adv["3"]; ?></div>
					<?php
						}else{ echo ''; }
					?>
					<!--<div class="content_blockAdv recommend_block">
                    <a href="news_detail.php?nid=<?php /*echo $row_news["news_id"];*/?>" class="btn">
						<div class="thumbimg"><img src="<?php /*echo $web_path_news."s".$rows_news["news_banner"];*/?>" alt=""></div>
						<div class="title"><?php /*echo tc_left($rows_news["news_title"],23);*/?></div>
                    </a>
					</div>-->
					<!--<div class="content_blockFB">
						<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; background: #f5f5f5;" allowTransparency="true"></iframe>
					</div>-->
					<div class="content_blockFB">
						<div class="fb-like-box" data-href="https://www.facebook.com/1cmLife" data-width="300px" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true"></div>
					</div>
					<div id="slidebar_adv" class="hidden-mobile">
					</div>
				</aside>
				<!-- Sidebar End -->

				<ul class="advertisement hidden-mobile" <?php if(isset($adv["1"]) || isset($adv["2"])){ echo ''; }else{ echo 'style="display: none;"'; } ?> >
				  <li><?php if(isset($adv["1"])){echo $adv["1"];}?></li>
                  <li><?php if(isset($adv["2"])){echo $adv["2"];}?></li> 
				</ul>
				<div class="fbslide hidden-mobile" id="fbslide">
					<div class="closebtn"></div>
					<p class="title">歡迎加入我們，<br />一同探索簡單有趣的生活品味：）</p>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2F1cm%2F761735067202346&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
				</div>

				<?php
					if(isset($rowsp_adv["adv_link"])&&$rowsp_adv["adv_link"]!=""){
				?>
					<div class="mobile_advertisement visible-mobile">
						<?php echo $rowsp_adv["adv_link"]; ?>
					</div>
				<?php
					}else { echo ''; }
				?>

				<div class="mobile_advertisement visible-mobile">
                    <div class="content_blockAdv mt_15 mb_15">
	                    <a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>" class="btn">
							<div class="thumbimg"><img src="<?php echo $web_path_news."s".$rows_news["news_banner"];?>" alt=""></div>
							<div class="title"><?php echo tc_left($rows_news["news_title"],23);?></div>
	                    </a>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</section>

		<footer id="footer">
			<!--<div class="footer_logo hidden-mobile">
				<a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('flogo','','images/flogoover.png'),'1'"><img src="images/flogo.png" height="32" width="80" alt="" name="flogo"></a>
			</div>
			<ul>
				<li class="footer_backindex"><a href="index.php">返回首頁</a></li>
				<li class="footer_gotop"><a href="javascript: void(0)">回到上方</a></li>
				<li class="hidden-mobile"><a href="about.php">關於我們</a></li>
				<li class="hidden-mobile"><a href="contact.php">聯絡我們</a></li>
			</ul>-->
		</footer>

	</div>
</body>
</html>