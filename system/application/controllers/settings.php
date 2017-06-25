<?php
class Settings extends Controller  
{
	function __construct( )
	{
		parent::Controller( ) ; 
		$this->load->config( 'link_pagination' ) ;  
		$this->load->helper( 'flash' ) ; 
		$this->load->helper( 'time' ) ; 		
		$this->load->helper( 'bday' ) ; 	
		$this->load->helper( 'string' ) ;
		$this->load->helper( 'sanitizer' ) ; 
		$this->load->library( 'datafilter' ) ; 
		$this->load->library( 'validation' ) ; 
		$this->load->library( 'pagination' ) ; 
		$this->load->library( 'email' ) ; 
		$this->load->model( 'users_model' ) ; 
		$this->load->model( 'user_social_media_accounts_model' ) ; 
		$this->load->model( 'user_profile_model' ) ; 
		$this->load->model( 'user_subscriptions_model' ) ; 
		$this->load->model( 'user_category_subscriptions_model' );
		$this->load->model( 'projects_model' ) ; 	
		$this->load->model( 'bids_model' ) ; 
		$this->load->model( 'projects_messages_model' ) ; 
		$this->load->model( 'categories_model' ) ;  
		$this->load->model( 'project_categories_model' ) ;  
		if ( $this->site_sentry->is_logged_in( ) === FALSE )  
		{		
			$this->session->set_userdata( 'return_url', $this->uri->uri_string( ) ) ;		
			$this->session->set_userdata( 'action_error', 'Please login to access the page.' ) ;		
			redirect( 'login/' ) ; 
			exit ; 
		} 
		$res = $this->users_model->get_user_by_hash( $this->session->userdata( 'hash_id' ), 'hash_id, id, username', 'result_array' ) ;
		$this->logged_userid = $res[0]['id'] ;
		$this->logged_username = $res[0]['username'] ; 
		$this->projects_per_page['projects_per_page'] = $this->config->item( 'projects_per_page' ) ;
		$this->assets_images = base_url()  . $this->config->config['layout']['assets_folder'] . '/' . $this->config->config['layout']['views_folder'] . '/' . $this->config->config['layout']['assets_images'] . '/' ; 
		
	
	}
	
	function index( )
	{
		$this->layout->buildPage('freelancers/index');
	}
	
	/* 
	--- URI's for settings controller ----
	settings/projects/new_project
	settings/projects/edit_project	
	settings/projects/my_projects
	settings/projects/view_project
	settings/profile/editprofile
	settings/profile 
	*/
	function _remap( $method )
	{

		switch( strtolower( $method ) )
		{
			case 'projects' : 
				$uri = strtolower( $this->uri->segment( 3 ) ) ;
				switch( $uri )
				{
					case 'new_project' :
						$this->new_project( ) ; 
						break ;
					case 'my_projects' :
						$this->my_projects( ) ; 
						break ;
					case 'view' :
						$this->view_project( ) ; 
						break ;	
					case 'viewbid' :
						$this->viewbid( ) ; 
						break ;
					case 'close' : 
						$this->close_project( ) ;
						break ;
					case 'save_project' :
						$this->save_project( ) ;  
						break ;	
					case 'preview_project' :
						$this->preview_project( ) ;  
						break ;
					case 'manage_subscriptions' :
						$this->manage_subscriptions( ) ;  
						break ;		
					case 'my_bids' :
						$this->my_bids( ) ;
						break ;
					case 'edit' :
						$this->edit_project( ) ;
						break ;	
					default :
						show_404( 'page' ) ; 
						break ;	
				}
				break ; 
			case 'profile' : 
				$uri = strtolower( $this->uri->segment( 3 ) ) ;
				switch( $uri )
				{
					case 'editprofile' : 
						$this->editprofile( ) ;
						break ;
					case 'updateprofile' :
						$this->updateprofile( ) ;
						break ;
					case 'changepassword' :
						$this->changepassword( ) ;
						break ;						
					default : 
						$this->editprofile( ) ;
						break ;
				}				
				break ;
			case 'bid' :
				$uri = $this->uri->uri_to_assoc( 3 ) ;
				$p = isset( $uri['p'] ) ? (int)$uri['p'] : '' ;
				$v = isset( $uri['v'] ) ? (int)$uri['v'] : '' ;
				if ( !empty( $p ) && !empty( $v ) )
				{
					$this->view_bid( $p, $v ) ;
				}	
				elseif ( isset( $uri['acceptbid'] ) ) 
				{
					$this->accept_bid( intval( $uri['acceptbid'] ) ) ;
				}
				elseif ( isset( $uri['deletebid'] ) )
				{
					$this->delete_bid( intval( $uri['deletebid'] ) ) ; 
				}	
				break ;
			case 'inbox' :	
				
				break;
			default:
				show_404( 'page' ) ; 
				break ;	
		}
	}

