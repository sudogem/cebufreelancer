<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Layout Model Class
 *
 * @package		YATS -- The Layout Library
 * @subpackage	Models
 * @category	Template
 * @author		Mario Mariani
 * @copyright	Copyright (c) 2006-2007, mariomariani.net All rights reserved.
 * @license		http://svn.mariomariani.net/yats/trunk/license.txt
 */
class Layout_model extends Model 
{
	var $common;
	var $theme;
	
	/**
	 * Constructor
	 *
	 * @access	public
	 */
	function Layout_model()
	{
		parent::Model();
		$this->theme  = $this->config->config['layout']['views_folder'] . '/' . $this->config->config['layout']['views_content'] . '/' ;
		$this->common = $this->config->config['layout']['views_folder'] . '/' . $this->config->config['layout']['views_commons'] . '/' ;
		$this->assets_images = base_url( ) . $this->config->config['layout']['assets_folder'] . '/' . $this->config->config['layout']['views_folder'] . '/' . $this->config->config['layout']['assets_images'] . '/' ;				
		$this->load->model( 'categories_model' ) ;	
		$this->load->model( 'users_model' ) ; 
		$this->load->model( 'users_resume_model' ) ; 
		$this->load->model( 'bids_model' ) ; 
		$this->load->model( 'projects_messages_model'  ) ;
		
	}
	

	
	function mainmenu()
	{
		$data = array();
		return $this->load->view($this->common . "menu", $data , true);
	}
	
	function rightb()
	{
		$data['assets_images'] = $this->assets_images ;
		$data['all_categories'] = $this->categories_model->get_all_categories( ) ; 
		return $this->load->view($this->common . "rightb", $data  , true);
	}
	
	function userpanel()
	{
		$urls = array( 'articles', 'privacy', 'tos', 'contact', 'tell_a_friend', 'about', 'users' ) ;
		$uri = $this->uri->segment( 1 );

		$rs = $this->users_model->get_user_by_hash( $this->session->userdata( 'hash_id' ), 'hash_id, id, username', 'result_array' ) ;
		if ( $rs ) {
			$this->logged_userid 	= $rs[0]['id'] ;
			$this->logged_username 	= $rs[0]['username'] ; 
		}	
		
		$userprofile = $this->users_resume_model->get_profile($this->logged_userid);
		$profile_pic = $userprofile[0]['up_profile_pic'];
		
		$upload_path_avatar = $this->layout->getSetting('upload_path_avatar');
		$data['upload_path_avatar'] = $upload_path_avatar;
		$data['profile_pic'] = (file_exists($upload_path_avatar.$profile_pic) && is_file($upload_path_avatar.$profile_pic)) ? $upload_path_avatar.$profile_pic : $upload_path_avatar.'default.png';

		if ( $this->site_sentry->is_logged_in( ) === TRUE && !in_array( $uri, $urls ) )  {
			return $this->load->view($this->common . "userpanel", $data, true) ; 
		}
	}
}

