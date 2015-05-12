<?php

class Cpn extends CI_Controller {

	var $css_style;
	
	function Cpn()
	{
		parent::__construct();	
		$is_logged_in = $this->session->userdata('logged_in');
		if ((!isset($is_logged_in)) || (!$is_logged_in)) {redirect('login/index/');}
		
		// $this->load->library('presentation');
		$this->refresh =  ''; //$this->presentation->get_refresh(-1);
		$this->css_style = $this->session->userdata('agent_css');
		$this->template = $this->session->userdata('template');
		$this->lang->load('pages', $this->session->userdata('use_language'));
		
		$this->load->helper('date');
		
		$this->load->library('allowed_access'); //append where clause with specific customer
		$this->load->model('cpn_model');
		//log_message('error', 'Cpn class called');
	}
		
	function index()
	{
		$this->lookup();
	} //index
	
	function lookup($criteria = '') //called by index to find which cpn to lookup
	{
		// template_view requires: style, page_title, back_btn, content, $display_footer
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->session->set_userdata(array('prior_uri'  => '','prior_page' => '')); //clear out the doubling back setup
		
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_lookup');
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_find'),);
		$data['content'] = array( 
																array (
																	'view' => 'cpn/lookup_cpn_view',
																	'data' => $criteria,
																),
															);

		$data['display_footer'] = 'show';

		if ($this->form_validation->run('lookup_cpn') == FALSE)
		{		
  		$this->load->view($this->template, $data);
  	}
		else
		{
		  $this->find();
  	}	
	} //lookup
	
	function find($cpn = '') // called by lookup_view
	{
	  if($cpn == '')
	  {
	    $cpn_to_match = $_POST['product_code'];
    }
    else
    {
      $cpn_to_match = $cpn;
    }
    
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_product_code');
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_lookup'),);
		$data['display_footer'] = 'show';
    
    
	  // see if the $cpn_to_match will only find one cpn in the jobits table
	  $unique = $this->cpn_model->is_unique($cpn_to_match);
    if($unique->num_rows() > 1) 
   	{
   	    $data['page_title'] = $this->lang->line('p_inventory');
	      $data['back_btn'] = array ('link' => site_url().'/cpn/lookup/'.$cpn_to_match, 'text' => $cpn_to_match,);
	      $this->session->set_userdata(array('last_uri'  => '/cpn/find/'.$cpn_to_match,'last_page' => $cpn_to_match)); //so we can return to this page if linky clicked
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Please be more specific, perhaps one of these:',
																		),
																		
																		array (
																			'view' => 'cpn/cpn_list_view',
																			'data' => $unique,
																		),
																		
																		array (
																			'view' => 'cpn/lookup_cpn_view',
																			'data' => '',
																		),
																	);

	   } elseif ($unique->num_rows() == 1) {
	      $this->load->model('wms_model');
	      $row = $unique->row();
	      $cpn = $row->product_code; //get the full cpn in case the fragment was unique
	      $data['back_btn'] = array ('link' => site_url().'/cpn/lookup/'.$cpn, 'text' => $cpn,);
	      $this->session->set_userdata(array('last_uri'  => '/cpn/find/'.$cpn,'last_page' => $cpn));
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Details of '.$cpn,
																		),
																		
																		array (
																			'view' => 'cpn/cpn_detail_view',
																			'data' => $this->cpn_model->show_inventory($row->product_code),
																		),
																		
																		array (
												    					'view' => 'wms/wms_summary_view',
    																	'data' => $this->wms_model->cpn_summary($cpn),
    																),
    																
																		array (
																			'view' => 'cpn/lookup_cpn_view',
																			'data' => '',
																		),
																	);

		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.$cpn_to_match.' was not found.<br />Please try again</div>');
				redirect('cpn/lookup/'.$cpn_to_match);
		 }
		 
