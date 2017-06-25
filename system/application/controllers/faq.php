<?php

class Faq extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;
	}
	
	function index( )
	{
		$this->layout->buildPage('faq/index');
	}
	
	function getsess()
	{
		$rs = $this->db->get( 'ci_sessions' )->result_array() ;
		for( $i=0; $i< count( $rs ); $i++ )
		{
			echo date( 'M d Y', $rs[$i]['last_activity'] ) . "<br>" ;
		}
	}
}	
?>