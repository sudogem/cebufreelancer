<?php
class Login extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;
		$this->load->helper( 'flash' ) ; 		
		$this->load->model( 'projects_messages_model' ) ;		
	}
	
	function index( )
	{
		$uri = $this->uri->uri_to_assoc( 1) ;
		$m = $this->session->userdata( 'action_error' ) ; 
		$this->session->unset_userdata( 'action_error' ) ;
		$data['flash_message'] = $m ;
		$this->layout->buildPage( 'login/login' , $data ) ; 
	}
	
	function check( )
	{
		$cmdlogin = $this->input->post( 'login' ) ;
		$rememberme = $this->input->post( 'remember' );
		if ( $cmdlogin != '' )
		{
			$s = $this->site_sentry->checklogin( )  ;
			if ( $s === FALSE ) 
			{
				$data['flash_message'] = "Invalid password/username"  ; 
				$this->layout->buildPage( 'login/login' , $data ) ; 
			}
			else
			{
				if ( !empty($rememberme) ) 	
				{
					$this->session->override_expiration(60 * 60 * 24 * 7 * 2) ;
				}
				
				$r = $this->session->userdata( 'return_url' ) ;
				if ( !empty($r) ) 
				{
					redirect( $r ) ;
					exit ; 
				}

				if ( $this->site_sentry->is_logged_in( ) )  
				{
					$res = $this->users_model->get_user_by_hash( $this->session->userdata( 'hash_id' ), 'hash_id, id, username', 'result_array' ) ; 
					if ( $res ) 
					{
						$this->logged_userid = $res[0]['id'] ; 
						$this->logged_username = $res[0]['username'] ;  
					}
				}				
				redirect("users/$this->logged_username");
			}
		}	
	}
}
