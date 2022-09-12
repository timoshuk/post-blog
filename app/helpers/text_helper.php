<?php

function trimStr($str, $len)
{

	if(strlen($str) > $len){
	$string = strip_tags($str);
	$string = substr($string, 0, $len);
	$string = rtrim($string, "!,.-");
	$string = substr($string, 0, strrpos($string, ' '));
	$string .= "… ";
	return $string;
	
}

return $str;

}
