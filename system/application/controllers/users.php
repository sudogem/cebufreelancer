<?php

class Users extends Controller {
    function __construct( ) {
        parent::Controller( ) ;
        $this->load->config( 'link_pagination' ) ;
        $this->load->library( 'pagination' ) ;
		$this->load->library('HTMLPurifier') ;
        $this->load->helper( 'bday' ) ;
		$this->load->helper( 'flash' ) ; 
		$this->load->helper( 'string' ) ;
		$this->load->plugin( 'captcha' ) ;
        $this->load->model( 'users_model' ) ;
        $this->load->model( 'user_profile_model' ) ;
        $this->load->model( 'user_social_media_accounts_model' ) ;
        $this->load->model( 'users_resume_model' ) ;
        $this->load->model( 'projects_messages_model' ) ;
        $this->load->model( 'users_portfolio_model' ) ;
        $this->load->model( 'bids_model' ) ;
        $this->freelancers_per_page['freelancers_per_page'] = $this->config->item( 'freelancers_per_page' ) ;
        $this->portfolio_per_page = $this->config->item( 'portfolio_per_page' ) ;        
        $rs1 = $this->users_model->get_user_by_hash( $this->session->userdata( 'hash_id' ), 'hash_id, id, username, email', 'result_array' ) ;
        if ( $rs1 ) {
			$this->logged_userid 	= $rs1[0]['id'] ;
			$this->logged_username 	= $rs1[0]['username'] ;
			$this->logged_email 	= $rs1[0]['email'] ;
		}
		
		$this->purifyconfig = HTMLPurifier_Config::createDefault();
		$this->purifyconfig->set('HTML.Allowed', '');
		$this->emptySearchdata = array(
								'fullname'		=> '',
								'username'		=> '',
								'specialties'	=> '',
								'jobtitle'		=> '',
								'search'		=> ''
		);
		
		$this->font_path = './fonts/ahbg.ttf';
    }

    function index( ) {
        $this->browse( );
    }

    function browse( ) {
		$this->session->unset_userdata($this->emptySearchdata);	// remove old sess
		
        $res = $this->users_model->get_all_freelancers( NULL, NULL, NULL ) ;
        $cur_offset = ( $this->uri->segment(3)!= '' ) ? (int)$this->uri->segment(3) : '' ;
        $config['base_url'] =  site_url( ) . '/users/browse' ;
        $config['total_rows'] = count( $res ) ;
        $config['per_page'] = $this->freelancers_per_page['freelancers_per_page'] ;
        $tmpcur_offset = (empty($cur_offset)) ? 0 : $config['per_page'];
        $limit = array( 'start' => $config['per_page'], 'end' => ($config['per_page'] * $cur_offset) - $tmpcur_offset);
        $this->pagination->initialize( $config ) ;
        $data['links'] = $this->pagination->create_links( ) ;
        // $data['all_freelancers'] = $this->users_model->get_all_freelancers( NULL, $limit, NULL ) ;
        $data['all_freelancers'] = $this->users_model->get_all_users( NULL, $limit) ;
        #$data['init_js'] = array('jquery-1.2.3.min.js') ;
        $data['extra_js'] = array('colorbox/jquery.colorbox.js') ; 
		$data['purifyconfig'] = $this->purifyconfig;
        $this->layout->buildPage('users/index', $data ) ;
    }

    function view()
    {
        $username = strtolower($this->uri->segment(2));
        $user = $this->users_model->get_user_by_where( array('username' => $username), '*');
		if (!$user) show_404();
		$userprofile = $this->users_resume_model->get_profile($user->id);  
        $workexperience = $this->users_resume_model->get_workexperience($user->id);
        $education = $this->users_resume_model->get_education($user->id);
		$references = $this->users_resume_model->get_references($user->id);
		$this->purifyconfig = HTMLPurifier_Config::createDefault();
		$this->purifyconfig->set('HTML.Allowed', 'b, strong, p, br');
		$data['purifyconfig'] = $this->purifyconfig;				
        $data['extra_js'] = array('colorbox/jquery.colorbox.js') ;       
		$data['upload_path'] = $this->layout->getSetting('upload_path');
		$data['upload_path_avatar'] = $this->layout->getSetting('upload_path_avatar');
		$data['live_path_avatar'] = $this->layout->getSetting('live_path_avatar');
        $data['username'] = $user->username;
		$data['menu_resume'] = true;
        $data['fullname'] = ucwords($userprofile[0]['up_fullname']);
        $data['profile'] = $userprofile[0];
        $data['workexperience'] = $workexperience;
        $data['education'] = $education;
        $data['references'] = $references;
		
		// $data['meta_title'] = ucwords($userprofile[0]['up_fullname']) . ', ' . $userprofile[0]['up_jobtitle'] ;
		$jobtitle = !empty($userprofile[0]['up_jobtitle']) ? ', '. $userprofile[0]['up_jobtitle'] : '';
		$data['meta_title'] = ucwords($userprofile[0]['up_fullname']) . $jobtitle;
        $this->layout->buildPage('users/view', $data ) ;
    }
    