	// --------------------- Projects ----------------------------- 
	function my_projects( )
	{
		$data = array( ) ; 
		$data['meta_title'] = 'My Project Postings - CebuFreelancer' ; 
		$where = array('created_by' => $this->logged_userid);
		$res = $this->projects_model->get_all_projects( NULL, NULL, $where ) ; 
		$cur_offset = ( $this->uri->segment(4)!= '' ) ? (int)$this->uri->segment(4) : 0 ; 
		$config['base_url'] =  site_url( ) . '/settings/projects/my_projects' ; 
		$config['total_rows'] = count( $res ) ; 
		$config['per_page'] = $this->projects_per_page['projects_per_page'] ; 
		$config['uri_segment'] = 4 ;		
		$limit = array( 'start' => $config['per_page'] , 'end' => $cur_offset ) ; 
		$this->pagination->initialize( $config ) ;				
		$data['links'] = $this->pagination->create_links( ) ; 		
		$data['all_projects'] = $this->projects_model->get_all_projects( NULL, $limit, $where ) ; 
		$data['contact_person'] = $this->users_model->get_user_by_id( $this->logged_userid, 'users.id, user_profile.fullname', 'row' )->fullname ;
		$this->layout->buildPage( 'settings/projects/my_projects' , $data ) ; 
	}
	
	function new_project( )
	{
		$data['meta_title'] = 'Post New Project - CebuFreelancer' ; 
		$this->load->view( 'custom_validations/project_validations' ) ;
		$cat = $this->categories_model->get_all_categories( 'category_id, category, category_url' ) ;
		$data['project_categories'] = $cat;  
		$tmp = array(
			'title' => $this->input->post( 'title' , TRUE ), 
			'description' => $this->input->post( 'description' , TRUE )  ,
			'dateposted' => time( ) ,
			'budget' => $this->input->post( 'budget' , TRUE ) ,
			'duration' => $this->input->post( 'duration' , TRUE ) ,	
			'project_status' => 'open' , 
			'created_by' => $this->users_model->get_user_by_id( $this->logged_userid, 'users.id, user_profile.fullname', 'row' )->fullname , 
			'categories' => $this->input->post( 'category', TRUE ) ,
			'hide_bid_amount' => $this->input->post( 'hide_bid_amount', TRUE )	,
			'payment_detail' => $this->input->post( 'payment_detail', TRUE )
		) ;
		if (isset($_POST['preview']))
		{
			$this->session->set_userdata( 'post_data', $tmp ) ;
			if ( $this->validation->run( ) === FALSE )
			{
				$data['flash_message'] = "<b>Please correct the following errors below.</b><br /><br />". $this->validation->error_string ;
				$data['flashb'] = 'red' ;
				$this->layout->buildPage( 'settings/projects/new_project' , $data ) ; 
			}
			else
			{
				$data['post_data'] = $tmp ;
				$this->layout->buildPage( 'settings/projects/preview_project' , $data ) ;		
			}
		}
		else
		{
			$this->layout->buildPage( 'settings/projects/new_project' , $data ) ;
		}
	}
	
