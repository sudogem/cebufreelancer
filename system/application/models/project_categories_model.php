<?php

class Project_categories_model extends Model
{
	function Project_categories_model( )
	{
		parent::Model() ;
		$this->_tablename = 'project_categories' ;
	}
	
	function insert_project_to_category( $data )
	{
		return $this->db->insert( $this->_tablename, $data ) ;
	}
	
	function get_all_project_categories( )
	{
		return $this->db->get( $this->_tablename )->result_array( ) ; 
	}
	
	function get_project_categories( $where = NULL, $select = NULL  )
	{
		($where != NULL) ? $this->db->where( $where ) : '' ;
		($select != NULL) ? $this->db->select( $select ) : '' ;
		$this->db->from( 'project_categories, categories' ) ;
		$this->db->where( 'categories.category_id = project_categories.category_id' ) ;				
		return $this->db->get( )->result_array( ) ;
	}
	
	function delete_project_categories( $project_id )
	{
		$this->db->where( 'project_id', $project_id ) ;
		$this->db->delete( $this->_tablename ) ;
	}
	
//	function get_projects( $)
//	{
//		$this->db->select( 'projects.project_id, projects.project_status, 
//		project_categories.category_id' ) ; 
//		$this->db->from( 'projects, project_categories' ) ; 
//		$this->db->where( 'projects.project_status = "1" and project_categories.category_id = "" ' ) ; 
//		$rs = $this->db->get( ) ;
//	}	
	
}	
?>