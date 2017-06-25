<?php if (!defined('BASEPATH')) exit('No direct script access allowed') ;

function flash_message( $flash_message = '', $borderclass = '', $allowclose = FALSE ) 
{

	if ( isset( $flash_message ) && $flash_message != '' )
	{
		if ( is_array( $flash_message ) )
		{
			$t = "<div id=\"flash\" class=\"flash {$borderclass}\" >" ; 
			if ( $allowclose ) $t .= "<a href=\"javascript:void(0)\" id='closeme' onClick=\"\" style=\"float:right;\" >CLOSE</a>" ;
			foreach( $flash_message as $s ) {
				$t .= $s ;
			}
			$t .= "</div>" ;
		}
		else
		{
			$t = "<div id=\"flash\" class=\"flash {$borderclass}\" >" ;
			if ( $allowclose ) $t .= "<a href=\"javascript:void(0)\" id='closeme' onClick=\"\" style=\"float:right;\" >CLOSE</a>" ;
			$t .= "$flash_message </div>" ; 
		}
		echo $t ;
	}
}
 