	function save_project( )
	{
		$this->load->view( 'custom_validations/project_validations' ) ;
		$this->config->load( 'email' ) ;
		if ( $this->input->post( 'save' ) )
		{
			$post_data = $this->session->userdata( 'post_data' ) ;
			$tmp_project = array(
				'title' => $post_data['title'], 
				'description' => $post_data['description'],
				'dateposted' => time( ),
				'hide_bid_amount' => $post_data['hide_bid_amount'],
				'budget' => $post_data['budget'],
				'payment_detail' =>	$post_data['payment_detail' ],
				'duration' => $post_data['duration'],
				'project_status' =>  'open' ,
				'created_by' => $this->logged_userid
			) ;
			$this->session->set_flashdata( 'flash_message', 'Successfully post projects.' ) ; 
			$this->projects_model->insert_project( $tmp_project ) ; 
			$project_id = $this->db->insert_id( ) ;
			$title = url_title( $tmp_project['title'] ); 
			//get the posted category
			$tmpcategories = $post_data['categories'] ;
			$n = count( $tmpcategories );
			for( $i=0; $i<$n; $i++ )
			{
				// check if the user wants to receive project notifications
				$res = $this->user_category_subscriptions_model->get_user_subscriptions( array( 'category_id' => (int)$tmpcategories[$i] ), 'user_id, category_id', 'user_id' );
				foreach( $res as $row )
				{
					$rs = array();
					$rs = $this->user_subscriptions_model->get_user_subscriptions( array( 'user_id' => $row['user_id'] ) ) ;
					if ( $rs[0]['project_posting_notification'] == 1 )
					{
						$rsemail = $this->users_model->get_user_by_id( $row['user_id'], 'users.email, users.username', 'result_array' );
						$subscribers[$rsemail[0]['username']] = $rsemail[0]['email'];
					}
				}
				$a = array( 'project_id' => $project_id, 'category_id' => (int)$tmpcategories[$i] ) ;
				$this->project_categories_model->insert_project_to_category( $a ) ;		
			}
			$m = count($tmpcategories);
			$i = 0;
			$categories = '';
			foreach ( $tmpcategories as $catid )
			{
			    $categories .= $this->categories_model->get_categories_by_criteria( array('category_id' => $catid), 'category', 'row' )->category  ;
				if ( ($i+1) < $m) $categories .= ', '; 
				$i++;
			}
			//remove duplicate emails
			$subscribers = array_unique( $subscribers );
			$link = site_url( "projects/view/$project_id/$title" );
			foreach( $subscribers as $name => $email )
			{
				$subject = $tmp_project['title'] . " posted at CebuFreelancer" ;
				$message = "
				Dear $name,<br /><br />
				We have a new project posted by " . $this->logged_username . "<br />
				Title: " . $tmp_project['title'] . "<br />
				Job type: " . $categories . "<br />
				Description: " . $tmp_project['description'] . "<br />
				<br />
				To view the full details of the project, just click the link below.<br>
				$link <br />
				<br />--------------------------------------------------------------
				<br>Want to stop receiving Project Notification emails? <br>
				Just <a href=\"http://cebufreelancer.com/login\" >login</a> to your account, then choose the 'Manage Subscription' menu.<br>
				<br />Please note:  This is an automated email, do not reply to this message.<br />
				Instead, use the contact link below for any inquiries or suggestions.<br /><br />
				<a href=\"http://cebufreelancer.com/contact\" >http://cebufreelancer.com/contact</a><br />
				<br />Thanks!<br /><br />
				-<br /><em>CebuFreelancer Team</em><br />" ;
				$this->email->initialize( array( 'mailtype' => 'html', 'useragent' => 'XHTMaiL', 'charset' => 'utf-8' ) ) ;
				$this->email->subject( $subject ) ; 
				$this->email->from( $this->config->item( 'mail_nr_fromemail' ), $this->config->item( 'mail_nr_fromname' ) ) ;
				$this->email->reply_to( $this->config->item( 'mail_nr_fromemail' ) ) ;
				$this->email->to( $email ) ;
				$this->email->message( $message ) ;
				$this->email->send( ) ;
			}
			$this->session->set_flashdata( 'flash_message', 'Successfully post project' ) ;
			$this->session->unset_userdata( 'postdata' ) ;
			redirect( 'settings/projects/my_projects' ) ;
			exit;
		} 
	}
	
