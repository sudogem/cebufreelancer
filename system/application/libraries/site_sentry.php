<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Site_sentry 
{

	function __construct( )
	{
 		$this->obj =& get_instance( ) ;
		$this->accgroup = array( 
		'admin' => 1 , 
		'member' => 2 ,
		'bot' => 3
		) ;
		$this->_tablename = 'users' ;
		$this->sessionname = 'cokiemon' ; 
	}
	
	function is_logged_in( )
	{
		if ($this->obj->session) {
			if ($this->obj->session->userdata( $this->sessionname )) { // if user has valid session, and such is logged in
				return TRUE ;
			} else {
				return FALSE ;
			}
		} else {
			return FALSE;
		}
	} 
	
	
	function checklogin( )
	{
		$password =  $this->obj->input->post( 'password' ) ; 
		$username = $this->obj->input->post( 'username' ) ; 
		$query = $this->obj->db->get_where( $this->_tablename, array( 'username' =>  $username , 'password' =>  $password, 'is_ban' => '0' ) ) ;
		$login_result = FALSE ;
		if ( $query->num_rows( ) > 0 )
		{
			foreach ( $query->result() as $row ) 
			{
				if ( $row->username == $username &&  ( $password ) ==  ( $row->password ) ) //dohash( $row->password )
				{
					$login_result 	= TRUE ;
					$hash_id 		= $row->hash_id ;
					$role 			= $row->user_type ;
					$user_id 		= $row->id ; 
				}
			}
		}
		
		if ( $login_result === TRUE ) {
			$credentials = array( 'hash_id' => $hash_id , $this->sessionname => $login_result, 'role' => $role );
			$this->obj->session->set_userdata($credentials);
			return TRUE ; //On success redirect user to default page
		} else {
			return FALSE ;
		}
	}
	
	function check( $role = 2 )	
	{
		$who = $this->obj->session->userdata( 'role' ) ;
		if ( !empty( $who ) && ( $who === strtolower( $this->accgroup[$role] )) ) return TRUE ;
		return FALSE ; 
	}
	
	function is_admin( )
	{
		if ( $this->obj->session->userdata( 'role' ) === 1 ) return TRUE ;
		return FALSE ;
	}
	
	function is_bot( )
	{
		if ( $this->obj->session->userdata( 'role' ) === 3 ) return TRUE ;
		return FALSE ;
	}
	
	function logout( )
	{
		$this->obj->session->sess_destroy( ) ;
	}
}
