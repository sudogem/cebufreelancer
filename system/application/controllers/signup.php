<?php
class Signup extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;
		$this->load->helper( 'flash' ) ;
		$this->load->helper( 'string' ) ;
		$this->load->library( 'tokenizer' ) ;
		$this->load->library( 'validation' ) ;
		$this->load->plugin( 'captcha' ) ;	
		$this->load->model( 'projects_messages_model' ) ;
		$this->load->model( 'users_temp_model' ) ;
		$this->load->model( 'users_model' ) ;
		$this->font_path = './fonts/ahbg.ttf';
	}
	
	function index( )
	{
		$vals = array(
			'img_path' => './captcha/',
			'img_url' => site_url() . 'captcha/' ,
			'word' => random_string( 'alnum' , 5 ) , 
			'img_width' => 313 ,
			'img_height' => 40 ,
			'font_path' => $this->font_path	
		) ;
		
		$cap = create_captcha($vals);
		$data = array(
			'captcha_id'	=> '',
			'captcha_time'	=> $cap['time'],
			'ip_address'	=> $this->input->ip_address(),
			'word'			=> $cap['word']
		);
		 
		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query) ;
		$data['captcha_img'] = $cap['image'] ; 		
		$this->layout->buildPage( 'signup/index' , $data ) ; 
	}

	function generate_form_captcha( )
	{
		$vals = array(
			'img_path' => './captcha/',
			'img_url' => site_url() . '/captcha/' ,
			'word' => random_string( 'alnum' , 5 ) , 
			'img_width' => 313 ,
			'img_height' => 40 ,		
			'font_path' => $this->font_path			
		) ;
		$cap = create_captcha($vals);
		$data = array (
			'captcha_id' => '',
			'captcha_time' => $cap['time'] ,
			'ip_address' => $this->input->ip_address( ) ,
			'word' => $cap['word']
		) ;
		
		$query = $this->db->insert_string('captcha', $data) ;
		$this->db->query($query);
		echo $cap['image'] ; 	
	}
	
	function do_signup( )
	{
		$signup = $this->input->post( 'signup' ) ;
		$this->load->view( 'custom_validations/signup_validations' ) ;
		if ( isset( $signup ) && $signup != '' )
		{
			$newuser = array(
				'username' => $this->input->post( 'username' , TRUE ) ,
				'fullname' => $this->input->post( 'fullname' , TRUE ) ,				
				'password' => $this->input->post( 'password' , TRUE ) ,			
				'email' => $this->input->post( 'email' , TRUE ) ,
				'created_at' => time( ) , 
				'user_type' => 2 ,
				'activation_code' => substr( $this->tokenizer->generate_hashcode( ), 0, 10 )
			) ;
			$agreement = TRUE ;
			// check if agreement was check
			$a = $this->input->post( 'agreement' ) ;
			if ( empty( $a ) ) $agreement = FALSE ; 
			if ( $this->validation->run( ) == FALSE ) 
			{
				// redirect to signup form
				$this->index( ) ;
			}
			else
			{
				if ( $agreement === FALSE )
				{
					$this->validation->error_string = ' You need to accept the Terms and Conditions to complete your registration.' ; 
					$this->index( ) ; 
				}
				elseif ( $this->db->insert( 'users_temp' , $newuser ) ) // lets add this user to the database, then send him a lovely welcome message.. 
				{
					$userid = $this->db->insert_id( ) ;
					$this->_sendActivationEmail( $userid , $newuser['email'] , $newuser['activation_code'] ) ;
					redirect( 'signup/success' , 'location' ) ; exit ;
				}
			}
		}
	}
	
	function success( )
	{
		$this->layout->buildPage( 'signup/success') ; 	
	}	

	// callbacks functions
	function email_check( )
	{
		$email = $this->input->post( 'email' ) ;
		$rs = $this->users_model->get_user_by_where( array( 'email' => $email ),  'email' ) ;
		// check if email is exist
		if ( $rs )
		{
			$this->validation->set_message('email_check', "Email '{$email}' is already taken by another user. Please choose another one. " );			
			return FALSE ;			
		}
		else
		{
			return TRUE ;
		}
	}
	
	// check if user name is available
	function username_checkforavailability( )
	{
		$username = $this->input->post( 'username' ) ;
		$rs = $this->users_model->get_user_by_where( array( 'username' => $username ),  'username' ) ;
		if ( $rs )
		{
			$this->validation->set_message('username_checkforavailability', "Username '{$username}' is already taken by another user. Please choose another one. " );			
			return FALSE ;			
		}
		else
		{
			$rs = $this->users_temp_model->get_users_temp( 'username', array( 'username' => $username ) ) ;		
			if ( $rs ) {
				$this->validation->set_message('username_checkforavailability', "Username '{$username}' is already taken by another user. Please choose another one. " );			
				return FALSE ;
			}
			//return TRUE ;
		}
		return TRUE ;
	}

	function password_check( )
	{
		if ( $this->input->post( 'password' ) !=  $this->input->post( 'password2' ) )
		{
			$this->validation->set_message( 'password_check' , 'Confirmation password does not match with your inputted password.' ) ;
			return false ;
		}
		return true ;
	}

	function captcha_check( )
	{
		// Then see if a captcha exists:
		// First, delete old captchas
		$expiration = time()-600 ; 
		$this->db->query( "DELETE FROM captcha WHERE captcha_time < ".$expiration ) ;		
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?" ;
		$binds = array( $this->input->post( 'seccode' , TRUE )  , $this->input->ip_address( ) , $expiration ) ;
		$query = $this->db->query($sql, $binds) ;
		$row = $query->row( ) ;
		if ($row->count == 0)
		{
			$this->validation->set_message('captcha_check', 'Verification code is invalid. Please submit the code that appears on the image.' );
			return FALSE ; 
		}
		else
		{
			return TRUE ; 
		}
	} 
	

	// send the user with activation email ----------------------------
	function _sendActivationEmail( $userid , $email , $activation_code )
	{
		$this->load->library( 'email' ) ;
		$this->config->load( 'email' ) ;
		$subject = $this->config->item( 'mail_subject_confirm' )  ; 
		$rs = $this->users_temp_model->get_users_temp( 'id, username, password', array( 'id' => $userid ) ) ;
		$username = $rs[0]['username'] ;
		$password = $rs[0]['password'] ;
		$link = site_url( "activate/index/$username/$activation_code" ) ;
		$message = "<h1>Welcome to CebuFreelancer!</h1> <br> <br>
					<br>To verify your account and complete the signup process please click on the link below:<br /><a href=$link>$link</a><br><br>
					Once you've verified your account, you can now post a new project or bid a project. <br>
					<br>Please note:  this is an automated email, do not reply to this message.<br>
					Instead, use the contact link below for any inquiries or suggestions.<br><br>
					<a href=\"http://cebufreelancer.com/contact\" >http://cebufreelancer.com/contact</a><br>
					<br>Thanks!<br><br>
					-<br><em>CebuFreelancer Team</em><br>" ;
		$this->email->useragent = 'XHTMaiL';					
		$this->email->initialize( array( 'mailtype' => 'html', 'charset' => 'utf-8' ) ) ;
		$this->email->subject( $subject ) ; 
		$this->email->from( $this->config->item( 'mail_nr_fromemail' ), $this->config->item( 'mail_nr_fromname' ) ) ;
		$this->email->reply_to( $this->config->item( 'mail_nr_fromemail' ) ) ;
		$this->email->to( $email ) ;
		$this->email->message( $message ) ;
		$this->email->send( ) ;
	}
	
}
?>