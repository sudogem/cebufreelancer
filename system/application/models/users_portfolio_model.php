<?php

class Users_portfolio_model extends Model {
    function Users_portfolio_model() {
        parent::Model() ;
        $this->ci =& get_instance();
        $this->load->config( 'link_pagination' );
		$this->load->helper( 'date' );
		$this->load->helper( 'bday' );
		$this->load->helper( 'sanitizer' );
        $this->load->library( 'tokenizer' ) ;
        $this->load->library( 'pagination' ) ;
        $this->load->library( 'datafilter' ) ;
        $this->load->model( 'users_model' ) ;
        $this->_tuser_portfolio = 'user_portfolio' ;
        $this->_tuser_portfolio_photos = 'user_portfolio_photos' ;
        $this->portfolio_per_page = $this->config->item( 'portfolio_per_page' ) ;
    }

    function get_all_portfolio( $fields = NULL, $limit = NULL, $where = NULL) {
        ($fields != NULL) ? $this->db->select( $fields ) :'' ;
        ($where != NULL) ? $this->db->where( $where ) : '' ;    
        $username = strtolower($this->uri->segment(2));  
		$this->db->join($this->_tuser_portfolio_photos, "user_portfolio.id = user_portfolio_photos.user_portfolio_id", "left");
        $res = $this->db->get( $this->_tuser_portfolio )->result_array( );          
		$cur_offset = ( $this->uri->segment(5)!= '' ) ? (int)$this->uri->segment(5) : '' ;
		$config['base_url'] =  site_url( ) . "/users/$username/portfolio/p/" ;
		$config['total_rows'] = count( $res ) ;
		$config['per_page'] = $this->portfolio_per_page;
		$config['uri_segment'] = 5;
		$tmpcur_offset = (empty($cur_offset)) ? 0 : $config['per_page'];
		$limit = array( 'start' => $config['per_page'], 'end' => ($config['per_page'] * $cur_offset) - $tmpcur_offset);
        ($limit != NULL) ? $this->db->limit($limit['start'], $limit['end']) : '';
        $this->pagination->initialize( $config ) ;
        ($where != NULL) ? $this->db->where( $where ) : '' ;  
		$this->db->join($this->_tuser_portfolio_photos, "user_portfolio.id = user_portfolio_photos.user_portfolio_id", "left");
        return array('result' => $this->db->get( $this->_tuser_portfolio )->result_array( ), 'pagination' => $this->pagination->create_links()); 
    }
	
