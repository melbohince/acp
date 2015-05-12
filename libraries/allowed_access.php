<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class Allowed_access {
  
  	var $obj;
  	
    function Allowed_access()  // call from controllers
  	{
  		//$this->obj =& get_instance();
  	}
  	
    function limit_access($allowed_access, $column_prefix = '') 
    {
          
  				if($allowed_access == "00000")
  				{
  				  return " ";
  		    }
  		    else {
  		      return " and ".$column_prefix."access_filter = '".$allowed_access."' ";
  	      }
  	  }

  } //Allowed_access

?>