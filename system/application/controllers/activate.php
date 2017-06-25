<?php

class Activate extends Controller 
{
	function __construct( )
	{
		parent::Controller();	
		$this->load->library( 'tokenizer' ) ;
		$this->load->model( 'categories_model' ) ;
		$this->load->model( 'users_model' ) ;
		$this->load->model( 'user_profile_model' ) ;
		$this->load->model( 'user_subscriptions_model' );
		$this->load->model( 'users_temp_model' ) ;
	}

	function index( )
	{
	 	$username = $this->uri->segment( 3 ) ;
	 	$activationcode = $this->uri->segment( 4 ) ;
	 	$rs = $this->users_temp_model->get_users_temp( 'id, username', array( 'username' => $username ), 'row' ) ;
		//print_r( $rs );
		if ( !$rs ) show_404( 'page' ) ;
		else $userid = $rs->id ;
		$res = $this->users_temp_model->getUserForActivation( $userid , $activationcode ) ; 
		//print_r( $res->result( ) );
		// echo 'n=' . $res->num_rows( );
		$user_data = $userprofile_data = array();
		if ( $res->num_rows( ) > 0 ) //if ( $res->num_rows( ) > 0 )
		{
			foreach( $res->result( ) as $row )
			{
				$user_data['username']                   = $row->username ;
				$user_data['password']                   = $row->password ;
				$user_data['email']                      = $row->email ;
				$user_data['user_type']                  = $row->user_type ;
				$user_data['hash_id']                    = $this->tokenizer->generate_hashcode( ) ; 
				$user_data['created_at']                 = $row->created_at ;
				$user_data['is_ban'] 					 = '0' ; 
				$user_data['forgotten_password_code']    =  '' ;
				$userprofile_data['profile']['fullname'] = $row->fullname ; 				
			}
			$this->users_model->insert_user( $user_data ) ;
			$user_id = $this->db->insert_id();
			$this->user_profile_model->save_profile( $user_id, $userprofile_data) ;
			$this->users_temp_model->deleteUserAfterActivation( $userid ) ;
			$this->_set_user_subscriptions( $userid );
			
			redirect( "activate/success/" ) ; 
			exit ;
		}
		else 
		{
			redirect( 'activate/failed' ) ; 
			exit ;
		}
	}
	
	// set the user subscriptions by default.
	function _set_user_subscriptions( $userid )
	{
		$data2 = array( 
			'user_id' => $userid ,
			'project_posting_notification' => 1,
			'newsletter_notification' => 1
		) ;
		$this->user_subscriptions_model->insert_user_subscriptions( $data2 ) ;
	}
				
	function success( ) 
	{
		$this->layout->buildPage( 'activate/success' ) ;
	}
	
	function failed( )
	{
		$this->layout->buildPage( 'activate/failed' ) ;
	}
	
}
