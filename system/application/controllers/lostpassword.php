<?php

class Lostpassword extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;	
		$this->load->config( 'email' ) ;		
		$this->load->helper( 'string' ) ;
		$this->load->helper( 'flash' ) ;
		$this->load->library( 'validation' ) ;
		$this->load->library( 'email' ) ;
		$this->load->model( 'users_model' ) ;
		$this->load->model( 'projects_messages_model' ) ;		
	}
	
	function index( )
	{
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;

		if ( $this->input->post( 'resetpw' ) )
		{
			$rules['email'] = 'required|valid_email' ;
			$this->validation->set_rules( $rules ) ;
			if ( $this->validation->run( ) === FALSE )
			{
				$this->session->set_flashdata( 'flash_message', $this->validation->error_string ) ;
				redirect( 'lostpassword/index' ) ; exit ;
			}
			else
			{
				$email = $this->input->post( 'email' ) ;
				$subject = $this->config->item( 'mail_lostpass_subject' )  ; 
				$forgotten_passcode = random_string( 'unique' ) ;
				$reset_passurl = site_url( "lostpassword/resetpassword/$forgotten_passcode" ) ;
				$rs = $this->users_model->get_user_by_where( array( 'email' => $email ) , 'email, id, username', 'result_array' ) ;
				if ( !$rs )
				{
					$this->session->set_flashdata( 'flash_message', 'The email address youve entered does not exists.' ) ;
					redirect( 'lostpassword/index' ) ; exit ;
				}
				$id = $rs[0]['id'] ;
				$data['username'] = $rs[0]['username'] ;
				$this->users_model->update_user( $id, array( "forgotten_password_code" => $forgotten_passcode ) ) ;
				$message = "Hey {$data['username']},<br />
				You asked to reset your CebuFreelancer account password.  Please click on the link below or copy and paste it into your browser's address bar. <br />
				$reset_passurl 
				<br />
				Your password will be automatically reset, and a new password will be emailed to you. <br />
				You can then login and change it to something you'll remember. <br />
				NOTE: If you do not wish to reset your password, ignore this message. <br />It will expire in the next 24 hours.
				<br />
				-Regards,<br />
				<em>CebuFreelancer Team</em>" ;
				$this->email->initialize( array( 'mailtype' => 'html', 'useragent' => 'XHTMaiL', 'charset' => 'utf-8' ) ) ;				
				$this->email->subject( $subject );
				$this->email->from( $this->config->item( 'mail_nr_fromemail' ) ) ;
				$this->email->reply_to( $this->config->item( 'mail_nr_fromemail' ) ) ;
				$this->email->to( $this->input->post( 'email' ) ) ;
				$this->email->message( $message ) ;
				$this->email->send( ) ;
				$this->layout->buildPage( 'lostpass/sendmsg' , $data ) ; 
			}
		}
		else
		{
			$this->layout->buildPage( 'lostpass/lostpassword', $data ) ; 
		}	
	}
	
	function resetpassword( )
	{
		$forgotten_password_code = $this->uri->segment( 3 ) ;
		$rs = $this->users_model->get_user_by_where( array( 'forgotten_password_code' => $forgotten_password_code ) , 'username, id, email', 'result_array' ) ;
		if ( !$rs ) { show_404( 'page' ) ; exit ; }
		$data['username'] = $rs[0]['username'] ;
		$userid = $rs[0]['id'] ;
		$email = $rs[0]['email'] ;
		$password = random_string( 'alnum', 10 ) ;
		$this->users_model->update_user( $userid, array( 'forgotten_password_code' => '', 'password' => $password ) ) ;
		$subject = $this->config->item( 'mail_lostpass_subject2' )  ; 
		$message = "
		Hey {$data['username']}, <br />
		Here is your new login information:<br />
		--------------------------------------------------------------<br />
		Username: {$data['username']} <br />
		Password: $password	<br />
		--------------------------------------------------------------<br />		
		-Regards,<br />
		<em>CebuFreelancer Team</em>" ;
		$this->email->initialize( array( 'mailtype' => 'html', 'useragent' => 'XHTMaiL', 'charset' => 'utf-8' ) ) ;				
		$this->email->subject( $subject );
		$this->email->from( $this->config->item( 'mail_nr_fromemail' ) ) ;
		$this->email->reply_to( $this->config->item( 'mail_nr_fromemail' ) ) ;
		$this->email->to( $email ) ;
		$this->email->message( $message ) ;
		$this->email->send( ) ;
		$this->layout->buildPage( 'lostpass/resetpassword', $data ) ; 
	}
}	
?>