	function preview_project()
	{
		$data['meta_title'] = 'Preview Project - CebuFreelancer' ; 
		$this->layout->buildPage( 'settings/projects/preview_project' ) ; 
	}
		
	function close_project( )
	{
		$project_id = ( int )$this->uri->segment( 4 ) ;
		$res = $this->projects_model->get_userproject_by_id( $this->logged_userid, $project_id ) ;
		if ( $res === FALSE ) {
			show_404( "page" ) ; 
			exit( ) ;
		}
		$project_title = $this->projects_model->get_project_by_id( $project_id, 'project_id, title', 'row' )->title ;
		$this->projects_model->update_project( $project_id, array( 'project_status' => 'closed' ) ) ;
		$this->session->set_flashdata( 'flash_message', "Successfully closed the project <b>$project_title</b>" ) ; 
		redirect( 'settings/projects/my_projects' ) ;
		exit ;
	}
	
	function edit_project( )
	{
		// only the bot can edit the project
		if ( !$this->site_sentry->check( 'bot' ) )
		{
			show_404( "page" ) ;   
			exit( ) ;
		}
		$this->load->view( 'custom_validations/project_validations' ) ;
		$project_id = (int)$this->uri->segment( 4 ) ;
		$rs1 = $this->projects_model->get_userproject_by_id( $this->logged_userid, $project_id ) ;
		
		if ( $this->input->post( 'update' ) )
		{
			$data = array( 
			'title'	=> $this->input->post( 'title', TRUE ) , 
			'description' =>  $this->input->post( 'description', TRUE ) , 	
			'dateposted' => strtotime( $this->input->post( 'dateposted' ) ) ,
			'project_status' => $this->input->post( 'project_status' ) ,
			'hide_bid_amount' => $this->input->post( 'hide_bid_amount', TRUE )	,
			'budget' => $this->input->post( 'budget' ) ,
			'duration' => $this->input->post( 'duration', TRUE ) ,
			'payment_detail' => $this->input->post( 'payment_detail', TRUE )
			) ;
			// delete previous category of the project
			$this->project_categories_model->delete_project_categories( $project_id ) ;
			// get the submited category
			$tmp = $this->input->post( 'category' ) ;
			$n = count( $tmp ) ;
			for( $i=0; $i<$n; $i++) 
			{
				$a = array( 'project_id' => $project_id, 'category_id' => (int)$tmp[$i] ) ;
				$this->project_categories_model->insert_project_to_category( $a ) ;		
			}			
			$this->projects_model->update_project( $project_id, $data ) ;
			$this->session->set_flashdata( 'flash_message', "Successfully updated the project" ) ; 
			redirect( 'settings/projects/my_projects' ) ;
			exit ;
		}
		else
		{
			$data['project_id'] = $project_id ;
			$data['tmp_categories'] = $this->project_categories_model->get_project_categories( array( 'project_categories.project_id' => $project_id ) ) ;
			$data['project_categories'] = $this->categories_model->get_all_categories( ) ;
			$data['project_details'] = $rs1 ;	
			$data['extra_js_mid'] = array( 'calendar/calendar.js', 'calendar/calendar-setup.js', 'calendar/lang/calendar-en.js' ) ;
			$data['extra_css'] = array( 'calendar/aqua/theme.css' ) ;
			$this->layout->buildPage( 'settings/projects/edit_project', $data ) ; 			
		}	
	}
	
