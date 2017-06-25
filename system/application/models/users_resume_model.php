<?php

class Users_resume_model extends Model {
	var $user_id;
	function Users_resume_model() {
		parent::Model() ;
		$this->load->helper( 'utils' ) ;
		$this->load->library( 'HTMLPurifier' ) ;
		$this->load->library( 'datafilter' ) ;
		$this->load->model( 'user_profile_model' ) ;
		$this->_tuser = 'users' ;
		$this->_tuser_profile = 'user_profile' ;
		$this->_tuser_education = 'user_education' ;
		$this->_tuser_workexperience = 'user_workexperience' ;
		$this->_tuser_reference = 'user_references' ;
		$this->_tuser_resume = 'user_resume' ;
		
	}
	
	function get_resume($user_id) {
		$data = array(
			'profile'			=> $this->get_profile($user_id),
			'education'			=> $this->get_education($user_id),
			'workexperience'	=> $this->get_workexperience($user_id),
			'references'		=> $this->get_references($user_id)
		);
		
		return $data;
	}
	
	function get_profile($user_id) {
		$q="users.id, users.hash_id, users.email,
		    user_profile.company as up_company, user_profile.location as ulocation, 
			user_profile.gender as up_gender, user_profile.fullname as up_fullname, user_profile.specialties as uspecialties,
			user_profile.aboutme as up_aboutme, user_profile.birthday as up_birthday, user_profile.email as up_email, user_profile.jobtitle as up_jobtitle,
			user_profile.job_objective as up_job_objective, user_profile.interests as up_interests, user_profile.location as up_location,
			user_profile.city as up_city, user_profile.state as up_state, user_profile.postalcode as up_postalcode, user_profile.specialties as up_specialties,
			user_profile.website as up_website, user_profile.contactno as up_contactno, user_profile.profile_pic as up_profile_pic,
			";
		$this->db->select($q);
		$this->db->where(array('users.id' => $user_id));
		$this->db->join('user_profile', 'user_profile.user_id = users.id', 'left');
		$res = $this->db->get($this->_tuser);
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ; 
		return FALSE ;
	}
	
	function get_workexperience($user_id) {
		$this->db->where(array('user_workexperience.user_id' => $user_id) );
		$this->db->order_by('weight', 'asc');
		$res = $this->db->get($this->_tuser_workexperience);
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ; 
		return FALSE ;		
	}

	function get_references($user_id) {
		$this->db->where(array('user_references.user_id' => $user_id) );
		$res = $this->db->get($this->_tuser_reference);
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ; 
		return FALSE ;		
	}
	
	function get_education($user_id) {
		$this->db->where(array('user_education.user_id' => $user_id) );
		$this->db->order_by('id', 'ASC');
		$res = $this->db->get($this->_tuser_education);
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ; 
		return FALSE ;		
	}

