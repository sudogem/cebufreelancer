<?php

class Logout extends Controller
{
	function Logout( )
	{
		parent::Controller( );
		$this->load->library( 'site_sentry' ) ;
	}
	
	function index( )
	{
		$this->site_sentry->logout( ) ;
		redirect( index_page( ) ) ; 
	}
	
}
?>