	function view_project( $opt = NULL )
	{
		$project_id = (int)$this->uri->segment( 4 ) ;
		$rs1 = $this->projects_model->get_userproject_by_id( $this->logged_userid, $project_id ) ;
		if ( $rs1 === FALSE ) 
		{
			show_404( "page" ) ; 
			exit( ) ;
		}
		$data['project_details'] = $rs1 ;	
		// get the messages
		$this->projects_messages_model->group_by_ = 'from' ;
		$data['messages'] = $this->projects_messages_model->get_project_messages( $project_id, $this->logged_userid ) ;
		$res = $this->projects_model->get_userproject_by_id( $this->logged_userid, $project_id ) ;
		if ( $res === FALSE )
		{
			// get only his bid bec he is not the owner of the project
			$data['bidders'] = $this->bids_model->get_project_bids_by_criteria( array( 'projects.project_id' => $project_id, 'user_id' => $this->logged_userid ) ) ;
		}
		else
		{
			// get all the users who made the bid
			$data['bidders'] = $this->bids_model->get_project_bids_by_criteria( array( 'projects.project_id' => $project_id ) ) ;
		}
		$created_by = $this->users_model->get_user_by_id( $rs1[0]['created_by'] , 'users.username', 'row' )->username ; 
		$data['opt'] = $opt ;
		$data['meta_title'] = h( $rs1[0]['title'] ) . ' - CebuFreelancer' ; 
		$data['assets_images'] = $this->assets_images ;
		$data['sendpm']	= "messages/compose/$project_id/$created_by" ;	
		$this->session->set_userdata( 'return_url', $this->uri->uri_string() ) ;
		$data['flash_message'] =  $this->session->userdata( 'flash_message' ) ;
		$data['flashb'] = $this->session->userdata( 'flashb' ) ;
		$this->session->unset_userdata( 'flash_message' ) ;
		$this->session->unset_userdata( 'flashb' ) ;
		$this->layout->buildPage( 'settings/projects/view_project2', $data ) ; 
	}
		
	// --------------------- Bids -------------------------------- 
	function my_bids( )
	{
		$data['meta_title'] = 'My Bids - CebuFreelancer' ; 
		$w = array( 'user_id' => $this->logged_userid ) ; 
		$this->bids_model->_groupby = "project_bids.project_id" ;
		$data['all_bids'] = $this->bids_model->get_project_bids_by_criteria( $w ) ; 
		$this->layout->buildPage( 'settings/bids/my_bids', $data ) ; 
	}
	
	function view_bid( $p, $v )
	{
		$data['meta_title'] = 'View Bids - CebuFreelancer' ; 
		//$data['extra_js'] = array( 'jquery-1.2.3.min.js' ,'common.js' ) ;		
		$w = array( 'project_bids.bid_id' => $v, 'project_bids.project_id' => $p ) ; 
		$rs = $this->bids_model->get_project_bids_by_criteria( $w ) ;
		if ( $rs === FALSE)
		{
			show_404( "page" ) ; 
			exit( ) ;
		}
		
		$p = $rs[0]['project_id'] ;
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ; 
		$data['bid_details'] = $rs ;
		$bidder = $this->users_model->get_user_by_id( $rs[0]['user_id'], 'users.username', 'row' )->username ;
		$data['biddername'] = $bidder ;
		$data['sendpm']	= "messages/compose2/$p/$v" ;
		$this->bids_model->update_project_bids( $v, array( 'isopen' => '1' ) ) ;
		$this->layout->buildPage( 'settings/bids/view_bid', $data ) ;
	}
	
	function accept_bid( $bid )  
	{
		$this->bids_model->update_project_bids( $bid, array( 'bid_status' => 'bid accepted' ) ) ;
		$this->session->set_flashdata( 'flash_message', 'You have successfully accepted his bid.' ) ;	
		header('location:' . $_SERVER['HTTP_REFERER']);
		exit ;
	}	
	
