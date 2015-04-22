<?php
//圖片檔案上傳相關處理模組v2.0
//版本2006/6/19
//editor by cully
//update 2010/04/09 增加縮圖$key 7 8 9 根據長寬 bycully
//增加縮圖名稱參數 file_sname;
//增加getSize();
class imgUploder{
	var $file_max;
	var $file_dir;
	var $user_msg;
	var $log_msg;
	var $overwrite;	
	var $fstyle;
	var $oldimg;
	var $fileex;
	var $smallimg;
	
	function imgUploder($Ufile){
		$this -> file = $Ufile['tmp_name'];//tmp_name上傳檔案後的暫存資料夾位置
		$this -> file_name = hc($Ufile['name']);//上傳檔案的原始名稱
		$this -> file_sname = "";
		$this -> file_size = $Ufile['size'];//上傳的檔案原始大小
		$this -> file_type = $Ufile['type'];//上傳的檔案類型
		if($this -> file_name != ""){	
			$r = explode('.', $this->file_name);
			$this -> fileex = $r[1];//取得上傳檔案的副檔名	
		}
	}

	function set($name, $value){
		$this -> $name = $value;
	}
	
	function get($name){
		return $this -> $name;
	}
	
	function getSize(){
		return getimagesize($this -> file_dir.$this -> file_name);//getimagesize取得圖像的大小
	}
	
	function chk_FileSize(){
		if($this -> file_max < $this -> file_size){
			$this -> user_msg = $this -> user_msg."上傳的檔案大小超過限制,圖片未成功儲存<br>";
		}
	}

	function chk_FileDir(){
		if(!is_dir($this -> file_dir)){/*is_dir(a)檢查a是否存在並為資料夾*/
			if(!mkdir($this -> file_dir, 0777)){/*mkdir(a)創建資料夾a，成功回傳ture*/
				$this -> user_msg = $this -> user_msg."建立使用者目錄錯誤-->".$this->file_dir."<br>";
			}
		}
	}
	
	function chk_Style(){//檢查上傳檔案的種類
		$r = strtolower($this -> fileex);
		if($this -> fstyle == "image"){
			if($r != "jpg" && $r != "jpeg" && $r != "png" && $r != "gif"){
				$this -> user_msg = $this -> user_msg."此檔案不是圖片格式->".$r."<br>";	
			}
		}
		if($this -> fstyle == "flash"){
			if($this -> file_type != "application/x-shockwave-flash"){
				$this -> user_msg = $this -> user_msg."此檔案不是flash格式<br>";	
			}
		}	
		
		$r = explode("\.", "$this->file_name");
		if($this -> fstyle == "rar"){
			if($r[1] != "rar" && $r[1] != "zip"){
				print_r ($r);
				$this -> user_msg = $this -> user_msg."此檔案不是壓縮檔<br>";	
			}
		}	
		if($this -> fstyle == "customer"){
			if($this -> fileex != "rar" && $this -> fileex != "zip" && $this -> fileex != "jpg" && $this -> fileex != "jpeg" && $this -> fileex != "doc" && $this -> fileex != "docx" && $this -> fileex != "xls" && $this -> fileex != "xlsx" && $this -> fileex != "pdf"){
				$this -> user_msg = $this -> user_msg."檔案只支援rar,zip,jpg,pdf,doc,docx,xls,xlsx等格式<br>";	
			}
		}			
		if($this -> fstyle == "css"){
			if($r[1] != "css" && $r[1] != "CSS"){
				$this -> user_msg = $this -> user_msg."此檔案不是css檔案<br>";	
			}
		}			
	}
		
	function chk_File(){
		if(file_exists($this -> file_dir.$this -> file_name)){/*file_exists() 檢查檔案是否存在*/
			if($this -> overwrite == "1"){//1警告存在
				$this -> user_msg = $this -> user_msg."檔案名稱重覆<br>";
			}
			if($this -> overwrite == "0"){//0改名寫入
				$this -> file_name = "2".$this -> file_name;
			}
			if($this -> overwrite == "3"){//3直接覆蓋
				$this -> file_name = $this -> file_name;
			}			
		}	
	}
	
	function chk_Copy(){
		if(!move_uploaded_file($this -> file, $this -> file_dir.$this -> file_name)){//move_uploaded_file移動檔案至指定資料夾
			//echo $this->file.'='.$this->file_dir.$this->file_name;
			$this -> user_msg = $this -> user_msg."檔案移動失敗!<br>";
		}
	}			

