<?php
// For overriding Native class to  convert filenames to lowercase.
class MY_Upload extends CI_Upload
{
        var $error = false;
        
	function _prep_filename($filename)
	{
		if (strpos($filename, '.') === false)
		{
			return $filename;
		}

		$parts = explode('.', $filename);
		$ext = array_pop($parts);
		$filename = array_shift($parts);

		foreach ($parts as $part)
		{
			if ($this->mimes_types(strtolower($part)) === false)
			{
				$filename .= '.' . $part . '_';
			}
			else
			{
				$filename .= '.' . $part;
			}
		}

		$filename .= '.' . $ext;
		return strtolower($filename);
	}
	
	function get_extension($filename)
	{
		$x = explode('.', $filename);
		return strtolower('.'.end($x));
	}

	function call_upload($params)
	{
		$error = false;
		$defaults = array(
			'type'              => 'avatar',
			'encrypt_name'		=> true,
			'resize'            => false,
			'image_library'     => 'gd2',
			'create_thumb'      => false,
			'maintain_ratio'    => true,
			'resize_width'      => 85,
			'resize_height'     => 87,
			'max_size'          => 0,
			'max_width'         => 1024,
			'max_height'        => 768,
			'allowed_types'     => 'gif|jpg|png|jpeg',
		);
			
		$params 			  = array_merge($defaults, $params);
		$type                 = $params['type'];
		$is_resize            = $params['resize'];

		if ($type == 'avatar') {
					$config['upload_path']      = './uploads/avatar/';
		}

		if ($type == 'portfolio') {
					$config['upload_path'] = './uploads/portfolio/';
		}	        

		$config['allowed_types']    = $params['allowed_types'];
		$config['max_size']         = $params['max_size'];
		$config['max_width']        = $params['max_width'];
		$config['max_height']       = $params['max_height'];
		$config['encrypt_name']     = $params['encrypt_name'];
                
		$this->initialize($config);
		
		if ( ! $this->do_upload('photo'))
		{
			$error = array('error' => $this->display_errors());
			return $error;
		}
		else
		{
			if ($is_resize) {
				$resize = $this->call_resize($this->file_name, $type, $params);
				if ($resize['error']) {
					$error = $resize['error'];
				}
			}
						 
			if ($error) {
				$data = array('error' => $error);
			}
			else {
				$data = array('upload_data' => $this->data());
			}
			
			return $data;
		}
	}
 
	/**
         * Resize the image based on type. Type can be avatar, portfolio, etc..
	 */
	function call_resize($image, $type, $props = array())
	{
			$this->ci =& get_instance();
			$defaults = array(
				'image_library' 	=> 'gd2',
				'source_image'  	=> $this->ci->layout->getSetting("upload_path_".$type).$image,
				'new_image'     	=> (isset($props['overwrite']) && $props['overwrite']) ? $this->ci->layout->getSetting("upload_path_".$type) : $this->ci->layout->getSetting("upload_path_".$type).'th_'.$image,
				'create_thumb'      => true,
				'maintain_ratio'    => true,
				'resize_width'      => (isset($props['resize_width']) && $props['resize_width']) ?  $props['resize_width'] : 160,
				'resize_height'     => (isset($props['resize_height']) && $props['resize_height']) ?  $props['resize_height'] : 160,
			);
			
			$props = array_merge($defaults, $props);
			$uploadConfig['image_library'] = $props['image_library'];
			$uploadConfig['source_image'] = $props['source_image'];
			$uploadConfig['new_image'] = $props['new_image'];
			$uploadConfig['create_thumb'] = $props['create_thumb'];
			$uploadConfig['maintain_ratio'] = $props['maintain_ratio'];
			$uploadConfig['width'] = $props['resize_width'];
			$uploadConfig['height'] = $props['resize_height'];
			$this->ci->load->library('image_lib');
			
			$this->ci->image_lib->initialize($uploadConfig); 
			if ( ! $this->ci->image_lib->resize())
			{
				$error = array('error' => $this->ci->image_lib->display_errors());
				return $error;                    
			}
			$this->ci->image_lib->clear();
	}	
}