	function viewbid( )
	{
		$data['meta_title'] = 'View Bids - CebuFreelancer' ; 
		$project_id = (int)$this->uri->segment( 4 ) ;
		$rs1 = $this->projects_model->get_project_by_id( $project_id ) ;
		if ( $rs1 === FALSE ) {
			show_404( "page" ) ; exit( ) ;
		}		
		$data['project_details'] = $rs1 ;	
		// get the messages
		$this->projects_messages_model->group_by_ = 'from' ;
		$data['messages'] = $this->projects_messages_model->get_project_messages( $project_id, $this->logged_userid ) ;
		$data['bidders'] = $this->bids_model->get_project_bids_by_criteria( array( 'projects.project_id' => $project_id, 'user_id' => $this->logged_userid ), 'bid_id, user_id, message, datebidded, amount, bid_status' ) ;		
		$created_by = $this->users_model->get_user_by_id( $rs1[0]['created_by'] , 'users.username', 'row' )->username ; 
		$this->session->set_userdata( 'return_url_viewbid', $this->uri->uri_string( ) ) ;		
		$data['sendpm']	= "messages/compose/$project_id/$created_by" ;	
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;
		$this->layout->buildPage( 'settings/projects/viewbid', $data ) ; 
	}
	
	function delete_bid( $bid_id ) 
	{
		$w = array( 'bid_id' => $bid_id, 'user_id' => $this->logged_userid ) ;
		$rs = $this->bids_model->get_project_bids_by_criteria( $w ) ;
		if ( $rs === FALSE ) {
			show_404( 'page' ) ; exit ;
	    }
		$this->session->set_flashdata( 'flash_message', 'Successfully delete bid.' ) ;
		$this->bids_model->delete_bid( $bid_id ) ;
		$return_url = $this->session->userdata( 'return_url_viewbid' ) ;
		redirect( $return_url ) ; exit ;
	}	
	
	// --------------------- Project subscription ----------------------------- 	
	function manage_subscriptions( )
	{
		$res = $this->user_subscriptions_model->get_user_subscriptions( array( 'user_id' => $this->logged_userid ) ) ;
		$data['meta_title'] = 'Manage Subscriptions - CebuFreelancer' ; 
		$data['project_posting_notification'] = isset( $res[0]['project_posting_notification'] ) && ( $res[0]['project_posting_notification'] == 1 ) ? TRUE : FALSE;
		$data['newsletter_notification'] = isset( $res[0]['newsletter_notification'] ) && ( $res[0]['newsletter_notification'] == 1 ) ? TRUE : FALSE;
		$data['flash_message'] = $this->session->flashdata( 'flash_message' );
		$data['flashb'] = $this->session->flashdata( 'flashb' );
		$data['project_categories'] = $this->categories_model->get_all_categories( ) ; 		
		$data['user_category_subscriptions'] = $this->user_category_subscriptions_model->get_user_category_subscriptions( $this->logged_userid, 'category_id' );
		if ( $this->input->post( 'update' ) )
		{
			$pp_notification = $this->input->post( 'project_posting_notification' );
			$nl_notification = $this->input->post( 'newsletter_notification' );
			$categories = $this->input->post( 'category', TRUE ); 
			$this->db->where( 'user_id', $this->logged_userid ) ;
			// if the user wants to receive project notifications
			if ( !empty( $pp_notification ) )
			{
				$res = $this->db->get( 'user_category_subscriptions' ) ;
				if ( $res->num_rows() > 0 )
				{
					// delete the previous subscriptions and it is very UGLY!!! 
					$this->user_category_subscriptions_model->delete_user_category_subscriptions( $this->logged_userid );
				}			
				if( $categories )
				{
					$n = count( $categories );
					for ( $i=0; $i<$n; $i++ )
					{
						$this->user_category_subscriptions_model->insert_user_category_subscriptions( array( 'user_id' => $this->logged_userid, 'category_id' => (int)$categories[$i] ) ) ;    
					}
				}
				else
				{
					$this->session->set_flashdata( 'flash_message', 'Please select at least 1 project category notifications.' );
					$this->session->set_flashdata( 'flashb', 'red' );
					redirect( 'settings/projects/manage_subscriptions' );
					exit;
				}
			}
			$res = $this->user_subscriptions_model->get_user_subscriptions( array( 'user_id' => $this->logged_userid ) ) ;
			$update = FALSE;
			if ( $res )
			{
				$data2 = array( 
					'project_posting_notification' => !empty($pp_notification) ? 1 : 0 ,
					'newsletter_notification' => !empty($nl_notification) ? 1 : 0
				) ;
				$this->user_subscriptions_model->update_user_subscriptions( $this->logged_userid, $data2 ) ;
				$update = TRUE;
			}
			else
			{
				$data2 = array( 
					'user_id' => $this->logged_userid,
					'project_posting_notification' => !empty($pp_notification) ? 1 : 0 ,
					'newsletter_notification' => !empty($nl_notification) ? 1 : 0
				) ;
				$this->user_subscriptions_model->insert_user_subscriptions( $data2 ) ;
				$update = TRUE;
			}			
			$this->session->set_flashdata( 'flash_message', 'Successfully update subscriptions.' );
		}
		
		if ( isset($update)) redirect( 'settings/projects/manage_subscriptions' );
		$this->layout->buildPage( 'settings/manage_subscriptions/index' , $data ) ;	
	}
	
