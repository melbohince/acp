<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Date_time_conversions {
  
	var $obj;
	
	function Date_time_conversions()
	{
		$this->obj =& get_instance();
		$this->obj->load->helper('date');
	}
	
  function short_date($timestamp)
  {
		$test = date("Y-m-d",strtotime($timestamp));
		$today = date("Y-m-d");
		$yesterday = date("Y-m-d", strtotime("-1 days"));
		$tomorrow = date("Y-m-d", strtotime("+1 days"));

		if($test == $today) {
			return 'Today';
		} elseif($test == $yesterday) {
			return 'Yesterday';
		} elseif($test == $tomorrow) {
			return 'Tommorrow';
		} else {
		  return mdate("%l",strtotime($timestamp));
		}
  }
  
  function time_stamp_string()
  {
    return date("Ymd-His");
  }
  
  function is_date($str) //not tested
  {
    $stamp = strtotime( $str );
    $month = date( 'm', $stamp );
    $day   = date( 'd', $stamp );
    $year  = date( 'Y', $stamp );

    return (checkdate( $month, $day, $year ));
  }
} //end class


?>