	function save_resume($data) {
		$user_id = ($this->user_id) ? $this->user_id : 0;
		$this->db->select('id');
		$this->db->where(array('id' => $user_id) );
		$res = $this->db->get($this->_tuser); 
		
		$this->db->trans_start();
		$this->user_profile_model->save_profile($user_id, $data);

		$tmpbegindate = $tmpenddate = array();
		$n = count($data['education']['begindate']['month']);
		for($j=0; $j < $n; $j++) {
			$month 				= $data['education']['begindate']['month'][$j];
			$year 				= $data['education']['begindate']['year'][$j];
			$tmpbegindate[$j]  	= "$month-$year";
			
			$month 				= $data['education']['enddate']['month'][$j];
			$year 				= $data['education']['enddate']['year'][$j];
			$tmpenddate[$j]  	= "$month-$year";
		}

		unset($data['education']['begindate']['month']);
		unset($data['education']['begindate']['year']);
		unset($data['education']['enddate']['month']);
		unset($data['education']['enddate']['year']);			
		
		for($j=0; $j < $n; $j++) {
			$data['education']['begindate'][$j] = $tmpbegindate[$j];
			$data['education']['enddate'][$j] = $tmpenddate[$j];
		}
		
		$this->save_education_weight(array('data' => $data['education']['weight'], 'user_id' => $user_id)); // update the ordering
		
		// update education
		$data['education'] = swap_key($data['education']);
		$n = count($data['education']);	
		for($j=0; $j < $n; $j++) {
			if (isset($data['education'][$j]['institution'])) {
				$id 			= isset($data['education'][$j]['id']) ? $data['education'][$j]['id'] : 0;
				$institution 	= $data['education'][$j]['institution'];
				$begindate 		= $data['education'][$j]['begindate'];
				$enddate 		= $data['education'][$j]['enddate'];
				$degree 		= $data['education'][$j]['degree'];
				$location 		= $data['education'][$j]['location'];
				$tmp_education 	= array(
							'institution' 	=> $institution, 
							'location'		=> $location,
							'begindate' 	=> $begindate, 
							'enddate' 		=> $enddate,
							'degree' 		=> $degree,
							'user_id' 		=> $user_id
							 ); 
				if (!empty($tmp_education['institution'])) {
					$tmp_education = $this->datafilter->clean($tmp_education);
					
					$this->db->where(array('id' => $id, 'user_id' => $user_id));
					$res = $this->db->get($this->_tuser_education); 
					if ($res->num_rows() > 0) {
						$this->db->where(array('id' => $id, 'user_id' => $user_id));
						$this->db->update($this->_tuser_education, $tmp_education);			
					} else {
						$this->db->insert($this->_tuser_education, $tmp_education);		
					}			
				}			
			}
		}
		
		$tmpbegindate = $tmpenddate = array();
		$n = count($data['workexperience']['begindate']['month']);
		for($j=0; $j < $n; $j++) {
			$month 				= $data['workexperience']['begindate']['month'][$j];
			$year 				= $data['workexperience']['begindate']['year'][$j];
			$tmpbegindate[$j]  	= "$month-$year";
			
			$month 				= $data['workexperience']['enddate']['month'][$j];
			$year 				= $data['workexperience']['enddate']['year'][$j];
			$tmpenddate[$j]  	= "$month-$year";
		}

		unset($data['workexperience']['begindate']['month']);
		unset($data['workexperience']['begindate']['year']);
		unset($data['workexperience']['enddate']['month']);
		unset($data['workexperience']['enddate']['year']);			
		
		for($j=0; $j < $n; $j++) {
			$data['workexperience']['begindate'][$j] = $tmpbegindate[$j];
			$data['workexperience']['enddate'][$j] = $tmpenddate[$j];
		}
		
		$this->save_workexperience_weight(array('data' => $data['workexperience']['weight'], 'user_id' => $user_id)); // update the experience ordering
		
		// update work experience
		$data['workexperience'] = swap_key($data['workexperience']);
		$n = count($data['workexperience']);
		for($j=0; $j < $n; $j++) {
			if (isset($data['workexperience'][$j]['company'])) {
				$id 				= isset($data['workexperience'][$j]['id']) ? $data['workexperience'][$j]['id'] : 0;
				$company 			= $data['workexperience'][$j]['company'];
				$begindate 			= $data['workexperience'][$j]['begindate'];
				$enddate 			= $data['workexperience'][$j]['enddate'];
				$jobtitle 			= $data['workexperience'][$j]['jobtitle'];
				$jobdetails 		= $data['workexperience'][$j]['jobdetails'];
				$location 			= $data['workexperience'][$j]['location'];
				$ischeck 			= $data['workexperience'][$j]['ischeck'];
				$tmp_workexperience = array(
							'company' 		=> $company, 
							'begindate' 	=> $begindate, 
							'enddate' 		=> ($ischeck == 'on') ? 'present' : $enddate,
							'jobtitle' 		=> $jobtitle,
							'jobdetails' 	=> $jobdetails,
							'location' 		=> $location,
							'user_id' 		=> $user_id
							 );	
				if (!empty($tmp_workexperience['jobtitle'])) {
					$tmp_workexperience = $this->datafilter->clean($tmp_workexperience);
					$this->db->where(array('id' => $id, 'user_id' => $user_id));
					$res = $this->db->get($this->_tuser_workexperience); 
					if ($res->num_rows() > 0) {
						$tmp_workexperience = array_merge($tmp_workexperience, array('updated_at' => unix_to_human(time(), true, false)));
						$this->db->where(array('id' => $id, 'user_id' => $user_id));
						$this->db->update($this->_tuser_workexperience, $tmp_workexperience);			
					} else {
						$tmp_workexperience = array_merge($tmp_workexperience, array('created_at' => unix_to_human(time(), true, false)));
						$this->db->insert($this->_tuser_workexperience, $tmp_workexperience);
					}			
				}			
			}
		}
		
		$this->save_references_weight(array('data' => $data['references']['weight'], 'user_id' => $user_id)); // update the ordering
		
		// update references
		$data['references'] = swap_key($data['references']);
		$n = count($data['references']);	
		for($j=0; $j < $n; $j++) {
			if (isset($data['references'][$j]['name'])) {
				$id 			= $data['references'][$j]['id'];
				$name 			= $data['references'][$j]['name'];
				$title 			= $data['references'][$j]['title'];
				$company 		= $data['references'][$j]['company'];
				$department 	= $data['references'][$j]['department'];
				$address 		= $data['references'][$j]['address'];
				$city 			= $data['references'][$j]['city'];
				$state 			= $data['references'][$j]['state'];
				$postalcode 	= $data['references'][$j]['postalcode'];
				$country 		= $data['references'][$j]['country'];
				$contactno 		= $data['references'][$j]['contactno'];
				$email 			= $data['references'][$j]['email'];
				$details		= $data['references'][$j]['details'];
				$tmp_references = array(
							'name' 			=> $name, 
							'title' 		=> $title, 
							'company' 		=> $company,
							'department' 	=> $department,
							'address' 		=> $address,
							'city' 			=> $city,
							'country' 		=> $country,
							'state' 		=> $state,
							'postalcode' 	=> $postalcode,
							'contactno' 	=> $contactno,
							'email' 		=> $email,
							'user_id'		=> $user_id,
							'details'		=> $details,
							 ); 
				if (!empty($tmp_references['name'])) {
					$tmp_references = $this->datafilter->clean($tmp_references);
					
					$this->db->where(array('id' => $id, 'user_id' => $user_id));
					$res = $this->db->get($this->_tuser_reference); 
					if ($res->num_rows() > 0) {
						$this->db->where(array('id' => $id, 'user_id' => $user_id));
						$this->db->update($this->_tuser_reference, $tmp_references);			
					} else {
						$this->db->insert($this->_tuser_reference, $tmp_references);		
					}			
				}			
			}
		}
		
		$this->db->trans_complete(); 
	}
	
