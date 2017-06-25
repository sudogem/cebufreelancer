<?php

class Messages extends Controller
{
	function __construct( )
	{
		parent::Controller( ) ;	
		$this->load->config( 'link_pagination' ) ; 
		$this->load->helper( 'flash' ) ; 
		$this->load->helper( 'string' ) ; 
		$this->load->helper( 'typography' ) ; 
		$this->load->helper( 'sanitizer' ) ; 
		$this->load->library( 'pagination' ) ;
		$this->load->library( 'email' ) ;
		$this->load->model( 'projects_messages_model' ) ;
		$this->load->model( 'users_model' ) ;
		$this->load->model( 'bids_model' ) ;
		$this->load->model( 'projects_model' ) ;
		if ( $this->site_sentry->is_logged_in( ) === FALSE ) 
		{
			$this->session->set_userdata( 'action_error', 'You need to login first in order to send/receive messages.' ) ;
			redirect( 'login/' ) ; exit ; 
		}
		$res = $this->users_model->get_user_by_hash( $this->session->userdata( 'hash_id' ), 'hash_id, id, username', 'result_array' ) ;
		$this->logged_userid = $res[0]['id'] ;
		$this->logged_username = $res[0]['username'] ; 
		$this->inbox_per_page['inbox_per_page'] = $this->config->item( 'inbox_per_page' ) ; 		
		$this->assets_script = base_url()  . $this->config->config['layout']['assets_folder'] . '/' . $this->config->config['layout']['views_folder'] . '/' . $this->config->config['layout']['assets_script'] . '/' ; 
	} 
			
	function index( ) 
	{
		$this->inbox( ) ; 
	}
	
	function inbox( ) 
	{
		$data['heading_title'] = 'Inbox';
		$data['all_messages'] = $this->projects_messages_model->get_project_message_by_criteria( array( 'to' => $this->logged_userid ), NULL, NULL ) ;
		$data['flashb'] = $this->session->flashdata( 'flashb' ) ; 
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;
		$this->layout->buildPage( 'message/inbox' , $data ) ; 		
	}
	
	function p( ) 
	{
		$uri = $this->uri->uri_to_assoc( 2 ) ;
		$p = isset( $uri['p'] ) ?  ( int ) $uri['p'] : 0 ;
		$b = isset( $uri['b'] ) ? ( int ) $uri['b'] : 0 ;
		$urls = $this->uri->assoc_to_uri( array( 'p' => $p, 'b' => $b ) ) ; 
		if ( !empty( $p ) && !empty( $b ) )
		{
			$w = array( 'project_id' => $p, 'to' => $this->logged_userid, 'from' => $b ) ;
			$res = $this->projects_messages_model->get_project_message_by_criteria( $w ) ; 
			if ( $res === FALSE ) {
				$_lastaction = $this->session->userdata( '_lastaction' );
				if ( $_lastaction === '_deletemessage' )
				{
				    $return_url = $this->session->userdata( 'return_url' ) ;
					redirect( $return_url ) ; exit ;
				}
				else
				{
					show_404( "page" ) ; exit ;
				}
			}
			$rs = $this->projects_model->get_project_by_id( $p, 'project_id, title' ) ;
			$project_title = $rs[0]['title'] ;
			$username = $this->users_model->get_user_by_id( $b,'users.username', 'row' )->username ;
			$this->session->set_userdata( 'lasturi', $this->uri->uri_string() ) ; 
			$cur_offset = ( $this->uri->segment(6)!= '' ) ? (int)$this->uri->segment(6) : 0 ; 
			$config['base_url'] =  site_url( ) . "/messages/$urls" ; 
			$config['total_rows'] = count( $res ) ; 
			$config['per_page'] = $this->inbox_per_page['inbox_per_page'] ; 
			$config['uri_segment'] = 6;
			$limit = array( 'start' => $config['per_page'] , 'end' => $cur_offset ) ; 
			$this->pagination->initialize( $config ) ;		
			$data['project_id'] = $p ;
			$data['links'] = $this->pagination->create_links( ) ; 		
			$data['all_messages'] = $this->projects_messages_model->get_project_message_by_criteria( $w, NULL, $limit ) ; 
			$data['flashb'] = $this->session->flashdata( 'flashb' ) ; 
			$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ; 
			$data['heading_title'] = "Messages of" . h(" $username on ") .  "<b>" . h($project_title) . "</b>" ;
			$this->layout->buildPage( "message/inbox2" , $data ) ; 	
		}
	}

