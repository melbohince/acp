<?php

class Menu extends CI_Controller {

  var $css_style;
  var $access_level;
  var $access_filter;
  var $user_name;
  var $lang;
	var $use_db;

	function Menu()
	{
		parent::__construct();
		$is_logged_in = $this->session->userdata('logged_in');
		if ((!isset($is_logged_in)) || (!$is_logged_in)) {redirect('login/index/');}
		
		//$this->load->library('presentation');
		$this->refresh =  ''; //$this->presentation->get_refresh(-1);
		$this->css_style = $this->session->userdata('agent_css'); 
		$this->template = $this->session->userdata('template'); 
		$this->lang->load('pages', $this->session->userdata('use_language')); 
		
		$this->access_level = (($this->session->userdata('admin') == 1) ? 'ADMIN' : 'USER');
		$this->user_name = $this->session->userdata('username');
		$this->access_filter = $this->session->userdata('access_filter');
		$this->session->set_userdata(array('prior_uri'  => '','prior_page' => '')); //clear out the doubling back setup
		
		$this->load->library('navigation');	
	}
	
	function index()
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_home');
		$data['back_btn'] = null;
		$data['content'] = array(
													array (
																'view' => 'app/menu_view',
																'data' => $this->navigation->main_menu(),
															),
													array (
																'view' => 'app/message_view',
																'data' => $this->user_name.' logged in as '.$this->access_level.' {'.$this->access_filter.'}<br />'.anchor('contact', ':: '.$this->lang->line('f_contact').' ::'),
															),
														);												
		$data['display_footer'] = 'hide';
		$this->load->view($this->template, $data);
	}
						
	function find()
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_find');
		$data['back_btn'] = array ('link' => site_url().'/menu/', 'text' => $this->lang->line('p_home'),);
		$data['content'] = array(
														array (
																'view' => 'app/menu_view',
																'data' => $this->navigation->find_menu(),
														),
												);												
		$data['display_footer'] = 'show';
		$this->load->view($this->template, $data);
	}
	
	function reports()
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_reports');
		$data['back_btn'] = array ('link' => site_url().'/menu/', 'text' => $this->lang->line('p_home'),);
		$data['content'] = array (
														array(	
																'view' => 'app/menu_view',
																'data' => $this->navigation->report_menu(),
															),
													);												
		$data['display_footer'] = 'show';
		$this->load->view($this->template, $data);
	}
	
	function warehouse()
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('m_warehouse');
		$data['back_btn'] = array ('link' => site_url().'/menu/', 'text' => $this->lang->line('p_home'),);
		$data['content'] = array (
														array(	
																'view' => 'app/menu_view',
																'data' => $this->navigation->warehouse_menu(),
															),
													);												
		$data['display_footer'] = 'show';
		$this->load->view($this->template, $data);
	}
	
	function administration()
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = 'Administration';
		$data['back_btn'] = array ('link' => site_url().'/menu/', 'text' => $this->lang->line('p_home'),);
		if($this->access_level != 'ADMIN')
		{
			$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">You need to an Administrator to use that menu!</div>');
			redirect('menu/index');
		}
		$data['content'] = array (
														array(	
																'view' => 'app/menu_view',
																'data' => $this->navigation->administration_menu(),
															),
													);												
		$data['display_footer'] = 'show';
		$this->load->view($this->template, $data);
	}
	
	function settings()
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_settings');
		$data['back_btn'] = array ('link' => site_url().'/menu/', 'text' => $this->lang->line('p_home'),);
		$data['content'] = array (
														array(		'view' => 'app/menu_view',
																'data' => $this->navigation->settings_menu(),
															),
													);		
															
		$data['display_footer'] = 'show';										
		$this->load->view($this->template, $data);
	}
	
} //end class

/* End of file menu.php */
/* Location: ./system/application/controllers/menu.php */