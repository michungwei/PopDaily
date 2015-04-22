<?php

function sendMail($fr_em, $fr_na, $to_em, $to_na, $subject, $msg){

	if($to_em != '' && IsEmail($to_em)){

		$recipient = $to_em;

		$subject = "=?UTF-8?B?".base64_encode($subject)."?=\n";

		$mail_headers  = "MIME-Version: 1.0\n";

		$mail_headers .= "Content-type: text/html; charset=utf-8\n"; 

		$from_name = "=?UTF-8?B?".base64_encode($fr_na)."?=";

		$mail_headers .= "From: ".$from_name."<".$fr_em.">\n";

		

		mail($recipient, $subject, $msg, $mail_headers) or die ("無法送出mail!");

	}else{

		echo "Email錯誤";

	}

}



function isValidEmail($address){

	// check an email address is possibly valid

	return preg_match('/^[a-z0-9.+_-]+@([a-z0-9-]+.)+[a-z]+$/i', $address);

}



function IsEmail($email){

	//if(eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$", $email)){
	if (preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$/i", $email)){
		return true;

	}else{

		return false;

	}

}

/*End PHP*/