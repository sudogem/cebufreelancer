<?php

class Privacy extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;
	}
	
	function index( )
	{
		$this->layout->buildPage('privacy/index');
	}
}	
?>