<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function select_birthday( $fields, $values, $cssclass = '' )
{
	$name = '' ;
	$tmpvalues = array();
	if ( !empty( $values ))
	{
		$tmpvalues = explode( '-', $values ) ;
	}
	
	$tmp_year = isset( $_POST['year'] ) ? $_POST['year'] : '' ;
	$m1 = "<select name=\"{$fields[0]}\" class=\"$cssclass\" >" ;
	for( $i=1; $i<=12; $i++ ) {
		$m = date( 'F', mktime(0,0,0,$i+1,0,0) ) ;	
		$m1 .= (isset($tmpvalues[1]) && $tmpvalues[1] == $i ) ?  '<option selected="selected" value="' . $i . '" >' . $m . '</option>' : '<option value="' . $i . '" >' . $m . '</option>' ; 
	}
	$m1 .= '</select>' ;
		
	$d1 = "<select name=\"{$fields[1]}\" class=\"$cssclass\" >" ;	
	for( $i=1; $i<=31; $i++ ) {
		$d1 .= (isset($tmpvalues[2]) && $tmpvalues[2] == $i ) ? '<option selected="selected" value="' . $i . '" >' . $i . '</option>' : '<option value="' . $i . '" >' . $i . '</option>' ; 
	}
	$d1 .= '</select>' ;
		
	$curyr = date('Y' , time() );
	$inityr = 1971;
	$y1 = "<select name=\"{$fields[2]}\" class=\"$cssclass\" >" ;
	for( $j =  $curyr; $j > $inityr; $j-- ) {
		$y1 .= (isset($tmpvalues[0]) && $tmpvalues[0] == $j ) ? '<option selected="selected" value="' . $j . '">' . $j . ' </option>' : '<option value="' . $j . '">' . $j . ' </option>' ;
	}
	$y1 .= '</select>' ;	
	
	echo $m1 . $d1 . $y1 ;
}

function generateDropdownDate($params) {
	$format 	= isset($params['format']) ? $params['format'] : '';
	$field		= isset($params['field']) ? $params['field'] : '';
	$values		= isset($params['values']) ? $params['values'] : '';
	$cssclass	= isset($params['cssclass']) ? $params['cssclass'] : '';
	$id         = isset($params['id']) ? $params['id'] : '';
	
	$name = '' ;
	$tmpvalues = array();
	if ( !empty( $values ))
	{
		$tmpvalues = explode( '-', $values ) ;
	}
 
	if ($format == 'mmyyyy') {
		$m1 = "<select name={$field}[month][] class=\"$cssclass\" >" ;
		for( $i=1; $i<=12; $i++ ) {
			$m = date( 'F', mktime(0,0,0,$i+1,0,0) ) ;	
			$m1 .= (isset($tmpvalues[0]) && $tmpvalues[0] == $i ) ?  '<option selected="selected" value="' . $i . '" >' . $m . '</option>' : '<option value="' . $i . '" >' . $m . '</option>' ; 
		}
		$m1 .= '</select>' ;	

		$curyr = date('Y', time());
		$inityr = 1990;
		$y1 = "<select name={$field}[year][] class=\"$cssclass\" >" ;
		for( $j =  $curyr; $j > $inityr; $j-- ) {
			$y1 .= (isset($tmpvalues[1]) && $tmpvalues[1] == $j ) ? '<option selected="selected" value="' . $j . '">' . $j . ' </option>' : '<option value="' . $j . '">' . $j . ' </option>' ;
		}
		$y1 .= '</select>' ;			
		
		
		echo $m1 . $y1;
	}

}

function mysql_date($php_date)  {

    return date( 'Y-m-d g:i:s a', $php_date );
}

// getgmdate
function get_local_date() {
	/*
	$h = "7";// Hour for time zone goes here e.g. +7 or -4, just remove the + or -
	$hm = $h * 60;
	$ms = $hm * 60;
	$gmdate = gmdate("Y-m-d g:i:s a", time()-($ms)); // the "-" can be switched to a plus if that's what your time zone is.
	*/
	$gmdate = date("Y-m-d H:i:s", time());	
	
	return $gmdate;
}

function convert_time_zone($date_time, $from_tz = 'utc', $to_tz = 'Asia/Manila')
{
$time_object = new DateTime($date_time, new DateTimeZone($from_tz));
$time_object->setTimezone(new DateTimeZone($to_tz));
return $time_object->format('Y-m-d g:i:s a');
}

function convertdate($param) {
	$format 		= $param['format'];
	$value			= $param['value'];
	
	if ($format == 'mmyyyy') {
		$tmpdate 	= explode('-', $value);
		$month 		= $tmpdate[0];
		$year 		= $tmpdate[1];
		$ts 		= mktime(0, 0, 0, $month, 1, $year);
		
		return date('F Y', $ts);
	}
}

function converttimestamp($param) {
	$format 		= $param['format'];
	$value			= $param['value'];
	
	if ($format == 'mmyyyy') {
		$tmpdate 	= explode('-', $value); // echo '<pre>';print_r($tmpdate);echo '</pre>';
		$month 		= $tmpdate[0];
		$year 		= $tmpdate[1];
		$ts = mktime(0, 0, 0, $month, 1, $year);
		
		return $ts;
	}
}