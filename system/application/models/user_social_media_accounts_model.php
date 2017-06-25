<?php 

class User_social_media_accounts_model extends Model {
	var $user_id;
	function User_social_media_accounts_model() {
		parent::Model();
		$this->load->library('datafilter');
		$this->_tuser_social_media_accounts = 'user_social_media_accounts' ;		
	}
	
	function get_by_user_id($user_id) {
		return $this->db->get_where($this->_tuser_social_media_accounts, array('user_id' => $user_id))->result_array();
	}
	
	function save($data) {
		$user_id            = $data['user_id'];
		$tmp_media_accounts = array(
			'user_id'                      => $data['user_id'],
			'facebook_account'             => $data['facebook_account'],
			'linkedin_account'             => $data['linkedin_account'],
			'twitter_account'              => $data['twitter_account']
		);
		
		$this->db->where(array('user_id' => $user_id));
		$res = $this->db->get($this->_tuser_social_media_accounts); 
		if ($res->num_rows() > 0) {
			$this->db->where(array('user_id' => $user_id));
			$this->db->update($this->_tuser_social_media_accounts, $tmp_media_accounts);			
		} else {
			$this->db->insert($this->_tuser_social_media_accounts, $tmp_media_accounts);		
		}
	}
}