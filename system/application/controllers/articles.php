<?php
	
	class Articles extends Controller 
	{
	
	    function __construct( ) 
	    {
	        parent::Controller( );
			$this->load->library( 'pagination' ) ;
			$this->assets_images = base_url()  . $this->config->config['layout']['assets_folder'] . '/' . $this->config->config['layout']['views_folder'] . '/' . $this->config->config['layout']['assets_images'] . '/' ; 					

			$rs = $this->users_model->get_user_by_hash( $this->session->userdata( 'hash_id' ), 'hash_id, id, username', 'result_array' ) ;
			if ( $rs ) {
				$this->logged_userid 	= $rs[0]['id'] ;
				$this->logged_username 	= $rs[0]['username'] ; 
			}			
	    }
	
	    function index() 
	    {
			$this->load->library('simplepie');
			$link = array( 
				'http://feeds.feedburner.com/freelancefolder', 
				'http://feeds.feedburner.com/FreelanceSwitch' 
			);
			$feed = new SimplePie();
			$feed->set_feed_url($link);
			$feed->enable_cache(false);
			$data['feed_result'] = $feed->init( );
			$feed->handle_content_type();	  
			$data['feed'] = $feed ;
			//print_r( $feed ) ;
			$p = $this->uri->segment( 3 ) ;
			$data['start'] = ( !empty( $p ) ) ? $p : 0 ;
			$config['base_url'] =  site_url( ) . '/articles/index' ; 
			$config['total_rows'] = count( $feed->get_items() ) ; 
			$config['per_page'] =  1 ;
			$this->pagination->initialize( $config ) ;
			$data['links'] = $this->pagination->create_links( ) ; 	
			$data['per_page'] = $config['per_page'] ;
			$this->layout->buildPage('articles/index', $data) ;
	    }
		

		
	}

?>