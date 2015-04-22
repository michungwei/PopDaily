<?php
include_once("_config.php");
include_once($inc_path."_getpage.php");

/*$nid=get("nid");*/
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



//新聞內容
$sql = "SELECT *
		FROM $table_news n,$table_newstype nt,$table_admin a
		WHERE n.newsType_id=nt.newsType_id AND a.admin_id=n.news_aut_id AND n.$isshow_news=1 AND n.news_id='$nid' AND n.$news_upday<=NOW()";
$row_news = $db -> query_first($sql);


//點擊次數紀錄
//if($row_news!=false&&!isset($SESSION["news$nid"])){
  //$_SESSION["news$nid"] = 1;防止灌水
  $sql_clicknum = "SELECT news_clicknum FROM $table_news WHERE news_id = '$nid'";
  $row_news_clicknum = $db -> query_first($sql_clicknum);



  $thisid=$row_news["news_id"];
  $data["news_clicknum"] = $row_news_clicknum["news_clicknum"]+1;
  $db -> query_update($table_news, $data, "$N_id = $thisid");
//}


//下一筆next
$sql = "SELECT news_id
		FROM $table_news
		WHERE $isshow_news=1 AND $news_upday<=NOW() AND $news_upday<(SELECT $news_upday FROM $table_news WHERE news_id='$nid') AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid')
		ORDER BY $news_upday DESC
		limit 1";
$row_nextnews = $db -> query_first($sql);



//上一筆pre
$sql = "SELECT news_id
		FROM $table_news
		WHERE $isshow_news=1 AND $news_upday<=NOW() AND $news_upday>(SELECT $news_upday FROM $table_news WHERE news_id='$nid') AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid')
		ORDER BY $news_upday ASC
		limit 1";
$row_prenews = $db -> query_first($sql);

//也許你會喜歡
$sql = "SELECT *
		FROM $table_news
	    WHERE $isshow_news=1 AND TO_DAYS(NOW()) - TO_DAYS(news_upday) <= 60 AND  news_upday<=NOW() AND $NT_id=(SELECT $NT_id FROM $table_news WHERE $N_id='$nid') AND $N_id<>'$nid'
	    ORDER BY news_clicknum DESC";
$rows_likenews_num = $db -> fetch_all_array($sql);
getSql($sql, 9, $query_str);
$rows_likenews = $db -> fetch_all_array($sql);

$db -> close();

$likenews_num = floor(sizeof($rows_likenews_num) / 9);

$tempImgStr = substr($row_news["news_content"], strpos($row_news["news_content"], "upload/"), 42 );
$startPos = strpos($tempImgStr, "upload/");
$endPos = strpos($tempImgStr, ".jpg");
if($endPos == null)
{
	$endPos = strpos($tempImgStr, ".png");
}

$url_length = $endPos - $startPos + 4;

//echo "<script>console.log( 'url_length: " . $url_length . "' );</script>";
//$content_first_img_url_test = "http://admin.popdaily.com.tw/".substr($tempImgStr, $startPos, $url_length );
//echo "<script>console.log( 'content_first_img_url_test: " . $content_first_img_url_test . "' );</script>";

