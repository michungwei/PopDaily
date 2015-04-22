<?php
include_once("_config.php");

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
			LIMIT 0,1";

$rowsp_adv = $db -> query_first($sql_adv);

//右方新聞
/*$sql_news = "SELECT * 
		    FROM $table_news
			WHERE $isshow_news=1 AND $isrightshow_news=1 AND $news_upday<=NOW()
			ORDER BY RAND() LIMIT 6";

$rows_news = $db -> fetch_all_array($sql_news);*/

//右方新聞(每周更新)
$sql_rnews = "SELECT * 
		      FROM $table_news
			  WHERE $isshow_news=1 AND TO_DAYS(NOW()) - TO_DAYS(news_upday) <= 7
			  ORDER BY news_clicknum DESC LIMIT 6";
$rows_rnews = $db -> fetch_all_array($sql_rnews);
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
	<link rel="stylesheet" href="css/style.css?ver=150323">
    <link rel="icon" href="<?php echo $web_icon?>" type="image/png" />
	<link rel="stylesheet" href="scripts/fancybox/jquery.fancybox.css">
	<script src="scripts/jquery-1.9.1.js"></script>
	<script src="scripts/jquery.timeout.interval.idle.js"></script>
	<script src="scripts/idle.js"></script>
	<script src="scripts/jquery.cookie.js"></script>
	<script src="scripts/all.js"></script>
    <script src="scripts/search.js"></script>
    <script src="scripts/fancybox/jquery.fancybox.js"></script>
	<?php include_once("analytics.php"); ?>
