<?php

class Users_model extends Model {
    function Users_model() {
        parent::Model() ;
        $this->_tuser = 'users' ;
    }

    function get_user_by_id( $user_id, $fields = null, $result_type = 'result_array' ) {
        // ($fields != NULL ) ? $this->db->select( $fields ) : '' ;
        // $this->db->where( 'id', $id ) ;
        // return $this->db->get( $this->_tuser )->{$result_type}( ) ;
		
		if ($fields != null) {
			$this->db->select($fields);
		}
		else {
			$q="users.id, users.username, users.hash_id, users.email,
				user_profile.company AS up_company, user_profile.location AS ulocation, user_profile.gender AS up_gender, 
				user_profile.fullname AS up_fullname, user_profile.specialties AS uspecialties, user_profile.aboutme AS up_aboutme, 
				user_profile.email AS up_email, user_profile.job_objective AS up_job_objective, user_profile.interests AS up_interests, 
				user_profile.location AS up_location, user_profile.city AS up_city, user_profile.city AS up_state, user_profile.birthday AS up_birthday,
				user_profile.postalcode AS up_postalcode, user_profile.specialties AS up_specialties, user_profile.website AS up_website, 
				user_profile.contactno AS up_contactno, user_profile.profile_pic AS up_profile_pic,
				";
			$this->db->select($q);		
		}

		$this->db->where(array('users.id' => $user_id));
		$this->db->join('user_profile', 'user_profile.user_id = users.id', 'left');
		$res = $this->db->get($this->_tuser);
		if ( $res->num_rows( ) > 0 )
			return $res->$result_type() ; 
		return FALSE ;		
    }

    function get_user_by_hash( $hash, $fields = 'hash_id, id',  $result_type = 'row' ) {
        ($fields != NULL ) ? $this->db->select( $fields ) : '' ;
        $this->db->where( 'hash_id', $hash ) ;
        return $this->db->get( $this->_tuser )->{$result_type}( ) ;
    }

    function get_user_by_where( $w, $fields = 'hash_id, id', $result_type = 'row' ) {
        ($fields != NULL ) ? $this->db->select( $fields ) : '*' ;
        $this->db->where( $w ) ;
        $res = $this->db->get( $this->_tuser ) ;
        if ( $res->num_rows( ) > 0 )
            return $res->{$result_type}( ) ;
        else
            return FALSE ;
    }

    function get_all_freelancers( $fields = NULL, $limit = NULL, $where = NULL ) {
        ($fields != NULL) ? $this->db->select( $fields ) :'' ;
        ($where != NULL) ? $this->db->where( $where ) : '' ;
        ($limit != NULL) ? $this->db->limit($limit['start'], $limit['end']) : '';
        return $this->db->get( $this->_tuser )->result_array( ) ;
    }

    function get_all_buyers( $fields = NULL, $limit = NULL, $where = NULL  ) {
        $where1 = 'user_type = "1"' ;
        ($fields != NULL) ? $this->db->select($fields) :'' ;
        ($where != NULL) ? $this->db->where( $where1 . $where) : $this->db->where($where1) ;
        ($limit != NULL ? $this->db->limit($limit['start'], $limit['end']) : '') ;
        return $this->db->get( $this->_tuser )->result_array( ) ;
    }

	function get_all_users($searchdata, $limit=0) { 
		$this->db->select('users.username AS username, 
			user_profile.fullname AS fullname, user_profile.jobtitle AS jobtitle, user_profile.location AS location, user_profile.company AS company, user_profile.specialties AS specialties');
		if (isset($searchdata['fullname']) && !empty($searchdata['fullname'])) {
			$this->db->like('user_profile.fullname', $searchdata['fullname']);
		}
		if (isset($searchdata['username']) && !empty($searchdata['username'])) {
			$this->db->like('users.username', $searchdata['username']);
		}
		if (isset($searchdata['jobtitle']) && !empty($searchdata['jobtitle'])) {
			$this->db->like('user_profile.jobtitle', $searchdata['jobtitle']);
		}
		if (isset($searchdata['specialties']) && !empty($searchdata['specialties'])) {
			$this->db->like('user_profile.specialties', $searchdata['specialties']);
		}		
		if (is_array($limit) && count($limit) > 0) {
			$this->db->limit($limit['start'], $limit['end']);
		}
		$this->db->join('user_profile', 'user_profile.user_id = users.id', 'left');
		
		$this->db->order_by('users.created_at', 'asc');
		$res = $this->db->get('users')->result_array();		
		
		return $res;
	}
	
    function insert_user( $data ) {
		$data = $this->datafilter->clean($data);
        $this->db->insert( $this->_tuser, $data ) ;
    }

    function update_user( $id, $data ) {
		$data = $this->datafilter->clean($data);
        $this->db->where( 'id' , $id );
        $this->db->update( $this->_tuser, $data );
    }

}