	function get_portfolio($user_id) {
		$this->db->select("
			date_format(created_at, '%b %d, %Y %r') as fmtcreated_at, 
			date_format(updated_at, '%b %d, %Y %r') as fmtupdated_at
			", false);
		$this->db->where(array('user_id' => $user_id) );
        $res = $this->db->get( $this->_tuser_portfolio )->result_array( );          
		$cur_offset = ( $this->uri->segment(4)!= '' ) ? (int)$this->uri->segment(4) : '' ;
		$config['base_url'] =  site_url( ) . "/portfolio/browse/p/" ;
		$config['total_rows'] = count( $res ) ;
		$config['per_page'] = $this->portfolio_per_page;
		$config['uri_segment'] = 4;
		$tmpcur_offset = (empty($cur_offset)) ? 0 : $config['per_page'];
		$limit = array( 'start' => $config['per_page'], 'end' => ($config['per_page'] * $cur_offset) - $tmpcur_offset);
        ($limit != NULL) ? $this->db->limit($limit['start'], $limit['end']) : '';
        $this->pagination->initialize( $config ) ;
        $this->db->where(array('user_id' => $user_id) );
		$this->db->select("*, 
			date_format(created_at, '%b %d, %Y') as fmtcreated_at,
			date_format(updated_at, '%b %d, %Y') as fmtupdated_at
			", false);
		$this->db->order_by('created_at', 'desc');
        return array('result' => $this->db->get( $this->_tuser_portfolio )->result_array( ), 'pagination' => $this->pagination->create_links());		
	}
	
	function get_portfolio_photos_by_user($user_portfolio_id) {
		$this->db->where(array('user_portfolio_id' => $user_portfolio_id));
		$res = $this->db->get( $this->_tuser_portfolio_photos );
		if ( $res->num_rows() > 0 )
			return $res->result_array();
			
		return false;
	}
	
	function get_portfolio_by_id($params) {
		$this->db->where(array( "$this->_tuser_portfolio.id" => $params['id'], 'user_id' => $params['user_id']));
		$this->db->join($this->_tuser_portfolio_photos, "user_portfolio.id = user_portfolio_photos.user_portfolio_id", "left");
		$res = $this->db->get( $this->_tuser_portfolio );
		if ( $res->num_rows() > 0 )
			return $res->result_array(); 
		return FALSE ;			
	}
	
	function save_portfolio($data) {
		$user_id 	= ($this->user_id) ? $this->user_id : 0;
		$id 		= isset($data['portfolio']['id']) ? $data['portfolio']['id'] : 0;
		$t 			= get_local_date();
		$this->db->select('user_id');
		$this->db->where(array('id' => $id, 'user_id' => $user_id));
		$res = $this->db->get($this->_tuser_portfolio); 
		$tmp_data = array(
			'title' 		=> $data['portfolio']['title'], 
			'content' 		=> $data['portfolio']['content'],
			'user_id'		=> $user_id,
		);
		
		$tmp_data = $this->datafilter->clean($tmp_data);
		
		if ($res->num_rows() > 0) {
			$tmp_data['updated_at'] = $t;
			$this->db->where(array('id' => $id, 'user_id' => $user_id));
			$this->db->update($this->_tuser_portfolio, $tmp_data); 			
			if (isset($data['filename'])) {
				$d = array('user_portfolio_id' => $id, 'hash_id' => $this->tokenizer->randuniqid(), 'filename' => $data['filename'], 'created_at' => $t, 'updated_at' => $t);
				$d = $this->datafilter->clean($d);
				$this->db->insert($this->_tuser_portfolio_photos, $d);	
			}
		}
		else
		{
			$t = get_local_date();
			$tmp_data['created_at'] = $t;
			$tmp_data['updated_at'] = $t;
			$this->db->insert($this->_tuser_portfolio, $tmp_data);	
			if (isset($data['filename'])) {
				$d = array('user_portfolio_id' => $this->db->insert_id(), 'hash_id' => $this->tokenizer->randuniqid(), 'filename' => $data['filename'], 'created_at' => $t, 'updated_at' => $t);
				$d = $this->datafilter->clean($d);
				$this->db->insert($this->_tuser_portfolio_photos, $d);			
			}
		}	
	}
	
	function check_num_photos($id, $numphotos = 0) {
		$this->db->where(array('user_portfolio_id' => $id));
		$res = $this->db->get($this->_tuser_portfolio_photos); 	
		if ($res->num_rows() > $numphotos) {
			return $res;
		}
		
		return false;
	}
	
	function check_photo_owner($params) {
		$id 	 = $params['id'];
		$user_id = $params['user_id'];
		$hash_id = $params['hash_id'];
		$user_portfolio_id = $params['user_portfolio_id'];
		
		// print_r($params);
		$this->db->select('id');
		$this->db->where(array('id' => $user_portfolio_id, 'user_id' => $user_id));
		if ($this->db->get($this->_tuser_portfolio)->num_rows() > 0) {
			$this->db->where(array('id' => $id, 'user_portfolio_id' => $user_portfolio_id, 'hash_id' => $hash_id));	
			$res = $this->db->get($this->_tuser_portfolio_photos);
			if ($res->num_rows() > 0) {
				return $res;
			}
			
			return false;
		}
	}
	
	function delete_photo_by_id($id)
	{
		$this->db->delete($this->_tuser_portfolio_photos, array('id' => $id)); 
	}
	
	function delete_photo($data) {
		$r = $data->result();
		$upload = $this->layout->getSetting('upload_path_portfolio');
		$filename = $r[0]->filename;
		
		@unlink($upload.$filename);       // delete the orig file 
		
		@unlink($upload.'th_'.$filename); // delete the thumbnail
	}
	
	function delete_by_ids( $id, $user_id)
	{
		$this->db->where_in('id', $id );
		$this->db->where('user_id', $user_id);
		if ($this->db->delete( $this->_tuser_portfolio )) {
			return true;
		}
		
		return false;
	}	
}
    