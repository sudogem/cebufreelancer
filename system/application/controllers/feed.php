<?php

class Feed extends Controller 
{

    function __construct( ) 
	{
        parent::Controller( );
		$this->load->model( 'projects_model' ); 
		$this->load->config( 'layout' );
		$this->load->helper( 'xml' );
    }

    function index() 
	{
		$where = " projects.project_status = 'open' " ; 
		$rs = $this->projects_model->get_all_projects( NULL, NULL, $where );   
		$data['encoding'] = 'utf-8';
        $data['feed_url'] = 'http://cebufreelancer.com';
		$data['feed_name'] = 'CebuFreelancer';
		$data['feed_description'] = $this->config->item( 'app_description' );
		$data['page_lang'] = 'en' ;
		$data['all_projects'] = $rs ;
		header( 'Content-type: application/xml' ) ;
		$this->load->view( 'feed/rss', $data );
    }

}
?>