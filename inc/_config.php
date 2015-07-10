<?php
/*Initial*/
ini_set('display_errors', 1);   # 0不顯示 1顯示 //錯誤是否顯示
error_reporting(E_ALL);         # report all errors
date_default_timezone_set("Asia/Taipei");//定義時區
mb_internal_encoding("UTF-8");//定義編碼
ini_set('magic_quotes_runtime', 0);//自動加上跳脫字元
ob_start();
session_start();//開session
header("Content-type:text/html; charset=utf-8");

$web_name = "PopDaily 波波黛莉的異想世界";//網站名稱
$web_url = "http://www.popdaily.com.tw/";//網址
$description = "PopDaily – 波波黛莉的異想世界";//網站描述-------------------------
$keywords = "流行,彩妝,保養,娛樂,生活,電影,趣味,單元";//關鍵字設定---------------------------------
//$author = "CODER 誠智數位";//作者
$copyright = "POPDAILY © 2014";//版權
$manage_name = "POPDAILY－網站管理系統";
$web_icon = "images/pop_icon.png";//網頁icon
$admin_icon = "../images/pop_icon.png";//網頁icon


/*Database資料庫設定*/

 $HS = "127.0.0.1";
 $ID = "homestead";
 $PW = "secret";
 $DB = "popdaily";



/*SMTP Server E-mail設定*/
$smtp_auth = false;
$smtp_host = "127.0.0.1";
$smtp_port = 25;
$smtp_id   = "";
$smtp_pw   = "";

/*Table 資料庫表格名稱*/
$table_admin    = "pop_admin";
$table_banner_b = "pop_banner_b";
$table_contact  = "pop_contact";
$table_news     = "pop_news";
$table_newstype = "pop_newstype";
$table_adv      = "pop_adv";

/*Upload path 存圖路徑*/
//banner_b
$web_path_banner_b = "upload/banner_b/";
$admin_path_banner = "../../upload/banner_b/";

//news
$web_path_news = "upload/news/";
$admin_path_news = "../../upload/news/";

//newstype
$web_path_newstype = "upload/newstype/";
$admin_path_newstype = "../../upload/newstype/";

//newscontent
$web_path_newscontent ="upload/newscontent/";
$admin_path_newscontent = "../../upload/newscontent/";

//newstype_c
$web_path_newstypec = "upload/newstypec/";
$admin_path_newstypec = "../../upload/newstypec/";

/*Image setup 圖片規格*/
//banner
$banner_pic_w = 1060;
$banner_pic_h = 437;


//newstype 列表圖
// $newstype_mpic_w = 346;
// $newstype_mpic_h = 471;
$newstype_mpic_w = 346;
$newstype_mpic_h = 510;
//newstype banner大圖
$newstype_bpic_w = 346;
$newstype_bpic_h = 538;


//news banner代表圖
$news_bannerpic_w = 1060;
$news_bannerpic_h = 600;
//news 列表圖
$news_mpic_w = 730;
$news_mpic_h = 285;
//news 右邊小圖
$news_spic_w = 300;
$news_spic_h = 170;
//news 下方同類推薦小圖
$news_slpic_w = 220;
$news_slpic_h = 220;
//news 大量上圖
$news_mostpic_w = 600;
$news_mostpic_h = 300;


/*資料用ARY*/
$ary_yn = array('否', '是');
$ary_stop_yn = array('是', '否');
$ary_page = array('不限', '首頁', '概念', '最新消息');//放置各網頁名稱
$ary_pro_status=array('未處理','已處理');
$aryAdminAuth=array('1'=>'全部','2'=>'新聞列表');
$ary_adv_type = array('1'=>'下方(左)','2'=>'下方(右)','3'=>'右側(上方)','4'=>'右側(下方1)','5'=>'右側(下方2)','6'=>'上方橫幅','7'=>'手機(320*50)','8'=>'上方橫幅(banner下)','9'=>'橫幅(翻頁上)','10'=>'首頁右上(320*50)','11'=>'橫幅(標題下)','12'=>'橫幅(內文下)','13'=>'手機置中神物(320*50)');

/*Email*/
/*$sys_email = "bill@coder.com.tw";
$sys_name = "客服中心";*/

require_once($inc_path."_func.php");
require_once($inc_path."_database.class.php");

/*End PHP*/

