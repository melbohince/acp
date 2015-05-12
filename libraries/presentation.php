<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// controls for setting the UI
// dependent on browser agent
class Presentation {
  
	var $obj;
	
	function Presentation()
	{
	}
	
  function get_style()
  {
		$this->obj =& get_instance();
    $this->obj->load->library('user_agent');
    // $css =  link_tag('system/application/css/reset-fonts-grids.css')."\n        "; //YUI
    
		if($this->obj->agent->mobile())
		{ 
		 return 'iphone.css';
		} else {
		 return 'desktop.css'; //later add more browser based
		}
  }

function get_template()
  {
		$this->obj =& get_instance();
    $this->obj->load->library('user_agent');
		if($this->obj->agent->mobile())
		{ 
		 return 'template_mobile';
		} else {
		 return 'template_desktop'; //later add more browser based
		}
  }
  	
	function set_style($style)
  {
		 return link_tag('system/application/css/'.$style); 
  }

	function get_refresh($seconds)
	{
		if($seconds < 0)
		{
			return "";
		} else {
			return '<meta http-equiv="refresh" content="'.$seconds.'" />'."\n";
		}
	}
} //end class


?>