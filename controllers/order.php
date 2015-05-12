<?php

class Order extends CI_Controller {

	var $css_style;
	
	function Order()
	{
		parent::__construct();	
		$is_logged_in = $this->session->userdata('logged_in');
		if ((!isset($is_logged_in)) || (!$is_logged_in)) {redirect('login/index/');}
		
		//$this->load->library('presentation');
		$this->refresh =  ''; //$this->presentation->get_refresh(-1);
		$this->css_style = $this->session->userdata('agent_css');
		$this->template = $this->session->userdata('template');
		$this->lang->load('pages', $this->session->userdata('use_language'));
		
		$this->load->library('allowed_access'); //append where clause with specific customer
		$this->load->model('order_model');
	}
		
	function index()
	{
		$this->lookup();
	}

	function lookup($criteria = '') //called by index to find which cpn to lookup
	{
		// template_view requires: style, page_title, back_btn, content, $display_footer
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_lookup');
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_find'),);
		$data['content'] = array( 
																array (
																	'view' => 'order/lookup_order_view',
																	'data' => $criteria,
																),
															);

		$data['display_footer'] = 'show';

		if ($this->form_validation->run('lookup_order') == FALSE)
		{		
  		$this->load->view($this->template, $data);
  	}
		else
		{
		  $this->find();
  	}	
	} //lookup
	
	function find() // called by lookup_view
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_orders');
		$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_find'),);
		$data['display_footer'] = 'show';

    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
        
    $po_to_match = $_POST['po_number'];
	  // see if the $cpn_to_match will only find one cpn in the jobits table
	  $unique = $this->order_model->is_unique($po_to_match);
    if($unique->num_rows() > 1) 
   	{
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Please be more specific, perhaps one of these:',
																		),
																		
																		array (
																			'view' => 'order/order_found_view',
																			'data' => $unique,
																		),
																		
																		array (
																			'view' => 'order/lookup_order_view',
																			'data' => '',
																		),
																	);

	   } elseif ($unique->num_rows() == 1) {
	      $row = $unique->row();
	      $po = $row->po_number; //get the full cpn in case the fragment was unique
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Purchase Orders for '.$po,
																		),
																		
																		array (
																			'view' => 'order/order_all_view',
																			'data' => $this->order_model->show_order($po),
																		),
																		
																		array (
																			'view' => 'order/lookup_order_view',
																			'data' => '',
																		),
																	);

		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.$po_to_match.' was not found.<br />Please try again</div>');
				redirect('order/lookup/'.$po_to_match);
		 }

    $this->load->view($this->template, $data);
	} //find

	
	function all($sort = '') // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_orders');
		$data['back_btn'] = array ('link' => site_url().'/menu/reports', 'text' => $this->lang->line('p_reports'),);
		$data['display_footer'] = 'show';

    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    $this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    
	  $unique = $this->order_model->all($sort);
    if($unique->num_rows() > 0) 
   	{
	      //die( $unique->num_rows()." too many found");
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Here are all your Orders:',
																		),
																		
																		array (
																			'view' => 'order/order_all_view',
																			'data' => $unique,
																		),

																	);

		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.' No Orders were found.<br />Please try again</div>');
				redirect('menu/reports');
		 }

    $this->load->view($this->template, $data);
	}
	
	function open($sort = '') // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_orders');
		$data['back_btn'] = array ('link' => site_url().'/menu/reports', 'text' => $this->lang->line('p_reports'),);
		$data['display_footer'] = 'show';

    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    $this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    
	  $unique = $this->order_model->open($sort);
    if($unique->num_rows() > 0) 
   	{
	      //die( $unique->num_rows()." too many found");
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Here are all your Orders:',
																		),
																		
																		array (
																			'view' => 'order/order_all_view',
																			'data' => $unique,
																		),

																	);

		 } else {
				//die("No records found!");
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.' No Orders were found.<br />Please try again</div>');
				redirect('menu/reports');
		 }

    $this->load->view($this->template, $data);
	}
		
	function show($fg_key)
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		//$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_reports'),);
		$data['back_btn'] = array ('link' => site_url().$this->session->userdata('last_uri'), 'text' => $this->session->userdata('last_page'));
		$data['display_footer'] = 'show';
		$data['page_title'] = $this->lang->line('p_orders');
    
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => 'Orders for product '.$fg_key.'<br /><em style="style="font-size:75%;> (past 6 months)</em>',
																),
																
																array (
																	'view' => 'order/order_list_view',
																	'data' => $this->order_model->show_orders($fg_key),
																),
															);
																
    $this->load->view($this->template, $data);
	}
}

/* End of file order.php */
/* Location: ./system/application/controllers/order.php */
?>