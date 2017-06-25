<?php

class Categories_model extends Model
{
	function Categories_model( )
	{
		parent::Model( ) ;
		$this->_tablename = 'categories' ;
	}
	
	function get_all_categories( $select = NULL )
	{
		($select != NULL) ? $this->db->select( $select ) : '' ;
		$this->db->order_by( 'category', 'asc' ) ;
		return $this->db->get( $this->_tablename )->result_array( ) ;
	}
	
	function get_categories_by_criteria( $wheres = NULL, $fields = NULL, $result_type = 'row' )
	{
		($fields != NULL) ? $this->db->select($fields) :''; 
		($wheres != NULL) ? $this->db->where($wheres) :''; 
		return $this->db->get( $this->_tablename )->{$result_type}( ) ;		
	}
	
	function get_all_project_categories( $category, $limit = NULL, $where = NULL )
	{
		($limit != NULL) ? $this->db->limit( $limit['start'], $limit['end']) : '' ; 
		($where != NULL) ? $this->db->where( $where ) : '' ; 
		$this->db->from( ' projects p , project_categories pc, categories c' ) ;
		$this->db->where( "p.project_id = pc.project_id
			and pc.category_id = c.category_id 
			and c.category_url = '$category'"  ) ;
			
		$this->db->order_by( 'p.dateposted', 'desc' )	;
		$res = $this->db->get( ) ;
		if ( $res->num_rows( ) > 0 )
			return $res->result_array( ) ;
		else
			return FALSE ;	
	}
}

