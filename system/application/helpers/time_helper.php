<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function days_remaining( $t ) {
	$days = floor((time() - $t )/86400) ;
	return $days ;
}

// http://www.php.net/manual/en/function.date.php#68716
function fnc_date_calc($this_date, $num_days  )
{
	$my_time = $this_date ;
    $timestamp = $my_time + ($num_days * 86400) ; //calculates # of days passed ($num_days) * # seconds in a day (86400)
	$timestamp = days_remaining( $timestamp ) ;
    return $timestamp ; 
}

function fnc_date_calc2($this_date,$num_days) 
{
    $my_time = $this_date ;
    $timestamp = $my_time + ($num_days * 86400); //calculates # of days passed ($num_days) * # seconds in a day (86400)
    //$return_date = date("Y/m/d",$timestamp);  //puts the UNIX timestamp back into string format
	return $timestamp ; 
    // return $return_date;//exit function and return string
}


/**
 * Timespan
 *
 * Returns a span of seconds in this format:
 *	10 days 14 hours 36 minutes 47 seconds
 *
 * @access	public
 * @param	integer	a number of seconds
 * @param	integer	Unix timestamp
 * @return	integer
 */	
if ( ! function_exists('numofyears'))
{
	function numofyears($seconds = 1, $time = '')
	{
		$CI =& get_instance();
		$CI->lang->load('date');

		if ( ! is_numeric($seconds))
		{
			$seconds = 1;
		}
	
		if ( ! is_numeric($time))
		{
			$time = time();
		}
	
		if ($time <= $seconds)
		{
			$seconds = 1;
		}
		else
		{
			$seconds = $time - $seconds;
		}
		
		$str = '';
		$years = floor($seconds / 31536000);
	
		if ($years > 0)
		{	
			$str .= $years.' '.$CI->lang->line((($years	> 1) ? 'date_years' : 'date_year')).', ';
		}	
	
		$seconds -= $years * 31536000;
		$months = floor($seconds / 2628000);
	
		if ($years > 0 OR $months > 0)
		{
			if ($months > 0)
			{	
				$str .= $months.' '.$CI->lang->line((($months	> 1) ? 'date_months' : 'date_month')).', ';
			}	
	
			$seconds -= $months * 2628000;
		}

		 
			
		return substr(trim($str), 0, -1);
	}
}
	

?>
