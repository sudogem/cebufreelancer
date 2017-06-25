<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Tokenizer
{
	function Tokenizer( )
	{
		// do nut ing bay
	}
	
	function &getInstance ( ) 
	{
		static $instance;
		if ( !isset( $instance ) ) {
			$instance = new Tokenizer();
		}
		return $instance;
	}
	
	// generate hash value( 2% possible for hashcollision ? )
	function generate_hashcode(  )
	{
		return uniqid( md5( time( ) ) , false ) ;
	}
	
	function randuniqid() {
		return uniqid("", true) . '_' . md5(mt_rand()); 
	}	
}
