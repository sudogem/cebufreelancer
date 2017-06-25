<?php

class Datafilter extends HTMLPurifier
{        
    public $purifyconfig;
    public $allowedElements;

	/**
	 * removed unwanted HTML elements
	 */
    function sanitize($s)
    {
		$sanitized_string = array();
        if ($this->allowedElements) {
            $this->purifyconfig = HTMLPurifier_Config::createDefault();
            $this->purifyconfig->set('HTML.Allowed', $this->allowedElements);
        } else {
            $this->purifyconfig = HTMLPurifier_Config::createDefault();
            $this->purifyconfig->set('HTML.Allowed', '');
        }
        
		if (is_array($s)) {
			foreach($s as $k => $v) {
				$sanitized_string[$k] = $this->is_string($v);
			}
			return $sanitized_string;
		} else {
			return $this->purify($s, $this->purifyconfig);
		}
    }
	
	/**
	  * Check if the element is a string, if its a string then purify it
	  * else map each element from array
	  */
	function is_string($elem)
	{
		if (!is_array($elem)) {
			return $this->purify($elem, $this->purifyconfig);
		} else {
			foreach ($elem as $key=>$value) $elem[$key] = is_string($value);
				return $elem;
		}
	}
	
	/**
	 * Set allowed HTML elements
	 */
    function setHTMLAllowedElements($elements)
    {
        $this->allowedElements = $elements;
    }

	/**
     * Clean the data coming from $_POST
	 */
    function clean($data)
    {
		return array_map(array($this, "sanitize"), $data);
    }
}
