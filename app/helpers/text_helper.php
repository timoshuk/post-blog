<?php

function trimStr($str)
{
	$string = strip_tags($str);
	$string = substr($string, 0, 300);
	$string = rtrim($string, "!,.-");
	$string = substr($string, 0, strrpos($string, ' '));
	$string .= "… ";

	return $string;
}