	function fromSource(){
		if(strtolower($this -> fileex) == "gif"){
			$source = imagecreatefromgif($this -> file_dir.$this -> file_name);
		}else if(strtolower($this -> fileex) == "png"){
			$source = imagecreatefrompng($this -> file_dir.$this -> file_name);
		}else{
			$source = imagecreatefromjpeg($this -> file_dir.$this -> file_name);
		}	
		return $source;
	}

	function createImg($target){
		if(strtolower($this -> fileex) == "gif"){
			if (!imagegif($target, $this -> file_dir.$this -> file_sname.$this -> file_name, 9)){
				$this -> user_msg = $this -> user_msg."縮圖建立失敗!<br>";
			}		
		}else if(strtolower($this -> fileex) == "png"){
			if(!imagepng($target, $this -> file_dir.$this -> file_sname.$this -> file_name, 9)){
				$this -> user_msg = $this -> user_msg."縮圖建立失敗!<br>";
			}		
		}else{
			if(!imagejpeg($target, $this -> file_dir.$this -> file_sname.$this -> file_name, 100)){
				$this -> user_msg = $this -> user_msg."縮圖建立失敗!<br>";
			}		
		}	
	}
	
//================================================================建立小圖function	
	function createSmailImg($w, $h, $key){
		$size = getimagesize($this -> file_dir.$this -> file_name);
		
		if($size[0] < $w && $size[1] < $h){ //小於圖片就不縮圖,直接置中
			$x = ($w-$size[0])/2;
			$y = ($h-$size[1])/2;
			$source = $this -> fromSource();
			$target = imagecreatetruecolor($w, $h);
			$background_color = ImageColorAllocate($target, 255, 255, 255);
			imagefill($target, 0, 0, $background_color);				
			imagecopyresampled($target, $source, $x, $y, 0, 0, $size[0], $size[1], $size[0], $size[1]);			
		}else if($key > 6){ 

			if($size[0] < $w && $size[1] < $h){ //如果寬高都比指定大小小..則不縮圖
				$w2 = $size[0];
				$h2 = $size[1];
				$w = $size[0];
				$h = $size[1];
			}else if($key == 7){//依寬度等比縮小
				$x = 0;
				$y = 0;
				if($size[0] < $w){
					$w2 = $size[0];
					$h2 = $size[1];
				}else{
					$w2 = $w;
					$h2 = ($w/$size[0]) * $size[1];
				}
			}else if($key == 8){  // 依高度等比縮小
				$x = 0;
				$y = 0;
				if($size[1] < $h){
					$w2 = $size[0];
					$h2 = $size[1];
				}else{
					$h2 = $h;
					$w2 = ($h/$size[1]) * $size[0];
				}	
			}else if($key == 9){ //如果高>寬則依高等比例縮小,反之
				$x = 0;
				$y = 0;
				if($size[0]/$w > $size[1]/$h){ //如果寬比例>高比例,依寬度等比縮小
					if($size[0] < $w){
						$w2 = $size[0];
						$h2 = $size[1];
					}else{
						$w2 = $w;
						$h2 = ($w/$size[0]) * $size[1];
					}
				}else{
					if($size[1] < $h){
						$w2 = $size[0];
						$h2 = $size[1];
					}else{
						$h2 = $h;
						$w2 = ($h/$size[1]) * $size[0];
						
					}	
				}
			}
			$source = $this -> fromSource();
			$target = imagecreatetruecolor($w2, $h2);
			$background_color = ImageColorAllocate($target, 255, 255, 255);
			imagefill($target, 0, 0, $background_color);	
			imagecopyresampled($target, $source, 0, 0, $x, $y, $w2, $h2, $size[0], $size[1]);	
		}else{ //其它有指定大小(固定寬高)
			$source = $this -> fromSource();
			$target = imagecreatetruecolor($w, $h);
			$background_color = ImageColorAllocate($target, 255, 255, 255);
			imagefill($target, 0, 0, $background_color);			
			if($key == 1){ //取中間1/3
				$w2 = floor($size[0])/floor(3);
				$h2 = floor($size[1])/floor(3);				
				imagecopyresampled($target, $source, 0, 0, $w2, $h2, $w, $h, $w2, $h2);
			}if($key == 0){ //原圖縮小
				imagecopyresampled($target, $source, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
			}
			if($key == 2){ // 從4分之1 x,y 讀取1/2 
				$w2 = floor($size[0])/floor(4);
				$h2 = floor($size[1])/floor(4);				
				imagecopyresampled($target, $source, 0, 0, $w2, $h2, $w, $h, $w2*2, $h2*2);
			}
			if($key == 3){ // 從1/9處讀取指定大小
				$w2 = floor($size[0]/9);
				$h2 = floor($size[1]/9);				
				imagecopyresampled($target, $source, 0, 0, $w2, $h2, $w, $h, $w*1.5, $h*1.5);
			}
			if($key == 5){ // 同比例縮小至寬高限制內,不足補空白
				$tempw = floor($size[0])/floor($w);
				$temph = floor($size[1])/floor($h);
				$x = 0;
				$y = 0;
				if($tempw > $temph){
					$w2 = $w;
					$h2 = floor($size[1]/$tempw);
					$y = (($size[1]/$temph)-$h2)/2;
				}
				if($tempw < $temph){
					$w2 = floor($size[0]/$temph);
					$h2 = $h;
					$x = (($size[0]/$tempw)-$w2)/2;
				}
				if($tempw == $temph){
					$w2 = $w;
					$h2 = $h;
				}								
				imagecopyresampled($target, $source, $x, $y, 0, 0, $w2, $h2, $size[0], $size[1]);
			}
			if($key == 6){ // 同比例縮小至寬高限制內,不足裁掉
				$tempw = floor($size[0])/floor($w);
				$temph = floor($size[1])/floor($h);
				$x = 0;
				$y = 0;
				if($tempw > $temph){
					$w2 = $w*$temph;
					$h2 = $size[1];
					$x = ($size[0]-$w2)/2;
				}
				if($tempw < $temph){
					$w2 = $size[0];
					$h2 = $h*$tempw;
					$y = ($size[1]-$h2)/2;
				}
				if($tempw == $temph){
					$w2 = $size[0];
					$h2 = $size[1];
				}
				imagecopyresampled($target, $source, 0, 0, $x, $y, $w, $h, $w2, $h2);
			}	
		}
		$this -> createImg($target);
		imagedestroy($source);
		imagedestroy($target);		
	}
	
//================================================================上傳檔案			
	function upload(){
		$this -> chk_FileSize();/*檢查圖片大小是否超過*/
		$this -> chk_Style();/*檢查檔案種類*/		
		$this -> chk_FileDir();/*檢查目標目錄是否存在*/		
		$this -> chk_File();/*檢查檔案名稱是否重複*/
		
		if($this -> user_msg == ""){/*若無user_msg錯誤訊息*/
			$this -> chk_Copy();/*將暫存檔移入指定資料夾*/	
		}	
		
		if($this -> user_msg != ""){
		    echo $this->user_msg;
			$this -> file_name = "";
			return false;
		}else{
			if($this -> oldimg != ""){
				@unlink($this -> file_dir.$this -> oldimg);/*若有舊圖則刪除舊圖(須給oldimg名稱)*/
			}
			if($this -> smallimg == "1"){//刪除[sm.檔名]的小圖
				@unlink($this -> file_dir."sm".$this -> oldimg);
			}			
			return true;
		}
	}
}

function removeDir($path){
	if(is_dir($path)){
		$dir = opendir($path);
		while($file = readdir($dir)){
			if($file != "." && $file != ".."){
				unlink($path."/".$file);
			}
		}
		closedir($dir);
		if(rmdir($path)){
			return true;
		}else{
			return false;
		}
	}
}
function copyDir($rpath, $tpath){
	$temp="";
	if (is_dir($rpath)){
		$dir = opendir($rpath);
		while($file=readdir($dir)){
			if($file != "." && $file != ".." && !is_dir($rpath.'/'.$file)){ //如果不是目錄的話就copy
				if(!copy($rpath.'/'.$file, $tpath.'/'.$file)){
					echo '移動檔案'.$rpath.'/'.$file.'失敗<br>';
					$temp = "error";
				}
			}
		}
		return $temp;
	}else{
		echo "目錄".$rpath."不存在<br>";
	}
}
/*End PHP*/