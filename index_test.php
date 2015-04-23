<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

error_reporting(0);

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
			Limit 0,1";

$rowsp_adv = $db -> query_first($sql_adv);
shuffle($rowsp_adv);

//大banner
$sql_banner = "SELECT * 
		       FROM $table_banner_b
			   WHERE $isshow_banner_b=1
			   ORDER BY $ind_banner DESC";
$rows_banner = $db -> fetch_all_array($sql_banner);


//右方新聞
/*$sql_rnews = "SELECT * 
		      FROM $table_news
			  WHERE $isshow_news=1 AND $isrightshow_news=1 AND $news_upday<=NOW()
			  ORDER BY RAND() LIMIT 6";

$rows_rnews = $db -> fetch_all_array($sql_rnews);*/

//右方新聞(每周更新)
$sql_rnews = "SELECT * 
		      FROM $table_news
			  WHERE $isshow_news=1 AND TO_DAYS(NOW()) - TO_DAYS(news_upday) <= 7
			  ORDER BY news_clicknum DESC LIMIT 6";
$rows_rnews = $db -> fetch_all_array($sql_rnews);


//搜尋
$sql_str = "";
if($keyword != ""){
	$sql_str .= "AND (news_title LIKE '%$keyword%' OR news_content LIKE '%$keyword%')";
}

//新聞列表
$sql = "SELECT * 
		FROM $table_news n,$table_newstype nt ,$table_admin a
	    WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.$news_upday<=NOW() AND n.$isshow_news = 1 $sql_str
		ORDER BY $news_upday DESC";

getSql($sql, 10, $query_str);
$rows_news = $db -> fetch_all_array($sql);



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
	<link rel="stylesheet" href="css/style.css?ver=150418">
	<link rel="stylesheet" href="css/bootstrap.css">
    <link rel="icon" href="<?php echo $web_icon?>" type="image/png" />
	<link rel="stylesheet" href="scripts/fancybox/jquery.fancybox.css">
	<script src="scripts/jquery-1.9.1.js"></script>
	<script src="scripts/jquery.timeout.interval.idle.js"></script>
	<script src="scripts/idle.js"></script>
	<script src="scripts/bootstrap.js"></script>
	<script src="scripts/jquery.cookie.js"></script>
	<script src="scripts/all_test.js"></script>
    <script src="scripts/search.js"></script>
	<script src="scripts/fancybox/jquery.fancybox.js"></script>
	<?php include_once("analytics_test.php"); ?>
	<script>
	if(jQuery(window).width()<=767)
		{
			$(function(){
					$('.content_sectionL').infinitescroll({
						navSelector 	:	'#page-nav',
						nextSelector	:	'#page-nav a',
						itemSelector	:	'.content_block',
						animate      	:   true,
						debug 			:   true,
						path: function(index) {
							return "index.php?page=" + index;
						},
			
						loading: {							msgText : 'Loading...',    //加载时的提示语
							finishedMsg: '您已經閱讀完全部了喔！',
							finished: function() {
								var el = document.body; 
								$('#infscr-loading').hide();
								$('#page-nav').show();
								//console.log("count = "+ count);
							}
						}

					});
				
					$(window).unbind('.infscr');
					$('#page-nav').click(function() {
						console.log("[desktop]page-nav clicked!!!");
						$('.content_sectionL').infinitescroll('retrieve');
						return false;
					});
					$(document).ajaxError(function(e,xhr,opt) {
						if(xhr.status==404)
						  $('#page-nav').remove();
					});
			});
		}
	</script>
	<!-- OneAD 宣告與查詢 開始 -->
<script type="text/javascript">
    var ONEAD = {};
        ONEAD.channel =  41; // PopDaily
        ONEAD.volume =  0.2; // range is 0 to 1 (float)
        ONEAD.slot_limit = {width: 1059, height: 440};
        // optional(s)
        ONEAD.slot_limit_multiple = {
            inread: {
                width: 492,
                height: 320
            }
        };
        ONEAD.response_freq = {start:1, step: 3};
        ONEAD.category = "-1";
        ONEAD.response_freq_multiple = {
            instream: "1,4,7,10,13,16,19,22,25,28,31,34,37,40,43,46,49,52,55,58,61,64,67,70,73,76,79,82,85,88,91,94,97",
            'mobile-incover': "1,3,5,7,9,11,13,15,17,19",
            inflip: "2,4,6,8,10,12,14,16,18,20",
        };
    ONEAD.cmd = ONEAD.cmd || [];
