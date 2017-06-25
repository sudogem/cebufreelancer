<?php
/*
This function takes a two dimensional array[x][y], swaps the first
        key with the second key so the values can be referenced using array[y][x].

        Example:
                    samplearray['directiory'][0] = "myicons";
                    samplearray['directiory'][1] = "myicons";
                    samplearray['directiory'][2] = "myiconsold";
                    samplearray['directiory'][3] = "myiconsold";

                    samplearray['filename'][0] = "hat.png";
                    samplearray['filename'][1] = "dog.png";
                    samplearray['filename'][2] = "mice.png";
                    samplearray['filename'][3] = "rat.png";

        The above array converts to:

                    newarray[0]['filename']     = "hat.png"
                    newarray[0]['directiory']     = "myicons"
                    newarray[1]['filename']     = "dog.png"
                    newarray[1]['directiory']     = "myicons"
                    newarray[2]['filename']     = "mice.png"
                    newarray[2]['directiory']     = "myiconsold"
                    newarray[3]['filename']     = "rat.png"
                    newarray[3]['directiory']     = "myiconsold" 
*/
function swap_key($multidimensional_array) {
	    $keys = array_keys( $multidimensional_array );
	    $array_swaped = array();
	    foreach($multidimensional_array[$keys[0]] as $key_counter => $value1) {
			$temp_array = array();
			foreach($keys as $key) {
				if (isset($multidimensional_array[$key][$key_counter])) {
					$temp_array[$key] = $multidimensional_array[$key][$key_counter];
				}
			}
			$array_swaped[] = $temp_array;
	    }
	    return $array_swaped; 
		
}

function is_image_exist($image, $path) {
	$f = $path.$image;
	if(file_exists($f) && !is_dir($f)) {
		return true;
	}
	
	return false;
}

function make_anchor_link($website) {
	if ( ! function_exists('site_url'))
	{
		function site_url($uri = '')
		{
			$CI =& get_instance();
			return $CI->config->site_url($uri);
		}
	}
	
	if ( ! function_exists('anchor'))
	{
		function anchor($uri = '', $title = '', $attributes = '')
		{
			$title = (string) $title;

			if ( ! is_array($uri))
			{
				$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
			}
			else
			{
				$site_url = site_url($uri);
			}

			if ($title == '')
			{
				$title = $site_url;
			}

			if ($attributes != '')
			{
				$attributes = _parse_attributes($attributes);
			}

			return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
		}
	}

	if ( ! function_exists('prep_url'))
	{
		function prep_url($str = '')
		{
			if ($str == 'http://' OR $str == '')
			{
				return '';
			}

			if (substr($str, 0, 7) != 'http://' && substr($str, 0, 8) != 'https://')
			{
				$str = 'http://'.$str;
			}

			return $str;
		}
	}
	
	$websitelist = '';
	$sites = preg_split("/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[\s,]+/", $website, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
	foreach($sites as $idx => $site) {
		$websitelist .= anchor(prep_url($site), $site, "rel=nofollow") . '<br />';
	}
	
	return $websitelist;
}