if($endPos != null)
{
	$content_first_img_url = "http://admin.popdaily.com.tw/".substr($tempImgStr, $startPos, $url_length );
}
 //echo "<script>console.log( 'Debug Objects: " . $content_first_img_url . "' );</script>";
 //echo "<script>console.log( 'Page: " . $page . "' );</script>";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="copyright" content="<?php echo $copyright; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:title" content="<?php echo $row_news["news_title"];?> - PopDaily 波波黛莉" ></meta>
	<meta property="og:type" content="article" ></meta>
	<meta property="og:description" content="<?php echo strip_tags(trim($row_news["news_content"])); ?>" ></meta>
	<meta property="og:image" content="<?php echo $content_first_img_url; ?>" ></meta>
	<title><?php echo $web_name; ?></title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css?ver=150420">
    <link rel="icon" href="<?php echo $web_icon?>" type="image/png" />
	<link rel="stylesheet" href="scripts/fancybox/jquery.fancybox.css">
	<script src="scripts/jquery-1.9.1.js"></script>
	<script src="scripts/jquery.infinitescroll.min.js"></script>
	<script src="scripts/jquery.timeout.interval.idle.js"></script>
	<script src="scripts/idle.js"></script>
	<script src="scripts/jquery.cookie.js"></script>
	<script src="scripts/all.js"></script>
    <script src="scripts/search.js"></script>
	<script src="scripts/fancybox/jquery.fancybox.js"></script>
    <script>
		function share2FB(){
		 	window.open("http://www.facebook.com/sharer/sharer.php?u=<?php echo $web_url."news_detail.php?nid=".$nid; ?>",'','width=653,height=369');
		}
	</script>
	<script>
		if(jQuery(window).width()>767)
		{
			$(function(){
					var maxPage = <?php echo $likenews_num; ?>;
					if(maxPage <= 1)
					{
						$('#page-nav').hide();
					}
				var count = 1;
					$('.content_sectionL').infinitescroll({
						navSelector 	:	'#page-nav',
						nextSelector	:	'#page-nav a',
						itemSelector	:	'.infi_block',
						animate      	:   true,
						debug 			:   false,
						maxPage			:	<?php echo $likenews_num; ?>,
						path: function(index) {
							return "news_detail.php?nid=<?php echo $nid;?>&page=" + index;
						},

						loading: {
							msgText : 'Loading...',    //加载时的提示语
							finishedMsg: '您已經閱讀完全部了喔！',
							finished: function() {
								var el = document.body;
								$('#infscr-loading').hide();
								$('#page-nav').show();
								count ++;
								if(count >= <?php echo $likenews_num; ?>)
								{
									$('#page-nav').hide();
								}
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
		else
		{
			$(function(){
				var count = 1;
				var maxPage = <?php echo $likenews_num; ?>;
					if(maxPage <= 1)
					{
						$('#page-nav').hide();
					}
					$('.content_section').infinitescroll({
						navSelector 	:	'#page-nav',
						nextSelector	:	'#page-nav a',
						itemSelector	:	'.infi_block_mobile',
						animate      	:   true,
						debug 			:   true,
						maxPage			:	<?php echo $likenews_num; ?>,
						path: function(index) {
							return "news_detail.php?nid=<?php echo $nid;?>&page=" + index;
						},

						loading: {
							msgText : 'Loading...',    //加载时的提示语
							finishedMsg: '您已經閱讀完全部了喔！',
							finished: function() {
								var el = document.body;
								$('#infscr-loading').hide();
								$('#page-nav').show();
								count++;
								if(count >= <?php echo $likenews_num; ?>)
								{
									$('#page-nav').hide();
								}
							}
						}

					});

					$(window).unbind('.infscr');
					$('#page-nav').click(function() {
						console.log("[mobile]page-nav clicked!!!");
						$('.content_section').infinitescroll('retrieve');
						return false;
					});
					$(document).ajaxError(function(e,xhr,opt) {
						if(xhr.status==404)
						  $('#page-nav').remove();
					});
			});
		}
	</script>
	<?php include_once("analytics.php"); ?>
</head>
<body>
	<?php include_once("menu.php"); ?>
	<div id="mask" class="mask"></div>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.3";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
	<div id="wrapper">
		<div id="popupBox" class="hidden-mobile hidden-tablet hidden-desktop">
			<div class="popupBox-close">
				<img src="images/mask_closebtn.png" onclick="hideDiv('popupBox');">
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
		<div class="linebtn visible-mobile">
			<a href="line://msg/text/<?php echo $row_news["news_title"]." - ".$web_name;?>   http://www.popdaily.com.tw/news_detail.php?nid=<?php echo $nid; ?>">
				<img src="images/lineIcon.png">
			</a>
		</div>
		<a href="#" class="gotopbtn"></a>
		<header id="header">
			<div><a class="mobile-menu visible-mobile" href="#menu2"></a></div>
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
		<div class="clear"></div>
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
					<li><a href="http://instagram.com/popdailymag" targes="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('imageinsta','','images/icon_instaover.png')"><img src="images/icon_insta.png" alt="" name="imageinsta"></a></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div class="topLineBar hidden-mobile">
			</div>
			<div class="mobile_advertisement visible-mobile">
				<?php if(isset($adv["7"])){echo $adv["7"];}?>
			</div>
			<div class="subtitle-advtise">
				<div class="subtitle-advtiseL hidden-mobile">
					<?php if(isset($adv["6"])){echo $adv["6"];}?>
				</div>
				<div class="subtitle-advtiseR hidden-mobile">
					<p class="title hidden-tablet">每天多一點新鮮樂趣，就從這裡開始！</p>
					<p class="title visible-tablet">多一點新鮮樂趣，就從這裡開始！</p>
                    <!--
					<iframe class="visible-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;width=300&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:21px;" allowTransparency="true"></iframe>
                    //-->
                    <div class="fb-like visible-tablet" data-href="https://www.facebook.com/PopDaliyMag" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
                    <div class="fb-like top-right-fb-like-button hidden-tablet" data-href="https://www.facebook.com/PopDaliyMag" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false" data-width="300"></div>
<!--
					<iframe class="top-right-fb-like-button fb_iframe_widget hidden-tablet" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;locale=en_US&amp;width=300&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:21px;" allowTransparency="true"></iframe>
//-->
				</div>
			</div>

			<!-- <div class="banner">
				<div class="fblike hidden-mobile hidden-tablet">
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:65px;" allowTransparency="true"></iframe>
					<div class="fb-share-button" data-href="https://www.facebook.com/pages/POP-DAILY/445164788956922" data-width="40" data-type="box_count"></div>
				</div>
			</div> -->
<!--
            	<div class="fblike hidden-mobile hidden-tablet">
					<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;width=40&amp;layout=box_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:65px;" allowTransparency="true"></iframe>
					<div class="fb-share-button" data-href="<?php echo $web_url;?>news_detail.php?nid=<?php echo $nid; ?>" data-width="40" data-type="box_count"></div>
				</div>
//-->
            	<div class="fblike hidden-mobile hidden-tablet">
                    <div class="fb-like" data-href="https://www.facebook.com/PopDaliyMag" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false" data-width="300"></div>
					<div class="fb-share-button" data-href="<?php echo $web_url;?>news_detail.php?nid=<?php echo $nid; ?>" data-width="40" data-type="box_count"></div>
                </div>
			<div class="content_section">
				<div class="content_sectionL content_sectionL_in" id="content_sectionL">

					<!-- 內文 Start -->
					<?php
						if($row_news["news_showType"]==1){
							echo '<img src="'.$web_path_news.'banner'.$row_news["news_banner"].'" alt="">';
						}
					?>
					<div class="content_block border_topNone">
                        <?php
						if(!isset($row_news)||$row_news=="" ){
						?>
                         <div class="delete_block">
						 <p class="icon"><img src="images/deleteimg.png" alt=""></p>
						 <p class="btn_home"><a href="index.php"><img src="images/btn_home.png" alt=""></a></p>
					     </div>
						<?php
						}else{
                        ?>
						<div class="title">
							<!--<div class="titleL">--><h4><?php echo $row_news["news_title"];?></h4><!--</div>-->
							<!-- <div class="titleR"><a href="news.php?ntid=<?php echo $row_news["newsType_id"]; ?>"><?php echo substr($row_news["newsType_Ename"],0,1);?></a></div> -->
						</div>
						<div class="date">
							<span><img src="images/icon_cal.png" height="15" width="16" alt=""></span>
							<span class="date_text">
							  <?php
								   echo date("m.d.y",strtotime($row_news["news_createtime"]));//strtotime轉化為int格式
								   echo "&nbsp;/&nbsp;";
								   echo date("l",strtotime($row_news["news_createtime"]));//strtotime轉化為int格式
								   echo "&nbsp;/&nbsp;";
								   echo $row_news["admin_cname"];
							  ?>
                            </span>
							<span class="fbshare">
								<!--<div class="fb-share-button" data-href="https://www.facebook.com/pages/1cm/761735067202346" data-width="57" data-type="button"></div>-->
                                <!-- <div><a href="http://www.facebook.com/sharer/sharer.php?u=<?php //echo $web_url."news_detail.php?nid=".$nid;?>" target="_blank"><img src="images/icon_share.png"></a></div> -->
								<div class="fb-share-button" data-href="http://www.popdaily.com.tw/news_detail.php?nid=<?php echo $nid; ?>" data-layout="button"></div>
								<div class="fb-like" data-href="<?php echo $web_url;?>news_detail.php?nid=<?php echo $nid; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>

							</span>
						</div>
						<div class="subtitle-advtise mt_10">
							<div class="subtitle-advtise_center">
								<?php if(isset($adv["11"])){echo $adv["11"];}?>
							</div>
						</div>
						<!--<div class="thumbimg"><img src="images/content_img.png" alt=""></div>-->
						<div class="description">
                            <?php
															$row_news["news_content"] = str_replace('src="../../', 'src="', $row_news["news_content"]);
															$row_news["news_content"] = str_replace('src="http://admin.popdaily.com.tw/', 'src="', $row_news["news_content"]);
															$row_news["news_content"] = str_replace('src="http://popadmin.popdaily.com.tw/', 'src="', $row_news["news_content"]);
															$row_news["news_content"] = str_replace('src="http://popdaily.com.tw/', 'src="', $row_news["news_content"]);
															$row_news["news_content"] = str_replace('src="//static.popdaily.com.tw/', 'src="', $row_news["news_content"]);
															$row_news["news_content"] = str_replace('src="http://www.onecentimetre.com/', 'src="http://1cm.life/', $row_news["news_content"]);
															$row_news["news_content"] = str_replace('src="http://www.popdaily.com.tw/../../', 'src="', $row_news["news_content"]);

															if($_SERVER['SERVER_NAME'] == 'www.popdaily.com.tw')
																$row_news["news_content"] = str_replace('popadmin.popdaily.com', 'www.popdaily.com', $row_news["news_content"]);
                            	echo $row_news["news_content"];
                            ?>
						</div>

                        <?php
						}
						?>
					</div>
					<div class="subtitle-advtise">
						<div class="subtitle-advtise_center">
							<?php if(isset($adv["12"])){echo $adv["12"];}?>
						</div>
					</div>
					<div class="clear"></div>
                    <div class="fb_line mt_15">
						<nobr>
							<font color="#4169e1">Facebook</font>
							<div class="fb-like mb_5" data-href="https://www.facebook.com/PopDaliyMag" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
						</nobr>
						歡迎加入我們，女孩間的樂趣只有自己最知道：）
					</div>
                    <div class="fb_block">
	                    <div class="fbshare_btn">
	                    	<!-- <a href="http://www.facebook.com/sharer/sharer.php?u=<?php //echo $web_url."news_detail.php?nid=".$nid;?>" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image3','','images/fbshare_btnover.png')"><img src="images/fbshare_btn.png" alt="" name="image3"></a> -->
	                    	<a onclick="share2FB()" href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image3','','images/fbshare_btnover.png')"><img src="images/fbshare_btn.png" alt="" name="image3"></a>
	                    </div>
						<!--<div class="fbshare_btn"><a href="#"><img src="images/fbshare_btn.png" alt=""></a></div>-->
						<div class="fbjoin_btn">
							<a href="https://www.facebook.com/pages/POP-DAILY/445164788956922" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('image4','','images/fbjoin_btnover.png')"><img src="images/fbjoin_btn.png" alt="" name="image4"></a>
						</div>
					</div>
					<div class="subtitle-advtise" align = "center">
						<div class="subtitle-advtise_center">
							<?php if(isset($adv["7"])){echo $adv["7"];}?>
							<?php if(isset($adv["8"])){echo $adv["8"];}?>
						</div>
					</div>

					<div class="page_btn">
						<div class="prevbtn">
							<?php if($row_prenews["news_id"]!=""){echo '<a href="news_detail.php?nid='.$row_prenews["news_id"].'" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('."'imgPrev'".','."''".','."'images/btn_prevover.png'".')">';}?><img src="images/btn_prev.png" alt="" name="imgPrev"><?php if($row_prenews["news_id"]!=""){echo "</a>";}?>
						</div>
						<div class="nextbtn">
							<?php if($row_nextnews["news_id"]!=""){echo '<a href="news_detail.php?nid='.$row_nextnews["news_id"].'" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('."'imgNext'".','."''".','."'images/btn_nextover.png'".')">';}?><img src="images/btn_next.png" alt="" name="imgNext"><?php if($row_nextnews["news_id"]!=""){echo "</a>";}?>
						</div>
					</div>
					<div class="subtitle-advtise">
						<div class="subtitle-advtise_center">
							<?php if(isset($adv["13"])){echo $adv["13"];}?>
						</div>
					</div>
					<ul class="advertisement_detail hidden-mobile" <?php if(isset($adv["1"]) && isset($adv["2"])){ echo ''; }else{ echo 'style="display: none;"'; } ?> >
						<li><?php if(isset($adv["1"])){echo $adv["1"];}?></li>
						<li><?php if(isset($adv["2"])){echo $adv["2"];}?></li>
					</ul>
					<div class="fb-comments" data-href="<?php echo $web_url;?>news_detail.php?nid=<?php echo $nid;?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
					<div class="like_section hidden-mobile">
	                    <?php
						if($rows_likenews!=false){
						echo '<p style="margin-top: 0px;"><img src="images/like_block_title.png" alt=""></p>';
						}
						?>
						<div class="infi_block">
	                    <?php
						$i=1;
						foreach($rows_likenews as $row_likenews){
						?>
						<div class="like_block <?php if($i==3 || $i==9){echo "border_rightNone";}?> <?php if($i==6){echo "border_rightNone";}?>">
	                        <a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
							<p class="like_blockimg">
	                          <img src="<?php echo $web_path_news,"sl",$row_likenews["news_banner"];?>" alt=""></p>
							</a>
	                        <p class="like_blockdescription"><a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>"><?php echo tc_left($row_likenews["news_title"],20);?></a></p>
						</div>
	                    <?php
	                    if($i % 3 == 0)
								echo "<div class=\"clear\"></div>";
						$i++;
						}
						unset($i);
						?>
						</div>
					<!-- 內文 End -->

	                </div>
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
					<!--<div class="mb_30">
					<script>
					var mediav_ad_pub = 'T5pthc_1035404';
					var mediav_ad_width = '300';
					var mediav_ad_height = '250';
					</script>
					<script type="text/javascript" language="javascript" charset="utf-8" src="http:/
					/static.mediav.com/js/mvf_g2.js"></script>
					</div>-->
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
                        <div class="fb-page" data-href="https://www.facebook.com/PopDaliyMag" data-hide-cover="true" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/PopDaliyMag"><a href="https://www.facebook.com/PopDaliyMag">PopDaily 波波黛莉的異想世界</a></blockquote></div></div>
<!--
						<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPopDaily-%25E6%25B3%25A2%25E6%25B3%25A2%25E9%25BB%259B%25E8%258E%2589%25E7%259A%2584%25E7%2595%25B0%25E6%2583%25B3%25E4%25B8%2596%25E7%2595%258C%2F445164788956922&amp;width&amp;height=427&amp;colorscheme=light&amp;show_faces=false&amp;header=true&amp;stream=true&amp;show_border=true&amp;appId=737197476301628" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:427px;" allowTransparency="true"></iframe>
//-->
						<!--<script>
						var mediav_ad_pub = 'afjPt3_1035406';
						var mediav_ad_width = '300';
						var mediav_ad_height = '250';
						</script>
						<script type="text/javascript" language="javascript" charset="utf-8"  src="http://static.mediav.com/js/mvf_g2.js"></script>
					-->
					</div>
					<div id="slidebar_adv" class="hidden-mobile">
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
					</div>
				</aside>
				<!-- Sidebar End -->

				<!--<div class="gotop">
					<!-- <a href="javascript: void(0)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('gotopbtn','','images/gotopover.png')"><img src="images/gotop.png" name="gotopbtn" alt=""></a>
				</div>-->
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
				<div class="content_test">
				<div class="like_section visible-mobile">
					<?php
					if($rows_likenews!=false){
					echo '<p><img src="images/like_block_title.png" alt=""></p>';
					}
					?>
					<div class="infi_block_mobile">
                    <?php
					$i=1;
					foreach($rows_likenews as $row_likenews){
					?>
					<div class="like_block <?php if($i%2==0){echo "border_rightNone";}?>">
                        <a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>">
						<p class="like_blockimg">
                          <img src="<?php echo $web_path_news,"sl",$row_likenews["news_banner"];?>" alt=""></p>
						</a>
                        <p class="like_blockdescription"><a href="news_detail.php?nid=<?php echo $row_likenews["news_id"];?>"><?php echo $row_likenews["news_title"];?></a></p>
					</div>
                    <?php
                    if($i % 2 == 0)
						echo "<div class=\"clear\"></div>";
					$i++;
					if($page > 1)
					{
						if($i==9){break;}
					}
					else
					{
						if($i==7){break;}
					}
					}
					unset($i);
					?>
					</div>
				</div>
				</div>

				<div class="fbslide hidden-mobile" id="fbslide">
					<div class="closebtn"></div>
					<p class="title">女孩間的樂趣只有自己最知道:）<br />加入popdaily，讓我們每天一起分享<br />更多新鮮事！</p>
                    <!--
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPOP-DAILY%2F445164788956922&amp;width=301&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;" allowTransparency="true"></iframe>
                    //-->
                    <div class="fb-page" data-href="https://www.facebook.com/PopDaliyMag" data-hide-cover="true" data-show-facepile="true" data-show-posts="false" data-width="301" data-height="258"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/PopDaliyMag"><a href="https://www.facebook.com/PopDaliyMag">PopDaily 波波黛莉的異想世界</a></blockquote></div></div>
				</div>
				<?php
					/*if(isset($rowsp_adv["adv_link"])&&$rowsp_adv["adv_link"]!=""){*/
				?>
					<div class="mobile_advertisement visible-mobile">
						<?php if(isset($adv["7"])){echo $adv["7"];}?>
					</div>
				<?php
					/*}else { echo ''; }*/
				?>
				<div class="clear"></div>
			</div>
		</section>
		<div class="clear"></div>
		<footer id="footer">
		<div id="page-nav" align="center">
			<a href="news_detail.php?page=2">載入更多女孩話題</a>
		</div>
		<div class="clear"></div>
		<!--<div>
			<script>
			var mediav_ad_pub = 'eEhCak_1035405';
			var mediav_ad_width = '728';
			var mediav_ad_height = '90';
			</script>
			<script type="text/javascript" language="javascript" charset="utf-8" src="http:/
			/static.mediav.com/js/mvf_g2.js"></script>
		</div>-->

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
				<!-- <div class="footer_icon visible-mobile">
					<a href="#" class="icon01" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('fficon03','','images/footer_icon01over.png')"><img src="images/footer_icon01.png" height="31" width="31" name="fficon03" alt=""></a>
					<a href="#" class="icon02" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('fficon04','','images/footer_icon02over.png')"><img src="images/footer_icon02.png" height="31" width="31" name="fficon04" alt=""></a>
				</div> -->
				<div class="footer_bg"><!--<a class="hidden-mobile" href="contact.php">聯絡我們</a>--><a class="visible-mobile" href="index.php">回到新聞列表</a></div>
			</div>
		</footer>

	</div>
<!-- lazyload -->
    <script type="text/javascript" src="ui/lazyload-master/jquery.lazyload.js"></script>
    <script>
	$(document).ready(function(e) {
		if($(window).width() <= 767)
		{
			$(".description img").lazyload({
				effect : "fadeIn",
				placeholder: "http://1.bp.blogspot.com/-Qt2R-bwAb4M/T8WKoNKBHRI/AAAAAAAACnA/BomA-Whl_Bk/s1600/grey.gif"
			});
		}

		$(".popupBox-close").hide();
		$("#popupBox").hide();
		popupDiv("popupBox");
    });
    </script>
</body>
</html>
