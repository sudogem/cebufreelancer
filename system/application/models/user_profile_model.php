<?php

class User_profile_model extends Model {
	function User_profile_model() {
		parent::Model();
		$this->ci =& get_instance();
		$this->load->config( 'link_pagination' );
		$this->load->library('datafilter');
		$this->load->library( 'pagination' ) ;
		$this->load->model( 'users_model' ) ;
		$this->_tuser = 'users' ;
		$this->_tuser_profile = 'user_profile' ;		
	}
	
	function is_user_profile_exist($user_id) {
		$this->db->where(array('user_profile.user_id' => $user_id));
		$res = $this->db->get($this->_tuser_profile);
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ; 
		return FALSE ;
	}

   function get_user_by_where( $w, $fields = 'id, fullname', $result_type = 'row' ) {
        ($fields != NULL ) ? $this->db->select( $fields ) : '*' ;
        $this->db->where( $w ) ;
        $res = $this->db->get( $this->_tuser_profile ) ;
        if ( $res->num_rows( ) > 0 )
            return $res->{$result_type}( ) ;
        else
            return FALSE ;
    }
	
	function save_profile($user_id, $data) {
		$this->db->where(array('user_id' => $user_id) );
		$res = $this->db->get($this->_tuser_profile); 
		$user_profile = $res->row();
		$data = $this->datafilter->clean($data);
		
		if ($user_profile) {
			$tmpbirthday= explode('-', $user_profile->birthday);
		}
		

		$year 		= isset($data['profile']['year']) ? $data['profile']['year'] : (isset($tmpbirthday[0]) ? $tmpbirthday[0] : '') ;
		$month 		= isset($data['profile']['month']) ? $data['profile']['month'] : (isset($tmpbirthday[1]) ? $tmpbirthday[1] : '') ;
		$day 		= isset($data['profile']['day']) ? $data['profile']['day'] : (isset($tmpbirthday[2]) ? $tmpbirthday[2] : '')  ;
		
		$tmp_profile = array(
					'birthday' 		=> $year . '-' . $month . '-' . $day, 
					'city' 			=> isset($data['profile']['city']) ? $data['profile']['city'] : (isset($user_profile->city) ? $user_profile->city : '') ,
					'company' 		=> isset($data['profile']['company']) ? $data['profile']['company'] : (isset($user_profile->company) ? $user_profile->company : '') , 
					'contactno' 	=> isset($data['profile']['contactno']) ? $data['profile']['contactno'] : (isset($user_profile->contactno) ? $user_profile->contactno : ''),
					'email' 	    => isset($data['profile']['email']) ? $data['profile']['email'] : (isset($user_profile->email) ? $user_profile->email : '') , 
					'fullname' 		=> isset($data['profile']['fullname']) ? $data['profile']['fullname'] : (isset($user_profile->fullname) ? $user_profile->fullname : '') , 
					'gender' 		=> isset($data['profile']['gender']) ? $data['profile']['gender'] : (isset($user_profile->gender) ? $user_profile->gender : '') , 
					'interests' 	=> isset($data['profile']['interests']) ? $data['profile']['interests'] : (isset($user_profile->interests) ? $user_profile->interests : '') , 
					'jobtitle' 		=> isset($data['profile']['jobtitle']) ? $data['profile']['jobtitle'] : (isset($user_profile->jobtitle) ? $user_profile->jobtitle : '') ,
					'job_objective' => isset($data['profile']['job_objective']) ? $data['profile']['job_objective'] : (isset($user_profile->job_objective) ? $user_profile->job_objective : '') ,
					'location' 		=> isset($data['profile']['location']) ? $data['profile']['location'] : (isset($user_profile->location) ? $user_profile->location : '') , 
					'postalcode' 	=> isset($data['profile']['postalcode']) ? $data['profile']['postalcode'] : (isset($user_profile->postalcode) ? $user_profile->postalcode : '') , 
					'specialties' 	=> isset($data['profile']['specialties']) ? $data['profile']['specialties'] : (isset($user_profile->specialties) ? $user_profile->specialties : '') ,
					'state' 		=> isset($data['profile']['state']) ? $data['profile']['state'] : (isset($user_profile->state) ? $user_profile->state : '') ,
					'website' 		=> isset($data['profile']['website']) ? $data['profile']['website'] : (isset($user_profile->website) ? $user_profile->website : '')
				     );
		
		// $tmp_profile = $this->datafilter->clean($tmp_profile);
		
		if ($res->num_rows() > 0) {
			$this->db->where('user_id', $user_id);
			$this->db->update($this->_tuser_profile, $tmp_profile); 
		}
		else {
			$tmp_profile['user_id'] = $user_id;
			$this->db->insert($this->_tuser_profile, $tmp_profile);	
		}
	}
	
	function update_profile_photo($user_id, $data) {
		if (isset($data['profile_pic'])) {
			$profile_pic = $data['profile_pic'];
			$photo = $this->has_photo($user_id); //upload 1 photo, removed previous photo
			if ($photo) {
				$this->delete_photo($photo->profile_pic);
				$this->db->where('user_id', $user_id);
				$this->db->update($this->_tuser_profile, array('profile_pic' => $profile_pic)); 				
			} else {
				$tmp_profile = array('user_id' => $user_id, 'profile_pic' => $profile_pic);
				$this->db->insert($this->_tuser_profile, $tmp_profile);				
			}
		}	
	}

	function has_photo($user_id) {
		$this->db->where(array('user_id' => $user_id));
		$res = $this->db->get($this->_tuser_profile)->row(); 
		return $res;
	}
	
	function delete_photo($filename) {
		if ($filename) {
			$upload = $this->layout->getSetting('upload_path_avatar');
			@unlink($upload.$filename);
		}
	}	
}