</script>
<script type="text/javascript">
    // For OneAD, DON'T MODIFY the following
    if (typeof(ONEAD) !== "undefined"){
        ONEAD.uid = "1000037";
        ONEAD.external_url = "http://demo.onead.com.tw/"; // base_url, post-slash is necessary
        ONEAD.mobile_external_url = "http://demo.onead.com.tw/";
        ONEAD.wrapper = 'ONEAD_player_wrapper';
        ONEAD.wrapper_multiple = {
            instream: "ONEAD_player_wrapper", // equals to inpage
            inread: "ONEAD_inread_wrapper",
            incover: "ONEAD_incover_wrapper"
        };
    }
    if (typeof window.isip_js == "undefined") {
        (function() {
        var src = 'http://ad-specs.guoshipartners.com/static/js/isip.js';
        var js = document.createElement('script');
        js.async = true;
        js.type = 'text/javascript';
        var useSSL = 'https:' == document.location.protocol;
        js.src = src;
        var node = document.getElementsByTagName('script')[0];
        node.parentNode.insertBefore(js, node.nextSibling); // insert after
        })();
    }
</script>
<script type="text/javascript">
    ONEAD_on_get_response = function(param){
    // if there is no pid, param is {}, it's not null
    if (param === null || param.pid === undefined){
        // 沒廣告
        // 如果是 mobile 的話，則放置 DFP 插入碼
    }else{
        var t = setInterval(function(){
            if (ONEAD_is_above(100)){    }
                 }, 1000);
             }
         }
        // 這個函式名稱是固定的，廣告播放完畢會呼叫之
        function changeADState(obj){
            if (obj.newstate == 'COMPLETED' || obj.newstate == 'DELETED' ){
                if (ONEAD.play_mode == 'incover'){
                    // remove the dimming block
                    ONEAD_cleanup(ONEAD.play_mode);
                }else{
                    ONEAD_cleanup();
                }
            }
        }
