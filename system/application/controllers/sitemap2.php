<?php
	
	class Sitemap2 extends Controller 
	{
		$urls = '';
		function Sitemap2( ) 
		{
			parent::Controller( );
			$this->load->helper(array('text','url'));
			$this->load->plugin('google_sitemap'); //Load Plugin	
			$this->urls = array(
				array( 'url' => 'projects', 'pagetype' => 'dynamic', 'params' => 'model:projects_model' ), 
				array( 'url' => 'users', 'pagetype' => 'dynamic', 'params' => 'model:users_model' ),
				array( 'url' => 'articles' )
			);			
		}
		
		function test()
		{
			echo 'xx';					
		}
		
		function index()
		{	
			$sitemap = new google_sitemap; //Create a new Sitemap Object
			foreach($this->urls as $uri )
			{
				if (isset($uri['pagetype']) && $uri['pagetype'] == 'dynamic' ) 
				{
					if (isset($uri['url']))
					{
						$item = new google_sitemap_item(base_url().$uri['url'], date("Y-m-d"), 'monthly', '0.8' ); //Create a new Item
						$sitemap->add_item($item);
					}
					if ( isset($uri['params']) )
					{
						$p = explode('|',$uri['params']);
						if (is_array($p))
						{
							foreach($p as $item)
							{
								$d = explode(':', $item);
								echo $d[1];
								$this->load->model( $d[1] );
							}
						}
					}
					$res = $this->projects_model->get_all_projects( NULL, NULL, NULL ) ; 
					foreach( $res as $data )	
					{
						$id = $data['project_id'];
						$url_title = url_title($data['project_id'];
						$item = "projects/view/$id/$url_title";
						$sitemap->add_item($item); //Append the item to the sitemap object
					}
					
				}
				
			}
			
			/*$sitemap->build("./sitemap.xml"); //Build it...
			//Let's compress it to gz
			$data = implode("", file("./sitemap.xml"));
			$gzdata = gzencode($data, 9);
			$fp = fopen("./sitemap.xml.gz", "w");
			fwrite($fp, $gzdata);
			fclose($fp);
			//Let's Ping google
			$this->_pingGoogleSitemaps(base_url()."/sitemap.xml.gz");*/
		}
		
		function _pingGoogleSitemaps( $url_xml )
		{
			$status = 0;
			$google = 'www.google.com';
			if( $fp=@fsockopen($google, 80) )
			{
				$req =  'GET /webmasters/sitemaps/ping?sitemap=' .
				urlencode( $url_xml ) . " HTTP/1.1\r\n" .
				"Host: $google\r\n" .
				"User-Agent: Mozilla/5.0 (compatible; " .
				PHP_OS . ") PHP/" . PHP_VERSION . "\r\n" .
				"Connection: Close\r\n\r\n";
				fwrite( $fp, $req );
				while( !feof($fp) )
				{
					if( @preg_match('~^HTTP/\d\.\d (\d+)~i', fgets($fp, 128), $m) )
					{
					$status = intval( $m[1] );
					break;
					}
				}
				fclose( $fp );
			}
			return( $status );
		}	
	}
