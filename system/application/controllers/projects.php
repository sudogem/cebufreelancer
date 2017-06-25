<?php

class Projects extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ; 
		$this->load->config( 'link_pagination' ) ; 
		$this->load->helper( 'time' ) ; 
		$this->load->helper( 'flash' ) ; 
		$this->load->helper( 'sanitizer' ) ; 		
		$this->load->library( 'validation' ) ;
		$this->load->library( 'pagination' ) ;		
		$this->load->model( 'projects_model' ) ; 
		$this->load->model( 'project_categories_model' ) ; 
		$this->load->model( 'users_model' ) ; 
		$this->load->model( 'projects_messages_model' ) ;
		$this->load->model( 'bids_model' ) ;
		$this->projects_per_page['projects_per_page'] = $this->config->item( 'projects_per_page' ) ; 
		if ( $this->site_sentry->is_logged_in( ) )  
		{
			$res = $this->users_model->get_user_by_hash( $this->session->userdata( 'hash_id' ), 'hash_id, id, username', 'result_array' ) ; 
			if ( $res ) 
			{
				$this->logged_userid = $res[0]['id'] ; 
				$this->logged_username = $res[0]['username'] ;  
			}
		}
		$this->assets_images = base_url()  . $this->config->config['layout']['assets_folder'] . '/' . $this->config->config['layout']['views_folder'] . '/' . $this->config->config['layout']['assets_images'] . '/' ; 		
	}
	
	function index( ) 
	{
		$this->browse( ) ; 
	}
	
	function browse( )
	{
		$data = array( ) ; 
		//$where = " projects.project_status = 'open' " ; 
		$where = '';
		$res = $this->projects_model->get_all_projects( NULL, NULL, $where ) ; 
		$cur_offset = ( $this->uri->segment(3)!= '' ) ? (int)$this->uri->segment(3) : 0 ; 
		$config['base_url'] =  site_url( ) . '/projects/browse' ; 
		$config['total_rows'] = count( $res ) ; 
		$config['per_page'] = $this->projects_per_page['projects_per_page'] ; 
		$config['num_links'] = 4 ; 
		$this->pagination->initialize( $config ) ;		
		$tmpcur_offset = (empty($cur_offset)) ? 0 : $config['per_page'];
		$data['links'] = $this->pagination->create_links( ) ; 	
		$limit = array( 'start' => $config['per_page'] , 'end' => ($config['per_page'] * $cur_offset) - $tmpcur_offset) ; 
		$data['all_projects'] = $this->projects_model->get_all_projects( NULL, $limit, $where ) ; 
		$this->layout->buildPage('projects/index' , $data );
	}
	
	function view( )
	{
		$id = (int)$this->uri->segment( 3 ) ;
		$res = $this->projects_model->get_project_by_id( $id ) ;
		if ( $res === FALSE ) {
			show_404( "page" ) ; 
			exit( ) ;
		}
		$this->session->set_userdata( 'return_url', $this->uri->uri_string() ) ;		
		$data['project_details'] = $res ;
		$project_id = $res[0]['project_id'] ; 
		$title = $res[0]['title'] ; 
		$created_by = $this->users_model->get_user_by_id( $res[0]['created_by'] , 'users.id, users.username', 'row' )->username ; 		
		$data['assets_images'] = $this->assets_images ;		
		$data['meta_title'] = $title . "&nbsp;- CebuFreelancer" ;
		$data['sendpm']	= "messages/compose/$project_id/$created_by" ;	
		$data['bidders'] = $this->bids_model->get_project_bids_by_criteria( array( 'projects.project_id' => $id ) ) ; 
		$data['flashb'] = $this->session->flashdata( 'flashb' ) ;	
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;	
		
		$this->layout->buildPage( 'projects/view_project' , $data ) ; 
	}
	
	function bid( )	
	{
		$this->load->view( 'custom_validations/bid_validations' ) ;		
		if ( $this->input->post( 'bid' ) )
		{
			if ( $this->site_sentry->is_logged_in( ) === FALSE ) 
			{
				$this->session->set_userdata( 'action_error', 'You must login first before you can bid the project.' ) ;
				redirect( 'login/' ) ; exit ; 
			}

			$data = array(
				'project_id' => ( int )$this->input->post( 'project_id', TRUE ), 
				'user_id' => ( int ) $this->logged_userid ,
				'message' => $this->input->post( 'message', TRUE ), 
				'datebidded' => time( ),
				'delivery_within' => ( int ) $this->input->post( 'delivery_within', TRUE ),
				'amount' => $this->input->post( 'amount', TRUE ) ,
				'bid_status' => 'waiting for buyer\'s confirmation'	
			) ;
		
			$rs = $this->projects_model->get_project_by_id( $data['project_id'], 'project_status, title' ) ;
			$project_status = $rs[0]['project_status'] ;
			$title = url_title( $rs[0]['title'] ) ;
			// the member cannot place a bid if the project is closed
			if ( strtolower( $project_status ) == 'closed' )
			{
				$this->session->set_flashdata( 'flashb', 'red' ) ;
				$this->session->set_flashdata( 'flash_message', 'You are not allowed to place a bid when the project is closed.' ) ;
			    redirect( "projects/view/" . $data['project_id'] . "/$title" ) ; exit ;
			}
			if ( $this->validation->run( ) === FALSE )
			{
				$this->session->set_flashdata( 'flashb', 'red' ) ;
				$this->session->set_flashdata( 'flash_message', $this->validation->error_string ) ;
				redirect( "projects/view/" . $data['project_id'] . "/$title" ) ; exit ;
			}
			else
			{
				// users can bid many times ??
				$this->config->load( 'email' ) ;
				$this->load->library( 'email' ) ;
				$this->session->set_flashdata( 'flashb', 'green' ) ;
				$this->session->set_flashdata( 'flash_message', 'Successfully place a bid.' ) ;
				$this->bids_model->insert_bid_to_project( $data ) ;
				//  send email
				$rs = $this->users_model->get_user_by_id( $this->logged_userid, 'users.email, users.username' ) ;
				$email = $rs[0]['email'] ;
				$uname = $rs[0]['username'] ; 
				$rs_project = $this->projects_model->get_project_by_id( $data['project_id'], 'title, created_by' ) ;
				$project_title = $rs_project[0]['title'] ;
				$created_by = $this->users_model->get_user_by_id( $rs_project[0]['created_by'], 'users.email', 'row' )->email ;
				$subject1 = "$uname place a bid on your project: $project_title posted in CebuFreelancer." ;
				$u = site_url( "projects/view/" . $data['project_id'] ) ;
				$clickurl = "<a href=$u >$project_title</a>" ;
				$message = $data['message'] ;
				$message = $message . "<br><br>To view the project details, just click this link: $clickurl " ;
				$message = $message . "<br>-<br /><em>CebuFreelancer Team</em><br />";
				$this->email->initialize( array( 'mailtype' => 'html', 'charset' => 'utf-8', 'wordwrap' => TRUE ) );
				$this->email->from( $this->config->item( 'mail_nr_fromemail' ) ) ;
				$this->email->reply_to( $this->config->item( 'mail_nr_fromemail' ) ) ;				
				$this->email->to( $created_by ) ;
				$this->email->subject( $subject1 ) ;
				$this->email->message( $message ) ;
				$this->email->send() ;
				redirect( "projects/view/{$data['project_id']}" ) ;
				exit ;				
			}
		}
	}

	function flag_ads( )
	{
		if ( $this->site_sentry->is_logged_in( ) === FALSE )  
		{		
			$this->session->set_userdata( 'action_error', 'Please login to access the page.' ) ;		
			redirect( 'login/' ) ; 
			exit ; 
		} 	
		$pid = ( int )$this->input->post( 'pid' );
		if (!empty( $pid ))
		{
			$rs = $this->db->get_where( 'project_flags', array( 'project_id' => $pid ) ) ;
			if ( $rs->num_rows() > 0 )
			{
				$rs = $rs->result_array();
				$flag = $rs[0]['flag_count'] ;
				$data = array( 'flag_count' => $flag + 1 );
				$this->db->where( 'project_id', $pid );
				$this->db->update('project_flags', $data);
			}
			else
			{
				$data = array( 'project_id' => (int)$pid, 'flag_by_userid' => (int)$this->logged_userid, 'flag_count' => 1 ); 
				$this->db->insert( 'project_flags', $data ) ;
			}
		}
	}  

	function _check_expired_projects( )
	{
		$where = " projects.isexpired = '0' " ; 
		$res = $this->projects_model->get_all_projects( NULL, NULL, $where ) ; 
		$n = count( $res ) ;
		for( $i=0; $i<$n; $i++ ) 
		{
			$dateposted = $res[$i]['dateposted'] ;
			$numofdays = $res[$i]['numofdays'] ;
			$project_id = $res[$i]['project_id'] ;
			$time_remaining = abs( fnc_date_calc( $dateposted, $numofdays ) ) ;
			if ( $time_remaining <= 0 )
			{
				$data = array( 'isexpired' => '1', 'project_status' => '2' ) ;
				$this->projects_model->update_project( $project_id, $data ) ;
			}
		}
	}
}
