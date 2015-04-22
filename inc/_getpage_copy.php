<?php
function getSql($sql, $page_size, $page_querystring){//分頁用
	global $page, $sql, $count, $page_count, $pre, $next, $querystring, $HS, $ID, $PW, $DB, $db; //global全域變數
    $querystring = clearPageStr($page_querystring);//將字串去掉'&page='
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;//若get有page則取其，若無預設1

    $result = $db -> query($sql); 
    $count = $db -> affected_rows;//總筆數

    $page_count = ceil($count/$page_size); //$page_count總頁數=總筆數/希望每頁筆數
		if($page > $page_count){//若[現在]的頁數>總頁數
			$page = $page_count; 
		}
		if($page <= 0){//若[現在]的頁數<=0
			$page = 1;                  
		} 
	$start = ($page-1)*$page_size;  //當頁第一筆為總共第?筆
    $pre = $page-1; //上一頁
    $next = $page+1; //下一頁
    $first = 1;   //第一頁
    $last = $page_count; //最後一頁
    $sql .= " LIMIT $start,$page_size";//從$start開始取出$page_size筆
	 
	return $count;
}

function pagesql(){
	global $sql;
	return $sql;
}

function showPage(){//顯示頁數
	global $page, $page_count, $count, $pre, $next, $querystring;
	if($querystring != ""){
    	$querystring = $querystring."&";
	}echo $page.' / '.$page_count.'&nbsp;&nbsp;共'.$count.'筆資料&nbsp;&nbsp;'; 
	
	if($page != 1){
		echo  '<a href=?'.$querystring.'page=1>首頁</a>&nbsp;&nbsp;
				<a href=?'.$querystring.'page='.$pre.'>上一頁</a>&nbsp;&nbsp;';    
	}
	$viewpage = 5;//預計頁數
	
	if($page_count > $viewpage){//總頁數>預計頁數
		if($page-$viewpage < 0){
			$s = 1;$j = $viewpage;
		}else{
			$s = $page-$viewpage+1;
			$j = $s+5;
			if($j >= $page_count){
				$j = $page_count;
			}
		}
	}else{
		$s = 1;
		$j = $page_count;
	}
	
	for($i = $s;$i <= $j;$i++){
		$num = $i;
		if($page == $num){
			echo $num."&nbsp;";
		}else{
			echo '<a href=?'.$querystring.'page='.$num.'>'.$num.'</a>&nbsp;&nbsp;';
		}
	}

	if($page < $page_count){
		echo '<a href=?'.$querystring.'page='.($page+1).'>下一頁</a>&nbsp;&nbsp;';
		echo '<a href=?'.$querystring.'page='.$page_count.'>末頁</a>&nbsp;';
	}
}


function showPage_front(){//前端用顯示頁數
	


/*/////////////////
	<div>
		<ul class="pagination">
			<li><a href="#"><img src="images/page_prev.png" height="18" width="31" alt=""></a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">6</a></li>
			<li><a href="#">7</a></li>
			<li><a href="#">8</a></li>
			<li><a href="#">9</a></li>
			<li><a href="#"><img src="images/page_next.png" height="18" width="31" alt=""></a></li>
		</ul>
	</div>
/////////////////*/
    global $page, $page_count, $count, $pre, $next, $querystring;
	if($querystring != ""){
    	$querystring = $querystring."&";
	}
	
	if($page != 1){
		echo  '<li><a href=?'.$querystring.'page='.$pre.'><img src="images/page_prev.png" height="18" width="31" alt=""></a></li>&nbsp;&nbsp;';    
	}
	$viewpage = 9;
	
	if($page_count > $viewpage){
		if($page-$viewpage < 0){
			$s = 1;$j = $viewpage;
		}else{
			$s = $page-$viewpage+1;
			$j = $s+5;
			if($j >= $page_count){
				$j = $page_count;
			}
		}
	}else{
		$s = 1;
		$j = $page_count;
	}
	
	for($i = $s;$i <= $j;$i++){
		$num = $i;
		if($page == $num){
			echo "<li>".$num."&nbsp;"."</li>";
		}else{
			echo "<li>".'<a href=?'.$querystring.'page='.$num.'>'.$num.'</a></li>&nbsp;&nbsp;';
		}
	}

	if($page < $page_count){
		echo '<li><a href=?'.$querystring.'page='.($page+1).'><img src="images/page_next.png" height="18" width="31" alt=""></a></li>&nbsp;&nbsp;';
	}
}



//套外部CSS 
/*function showPage2(){
	global $page, $page_count, $count, $pre, $next, $querystring;

	if($querystring != ""){
		$querystring = $querystring."&";
	}

	if($page != 1){
		echo '<div id="preButton" class="pageButton"><a href=?'.$querystring.'page=1>←</a>&nbsp;&nbsp;<a href=?'.$querystring.'page='.$pre.'>Pre</a></div>'; 
	}else{
		echo '<div id="preButton" class="pageButton">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>';
	}
	$viewpage = 5;
	
	if($page_count > $viewpage){
		if($page-$viewpage<0){
	  		$s = 1; $j = $viewpage;
		}else{
			$s = $page-$viewpage+1;
	 		$j = $s+5;
	 		if($j >= $page_count){
	 			$j = $page_count;
	 		}
		}
	}else{
		$s = 1;
		$j = $page_count;
	}
	for($i = $s; $i <= $j; $i++){
		$num = $i;
		if($page == $num){
			echo '<div id="numberButton" class="pageButton">'.$num.'</div>';
		}else{
			echo '<div id="numberButton" class="pageButton"><a href=?'.$querystring.'page='.$num.'>'.$num.'</a></div>';
		}
	}

	if($page < $page_count){
		echo '<div id="nextButton" class="pageButton"><a href=?'.$querystring.'page='.($page+1).'>Next</a>&nbsp;&nbsp;<a href=?'.$querystring.'page='.$page_count.'> → </a></div>  ';
	}
}*/
 
function clearPageStr($querystring){//傳回去除'&page='的字串
	$pageind = strpos($querystring, '&page=');//strpos(a,b)搜尋b在a第一次出現的位置，未出現回傳false
	if($pageind !== false){//若有&page=
		$pageind2 = strpos(substr($querystring, $pageind+6), '&');//取得'&page='後的字串，並取得&字位置
		$querystring_ = substr($querystring, 0, $pageind);//取得&page前字串
		if($pageind2 !== false){//若'&page='有&
			$querystring_ .= substr($querystring, $pageind+6+$pageind2);//將'&page='前後字串結合
		}
	}else{//若無&page=
    $querystring_ = $querystring;
	}
	return $querystring_;
}
/*End PHP*/

