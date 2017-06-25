<?php

class Buyers extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;
		$this->load->model( 'projects_messages_model' ) ;
	}
	
	function index( )
	{
		$this->layout->buildPage('employers/index');
	}
	
	function browse( )
	{
		$this->layout->buildPage('employers/index');
	}
}
?>