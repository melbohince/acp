<?php

class Release extends CI_Controller {

	var $css_style;
	
	function Release()
	{
		parent::__construct();	
		$is_logged_in = $this->session->userdata('logged_in');
		if ((!isset($is_logged_in)) || (!$is_logged_in)) {redirect('login/index/');}
		
		// $this->load->library('presentation');
		$this->refresh =  ''; //$this->presentation->get_refresh(-1);
		$this->css_style = $this->session->userdata('agent_css');
		$this->template = $this->session->userdata('template');
		$this->lang->load('pages', $this->session->userdata('use_language'));
		
		$this->load->library('allowed_access'); //append where clause with specific customer
		$this->load->model('release_model');
		
	}
		
	function index()
	{
		$this->all();
	}
	
	function all($sort = '') // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_releases');
		$data['back_btn'] = array ('link' => site_url().'/menu/reports', 'text' => $this->lang->line('p_reports'),);
		$data['display_footer'] = 'show';

    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    $this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    
	  $unique = $this->release_model->all($sort);
    if($unique->num_rows() > 0) 
   	{
	      //die( $unique->num_rows()." too many found");
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Here are all your Releases:',
																		),
																		
																		array (
																			'view' => 'release/release_all_view',
																			'data' => $unique,
																		),

																	);

		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.' No Releases were found.<br />Please try again</div>');
				redirect('menu');
		 }

    $this->load->view($this->template, $data);
	}

	function open($sort = '') // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_releases');
		$data['back_btn'] = array ('link' => site_url().'/menu/reports', 'text' => $this->lang->line('p_reports'),);
		$data['display_footer'] = 'show';

		$this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
		$this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
		
	  $unique = $this->release_model->open($sort);
    if($unique->num_rows() > 0) 
   	{
	      //die( $unique->num_rows()." too many found");
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Here are your open Releases:',
																		),
																		
																		array (
																			'view' => 'release/release_open_view',
																			'data' => $unique,
																		),

																	);

		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.' No Releases were found.<br />Please try again</div>');
				redirect('menu/reports');
		 }

    $this->load->view($this->template, $data);
	}

	function shipped($sort = '') // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_shipments');
		$data['back_btn'] = array ('link' => site_url().'/menu/reports', 'text' => $this->lang->line('p_reports'),);
		$data['display_footer'] = 'show';

    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    $this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    
	  $unique = $this->release_model->shipped($sort);
    if($unique->num_rows() > 0) 
   	{
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Here are your recent Shipments:',
																		),
																		
																		array (
																			'view' => 'release/release_shipped_view',
																			'data' => $unique,
																		),

																	);

		 } else {
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.' No recent Shipments were found.<br />Please try again</div>');
				redirect('menu/reports');
		 }

    $this->load->view($this->template, $data);
	}
		
	function show($fg_key)
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		//$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_lookup'),);
		$data['back_btn'] = array ('link' => site_url().$this->session->userdata('last_uri'), 'text' => $this->session->userdata('last_page'),);
		$data['display_footer'] = 'show';
		$data['page_title'] = $this->lang->line('p_releases');
		
    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => 'Releases for product '.$fg_key,
																),
																
																array (
																	'view' => 'release/release_list_view',
																	'data' => $this->release_model->show_releases($fg_key),
																),
															);
																
    $this->load->view($this->template, $data);
	}
	
	function lookup_cpn_by_shipto($criteria = '') //called by index to find which cpn to lookup
	{
		// template_view requires: style, page_title, back_btn, content, $display_footer
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_lookup');
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_find'),);
		
		$unique_shiptos = $this->release_model->shipto_destinations();
		$destinations = array();
		foreach($unique_shiptos->result_array() as $tablerow)
		{
		  $destinations[$tablerow['shipto']] = $tablerow['shipto'];
	  }

		$data['content'] = array( 
																array (
																	'view' => 'release/lookup_cpn_by_shipto_view',
																	'data' => $destinations,
																),
															);

		$data['display_footer'] = 'show';

		if ($this->form_validation->run('lookup_cpn_by_shipto') == FALSE)
		{		
  		$this->load->view($this->template, $data);
  	}
		else
		{
		  $this->find_cpn_by_shipto();
  	}	
	} //lookup_desc
	
	function find_cpn_by_shipto() // called by lookup_view
	{
	  $shipto_to_match = $_POST['shipto'];
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_product_code');
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_lookup'),);
		$data['display_footer'] = 'show';

    $this->session->set_userdata(array('last_uri'  => uri_string().'/'.$shipto_to_match,'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
	  // see if the $cpn_to_match will only find one cpn in the jobits table
	  $unique = $this->release_model->find_cpn_by_shipto($shipto_to_match);
    if($unique->num_rows() > 1) 
   	{
   	    $data['page_title'] = $this->lang->line('p_releases');
	      //$data['back_btn'] = array ('link' => site_url().'/release/lookup_cpn_by_shipto/'.$shipto_to_match, 'text' => $shipto_to_match,);
	      $data['back_btn'] = array ('link' => site_url().$this->session->userdata('last_uri'), 'text' => $this->session->userdata('last_page'),);
	      //switch to get cpn content
				$data['content'] = array(		
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Products that have been released to "'.$shipto_to_match.'"',
																		),
																		
																		array (
																			'view' => 'release/release_unique_product_code_view', //'cpn/cpn_list_view',
																			'data' => $unique,
																		),

																	);

	   } elseif ($unique->num_rows() == 1) {
	      $row = $unique->row();
	      $shipto = $row->shipto;
	      $cpn = $row->product_code;
	      //switch to get cpn content
	      $data['back_btn'] = array ('link' => site_url().'/release/lookup_cpn_by_shipto/'.$shipto, 'text' => $shipto,);
	      $this->load->model('cpn_model');
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Products sent to "'.$shipto_to_match.'"',
																		),
																		
																		array (
																			'view' => 'cpn/cpn_detail_view',
																			'data' => $this->cpn_model->show_inventory($cpn),
																		),
																		
																		array (
																			'view' => 'release/lookup_cpn_by_shipto_view',
																			'data' => '',
																		),
																	);

		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.$shipto_to_match.' was not found.<br />Please try again</div>');
				redirect('release/lookup_cpn_by_shipto/'.$shipto_to_match);
		 }

    $this->load->view($this->template, $data);
	} //find_by_shipto	
	
} //class release

/* End of file release.php */
/* Location: ./system/application/controllers/release.php */
?>