	function compose( )
	{
		$projectid = (int)$this->uri->segment( 3 ) ; 
		$owner = $this->uri->segment( 4 ) ;  
		$s = array( 'username' => $owner ) ;
		$ownerid = $this->users_model->get_user_by_where( $s, 'username, id'  ) ;
		if ( $ownerid === FALSE ) {
			show_404( "page" ) ; exit ;
		}
		else {
			$ownerid = $ownerid->id ;
		}
		$rs1 = $this->projects_model->get_userproject_by_id( $ownerid, $projectid ) ;
		if ( $rs1 === FALSE )
		{
			show_404( "page" ) ; exit ;
		}
		$res2 = $this->projects_model->get_project_by_id( $projectid ) ;
		$data['project_id'] = $projectid ;
		$data['to'] = $ownerid ; 
		$data['owner_name'] = $owner ;
		$data['subject'] = htmlspecialchars( $res2[0]['title'], ENT_QUOTES, 'UTF-8' ) ;
		$data['flashb'] = $this->session->flashdata( 'flashb' ) ;
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;
		$this->layout->buildPage( 'message/compose' , $data ) ; 
	}
	
	function compose2( )
	{
		$project_id = (int)$this->uri->segment( 3 ) ; 
		$bid_id = (int)$this->uri->segment( 4 ) ;  
		$w = array( 'project_bids.project_id' => $project_id, 'project_bids.bid_id' => $bid_id ) ;
		$rs1 = $this->bids_model->get_project_bids_by_criteria( $w ) ;
		if ( $rs1 === FALSE )
		{
			show_404( "page" ) ; exit ;		
		}
		
		$s = array( 'id' => $rs1[0]['user_id'] ) ;
		$rs2 = $this->users_model->get_user_by_where( $s, 'username, id', 'result_array' ) ; 
		$owner = $rs2[0]['username'] ; 
		$res2 = $this->projects_model->get_project_by_id( $project_id ) ;
		$data['project_id'] = $project_id ;
		$data['created_by'] = $this->logged_userid ; 
		$data['to'] = $rs1[0]['user_id'] ;
		$data['owner_name'] = $owner ;
		$data['subject'] = htmlspecialchars( $res2[0]['title'], ENT_QUOTES, 'UTF-8' ) ;
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;
		$data['flashb'] = $this->session->flashdata( 'flashb' ) ;
		$this->layout->buildPage( 'message/compose' , $data ) ; 	
	}
	
	function view( )
	{
		$id = ( int )$this->uri->segment( 3 ) ; 
		$msg = array( 'message_id' => $id , 'to' => $this->logged_userid ) ; 
		$res = $this->projects_messages_model->get_project_message_by_criteria( $msg ) ; 
		// check if she is the receiver of the message
		if ( $res === FALSE ) 
		{ 
			show_404( "page" ) ; exit ; 
		}  
		$data['message_details'] = $res ; 
		$data['flashb'] = $this->session->flashdata( 'flashb' ) ; 
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;
		$this->projects_messages_model->update_project_message( $id, array( 'isopen' => '1' ) ) ; 
		$this->layout->buildPage( 'message/view' , $data ) ; 
	}

	function reply( )
	{
		$this->config->load( 'email' ) ;
		$message = trim( $this->input->post( 'message', TRUE )) ;
		$msg_id = ( int )$this->input->post( 'msg_id' ) ;
		$nl2 = "-";
		$nl2 = repeater($nl2, 55) ; 		
		if ( $this->input->post( 'reply' ))
		{
			if ( empty( $message ) )
			{
				$this->session->set_flashdata( 'flash_message', 'Please input a message.' ) ; 
				header( 'Location:' . $_SERVER['HTTP_REFERER'] ) ; exit ; 
			}
			else
			{
				$msg = array( 'message_id' => $msg_id , 'to' => $this->logged_userid ) ; 
				$res = $this->projects_messages_model->get_project_message_by_criteria( $msg ) ; 
				if ( $res === FALSE ) 
				{ 
					show_404( "page" ) ; exit ;	
				}
				$data = array( 
					'project_id' => $res[0]['project_id'] , 
					'from' => $this->logged_userid , 
					'to' => $res[0]['from'], 
					'message' => $message , 
					'dateposted' => time( ) , 
					'subject' => $res[0]['subject'] 
				) ; 
				$this->session->set_flashdata( 'flash_message', 'Successfully send message. ' ) ;  
				$this->projects_messages_model->insert_project_message( $data ) ; 
				$rs = $this->users_model->get_user_by_id( $data['to'], 'users.email, users.username' ) ;
				$subject = "You got a new message on the subject {$data['subject']} posted on Cebufreelancer." ;
				$data['message'] = nl2br( $data['message'] ) ;
				$message = "
				Hi {$rs[0]['username']}, you got a message in the topic: {$data['subject']}.
				<br><br>Message:
				<br>{$data['message']}
				<br><br>-<br><em>CebuFreelancer Team</em><br>" ;
				$this->email->useragent = 'XHTMaiL';					
				$this->email->initialize( array( 'mailtype' => 'html', 'useragent' => 'XHTMaiL', 'charset' => 'utf-8' ) ) ;
				$this->email->subject( $subject ) ; 
				$this->email->from( $this->config->item( 'mail_nr_fromemail' ), $this->config->item( 'mail_nr_fromname' ) ) ;
				$this->email->reply_to( $this->config->item( 'mail_nr_fromemail' ) ) ;
				$this->email->to( $rs[0]['email'] ) ;
				$this->email->message( $message ) ;
				$this->email->send( ) ;
				redirect( "messages/view/$msg_id" ) ; exit ;
			} 
		} 
	} 
	
