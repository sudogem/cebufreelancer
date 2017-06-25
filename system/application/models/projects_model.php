<?php

class Projects_model extends Model
{
	function Projects_model()
	{
		parent::Model() ;
		$this->_tablename = 'projects' ;
	}
	
	function get_project_by_id( $id, $fields = NULL, $result_type = 'result_array' )
	{
		($fields != NULL) ? $this->db->select($fields) :''; 
		$this->db->where( 'project_id', $id ) ;
		$res = $this->db->get( $this->_tablename ) ;
		if ( $res->num_rows( ) > 0 )
			return $res->{$result_type}( ) ; 
		return FALSE ;
	}
	
	function get_userproject_by_id( $userid, $projectid )
	{
		$this->db->where( array( 'created_by' => $userid, 'project_id' => $projectid ) ) ;
		$res = $this->db->get( $this->_tablename ) ;
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ; 
		return FALSE ;
	}
	
	function get_all_projects( $fields = NULL, $limit = NULL, $where = NULL )
	{
		($fields != NULL) ? $this->db->select($fields) :''; 
		($where != NULL) ? $this->db->where($where) :''; 
		($limit != NULL) ? $this->db->limit($limit['start'], $limit['end']) : '' ; 
		$this->db->order_by( 'dateposted', 'desc' ) ;
		return $this->db->get( $this->_tablename )->result_array( ) ; 
	}
		
	function insert_project( $data )
	{
		$data = $this->datafilter->clean($data);
		$this->db->insert( $this->_tablename, $data ) ;
	}
	
	function update_project( $id, $data )
	{
		$data = $this->datafilter->clean($data);
		$this->db->where( 'project_id', $id ) ;
		$this->db->update( $this->_tablename, $data ) ;
	}
	
}

?>