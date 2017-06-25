<?php


class Project_flags_model extends Model
{
	function Project_flags_model( )
	{
		parent::Model() ;
		$this->_tablename = 'project_flags' ;
	}
	
	function insert_flag( $data )
	{
	    $this->db->insert( $this->_tablename, $data);
	}
	
	
}	
?>