</script>
<!-- OneAD 宣告與查詢 結束 -->
</head>
<body>
	<?php include_once("menu.php"); ?>
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
		<div id="popupBox" class="hidden-mobile hidden-tablet hidden-desktop">
			<div class="popupBox-close">
				<img src="images/mask_closebtn.png" onclick="hideDiv('popupBox');" height="35" width="60">
			</div>
			<div class="popupBox-Ad" align = "center">
				<!-- popdaily_mobile_inter_300x250 -->
				<div id='div-gpt-ad-1426590175838-0'>
				<script type='text/javascript'>				
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1426590175838-0'); });
				</script>
				</div>
			</div>
		</div>
		<header id="header">
			<!-- <nav class="headerL">
				<span><a href="about.php">ABOUT</a></span>
				<span><a href="news_type.php">NEWS</a></span>
			</nav>
			<div class="headerC">
				<p><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagelogo','','images/logoover.png')"><img src="images/logo.png" alt="" name="imagelogo"></a></p>
			</div>
			<div class="headerR hidden-mobile">
				<div class="search">
					<input type="text" id="search" name="search" value="search">
					<p class="btn" id="search_btn" onClick="search()"><img src="images/search_btn.png" alt=""></p>
				</div>
				<span class="hidden-tablet"><a href="https://www.facebook.com/pages/1cm/761735067202346" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imagefb','','images/icon_fbover.png')"><img src="images/icon_fb.png" alt="" name="imagefb"></a></span>
				<span class="hidden-tablet"><a href="http://instagram.com/1___cm" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imageinsta','','images/icon_instaover.png')"><img src="images/icon_insta.png" alt="" name="imageinsta"></a></span>
			</div> -->
			<a class="mobile-menu visible-mobile" href="#menu2"></a>
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
			<!-- InPage 廣告插入點(開 始) -->
			 <div id="div-onead-ad">
			 <script type="text/javascript">
					if (typeof(ONEAD) !== "undefined"){
						ONEAD.cmd = ONEAD.cmd || [];
						ONEAD.cmd.push(function(){
							ONEAD_slot('div-onead-ad');
						});
					}
			 </script>
			</div>
			<!-- InPage 廣告插入點(結束) -->
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
			<div class="banner mt_10" <?php echo $keyword != "" ? 'style="display: none;"' : ""; ?> >
				<div class="fblike hidden-mobile hidden-tablet">
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:65px;" allowTransparency="true"></iframe>
					<div class="fb-share-button" data-href="https://www.facebook.com/pages/POP-DAILY/445164788956922" data-width="40" data-type="box_count"></div>
				</div>
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  	<ol class="carousel-indicators hidden-mobile">
                        <?php
						   $i=0;
						   foreach($rows_banner as $row_banner){
						?>
					    <li data-target="#carousel-example-generic" <?php if($i==0){echo'class="active"';}?> data-slide-to="<?php echo"$i";$i++;?>"></li>
                        <?php
						   }
						   unset($i);
						?>
				  	</ol>
				  	<div class="carousel-inner">

                    <?php
					 $i=true;
					 foreach($rows_banner as $row_banner){
					?>
					    <div class="item <?php if($i){$i=0;echo "active";}?>"><!--active-->
						    <?php  if($row_banner["banner_b_href"]!=""){echo '<a href="'.$row_banner["banner_b_href"],'"';if($row_banner["banner_hreftarget"]==1){echo 'target="_blank"';} echo '>';}?><img src="<?php echo $web_path_banner_b.$row_banner["banner_b_pic"];?>" alt=""><?php  if($row_banner["banner_b_href"]!=""){echo '</a>';}?>
					    </div>
                    <?php
					 }
					?>
				  	</div>
				  	<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('bnPrev','','images/banner_prevover.png')">
				    	<img src="images/banner_prev.png" alt="" name="bnPrev">
				  	</a>
				  	<a class="right carousel-control" href="#carousel-example-generic" data-slide="next" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('bnNext','','images/banner_nextover.png')">
				    	<img src="images/banner_next.png" alt="" name="bnNext">
				  	</a>
				</div>
			</div>
			<div class="subtitle-advtise">
				<div class="subtitle-advtise_center">
                    <?php if(isset($adv["8"])){echo $adv["8"];}?>
				</div>
			</div>
			<div class="content_section">
				<div class="content_sectionL">

					<!-- 內文 Start -->
                    <?php
					 $i=1;
					 foreach($rows_news as $row_news){ 
					?>
					<div class="content_block">
                    
						<div class="title">
							<div class="titleL"><h3><a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>" class="btn"><?php echo $row_news["news_title"];?></a></h3></div>
							<div class="titleR">
								<!-- <a href="news.php?ntid=<?php echo $row_news["newsType_id"];?>"><?php echo substr($row_news["newsType_Ename"],0,1);?></a> -->
								<div class="scrolltop"></div>
							</div>
						</div>
						<div class="date">
                            <span><img src="images/icon_cal.png" height="15" width="16" alt=""></span>
							<span class="date_text">
								<?php
									echo date("m.d.y",strtotime($row_news["news_createtime"]));//strtotime轉化為int格式	
								?>
								/
								<font class="hidden-mobile">
									<?php
										echo date("l",strtotime($row_news["news_createtime"]));//strtotime轉化為int格式
										echo ' /';
									?>
								</font>
								<?php
									echo $row_news["admin_cname"];
								?> 	
							    <?php 
								   // echo date("m.d.y",strtotime($row_news["news_createtime"]));//strtotime轉化為int格式
								   // echo "&nbsp;/&nbsp;";
								   // echo date("l",strtotime($row_news["news_createtime"]));//strtotime轉化為int格式
								   // echo "&nbsp;/&nbsp;";
								   // echo $row_news["admin_cname"];
								?>
                            </span>
							<span class="fbshare">
                                <div class="fb-share-button" data-href="<?php echo $web_url;?>news_detail.php?nid=<?php echo $row_news["news_id"]; ?>"></div>
							</span>
							<span class="morebtn">
								<a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>" class="btn" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image0<?php echo $row_news["news_id"]; ?>','','images/content_btnover.png')"><img src="images/content_btn.png" name="image0<?php echo $row_news["news_id"]; ?>" alt=""></a>
							</span>
						</div>
						<div class="thumbimg"><a href="news_detail.php?nid=<?php echo $row_news["news_id"];?>" class="btn"><img src="<?php if($row_news["news_banner"]!=""){echo $web_path_news,"m",$row_news["news_banner"];}?>" height="284" alt="" onerror="javascript:this.src='images/nopic.png'"></a></div>
						<div class="description">
							<?php echo tc_left(strip_tags($row_news["news_content"]),85)?>
						</div>
                        <div class="mobileADV visible-mobile mb_15">
							<?php
								if(empty($adv["7"])){
									echo '';
								}else{
									if( isset($adv["7"]) && ($i == 2 || $i == 4 || $i == 10)){
										echo $adv["7"];
									}
								}
							?>
						</div>
					</div>
					<?php
					 $i++;
                     }
					 unset($i);
					?>
					<?php
					if(count($rows_news)=="0"){
					?>
                    <div class="sorry_error">抱歉，我們沒有找到任何相關資訊</div>
                    <?php 
				    }else{
					?>
					<!-- 分頁 Start -->
	                <div class="pagination_outer">
						<div>
							<ul class="pagination">
							    <?php showPage_front(); ?>
							</ul>
						</div>
					</div>
					<!-- 分頁 End -->
                    <?php
					}
					?>
					<!-- 內文 End -->
					<div class="subtitle-advtise_mb0">
						<div class="subtitle-advtise_center">
							<?php if(isset($adv["9"])){echo $adv["9"];}?>
							<?php if(isset($adv["7"])){echo $adv["7"];}?>
						</div>
					</div>
				</div>

				<!-- Sidebar Start -->
				<aside class="content_sectionR hidden-mobile" id="sidebar">
					<?php
						if( isset($adv["3"]) ){
					?>
						<div class="content_blockAdv"><?php echo $adv["3"]; ?></div>
					<?php
						}else{ echo ''; }
					?>
					<?php
						if( isset($adv["10"]) ){
					?>
						<div class="content_blockAdv"><?php echo $adv["10"]; ?></div>
					<?php
						}else{ echo ''; }
					?>

                    <?php
					 foreach($rows_rnews as $row_rnews){
					?>
					<div class="content_blockAdv recommend_block">
                        <a href="news_detail.php?nid=<?php echo $row_rnews["news_id"];?>">
						<div class="thumbimg"><img src="<?php echo $web_path_news,"s",$row_rnews["news_banner"];?>" alt=""></div>
						<div class="title"><?php echo tc_left($row_rnews["news_title"],23);?></div>
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

				<ul class="advertisement hidden-mobile" <?php if(isset($adv["1"]) || isset($adv["2"])){ echo ''; }else{ echo 'style="display: none;"'; } ?> ><!--廣告1.2-->
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
				<!--<div class="mobile_advertisement visible-mobile">
                    <?php
						foreach($rows_rnews as $row_rnews){
					?>
						<div class="content_blockAdv mt_15 mb_15">
	                        <a href="news_detail.php?nid=<?php echo $row_rnews["news_id"];?>">
							<div class="thumbimg"><img src="<?php echo $web_path_news,"s",$row_rnews["news_banner"];?>" alt=""></div>
							<div class="title"><?php echo tc_left($row_rnews["news_title"],23);?></div>
	                        </a>
						</div>
                    <?php
                    	}
					?>
				</div>-->
			</div>
		</section>
		<div class="clear"></div>
		<footer id="footer">
			<div id="page-nav" align="center" class="visible-mobile">
				<a href="news_detail.php?page=2">載入更多女孩話題</a>
			</div>	
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
					<span class="footer_icon border_right1 footer_mobile_border">
						<div>
						<a href="https://www.facebook.com/pages/POP-DAILY/445164788956922" target="_blank" class="icon01" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('fficon01','','images/footer_icon01over.png')"><img src="images/footer_icon01.png" height="31" width="31" name="fficon01" alt=""></a>
						<a href="#" target="_blank" class="icon02" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('fficon02','','images/footer_icon02over.png')"><img src="images/footer_icon02.png" height="31" width="31" name="fficon02" alt=""></a>
						</div>
					</span>
				</div>
				<div class="footer_bg"><!--<a align="center" class="hidden-mobile" href="contact.php">聯絡我們</a>--><a class="visible-mobile" href="index.php">回到新聞列表</a></div>
			</div>
		</footer>

	</div>
<!-- lazyload -->
    <script type="text/javascript" src="ui/lazyload-master/jquery.lazyload.js"></script>
    <script>
	$(document).ready(function(e) {
        /*$(".content_block .thumbimg img").lazyload({
            effect : "fadeIn",
			//placeholder: "http://1.bp.blogspot.com/-Qt2R-bwAb4M/T8WKoNKBHRI/AAAAAAAACnA/BomA-Whl_Bk/s1600/grey.gif"
        });*/
    });
    </script>
</body>
</html>