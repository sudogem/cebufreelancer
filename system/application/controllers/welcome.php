<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		// $this->load->view('welcome_message');
		
        $this->load->library('HTMLPurifier');
        $dirty_html = '<a href="javascript:alert(\'test\')">ds</a><p>test<br /><img src="noalt.jpg">';
        $config = HTMLPurifier_Config::createDefault();
        $clean_html = $this->htmlpurifier->purify( $dirty_html , $config );
        echo $clean_html;
		
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */