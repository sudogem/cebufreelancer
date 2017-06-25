<?php 

class common_users_resume extends Users_resume_model {
	var $user_id;
	
	function __construct() {
		parent::Model() ;
	}
	
	function hello() {
		print "helo";
	}
	
}	