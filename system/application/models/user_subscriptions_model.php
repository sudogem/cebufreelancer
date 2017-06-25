<?php

class User_subscriptions_model extends Model
{
	function User_subscriptions_model( )
	{
		parent::Model() ;
		$this->_tablename = 'user_subscriptions' ;
	}
	
	function get_user_subscriptions( $w )
	{
		$this->db->where( $w );
	    $res = $this->db->get( $this->_tablename ) ;
		if ( $res->num_rows() > 0 )
			return $res->result_array( ) ;
		else
			return FALSE;
	}
	
	function insert_user_subscriptions( $data )
	{
	    $this->db->insert( $this->_tablename, $data);
	}
	
	function update_user_subscriptions( $user_id, $data )
	{
		$this->db->where( 'user_id', $user_id );
	    $this->db->update( $this->_tablename, $data);
	}
}	
?>