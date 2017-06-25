<?php

class Categories extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ; 
		$this->load->config( 'link_pagination' ) ; 
		$this->load->helper( 'time' ) ; 		
		$this->load->library( 'validation' ) ;
		$this->load->library( 'pagination' ) ;		
		$this->load->model( 'categories_model' ) ; 
		$this->load->model( 'users_model' ) ; 
		$this->load->model( 'projects_messages_model' ) ;
		$this->projects_per_page['projects_per_page'] = $this->config->item( 'projects_per_page' ) ; 

        $rs1 = $this->users_model->get_user_by_hash( $this->session->userdata( 'hash_id' ), 'hash_id, id, username', 'result_array' ) ;
        if ( $rs1 ) {
			$this->logged_userid 	= $rs1[0]['id'] ;
			$this->logged_username 	= $rs1[0]['username'] ; 
		}		
	}
	
	function index( )
	{
		$data = array( ) ; 
		$caturl = $this->uri->segment( 2 ) ; 
		$where = array("p.project_status" => "open"); //" p.project_status = 'open' " ; 
		$rs = $this->categories_model->get_all_project_categories( $caturl, NULL, $where ) ; 
		$cur_offset = ( $this->uri->segment(3)!= '' ) ? (int)$this->uri->segment(3) : 0 ; 
		$config['base_url'] =  site_url( ) . "/categories/$caturl" ; 
		$config['total_rows'] = count( $rs ) ; 
		$config['per_page'] = $this->projects_per_page['projects_per_page'] ; 
		$limit = array( 'start' => $config['per_page'] , 'end' => $cur_offset ) ; 
		$this->pagination->initialize( $config ) ; 
		$data['links'] = $this->pagination->create_links( ) ; 
		$data['all_projects'] = $this->categories_model->get_all_project_categories( $caturl, $limit, $where ) ; 
		$data['category_name'] = $this->categories_model->get_categories_by_criteria( array( 'category_url' => $caturl ), 'category_url, category' )->category ;
		$data['meta_title'] =  $data['category_name'] . "&nbsp;- CebuFreelancer" ;
		$this->layout->buildPage( 'category/index' , $data ) ;	
	}
	
	
}	
?>