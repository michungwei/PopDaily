<?php
function escapeJsonString($string) { 
    $replacements = array(
        '@[\\\\"]@'        => '',                        
        '@\n@'             => '',                            
        '@\r@'             => '',                            
        '@\t@'             => '',                           
        '@[[:cntrl:]]@e'   => ''                        
    );
    $result = preg_replace(array_keys($replacements), array_values($replacements), $string);
 
    return $result;
}

function isLogin(){
	return (isset($_SESSION["session_acc"]) && trim($_SESSION["session_acc"])!="" && isset($_SESSION["session_name"]) && trim($_SESSION["session_name"])!="" && isset($_SESSION["session_id"]) && trim($_SESSION["session_id"]!=""));
}
/*End PHP*/