	function about()
	{
		
	}
	
    function portfolio()
    {
		$username = strtolower($this->uri->segment(2));
		$user = $this->users_model->get_user_by_where( array('username' => $username), 'id, username' );
		if (!$user) show_404();
		$userprofile = $this->users_resume_model->get_profile($user->id);  
		$data['username'] = $user->username;
		$data['menu_portfolio'] = true;		
		$res = $this->users_portfolio_model->get_portfolio($user->id);
		$data['portfolio_data'] = $res;
		$photos = array();
		foreach($res['result'] as $idx => $row) {
			$photos[$row['id']] = $this->users_portfolio_model->get_portfolio_photos_by_user($row['id']);
		}
		$data['portfolio_photodata'] = $photos;
		$data['upload_path'] = $this->layout->getSetting('base_upload_path_portfolio'); 
		$data['upload_dir_path'] = $this->layout->getSetting('upload_path_portfolio'); 
		$data['live_path_portfolio'] = $this->layout->getSetting('live_path_portfolio');
		$data['meta_title'] = ucwords($userprofile[0]['up_fullname']) . ', ' . $userprofile[0]['up_jobtitle'];
		$this->layout->buildPage('users/portfolio', $data );  
    }

	function andFunc($n) {
		$isEmpty = !empty($n) ? false : true;
		return $isEmpty;
	}
    
	function socialmedia()
	{
		$username = strtolower($this->uri->segment(2));
		$user = $this->users_model->get_user_by_where( array('username' => $username), 'id, username' );	
		if (!$user) show_404();
		$data['username'] = $user->username;
		$userprofile = $this->users_resume_model->get_profile($user->id);  
		$tmpsocialmedia = $this->user_social_media_accounts_model->get_by_user_id($this->logged_userid);
		$user_social_media_account = isset($tmpsocialmedia[0]) ? $tmpsocialmedia[0] : '';
		$data['menu_socialmedia'] = true;
		$data['assets_path'] = $this->layout->getSetting('assets_url'); 
		$tmp = array(
			'facebook_account' 	    => !empty($user_social_media_account['facebook_account']) ? $user_social_media_account['facebook_account'] : '',
			'linkedin_account' 		=> !empty($user_social_media_account['linkedin_account']) ? $user_social_media_account['linkedin_account'] : '',
			'twitter_account' 		=> !empty($user_social_media_account['twitter_account']) ? $user_social_media_account['twitter_account'] : '',
		);
		$data['user_social_media_account'] = $tmp;
		
		$data['meta_title'] = ucwords($userprofile[0]['up_fullname']) . ', ' . $userprofile[0]['up_jobtitle'];
		$this->layout->buildPage('users/socialmedia', $data );  
	}
	
    function testimonial() 
    {
    	$data['res'] = 'testi....';
		$this->layout->buildPage('users/testimonial', $data, 'widget');       
    }
    
    function contact()
    {
		$data = array();
		$username = strtolower($this->uri->segment(2));
		$res = $this->users_model->get_user_by_where( array('username' => $username), 'id, username' );
		$profile = $this->user_profile_model->get_user_by_where(array('user_id' => $res->id), 'fullname, email, contactno, jobtitle' );
		$data['fullname'] = $profile->fullname;
		$data['username'] = $res->username;
		$data['contactinfos'] = array('email' => $profile->email, 'contactno' => $profile->contactno);
		$data['menu_contact'] = true;
		$data['extra_js'] = array('colorbox/jquery.colorbox.js') ;
		
		$data['meta_title'] = ucwords($profile->fullname) . ', ' . $profile->jobtitle;
		$this->layout->buildPage('users/contactview', $data);
    }
	
