<?php

class Advertising extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;
	}
	
	function index( )
	{
		$this->layout->buildPage('advertising/index') ;
	}
}	
?>