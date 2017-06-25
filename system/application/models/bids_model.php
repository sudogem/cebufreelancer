<?php

class Bids_model extends Model
{
	var $_groupby ;
	function Bids_model( )
	{
		parent::Model( ) ;
		$this->_tablename = 'project_bids' ;
	}
	
	function get_project_bids_by_criteria( $wheres = NULL, $fields = NULL )
	{
		($fields != NULL) ? $this->db->select($fields) :''; 
		($wheres != NULL) ? $this->db->where($wheres) :'';
		$this->db->join( 'projects', 'projects.project_id = project_bids.project_id' ) ; 
		$this->db->from( 'project_bids' ) ;
		$this->db->order_by( 'datebidded', 'desc' ) ;
		if ( $this->_groupby ) $this->db->group_by( $this->_groupby ) ; 
		$rs = $this->db->get( ) ;
		if ( $rs->num_rows( ) > 0 ) return $rs->result_array( ) ;
		return FALSE ;	
	}
	
	function insert_bid_to_project( $data )
	{
		$this->db->insert( $this->_tablename, $data ) ;
	}
	
	function update_project_bids( $id, $data )
	{
		$this->db->where( 'bid_id', $id ) ;
		$this->db->update( $this->_tablename, $data ) ;
	}
	
	function delete_bid( $id )
	{
		$this->db->delete( $this->_tablename, array( 'bid_id' => $id ) ) ;
	}	
		
}	
?>