</head>
<body><!-- oncontextmenu="window.event.returnValue=false;alert('版權所有')"-->
	<div id="mask" class="mask"></div>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div id="wrapper">
		<div id="popupBox" class="hidden-tablet hidden-desktop">
			<div class="popupBox-close">
				<img src="images/mask_closebtn.png" onclick="hideDiv('popupBox');">
			</div>
			<!-- popdaily_mobile_inter_300x250 -->
			<div id='div-gpt-ad-1426590175838-0'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1426590175838-0'); });
			</script>
			</div>
		</div>
		<header id="header">
			<div class="mobile-switch visible-mobile"></div>
			<ul class="mobile-list">
				<?php
					foreach ($rows_newt as $row_newt) {
				?>
					<li>
						<a href="news.php?ntid=<?php echo $row_newt["newsType_id"];?>">
							<?php echo $row_newt["newsType_Cname"]; ?>
						</a>
					</li>
				<?php
					}
				?>
				<!-- <li><a href="news_type.php">彩妝</a></li>
				<li><a href="news_type.php">保養</a></li>
				<li><a href="news_type.php">娛樂</a></li>
				<li><a href="news_type.php">生活</a></li>
				<li><a href="news_type.php">電影</a></li>
				<li><a href="news_type.php">趣味</a></li>
				<li><a href="news_type.php">單元</a></li> -->
				<li class="mobileClose"><img src="images/mobileClose.png" height="31" width="31" alt=""></li>
			</ul>
			<a href="index.php"><img src="images/logo.png" height="75" width="172" alt=""></a>
			<div class="mobile-fb visible-mobile"><a href="https://www.facebook.com/pages/POP-DAILY/445164788956922" target="_blank"><img src="images/icon_fb.png" alt=""></a></div>
			<div class="mobile-insta visible-mobile"><a href="#" target="_blank"><img src="images/icon_insta.png" alt=""></a></div>
		</header>

		<section id="content">
			<!--<div class="subtitle hidden-mobile">
				<a href="news_type.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('subtitle','','images/subtitleover.png')">
					<img src="images/subtitle.png" alt="" name="subtitle">
				</a>
			</div>-->
			<nav class="navigation hidden-mobile">
				<?php
					$i = 0;
					foreach ($rows_newt as $row_newt) {
						$i++;
				?>
					<span <?php echo $i == 8 ? 'class="border_right1"' : ""; ?> >
						<a href="news.php?ntid=<?php echo $row_newt["newsType_id"];?>">
							<?php echo $row_newt["newsType_Cname"]; ?>
						</a>
					</span>
				<?php
					}
					unset($i);
				?>
				<!-- <span><a href="news_type.php">彩妝</a></span>
				<span><a href="news_type.php">保養</a></span>
				<span><a href="news_type.php">娛樂</a></span>
				<span><a href="news_type.php">生活</a></span>
				<span><a href="news_type.php">電影</a></span>
				<span><a href="news_type.php">趣味</a></span>
				<span class="border_right1"><a href="news_type.php">單元</a></span> -->
			</nav>
			<div class="navsidebar hidden-mobile">
				<ul>
					<li class="search">
						<input type="text" id="search" name="search" value="search">
						<p class="btn" id="search_btn" onClick="search()"><img src="images/search_btn.png" alt=""></p>
					</li>
					<li><a href="https://www.facebook.com/pages/POP-DAILY/445164788956922" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagefb','','images/icon_fbover.png')"><img src="images/icon_fb.png" alt="" name="imagefb"></a></li>
					<li><a href="http://instagram.com/popdailymag" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imageinsta','','images/icon_instaover.png')"><img src="images/icon_insta.png" alt="" name="imageinsta"></a></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div class="topLineBar hidden-mobile">
			</div>
			<div class="subtitle-advtise">
				<div class="subtitle-advtiseL">
					<?php if(isset($adv["6"])){echo $adv["6"];}?>
				</div>
				<div class="subtitle-advtiseR hidden-mobile">
					<p class="title hidden-tablet">每天多一點新鮮樂趣，就從這裡開始！</p>
					<p class="title visible-tablet">多一點新鮮樂趣，就從這裡開始！</p>
					<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>

					<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;locale=en_US&amp;width=275&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:275px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>
			<!-- <div class="banner">
				<div class="fblike hidden-mobile hidden-tablet">
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:65px;" allowTransparency="true"></iframe>
					<div class="fb-share-button" data-href="https://www.facebook.com/pages/POP-DAILY/445164788956922" data-width="40" data-type="box_count"></div>
				</div>
				<img src="images/about_banner.png" alt="">
			</div> -->
			<div class="content_section">
				<div class="content_sectionL">
					<div class="fblike hidden-mobile hidden-tablet">
						<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:65px;" allowTransparency="true"></iframe>
						<div class="fb-share-button" data-href="https://www.facebook.com/pages/POP-DAILY/445164788956922" data-width="40" data-type="box_count"></div>
					</div>

					<!-- 內文 Start -->
                    <?php
					  foreach($rows_newt as $row_newt){
					?>
					<div class="news_type_block">
						<a href="news.php?ntid=<?php echo $row_newt["newsType_id"];?>"<?php if($row_newt["newsType_pic_change"]!=""){ ?> onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imageNews<?php echo $row_newt["newsType_id"];?>','','<?php echo $web_path_newstypec,$row_newt["newsType_pic_change"];?>')"<?php };?>>
                        
                        
                        
                        <img src="<?php echo $web_path_newstype,"m",$row_newt["newsType_pic"];?>" alt="" name="imageNews<?php echo $row_newt["newsType_id"];?>"></a>
						<div class="tag"><a href="news.php?ntid=<?php echo $row_newt["newsType_id"];?>"><?php echo $row_newt["newsType_Cname"]; ?></a></div>
					</div>
                    
                    <?php
					  }
					?>

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
                    
                    <?php
					 foreach($rows_news as $row_news){
					?>
					<div class="content_blockAdv recommend_block">
                    <a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>">
						<div class="thumbimg"><img src="<?php echo $web_path_news,"s",$row_news["news_banner"];?>" alt=""></div>
						<div class="title"><?php echo tc_left($row_news["news_title"],23);?></div>
                    </a>
					</div>
                    <?php
                     }
					?>
                    
					<div class="content_blockFB">
						<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPopDaily-%25E6%25B3%25A2%25E6%25B3%25A2%25E9%25BB%259B%25E8%258E%2589%25E7%259A%2584%25E7%2595%25B0%25E6%2583%25B3%25E4%25B8%2596%25E7%2595%258C%2F445164788956922&amp;width&amp;height=427&amp;colorscheme=light&amp;show_faces=false&amp;header=true&amp;stream=true&amp;show_border=true&amp;appId=737197476301628" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:427px;" allowTransparency="true"></iframe>
					</div>
					<?php
						if( isset($adv["4"]) ){
					?>
						<div class="content_blockAdv"><?php if(isset($adv["4"])){echo $adv["4"];}?></div>
					<?php
						}else{ echo ''; }
					?>

					<?php
						if( isset($adv["5"]) ){
					?>
						<div class="content_blockAdv height_adjust"><?php if(isset($adv["5"])){echo $adv["5"];}?></div>
					<?php
						}else{ echo ''; }
					?>
				</aside>
				<!-- Sidebar End -->

				<ul class="advertisement hidden-mobile" <?php if(isset($adv["1"]) || isset($adv["2"])){ echo ''; }else{ echo 'style="display: none;"'; } ?> >
					<li><?php if(isset($adv["1"])){echo $adv["1"];}?></li>
					<li><?php if(isset($adv["2"])){echo $adv["2"];}?></li>
				</ul>
				<div class="gotop">
					<!-- <a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('gotopbtn','','images/gotopover.png')"><img src="images/gotop.png" name="gotopbtn" alt=""></a> -->
				</div>
				<div class="fbslide hidden-mobile" id="fbslide">
					<div class="closebtn"></div>
					<p class="title">女孩間的樂趣只有自己最知道:）<br />加入popdaily，讓我們每天一起分享<br />更多新鮮事！</p>
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
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
					<?php
						foreach($rows_news as $row_news){
					?>
						<div class="content_blockAdv mt_15 mb_15">
	                    <a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>">
							<div class="thumbimg"><img src="<?php echo $web_path_news,"s",$row_news["news_banner"];?>" alt=""></div>
							<div class="title"><?php echo tc_left($row_news["news_title"],23);?></div>
	                    </a>
						</div>
                    <?php
                    	}
                    	$db -> close();
					?>
				</div>
			</div>	
		</section>
		<div class="clear"></div>
		<footer id="footer">
			<div class="footer_section">
				<div class="navi">
					<?php
						$i = 0;
						foreach ($rows_newt as $row_newt) {
							$i++;
					?>
						<span <?php echo $i % 3 == 0 ? 'class="footer_mobile_border"' : ""; ?> >
							<a href="news.php?ntid=<?php echo $row_newt["newsType_id"];?>">
								<?php echo $row_newt["newsType_Cname"]; ?>
							</a>
						</span>
					<?php
						}
						unset($i);
					?>
					<!-- <span><a href="news_type.php">彩妝</a></span>
					<span class="footer_mobile_border"><a href="news_type.php">保養</a></span>
					<span><a href="news_type.php">娛樂</a></span>
					<span><a href="news_type.php">生活</a></span>
					<span class="footer_mobile_border"><a href="news_type.php">電影</a></span>
					<span><a href="news_type.php">趣味</a></span>
					<span><a href="news_type.php">單元</a></span> -->
					<span class="footer_icon border_right1 footer_mobile_border">
						<div>
						<a href="https://www.facebook.com/pages/POP-DAILY/445164788956922" target="_blank" class="icon01" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('fficon01','','images/footer_icon01over.png')"><img src="images/footer_icon01.png" height="31" width="31" name="fficon01" alt=""></a>
						<a href="#" target="_blank" class="icon02" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('fficon02','','images/footer_icon02over.png')"><img src="images/footer_icon02.png" height="31" width="31" name="fficon02" alt=""></a>
						</div>
					</span>
				</div>
				<div class="footer_bg"><a class="hidden-mobile" href="contact.php">聯絡我們</a><a class="visible-mobile" href="index.php">回到新聞列表</a></div>
			</div>
		</footer>

	</div>
    <script>
	$(document).ready(function(e) {
		
		$(".popupBox-close").hide();
		$("#popupBox").hide();
		popupDiv("popupBox");
    });
    </script>
</body>
</html>