	// --------------------- Profile ----------------------------- 	
	function editprofile( )
	{
		$this->load->library( 'form_validation' );
		$this->load->library( 'upload' );
		$data['meta_title'] = 'Edit Profile - CebuFreelancer' ; 
		$data['upload_path'] = $this->layout->getSetting('base_upload_path_avatar');

			
		$this->session->set_userdata( 'action_error', 'You need to login first to continue the process.' ) ;		
		$this->load->view(  'custom_validations/profile_validations'  ) ;

		if (isset($_POST['update']))
		{
			$month 	= $this->input->post('month');
			$day 	= $this->input->post('day');
			$year 	= $this->input->post('year');
			
			$tmp_user = array(
				'email' 		=> $this->input->post('email'),
			);
			
			$tmp_user_profile = array(
				'fullname' 		=> $this->input->post('fullname')
			);
			$error = false;
			if ( $this->form_validation->run() === FALSE )
			{
				// $data['post_data'] = array_merge($tmp_user, $tmp_user_profile);
				$data['post_data'] = $tmp_user;
				$data['flash_message'] = '<b>Please correct the following errors below.</b><br /><br />' . validation_errors();
				$data['flashb'] = 'red' ;
				$this->layout->buildPage( 'settings/profile/editprofile', $data  ) ;
			}
			else
			{
				if (!empty($_FILES['photo']['name'])) {
					$upload = $this->upload->call_upload(array('type' => 'avatar', 'resize' => true, 'overwrite' => true, 'resize_width' => 160, 'resize_height' => 160));
					if (isset($upload['error'])) {
						$data['flash_message'] = "<b>Please correct the following errors below.</b><br /><br />". $upload['error'];
						$data['flashb'] = 'red';
						$error = true;
					}
				}
				
				if ( ! $error ) {
					if (isset($upload['upload_data'])) {
						$tmpPic['profile_pic'] = $this->upload->file_name;
						$this->user_profile_model->update_profile_photo( $this->logged_userid, $tmpPic) ;
					}
					
					if ($_POST['socialmedia']) {
						$tmp_socialmedia = array(
							'facebook_account'     => $_POST['socialmedia']['facebook_account'],
							'linkedin_account'     => $_POST['socialmedia']['linkedin_account'],
							'twitter_account'      => $_POST['socialmedia']['twitter_account'],
							'user_id'              => $this->logged_userid
						);
					}
					$this->users_model->update_user( $this->logged_userid, $tmp_user ) ; 
					$this->user_profile_model->save_profile( $this->logged_userid, array('profile' => $tmp_user_profile)); 
					
					$res = $this->users_model->get_user_by_id( $this->logged_userid ) ;
					if ($_POST['socialmedia']) {
						$this->user_social_media_accounts_model->save($tmp_socialmedia) ;
					}
					$user_details = $this->users_model->get_user_by_id( $this->logged_userid ) ;
					$data['user_details'] = $user_details ;							
					$data['post_data'] = $tmp_socialmedia;
					$data['user_social_media_account'] = $this->user_social_media_accounts_model->get_by_user_id($this->logged_userid);
					$data['flash_message'] = 'Successfully update profile.' ;
					$data['flashb'] = 'green' ;				
				}
				
				$this->layout->buildPage( 'settings/profile/editprofile', $data  ) ;
			}						
		}
		else
		{		
			$res = $this->users_model->get_user_by_id( $this->logged_userid ) ;		
			$data['user_details'] = $res ;
			
			$upload_path_avatar = $this->layout->getSetting('upload_path_avatar');
			$live_path_avatar = $this->layout->getSetting('live_path_avatar');
			$data['upload_path_avatar'] = $upload_path_avatar;
			$data['live_path_avatar'] = $live_path_avatar;
			$data['profile_pic'] = (file_exists($upload_path_avatar.$res[0]['up_profile_pic']) && is_file($upload_path_avatar.$res[0]['up_profile_pic'])) ? $live_path_avatar.$res[0]['up_profile_pic'] : $live_path_avatar.'default.png';
		
			$data['user_social_media_account'] = $this->user_social_media_accounts_model->get_by_user_id($this->logged_userid);
			$this->layout->buildPage( 'settings/profile/editprofile' , $data ) ;
		}
	}
	