	function contactform()
	{
		$this->load->library( 'email' ) ;
		$this->load->library( 'form_validation' ) ;
		$this->load->library( 'HTMLPurifier' );
		$this->load->library( 'datafilter' );		
		$this->config->load( 'email' ) ;	
		$username = strtolower($this->uri->segment(2));
		$user = $this->users_model->get_user_by_where( array('username' => $username), 'id, username, email' );
		if ( ! $user ) show_404();
		$user_id = $user->id;
		$email = $user->email;
		$profile = $this->user_profile_model->get_user_by_where( array('user_id' => $user_id), 'id, fullname' );
		$data['fullname'] = $profile->fullname;
		$data['username'] = $user->username;
		$data['captcha_img'] = $this->captcha();
		
		if ($_POST) {
			$this->load->view('custom_validations/contact_validations') ;
			$tmp = array(
				'subject'   	=> $this->input->post('subject'),
				'message'   	=> $this->input->post('message'),
				'from'          => $this->logged_userid,
				'to'            => $user_id,
				'message'       => $this->input->post('message'),
				'dateposted'    => time( ) ,				
			);
			
			$error = false;
			if ( $this->form_validation->run() === FALSE )
			{
				$data['post_data'] = $tmp ;
				$data['flash_message'] = '<b>Please correct the following errors below.</b><br /><br />' . validation_errors();
				$data['flashb'] = 'red' ;
				$this->layout->buildPage('users/contactform', $data, 'widget');
			}
			else
			{
				$this->projects_messages_model->insert_project_message( $tmp ) ; 
				
				$sender = $this->user_profile_model->get_user_by_where( array('user_id' => $this->logged_userid), 'id, fullname');
				$from = explode(' ', $sender->fullname);
				$from = $from[0];
				$msg = $this->datafilter->clean($tmp);
				$subject = "You got a message from ".$sender->fullname . " in CebuFreelancer";
				$this->email->useragent = 'XHTMaiL';
				$this->email->initialize( array( 'mailtype' => 'html', 'charset' => 'utf-8' ) ) ;
				$this->email->subject($subject) ; 
				$this->email->from( $this->config->item( 'mail_nr_fromemail' ), $sender->fullname );
				$this->email->reply_to($email) ;
				$this->email->to($email) ;
				$url_profile = site_url("users/$this->logged_username");
				$url_login = site_url("login");
				$to = explode(' ', $profile->fullname);
				$to = $to[0];
				$msg = "
				Hi $to,
				<br>
				{$msg['message']}
				<br>
				<br>In order to reply this message you need to login first and check the inbox, <a href='$url_login' >click here to login</a>.<br>
                <a href='$url_profile' >Click here to view profile of {$sender->fullname}</a>.<br><br>
				Thanks,
				<br><em>The CebuFreelancer Team</em><br>
				";
				$this->email->message($msg) ;
				$this->email->send( );
				$this->session->set_flashdata( 'flashb', 'green' ) ;
				$this->session->set_flashdata( 'flash_message', 'Successfully send message. ' ) ;
				
				header( 'Location:' . $_SERVER['HTTP_REFERER'] ) ; exit ;
			}			
		}
		else {
			$data['flashb'] = $this->session->flashdata('flashb');
			$data['flash_message'] = $this->session->flashdata('flash_message');
			$this->layout->buildPage('users/contactform', $data, 'widget'); 			
		}	
	}
	
	function s()
	{
		$searchdata = array();
		if (count($_POST) > 0) {
			$searchdata = array(
			'username'		=> $this->input->post('username'),
			'fullname'		=> $this->input->post('fullname'),
			'specialties'	=> $this->input->post('specialties'),
			'jobtitle'		=> $this->input->post('jobtitle'),
			'search'		=> true
			);
			$this->session->set_userdata($searchdata);		
		}
		else {
			if ($this->session->userdata('search')) {
				$searchdata = array(
				'username'		=> $this->session->userdata('username'),
				'fullname'		=> $this->session->userdata('fullname'),
				'specialties'	=> $this->session->userdata('specialties'),
				'jobtitle'		=> $this->session->userdata('jobtitle')
				);			
			}
			else {
				redirect( 'users/' ) ; 
			}
		}
	
		$res = $this->users_model->get_all_users($searchdata);
        $cur_offset = ( $this->uri->segment(3)!= '' ) ? (int)$this->uri->segment(3) : '' ;
        $config['base_url'] =  site_url( ) . '/users/s' ;
        $config['total_rows'] = count( $res ) ;
        $config['per_page'] = $this->freelancers_per_page['freelancers_per_page'] ;
        $tmpcur_offset = (empty($cur_offset)) ? 0 : $config['per_page'];
		
        $limit = array( 'start' => $config['per_page'], 'end' => ($config['per_page'] * $cur_offset) - $tmpcur_offset);
        $this->pagination->initialize( $config ) ;
		$data['links'] = $this->pagination->create_links( );
		
		$res = $this->users_model->get_all_users($searchdata, $limit);
		$data['all_freelancers'] = $res;
		$data['purifyconfig'] = $this->purifyconfig;
		$this->layout->buildPage('users/index', $data ) ;	
	}

	function captcha()
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
		// $data['captcha_img'] = $cap['image']; 
		return $cap['image']; 
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
			$this->form_validation->set_message('captcha_check', 'Verification code is invalid. Please submit the code that appears on the image.' );
			return FALSE ; 
		}
		else
		{
			return TRUE ; 
		}
	}	
}

