<?php
class Projects_messages_model extends Model
{
	var $group_by_ = '' ;
	function Projects_messages_model()
	{
		parent::Model() ;
		$this->load->library( 'datafilter' ) ;
		$this->_tablename = 'project_messages' ;
	}
	
	function get_project_messages( $projectid, $to )
	{
		$w = array( 'project_id' => $projectid , 'to' => $to ) ;
		$this->db->where( $w ) ;
		isset( $this->group_by_ ) ? $this->db->group_by( $this->group_by_ ) : '' ;
		$this->db->order_by( 'dateposted', 'desc' ) ;
		$res = $this->db->get( $this->_tablename ) ;
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ;
		else
			return FALSE ;	
	}
	
	function get_project_message_by_user( $userid, $limit = NULL )
	{
		($limit != NULL) ? $this->db->limit($limit['start'], $limit['end']) : '' ; 	
		$w = array( 'to' => $userid  ) ;
		$this->db->where( $w ) ;
		$this->db->order_by( 'dateposted', 'desc' ) ;
		$res = $this->db->get( $this->_tablename ) ;
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ;
		else
			return FALSE ;	
	}
	
	function get_project_message_by_criteria( $wheres = NULL , $fields = NULL, $limit = NULL ) 
	{
		($wheres != NULL) ? $this->db->where( $wheres ) : '' ;
		($fields != NULL) ? $this->db->select( $fields ) : '' ;  
		($limit != NULL) ? $this->db->limit($limit['start'], $limit['end']) : '' ; 
		$this->db->order_by( 'dateposted', 'desc' ) ;
		$res = $this->db->get( $this->_tablename ) ;
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ;
		else
			return FALSE ;	
	}
	
	function get_project_message_by_projectid( $projectid, $to )
	{
		$w = array( 'project_id' => $projectid , 'to' => $to ) ;
		$this->db->where( $w ) ;
		$res = $this->db->get( $this->_tablename ) ;
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ;
		else
			return FALSE ;	
	}
				
	function get_project_message_by_id( $id, $userid )
	{
		$w = array( 'message_id' => $id , 'to' => $userid ) ;
		$this->db->where( $w ) ;
		return $this->db->get( $this->_tablename )->result_array( ) ;		
	}
	
	function insert_project_message( $data )
	{
		$data = $this->datafilter->clean($data);
		$this->db->insert( $this->_tablename, $data ) ;
	}
	
	function update_project_message( $id, $data )
	{
		$data = $this->datafilter->clean($data);
		$this->db->where( 'message_id', $id ) ;
		$this->db->update($this->_tablename, $data ) ;
	}
	
	function delete_project_message( $message_id )
	{
		$this->db->where('message_id', $message_id );
		$this->db->delete( $this->_tablename ) ;
	}
}	
?>