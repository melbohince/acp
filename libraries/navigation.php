<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Navigation {
  
	var $obj;
	var $lang;
	
	function Navigation()
	{
		$this->obj =& get_instance();
	
		$this->obj->lang->load('pages', $this->obj->session->userdata('use_language')); 
		$this->obj->access_level = (($this->obj->session->userdata('admin') == 1) ? 'ADMIN' : 'USER');
		$this->obj->wms_mgr = (($this->obj->session->userdata('wms_mgr') == 1) ? 'YES' : 'NO');
	}
	
  function main_menu()
  {
    $menu = '<div id="navlist"><ul id="home">';
    
    $menu .= "<li>".anchor('menu/find', $this->obj->lang->line('m_find'))."</li>";
    $menu .= "<li>".anchor('menu/reports', $this->obj->lang->line('m_reports'))."</li>";
    $menu .= "<li>".anchor('menu/warehouse', $this->obj->lang->line('m_warehouse'))."</li>";
    //$menu .= "<li>".anchor('menu/settings', $this->obj->lang->line('m_settings'))."</li>";
    if($this->obj->access_level == 'ADMIN')
		{
  		$menu .= "<li>".anchor('menu/administration', $this->obj->lang->line('m_administration'))."</li>";
    }
		$menu .= "<li>".anchor('help', $this->obj->lang->line('m_help'))."</li>";
		//$menu .= "<li>&nbsp</li>";
		//$menu .= '<li><a href="http://www.arkay.com">Arkay Website</a></li>';
    $menu .= "</ul></div>";
    
    return $menu; 
  }
  
  function find_menu()
  {
    $menu = '<div id="navlist"><ul>';

    $menu .= "<li>".anchor('cpn', $this->obj->lang->line('m_product_code'))."</li>";
    $menu .= "<li>".anchor('cpn/lookup_line', $this->obj->lang->line('m_product_line'))."</li>";
    $menu .= "<li>".anchor('order/lookup', $this->obj->lang->line('m_purchase_orders'))."</li>";
    $menu .= "<li>".anchor('cpn/lookup_desc', $this->obj->lang->line('m_description'))."</li>";
    $menu .= "<li>".anchor('release/lookup_cpn_by_shipto', $this->obj->lang->line('m_shipto'))."</li>";
    $menu .= "</ul></div>";

    return $menu; 
  }
  
  function report_menu()
  {
    $menu = '<div id="navlist"><ul>';

    $menu .= "<li>".anchor('job/all', $this->obj->lang->line('m_jobs'))."</li>";
		$menu .= "<li>".anchor('order/open', $this->obj->lang->line('m_orders'))."</li>";
		$menu .= "<li>".anchor('release/open', $this->obj->lang->line('m_releases'))."</li>";
		$menu .= "<li>".anchor('release/shipped', $this->obj->lang->line('m_shipments'))."</li>";
		//if($this->obj->session->userdata('access_filter') != '00120') //$this->obj->access_level == 'ADMIN')
     $menu .= "<li>".anchor('cpn/can_ship', $this->obj->lang->line('m_can_ship'))."</li>";
    //endif
    $menu .= "<li>".anchor('cpn/shortages', $this->obj->lang->line('m_shortages'))."</li>";

    $menu .= "</ul></div>";

    return $menu; 
  }

  function warehouse_menu()
  {
    $menu = '<div id="navlist"><ul>';

    $menu .= "<li>".anchor('wms/transit', 'In Transit')."</li>";
    $menu .= "<li>".anchor('wms/onhand', 'On-hand')."</li>";
    $menu .= "<li>".anchor('wms/all', 'All')."</li>";
    if($this->obj->wms_mgr == 'YES')
    {
        $menu .= "<li>".anchor('wms/scan_receipt', 'Receive')."</li>";
        $menu .= "<li>".anchor('wms/scan_issue', 'Issue')."</li>";
    }
    $menu .= "</ul></div>";

    return $menu; 
  }
  function settings_menu()
  {
    $menu = '<div id="navlist"><ul>';

    $menu .= "<li>".anchor('login/change_password', $this->_todo().$this->obj->lang->line('m_change_password'))."</li>";
		$menu .= "<li>".anchor('menu/', $this->_todo().$this->obj->lang->line('m_preferences'))."</li>";

    $menu .= "</ul></div>";
    $menu .= '<h3 style="color:red;">* UNDER CONSTRUCTION!</h3>';
    return $menu; 
  }
  
  function administration_menu()
  {
    $menu = '<div id="navlist"><ul>';

    $menu .= "<li>".anchor('login/crud/', 'Manage Users')."</li>";
    $menu .= "</ul></div>";

    return $menu; 
  }
  
	function use_pagination($uri,$total_rows,$per_page)
	{
		$this->obj =& get_instance();
		$this->obj->load->library('pagination');
		$config['base_url'] = base_url().$uri;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['last_link'] = '&gt;&gt;';
		$config['first_link'] = '&lt;&lt;';
		$config['next_tag_open'] = '<div class="pagination-next">';
		$config['next_tag_close'] = '</div>';
		$config['prev_tag_open'] = '<div class="pagination-next">';
		$config['prev_tag_close'] = '</div>';
		$this->obj->pagination->initialize($config);
		return $this->obj->pagination->create_links();
	}
	
	function _todo()
	{
		return '<span style="color:red;">*</span>';
	}
} //end class


?>