	function send( )
	{
		$this->config->load( 'email' ) ;
		$data = array(
			'project_id' => $this->input->post( 'pid' , TRUE ) ,
			'from' => $this->logged_userid ,
			'to' => $this->input->post( 'to' , TRUE ) ,
			'message' => $this->input->post( 'message', TRUE ),
			'dateposted' => time( ) ,
			'subject' => trim( $this->input->post( 'subject', TRUE ) ) 
		) ;
		$p = $this->input->post( 'submit' ) ;
		if ( isset( $p ) )
		{
			if ( empty( $data['subject'] ) )
			{
				$this->session->set_flashdata( 'flashb', 'red' ) ;
				$this->session->set_flashdata( 'flash_message', 'Please input a subject.' ) ; 
				header( 'Location:' . $_SERVER['HTTP_REFERER'] ) ; exit ;
			}
			if ( empty( $data['message'] ) )
			{
				$this->session->set_flashdata( 'flashb', 'red' ) ;
				$this->session->set_flashdata( 'flash_message', 'Please input a message.' ) ; 
				header( 'Location:' . $_SERVER['HTTP_REFERER'] ) ; exit ;
			}
			else
			{
				$this->session->set_flashdata( 'flashb', 'green' ) ;
				$this->session->set_flashdata( 'flash_message', 'Successfully send message. ' ) ;
				$this->projects_messages_model->insert_project_message( $data ) ; 
				$rs = $this->users_model->get_user_by_id( $data['to'], 'users.email, users.username' ) ;
				$subject = "You got a new message on the subject {$data['subject']} posted on Cebufreelancer." ;
				$data['message'] = nl2br( $data['message'] ) ;
				$message = "
				Hi {$rs[0]['username']}, someone just sent you a message about the topic: {$data['subject']}.
				<br><br>Message:
				<br>{$data['message']}
				<br><br>-<br><em>CebuFreelancer Team</em><br>" ;
				$this->email->useragent = 'XHTMaiL';					
				$this->email->initialize( array( 'mailtype' => 'html', 'useragent' => 'XHTMaiL', 'charset' => 'utf-8' ) ) ;
				$this->email->subject( $subject ) ; 
				$this->email->from( $this->config->item( 'mail_nr_fromemail' ), $this->config->item( 'mail_nr_fromname' ) ) ;
				$this->email->reply_to( $this->config->item( 'mail_nr_fromemail' ) ) ;
				$this->email->to( $rs[0]['email'] ) ;
				$this->email->message( $message ) ;
				$this->email->send( ) ;
				header( 'Location:' . $_SERVER['HTTP_REFERER'] ) ; exit ;
			}
		}
	}
	
	function doaction( )
	{
		$act = $this->uri->segment( 3 ) ;
		if ( $act == '1' ) {
			$this->_deletemessage( ) ;
		}	
		else {
			show_404( 'page' ) ; exit ;
		}
	}
	
	//-----------------------  Private functions  ---------------------------------------
	function _deletemessage( )
	{
		$success_delete = FALSE;
		$chk = $this->input->post( 'chk' ) ;
		foreach( $chk as $v )
		{
			$w = array(
				'message_id' => $v ,
				'to' => $this->logged_userid
			) ;
			$rs = $this->projects_messages_model->get_project_message_by_criteria( $w, 'message_id, to' ) ;
			if ( $rs ) {
				$this->projects_messages_model->delete_project_message( $v ) ;
				$success_delete = TRUE;
			}
		}
		if ( $success_delete ) 
		{
			$this->session->set_flashdata( 'flashb', 'green' );
			$this->session->set_flashdata( 'flash_message', 'Successfully delete message(s). ' ) ; 
		}
		else {
			$this->session->set_flashdata( 'flashb', 'red' )  ;
			$this->session->set_flashdata( 'flash_message', 'Please select a message to delete.' ) ; 
		}
		redirect('messages/inbox' );
		#exit;
	}
	
}
?>