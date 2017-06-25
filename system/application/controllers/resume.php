<?php 
class Resume extends Controller {
    function __construct( ) {
        parent::Controller( ) ;
        $this->load->config( 'link_pagination' ) ;
        $this->load->helper( 'bday' ) ;
        $this->load->helper( 'date' ) ;
        $this->load->helper( 'flash' ) ; 
        $this->load->library( 'pagination' ) ;
        $this->load->library( 'validation' ) ; 
        $this->load->library( 'form_validation' );
        $this->load->model( 'users_resume_model' ) ;
                if ( $this->site_sentry->is_logged_in( ) === FALSE )  
                {		
                        $this->session->set_userdata( 'return_url', $this->uri->uri_string( ) ) ;		
                        $this->session->set_userdata( 'action_error', 'Please login to access the page.' ) ;		
                        redirect( 'login/' ) ; 
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
	}
    
    function edit() {
      $month = $this->input->post( 'month', TRUE ) ;
      $day = $this->input->post( 'day', TRUE ) ; 
      $year = $this->input->post( 'year', TRUE )  ;
      
      $this->load->view('custom_validations/resume_validations');
      $purifyconfig = HTMLPurifier_Config::createDefault();
      $purifyconfig->set('HTML.Allowed', '');
      $data['purifyconfig'] = $purifyconfig;		
      
        if (isset($_POST['submit'])) {
			$tmpdata = array(
			  'profile'		          => $this->input->post('profile' ),
			  'workexperience'	      => $this->input->post('workexperience' ),
			  'newworkexperience'	  => $this->input->post('newworkexperience' ),
			  'education'		      => $this->input->post('education' ),
			  'references'		      => $this->input->post('references' )
			);
 
        $data['resume'] = $this->users_resume_model->get_resume($this->logged_userid); 
        $error = false;
        if ( $this->form_validation->run() === FALSE )
        {
          $data['flash_message'] = '<b>Please correct the following errors below.</b><br /><br />' . validation_errors();
          $data['flashb'] = 'red' ;
          $this->layout->buildPage( 'resume/index', $data  ) ;
        }
        else 
        {
          $this->users_resume_model->user_id = $this->logged_userid;
          $this->users_resume_model->save_resume($tmpdata);
          $this->session->set_flashdata( 'flash_message', 'Successfully saved. ' );  
          redirect('resume/edit');			
        }
      }
      else {
        $data['resume'] = $this->users_resume_model->get_resume($this->logged_userid); 
        $data['flash_message'] = $this->session->flashdata('flash_message');
        $data['flashb'] = 'green' ;			
        $this->layout->buildPage('resume/index', $data ) ;    
      } 
    }
    
    function delete() {
			$u        	= $this->uri->uri_to_assoc(1);
			$id		  	= $u['id'];
			$type	  	= $u['type'];			
    	    $type 		= strtolower($type);
    	    $type_data 	= array('work', 'education', 'references');
			
    	    if (!in_array($type, $type_data)) show_404();
    	    if ($type == 'work') {
    	    	    $this->users_resume_model->delete_workexperience(array('id' => $id, 'user_id' => $this->logged_userid));
    	    }
    	    
    	    if ($type == 'education') {
    	    	    $this->users_resume_model->delete_school(array('id' => $id, 'user_id' => $this->logged_userid));
    	    }

    	    if ($type == 'references') {
    	    	    $this->users_resume_model->delete_references(array('id' => $id, 'user_id' => $this->logged_userid));
    	    }    	    
			$this->session->set_flashdata( 'flash_message', 'Successfully deleted. ' );  
			redirect('resume/edit');
    }
}

