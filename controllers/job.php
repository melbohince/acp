<?php

class Job extends CI_Controller {

	var $css_style;
	
	function Job()
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
		$this->load->model('job_model');
	}
		
	function index()
	{
		$this->all();
	}
	
	function all($sort = '') // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_jobs');
		$data['back_btn'] = array ('link' => site_url().'/menu/reports', 'text' => $this->lang->line('p_reports'),);
		$data['display_footer'] = 'show';

    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    $this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    
	  $unique = $this->job_model->all($sort);
    if($unique->num_rows() > 0) 
   	{
				$data['content'] = array(
																		array (
																			'view' => 'app/message_view',
																			'data' => 'Here are all your jobs:',
																		),
																		
																		array (
																			'view' => 'job/job_all_view',
																			'data' => $unique,
																		),

																	);

		 } else {
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.'No Jobs were found.<br />Please try again</div>');
				redirect('menu/reports');
		 }

    $this->load->view($this->template, $data);
	}
	
	
	function show($fg_key)
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		//$data['back_btn'] = array ('link' => site_url().'/menu/find', 'text' => $this->lang->line('p_reports'),);
		$data['back_btn'] = array ('link' => site_url().$this->session->userdata('last_uri'), 'text' => $this->session->userdata('last_page'),);
		$data['display_footer'] = 'show';
		$data['page_title'] = $this->lang->line('p_product_code');

    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => 'Jobs for product '.$fg_key,
																),
																
																array (
																	'view' => 'job/job_list_view',
																	'data' => $this->job_model->show_jobs($fg_key),
																),
															);
																
    $this->load->view($this->template, $data);
	}
}

/* End of file job.php */
/* Location: ./system/application/controllers/job.php */
?>