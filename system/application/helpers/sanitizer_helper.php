<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function h( $str )
{
	return htmlspecialchars( $str, ENT_QUOTES, 'UTF-8' ) ;
}

function issetvar($var, $ret = false) 
{
	if (isset($var) && !empty($var)) {
		return $var;
	} else {
		return $ret;
	}
	
}

function printr($post=0)
{
	$post = $post ? $post : $_POST;
	print '<pre style="display:none">xDATA=';
	print_r($post);
	print '</pre>';	
}
