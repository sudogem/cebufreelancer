<?php
class MY_Input extends CI_Input{

    function MY_Input()
    {
        parent::CI_Input();
    }


    /**
     * Fetch an item from the POST array
     *
     * @access    public
     * @param    string
     * @param    bool
     * @return    string
     */
    function post($index = '', $xss_clean = FALSE)
    {        
        $value  = $this->brackets_to_index($index , "post");

        if ( ! isset($value))
        {
            return FALSE;
        }

        if ($xss_clean === TRUE)
        {
            if (is_array($value))
            {
                foreach($value as $key => $val)
                {                    
                    $value[$key] = $this->xss_clean($val);
                }
            }
            else
            {
                return $this->xss_clean($value);
            }
        }

        return $value;
    }

    // --------------------------------------------------------------------

    /**
     * Set an item from the POST array
     *
     * @access    public
     * @param    string
     * @param    bool
     * @return    string
     */
    function set_post($index = '', $value)
    {
        return $this->set_brackets_to_index($index , $value ,  'post');
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Fetch an item from the COOKIE array
     *
     * @access    public
     * @param    string
     * @param    bool
     * @return    string
     */
    function cookie($index = '', $xss_clean = FALSE)
    {
        $value  = $this->brackets_to_index($index , "cookie");

        if ( ! isset($value))
        {
            return FALSE;
        }

        if ($xss_clean === TRUE)
        {
            if (is_array($value))
            {
                $cookie = array();
                foreach($value as $key => $val)
                {
                    $cookie[$key] = $this->xss_clean($val);
                }
        
                return $cookie;
            }
            else
            {
                return $this->xss_clean($value);
            }
        }
        else
        {
            return $value;
        }
    }    
    
    /*
     * This function gets the value of an "array item" passed via post, get or cookie which is written on the form
     * array[array1][array2][item]
     * @access    public
     * @param    string the form of the array
     * @param    string the method used to send the variable possible values are: "post" , "get" and "cookie" .. default is "post"
     * @return    string
     */
    
    function brackets_to_index($str , $method="post"){

        // first we remove the closing bracket ]
        $str2 = str_replace("]" , "" , $str);
        // next , we explode the str by opening bracket [
        $array = explode("[", $str2);

        switch($method){
	        default:
	            $value = $_POST;
	        break;
	        case "cookie":
	            $value = $_COOKIE;
	        break;
	        case "get":
	            $value = $_GET;
	        break;
        }
        // finally we get the index value from the specified array
        foreach($array as $key=>$index){
			if (isset($value[$index]))
				$value = $value[$index];
        }
        $value = isset($value) ? $value : NULL;
        $value = ($value === false) ? "" : $value;
        switch($method){
	        default:
	            $_POST[$str]   = $value;
	        break;
	        case "cookie":
	            $_COOKIE[$str] = $value;
	        break;
	        case "get":
	            $_GET[$str]    = $value;
	        break;
        }

        return $value;

    }



    function set_brackets_to_index($str , $value, $method = 'post'){

        // first we remove the closing bracket ]
        $str2 = $str;
        if(strpos($str2 , '[') != 0){
        $str2  = substr($str2 , 0 ,strpos($str2 , '[')) . ']' . strstr($str2 , '['); // add ] after the first index
        $str2  = "[" . $str2;
        }
        $str2 = str_replace("]" , "']" , $str2);
        $str2 = str_replace("[" , "['" , $str2);

        switch($method){
        default:
            eval( '$_POST'.$str2.' = $value; ');
        break;
        case "get":
            eval( '$_GET'.$str2.' = $value; ');
        break;
        case "file":
            eval( '$_FILES[\'userfile\'][\'name\']'.$str2.' = $value; ');
        break;
        }
    }



    function file($str , $key = "name"){
        // first we remove the closing bracket ]
        $str2 = str_replace("]" , "" , $str);
        // next , we explode the str by opening bracket [
        $array = explode("[", $str2);

        $value = $_FILES['userfile'];

        for($i = 0 ; $i < count($array) ; $i++){
        if($i == 0) $value = $value[$key];
        else        $value = $value[$array[$i]];
        }

        return $value;
    }

    // --------------------------------------------------------------------

    /**
     * Set an item from the POST array
     *
     * @access    public
     * @param    string
     * @param    bool
     * @return    string
     */
    function set_file($index = '', $value)
    {
        return $this->set_brackets_to_index($index , $value , 'file');
    }
}