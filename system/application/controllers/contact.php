<?php

class Contact extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;
		$this->load->helper( 'flash' ) ;
		$this->load->helper( 'string' ) ;				
		$this->load->library( 'email' ) ;
//		$this->load->library( 'tokenizer' ) ;
		$this->load->plugin( 'captcha' ) ;	
		
		$this->font_path = './fonts/mcgarey.ttf'	 ;
	}
	
	function index( )
	{
		$vals = array(
			'img_path' => './captcha/',
			'img_url' => site_url() . 'captcha/' ,
			'word' => random_string( 'alnum' , 7 ) , 
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
		
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;
		$this->layout->buildPage( 'contact/index', $data );
	}
	
	function send( )
	{
		$name = $this->input->post( 'name', TRUE ) ;
		$email = $this->input->post( 'email', TRUE ) ;
		$inquiry = ( int )$this->input->post( 'inquirytype' ) ;
		$message = $this->input->post( 'message', TRUE ) ;
		$this->load->library( 'validation' ) ;
		if ($this->input->post('submit') )
		{
			$rules['seccode'] = 'required|callback_captcha_check' ;
			$rules['name'] = 'required' ;
			$rules['inquirytype'] = 'required' ;
			$rules['email'] = 'trim|required|valid_email' ;
			$this->validation->set_rules( $rules ) ;
			$fields['seccode'] = 'verification code' ; 
			$this->validation->set_fields( $fields ) ;
			switch( $inquiry )
			{
				case 1:
					$subject = 'Advertise';
					break ;
				case 2: 
					$subject = 'Dispute over project';			
					break ;
				case 3:
					$subject = 'Dispute with other members';			
					break ;
				case 4:
					$subject = 'Errors/Bugs';			
					break ;
				case 5:
					$subject = 'Feedback';			
					break ;
				case 6:
					$subject = 'Others';			
					break ;
				default:			
					$subject = 'Default'; 
					break ;
			}
			if ($this->validation->run() == FALSE)
			{
				$this->index();
			}
			else
			{
				$this->config->load( 'email' ) ;
				$this->email->initialize( array( 'mailtype' => 'html', 'useragent' => 'XHTMaiL', 'charset' => 'utf-8' ) ) ;
				$this->email->subject( $subject ) ; 
				$this->email->from( $email, $name ) ;
				$this->email->reply_to( $email ) ;
				$this->email->to( $this->config->item( 'mail_fromemail' ) ) ;
				$this->email->message( $message ) ;
				$this->session->set_flashdata( 'flash_message', 'Youve successfully sent the message. Thanks.' ) ;
				$this->email->send( ) ;
				redirect( "contact/" ) ;
			}
		}
	}

	function generate_form_captcha( )
	{
		$vals = array(
			'img_path' => './captcha/',
			'img_url' => site_url() . 'captcha/' ,
			'word' => random_string( 'alnum' , 6 ) , 
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
	
}	
?>