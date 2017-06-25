<?php

class Users_temp_model extends Model
{
	function Users_temp_model()
	{
		parent::Model() ;
		$this->_tablename = 'users_temp' ;
	}
	
	function get_users_temp( $fields = NULL, $wheres = NULL, $result_type = 'result_array' ) 
	{	
		($fields != NULL ) ? $this->db->select( $fields ) : '' ; 
		($wheres != NULL ) ? $this->db->where( $wheres ) : '' ; 
		$rs = $this->db->get( $this->_tablename ) ;
		if ( $rs->num_rows( ) > 0 ) return $rs->$result_type( ) ;
		return FALSE; 
	}
	
	function getUserForActivation( $id , $activation_code )
	{
		$s = array(
			'id' => $id ,
			'activation_code' => $activation_code 
		) ;
		$this->db->where( $s ) ;
		return $this->db->get( $this->_tablename );
	}

	function deleteUserAfterActivation( $id )
	{
		$this->db->where( 'id' , $id ) ;
		$res = $this->db->delete( $this->_tablename ) ;
		if ( $res == true  ) return TRUE ;
		return FALSE ;
	}	
}	
?>