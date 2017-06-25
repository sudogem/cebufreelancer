<?php

class Tell_a_friend extends Controller 
{
	function __construct( )
	{
		parent::Controller( ) ;
		$this->load->helper( 'flash' ) ; 
		$this->load->helper( 'file' ) ; 
		$this->load->library( 'validation' ) ;		
		$this->load->library( 'email' ) ;	
        $rs1 = $this->users_model->get_user_by_hash( $this->session->userdata( 'hash_id' ), 'hash_id, id, username', 'result_array' ) ;
        if ( $rs1 ) {
			$this->logged_userid 	= $rs1[0]['id'] ;
			$this->logged_username 	= $rs1[0]['username'] ; 
		}		
	}
	
	function index( )
	{
		$data['flash_message'] = $this->session->flashdata( 'flash_message' );
		$this->layout->buildPage('tell_a_friend/index', $data );
	}
	
	function send( )
	{
		if ( $this->input->post( 'tellthem' ) )
		{
			$this->config->load( 'email' ) ;
			$subject = $this->config->item( 'mail_subject' )  ; 
			$name = $this->input->post( 'name', TRUE ) ;
			//$name = !empty( trim($name) ) ? $name : 'marco' ;
			$emails = $this->input->post( 'email', TRUE ) ;
			if ( !empty($name) )
			{
				$intro['intro'] = "Hi,<br>
				your friend $name wants to share this to you.<br><br>
				";
			}
			else
			{
				$intro['intro'] = '';
			}
			
			$tpl = $this->load->view( 'mailers/mailer1', $intro, TRUE );
			$message =   $tpl ;
			$n = count( $emails ) ;
			$this->email->useragent = 'XHTMaiL';
			$this->email->initialize( array( 'mailtype' => 'html', 'useragent' => 'XHTMaiL', 'charset' => 'utf-8' ) ) ; 
			$this->email->subject( $this->config->item( 'mail_tellafiend_subject' ) ) ;
			$this->email->from( $this->config->item( 'mail_nr_fromemail' ), $this->config->item( 'mail_nr_fromname' ) ) ;
			$this->email->reply_to( $this->config->item( 'mail_nr_fromemail' ) ) ; 
			for( $i=0; $i<$n; $i++ ) 
			{
				if ( $this->validation->valid_email( trim($emails[$i]) ) )
				{
					$data = array( 'email' => trim($emails[$i]), 'datesent' => time(), 'is_send' => 'yes', 'send_by' => $name );
					$this->db->select( 'email' );
					$this->db->where( 'email',  $emails[$i] );
					$rs = $this->db->get( 'usermails' ) ;
					if ( $rs->num_rows() == 0 )
					{		
						$this->db->insert( 'usermails', $data);
						$this->email->subject( $this->config->item( 'mail_tellafiend_subject' ) ) ;
						$this->email->to( trim($emails[$i]) ) ;
						$this->email->message( $message ) ;
						$this->email->send( ) ; 
					}
				}
			}
			$this->layout->buildPage('tell_a_friend/success');
			$this->session->set_flashdata( 'flash_message', 'Thank you for telling this site to your friends.' );
			redirect( 'tell_a_friend/index' );
			exit;					
		}
		else
		{
			$data['flash_message'] = $this->session->flashdata( 'flash_message' );
			$this->layout->buildPage( 'tell_a_friend/index3', $data );
		}
	}
	
	function send_mailers( )
	{
		$p = 'images/emails.txt' ;
		$emailstr = read_file( $p ) or die('file not found') ;
		$emails = explode( ',', $emailstr ) ;
		$data['intro'] = '';
		$message = $this->load->view( 'mailers/mailer1', $data, TRUE );
		#print_r( $emails ) ;
		$n = count( $emails ) ;
		$this->email->useragent = 'XHTMaiL';
		$this->email->initialize( array( 'mailtype' => 'html', 'useragent' => 'XHTMaiL', 'charset' => 'utf-8' ) ) ; 
		$this->email->subject( $this->config->item( 'mail_tellafiend_subject' ) ) ;
		$this->email->from( $this->config->item( 'mail_nr_fromemail' ), $this->config->item( 'mail_nr_fromname' ) ) ;
		$this->email->reply_to( $this->config->item( 'mail_nr_fromemail' ) ) ; 
		for( $i=0; $i<$n; $i++ ) 
		{
			#echo $emails[$i];
			$this->email->subject( $this->config->item( 'mail_tellafiend_subject' ) ) ;
			$this->db->select( 'email' );
			$this->db->where( 'email=',  trim($emails[$i]) );
			$rs = $this->db->get( 'usermails' )  ;
			if ( $rs->num_rows() == 0  )
			{		
				$data = array( 'email' => trim($emails[$i]), 'datesent' => time(), 'is_send' => 'yes', 'send_by' => '' );			
				$this->db->insert( 'usermails', $data);			
				$this->email->subject( $this->config->item( 'mail_tellafiend_subject' ) ) ;
				$this->email->to( $emails[$i] ) ;
				$this->email->message( $message ) ;
				$this->email->send( ) ;
			}
		}
		echo 'Yehey!!! Successfully send mailers.';
	}
}	
?>