//log_message('error', 'last='.$this->session->userdata('last_uri').' in fg/find');
//log_message('error', 'prior='.$this->session->userdata('prior_uri').' in fg/find');

    $this->load->view($this->template, $data);
	} //find
	
	function show($fg_key)
	{
	  $this->load->model('wms_model');
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		//$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_find'),);
		log_message('error', 'last='.$this->session->userdata('last_page').' in fg/show');
		log_message('error', 'prior='.$this->session->userdata('prior_page').' in fg/show');
		if($this->session->userdata('prior_uri') == '') //have we passed thru here before (returning from a list button
    {
		  $data['back_btn'] = array ('link' => site_url().$this->session->userdata('last_uri'), 'text' => $this->session->userdata('last_page'),);
		  $this->session->set_userdata(array('prior_uri'  => site_url().$this->session->userdata('last_uri'),'prior_page' => $this->session->userdata('last_page'))); //for doubling back
  	} 
  	else
  	{
	    $data['back_btn'] = array ('link' => $this->session->userdata('prior_uri'), 'text' => $this->session->userdata('prior_page'),);
    }
	
		$data['display_footer'] = 'show';
		$data['page_title'] = $this->lang->line('p_product_code');
    
    
    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $fg_key)); //so we can return to this page if linky clicked 
		
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => 'Details of '.$fg_key,
																),
																
																array (
																	'view' => 'cpn/cpn_detail_view',
																	'data' => $this->cpn_model->show_inventory($fg_key),
																),
																																
																array (
																	'view' => 'wms/wms_summary_view',
																	'data' => $this->wms_model->cpn_summary($fg_key),
																),
															);
																
    $this->load->view($this->template, $data);
	} //show

	function lookup_line($criteria = '') //lookup by product's line
	{
		// template_view requires: style, page_title, back_btn, content, $display_footer
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->session->set_userdata(array('prior_uri'  => '','prior_page' => '')); //clear out the doubling back setup
		
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_lookup');
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_find'),);
		$data['content'] = array( 
																array (
																	'view' => 'cpn/lookup_line_view',
																	'data' => $criteria,
																),
															);

		$data['display_footer'] = 'show';

		if ($this->form_validation->run('lookup_line') == FALSE)
		{		
  		$this->load->view($this->template, $data);
  	}
		else
		{
		  $this->find_line();
  	}	
	} //lookup_line
		
	function find_line($line = '') // called by lookup_line_view
	{
		if($line == '')
	  {
	    $line_to_match = $_POST['product_line'];
    }
    else
    {
      $line_to_match = $line;
    }
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = 'Look Up';
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_lookup'),);
		$data['display_footer'] = 'show';
    
    
	  // see if the $cpn_to_match will only find one cpn in the jobits table
	  $unique = $this->cpn_model->is_unique_line($line_to_match);
    if($unique->num_rows() > 1) 
   	{
   	    $data['page_title'] = $this->lang->line('p_inventory');
   	    $data['back_btn'] = array ('link' => site_url().'/cpn/lookup_line/'.$line_to_match, 'text' => $line_to_match,);
	      $this->session->set_userdata(array('last_uri'  => '/cpn/find_line/'.$line_to_match,'last_page' => $line_to_match));
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Please be more specific, perhaps one of these:',
																		),
																		
																		array (
																			'view' => 'cpn/cpn_line_view',
																			'data' => $this->cpn_model->show_product_lines($line_to_match),
																		),
																		
																		array (
																			'view' => 'cpn/lookup_line_view',
																			'data' => '',
																		),
																	);

	   } elseif ($unique->num_rows() == 1) {
	      $row = $unique->row();
	      $line = $row->product_line; //get the full cpn in case the fragment was unique
	      $data['back_btn'] = array ('link' => site_url().'/cpn/lookup_line/'.$line, 'text' => $line,);
	      $this->session->set_userdata(array('last_uri'  => '/cpn/find_line/'.$line,'last_page' => $line));
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Product Codes of '.$line,
																		),
																		
																		array (
																			'view' => 'cpn/cpn_list_view',
																			'data' => $this->cpn_model->show_inventory_by_line($line),
																		),
																		
																		array (
																			'view' => 'cpn/lookup_line_view',
																			'data' => '',
																		),
																	);

		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.$line_to_match.' was not found.<br />Please try again</div>');
				redirect('cpn/lookup_line/'.$line_to_match);
		 }

    $this->load->view($this->template, $data);
	} //find line
	
	function lookup_desc($criteria = '') //called by index to find which cpn to lookup
	{
		// template_view requires: style, page_title, back_btn, content, $display_footer
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->session->set_userdata(array('prior_uri'  => '','prior_page' => '')); //clear out the doubling back setup
		
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_lookup');
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_find'),);
		$data['content'] = array( 
																array (
																	'view' => 'cpn/lookup_desc_view',
																	'data' => $criteria,
																),
															);

		$data['display_footer'] = 'show';

		if ($this->form_validation->run('lookup_desc') == FALSE)
		{		
  		$this->load->view($this->template, $data);
  	}
		else
		{
		  $this->find_desc();
  	}	
	} //lookup_desc
	
	function find_desc($desc = '') // called by lookup_view
	{
		if($desc == '')
	  {
	    $desc_to_match = $_POST['product_desc'];
    }
    else
    {
      $desc_to_match = $desc;
    }
	  
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_product_code');
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_lookup'),);
		$data['display_footer'] = 'show';
    
	  $unique = $this->cpn_model->find_by_desc($desc_to_match);
    if($unique->num_rows() > 1) 
   	{
	      $data['page_title'] = $this->lang->line('p_inventory');
	      $data['back_btn'] = array ('link' => site_url().'/cpn/lookup_desc/'.$desc_to_match, 'text' => $desc_to_match,);
	      $this->session->set_userdata(array('last_uri'  => '/cpn/find_desc/'.$desc_to_match,'last_page' => $desc_to_match));
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Please be more specific, perhaps one of these:',
																		),
																		
																		array (
																			'view' => 'cpn/cpn_list_view',
																			'data' => $unique,
																		),
																		
																		array (
																			'view' => 'cpn/lookup_cpn_view',
																			'data' => '',
																		),
																	);

	   } elseif ($unique->num_rows() == 1) {
	      $row = $unique->row();
	      $desc = $row->description; //get the full cpn in case the fragment was unique
	      $data['back_btn'] = array ('link' => site_url().'/cpn/lookup_desc/'.$desc, 'text' => $desc,);
	      $this->session->set_userdata(array('last_uri'  => '/cpn/find_desc/'.$desc,'last_page' => $desc));
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Inventory for '.$desc,
																		),
																		
																		array (
																			'view' => 'cpn/cpn_detail_view',
																			'data' => $this->cpn_model->show_inventory($row->product_code),
																		),
																		
																		array (
																			'view' => 'cpn/lookup_cpn_view',
																			'data' => '',
																		),
																	);

		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.$desc_to_match.' was not found.<br />Please try again</div>');
				redirect('cpn/lookup_desc/'.$desc_to_match);
		 }

    $this->load->view($this->template, $data);
	} //find_desc	
	
	function show_line($line)
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_lookup'));
		$data['display_footer'] = 'show';
		$data['page_title'] = $data['page_title'] = $this->lang->line('p_inventory');
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => 'Products of '.$line,
																),
																
																array (
																	'view' => 'cpn/cpn_list_view',
																	'data' => $this->cpn_model->show_inventory_by_line($line),
																),
															);
																
    $this->load->view($this->template, $data);
	}
	
	function shortages($sort = '') // called by lookup_view
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_shortages');
		$data['back_btn'] = array ('link' => site_url().'/menu/reports', 'text' => $this->lang->line('p_reports'),);
		$data['display_footer'] = 'show';
    
    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    //$this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    
	  $short = $this->cpn_model->shortages($sort);
    if($short->num_rows() > 0) 
   	{
	      //die( $unique->num_rows()." too many found");
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Items that do not meet Order quantity:',
																		),
																		
																		array (
																			'view' => 'cpn/cpn_shortage_view',
																			'data' => $short,
																		),

																	);


		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.' No shortages found.</div>');
				redirect('menu/reports');
		 }

    $this->load->view($this->template, $data);
	} //shortages
	
	function can_ship($sort = '') // called by lookup_view
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_can_ship');
		$data['back_btn'] = array ('link' => site_url().'/menu/reports', 'text' => $this->lang->line('p_reports'),);
		$data['display_footer'] = 'show';
    
    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    //$this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    
	  $ready = $this->cpn_model->can_ship($sort);
    if($ready->num_rows() > 0) 
   	{
	      //die( $unique->num_rows()." too many found");
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Items that are ready to ship:',
																		),
																		
																		array (
																			'view' => 'cpn/cpn_liability_view',//cpn_canship_view',
																			'data' => $ready,
																		),

																	);


		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.' No shortages found.</div>');
				redirect('menu/reports');
		 }

    $this->load->view($this->template, $data);
	} //can_ship
}

/* End of file cpn.php */
/* Location: ./system/application/controllers/cpn.php */
?>