	function do_resize($image)
	{
		$uploadConfig['image_library'] = 'gd2';
		$uploadConfig['source_image'] = $this->layout->getSetting('upload_path_portfolio').$image;
		$uploadConfig['create_thumb'] = TRUE;
		$uploadConfig['maintain_ratio'] = TRUE;
		$uploadConfig['width'] = 75;
		$uploadConfig['height'] = 50;
		$this->load->library('image_lib', $uploadConfig);

		if ( ! $this->image_lib->resize())
		{
			$error = array('error' => $this->image_lib->display_errors());
			return $error;                    
		}
	}
	
	function do_upload()
	{
		$config['upload_path'] = $this->layout->getSetting('upload_path_avatar');
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->load->library('upload', $config);
                
		if ( ! $this->upload->do_upload('photo'))
		{
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			return $data;
		}
	}
	
	function changepassword( )
	{
		$data['meta_title'] = 'Change Password - CebuFreelancer' ; 
		if ( $this->input->post( 'changepw' ) )
		{
			$rules['oldpw'] = 'trim|required' ;
			$rules['newpw'] = 'trim|required|matches[newpw2]' ;
			$fields['newpw'] = 'new password' ;
			$fields['oldpw'] = 'old password' ;
			$fields['newpw2'] = 'retyped new password' ;
			$this->validation->set_rules( $rules ) ;
			$this->validation->set_fields( $fields ) ; 
			if ( $this->validation->run( ) === FALSE )
			{
				$this->session->set_flashdata( 'flash_message' , "<b>Please correct the following errors below.</b><br /><br />" . $this->validation->error_string ) ; 
				$this->session->set_flashdata( 'flashb', 'red' ) ;
				redirect( 'settings/profile/changepassword' ) ; exit ;
			}
			else
			{
				$curpw = $this->users_model->get_user_by_where( array( 'id' => $this->logged_userid ) , 'id, password' )->password ;
				if ( $curpw !== $this->input->post( 'oldpw' ) )
				{
					$this->session->set_flashdata( 'flash_message' , 'Old password is invalid.' ) ; 
					$this->session->set_flashdata( 'flashb', 'red' ) ;
					redirect( 'settings/profile/changepassword' ) ; exit ;
				}
				else
				{
					$this->users_model->update_user( $this->logged_userid, array( 'password' => $this->input->post( 'newpw' ) ) ) ;
					$this->session->set_flashdata( 'flash_message' , 'Successfully change password.' ) ; 
					redirect( 'settings/profile/changepassword' ) ; exit ;
				}
			}
		}
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;
		$data['flashb'] = $this->session->flashdata( 'flashb' ) ;
		$this->layout->buildPage( 'settings/profile/changepassword' ,$data ) ;	
	}
	
}
	
	
