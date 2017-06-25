<?php
class User_category_subscriptions_model extends Model
{
	function User_category_subscriptions_model( )
	{
		parent::Model() ;
		$this->_tablename = 'user_category_subscriptions' ;
	}
	
	function get_user_category_subscriptions( $user_id, $select = NULL )
	{
		($select != NULL) ? $this->db->select( $select ) : '' ;
		$this->db->where( 'user_id', $user_id ) ;
		$res = $this->db->get( $this->_tablename ) ;
		if ( $res->num_rows() > 0 )
		{
			return $res->result_array() ;
		}
		return FALSE;
	}
	
	function get_user_subscriptions( $where, $select = NULL, $groupby = NULL )
	{
		($select != NULL) ? $this->db->select( $select ) : '' ;
	    ($where != NULL) ? $this->db->where( $where ) : '' ;
		($groupby != NULL) ? $this->db->group_by( $groupby ) : '' ;
		$res = $this->db->get( $this->_tablename ) ;
		if ( $res->num_rows() > 0 )
		{
			return $res->result_array();
		}
		return FALSE;		
	}
	
	function insert_user_category_subscriptions( $data )
	{
	    $this->db->insert( $this->_tablename, $data);
	}
	
	function delete_user_category_subscriptions( $user_id )
	{
		$this->db->where( 'user_id', $user_id ) ;
		$this->db->delete( $this->_tablename );
	}
}
?>