<?php

class Tos extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;
	}
	
	function index( )
	{
		$this->layout->buildPage('tos/index');
	}
}	
?>