	function save_workexperience_weight($params) {
		$data 			= $params['data'];
		$user_id        = $params['user_id'];
		$nweight        = count($data);
		for($k=0, $ctr=1; $k < $nweight; $k++, $ctr++ ) {
			$id = $data[$k];
			$this->db->where(array('id' => $id, 'user_id' => $user_id));
			$this->db->update($this->_tuser_workexperience, array('weight' => $ctr));
		}	
	}

	function save_education_weight($params) {
		$data 			= $params['data'];
		$user_id        = $params['user_id'];
		$nweight        = count($data);
		for($k=0, $ctr=1; $k < $nweight; $k++, $ctr++ ) {
			$id = $data[$k];
			$this->db->where(array('id' => $id, 'user_id' => $user_id));
			$this->db->update($this->_tuser_education, array('weight' => $ctr));
		}	
	}

	function save_references_weight($params) {
		$data 			= $params['data'];
		$user_id        = $params['user_id'];
		$nweight        = count($data);
		for($k=0, $ctr=1; $k < $nweight; $k++, $ctr++ ) {
			$id = $data[$k];
			$this->db->where(array('id' => $id, 'user_id' => $user_id));
			$this->db->update($this->_tuser_reference, array('weight' => $ctr));
		}	
	}
	
	function delete_workexperience($where) {
		$this->db->where($where);
		$this->db->delete($this->_tuser_workexperience);
	}
	
	function delete_school($where) {
		$this->db->where($where);
		$this->db->delete($this->_tuser_education);
	}	

	function delete_references($where) {
		$this->db->where($where);
		$this->db->delete($this->_tuser_reference);
	}		
}	