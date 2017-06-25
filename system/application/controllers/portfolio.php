<?php 
class Portfolio extends Controller {
    function __construct( ) {
        parent::Controller( ) ;
        $this->load->config( 'link_pagination' ) ;
        $this->load->helper( 'bday' ) ; 
        $this->load->helper( 'flash' ) ;
        $this->load->helper( 'utils' ) ;
        $this->load->library( 'pagination' ) ;
        $this->load->library( 'validation' ) ; 
        $this->load->model( 'users_portfolio_model' ) ;
        $this->load->model( 'users_model' ) ;
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
    
    function form($id=0) {
	    $error = false;
        $data['form_title'] = (!empty($id)) ? 'Edit portfolio' : 'Add portfolio';
		$rules['portfolio[title]'] = 'trim|required' ;
		$rules['portfolio[content]'] = 'trim|required' ;
		$rules['photo'] = 'callback_check_num_photos' ;
		$this->validation->set_rules( $rules ) ;
		$fields['portfolio[title]'] = 'title' ;
		$fields['portfolio[content]'] = 'description' ;
		$this->validation->set_fields( $fields ) ;
		$data['id'] = $id;
		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flashb'] = $this->session->flashdata('flashb');
		$data['upload_path'] = $this->layout->getSetting('base_upload_path_portfolio'); 
		$data['upload_dir_path'] = $this->layout->getSetting('upload_path_portfolio'); 
		
		$purifyconfig = HTMLPurifier_Config::createDefault();
		$purifyconfig->set('HTML.Allowed', '');
		$data['purifyconfig'] = $purifyconfig;
		$data['numphotos'] = $this->users_portfolio_model->check_num_photos($id, 9);

		if (isset($_POST['preview'])) {
			if ($this->validation->run() === false) {
				$data['flash_message'] = "<b>Please correct the following errors below.</b><br /><br />". $this->validation->error_string ;
				$data['flashb'] = 'red' ;
				$error = true;
			}
			else
			{
				if (!empty($_FILES['photo']['name'])) {
				    $this->load->library( 'upload' ) ;
					$upload = $this->upload->call_upload(array('type' => 'portfolio', 'resize' => true, 'resize_width' => 800, 'resize_height' => 600));
					if (isset($upload['error'])) {
						$data['flash_message'] = "<b>Please correct the following errors below.</b><br /><br />". $upload['error'];
						$data['flashb'] = 'red' ;
						$error = true;
					}
				}
 
				if (!$error) {
					$postdata = array(
						'id'				=> $id,
						'portfolio'			=> 	$this->input->post('portfolio', true),
					);	
					if (isset($upload['upload_data'])) {
						$postdata['filename'] = $this->upload->file_name;
					}
					$this->users_portfolio_model->user_id = $this->logged_userid;
					$this->users_portfolio_model->save_portfolio($postdata);
					$this->session->set_flashdata( 'flash_message', 'Successfully saved.' );  
					
					redirect('portfolio/form/' . $id);	
				}
 
			}
		}
		$data['portfolio_data'] = $this->users_portfolio_model->get_portfolio_by_id(array('user_id' => $this->logged_userid, 'id' => $id));
        $this->layout->buildPage('portfolio/form', $data ) ;
    }
    
	function check_num_photos($n)
	{
		if ($_FILES && $_FILES['photo']['name'] != '') {
			$id = $this->input->post('portfolio[id]');
			if ($this->users_portfolio_model->check_num_photos($id, 9) !== false) {
				$this->validation->set_message('check_num_photos', 'You can upload up to 5 photos only.');
				return false;			
			}
			
			return true;
		}
	}
	
    function browse() {
		$data['flashb'] = $this->session->flashdata( 'flashb' ) ; 
		$data['flash_message'] = $this->session->flashdata( 'flash_message' ) ;
		$res = $this->users_portfolio_model->get_portfolio($this->logged_userid);
		$data['portfolio_data'] = $res;
		$data['upload_path'] = $this->layout->getSetting('upload_path');    	
    	$this->layout->buildPage('portfolio/browse', $data);
    }
    
    function delete(){
		redirect('resume/edit');
    }
	
	function do_upload()
	{
		$config['upload_path'] = $this->layout->getSetting('upload_path_portfolio');
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
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

	function doaction( )
	{
		$act = $this->uri->segment( 3 ) ;
		if ( $act == '1' ) {
			$this->_delete( ) ;
		}	
		else {
			show_404( 'page' ) ; exit ;
		}
	}
	
	function deletephoto()
	{
		$u        = $this->uri->uri_to_assoc(1);
		$id		  = $u['id'];
		$p		  = $u['p'];
		$hash_id  = $u['token'];
	
		$res = $this->users_portfolio_model->check_photo_owner(array('user_id' => $this->logged_userid, 'user_portfolio_id' => $p, 'id' => $id, 'hash_id' => $hash_id));
		if ($res) {
			$this->session->set_flashdata( 'flashb', 'green' );
			$this->session->set_flashdata( 'flash_message', 'Successfully delete the photo') ; 	
		
			$this->users_portfolio_model->delete_photo_by_id($id);
			$this->users_portfolio_model->delete_photo($res);
		} else {
			$this->session->set_flashdata( 'flashb', 'red' )  ;
			$this->session->set_flashdata( 'flash_message', 'Error in deleting the photo.' ) ; 		
		}
        redirect("portfolio/form/$p");
	}
	
    //-----------------------  Private functions  ---------------------------------------
	function _delete( )
	{
		$success_delete = FALSE;
		$chk = $this->input->post( 'chk' ) ;
		if ($_POST['boxchecked'] > 0) {
			$success_delete = $this->users_portfolio_model->delete_by_ids( array_values($chk), $this->logged_userid);
			if ( $success_delete ) 
			{
				$this->session->set_flashdata( 'flashb', 'green' );
				$this->session->set_flashdata( 'flash_message', 'Successfully delete message(s). ' ) ; 
			}		
		}  
		else {
			$this->session->set_flashdata( 'flashb', 'red' )  ;
			$this->session->set_flashdata( 'flash_message', 'Please select a message to delete.' ) ; 
		}
		redirect('portfolio/browse' );
	}	
}

