<?php

class Wms extends CI_Controller {

	var $css_style;
	var $message;
	
	function Wms()
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
		$this->load->model('wms_model');
	}
		
	function index()
	{
		$this->all();
	}
		
	function transit($sort = 'cpn')
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['back_btn'] = array ('link' => site_url().'/menu/warehouse', 'text' => $this->lang->line('m_warehouse'),);
		$data['display_footer'] = 'show';
		$data['page_title'] = $this->lang->line('m_warehouse');

    //$this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked 
      
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => 'Inventory In Transit',
																),
																
																array (
																	'view' => 'wms/wms_transit_view',
																	'data' => $this->wms_model->transit($sort),
																),
															);
																
    $this->load->view($this->template, $data);
	}

	function onhand($sort = 'cpn')
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['back_btn'] = array ('link' => site_url().'/menu/warehouse', 'text' => $this->lang->line('m_warehouse'),);
		$data['display_footer'] = 'show';
		$data['page_title'] = $this->lang->line('m_warehouse');

    //$this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked    
     
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => 'Inventory On-hand',
																),
																
																array (
																	'view' => 'wms/wms_onhand_view',
																	'data' => $this->wms_model->onhand($sort),
																),
															);
																
    $this->load->view($this->template, $data);
	}
	
	function all($sort = 'cpn', $notice = '')
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['back_btn'] = array ('link' => site_url().'/menu/warehouse', 'text' => $this->lang->line('m_warehouse'),);
		$data['display_footer'] = 'show';
		$data['page_title'] = 'All Inventory';

    //$this->session->set_userdata(array('prior_uri'  => '','prior_page' => ''));
    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked 
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $notice,
																),
																
																array (
																	'view' => 'wms/wms_all_view',
																	'data' => $this->wms_model->all($sort),
																),
															);
																
    $this->load->view($this->template, $data);
	}
	
	function scan_receipt($criteria = '') //called by index to find which pallet to receive
	{
		// template_view requires: style, page_title, back_btn, content, $display_footer
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->session->set_userdata(array('prior_uri'  => '','prior_page' => '')); //clear out the doubling back setup
		
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = 'Receive';
		$data['back_btn'] = array ('link' => site_url().'/menu/warehouse', 'text' => $this->lang->line('m_warehouse'),);
		$data['content'] = array( 
																array (
																	'view' => 'wms/wms_receive_view',
																	'data' => $criteria,
																),
															);

		$data['display_footer'] = 'show';

		if ($this->form_validation->run('pallet_lookup') == FALSE)
		{		
  		$this->load->view($this->template, $data);
  	}
		else
		{
		  $this->receive();
  	}	

  	
	} //scan receipt
	
	function receive($pallet = '')
	{
  	if($pallet == '')
    {
      $pallet_to_match = $_POST['pallet_id'];
      $goto = 'form';
    }
    else
    {
      $pallet_to_match = $pallet;
      $goto = 'list';
    }
  
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
    $data['back_btn'] = array ('link' => site_url().'/menu/warehouse', 'text' => $this->lang->line('m_warehouse'),);
		$data['display_footer'] = 'show';
		$data['page_title'] = 'Receive';

    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    $unique = $this->wms_model->is_unique($pallet_to_match);
    $row = $unique->row();
    $pallet = $row->pallet_id; //get the full pallet in case the fragment was unique
    
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => '<div>'.$this->wms_model->receive($pallet).'</div>',
																),
																
																array (
																	'view' => 'wms/wms_receive_view',
																	'data' => '',
																),
															);
		
    if($goto == 'list')
    {
      redirect('wms/transit');  
    }
                            														
    $this->load->view($this->template, $data);
	} //receive

	
	function scan_issue($criteria = '') //called by index to find which pallet to receive
	{
		// template_view requires: style, page_title, back_btn, content, $display_footer
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->session->set_userdata(array('prior_uri'  => '','prior_page' => '')); //clear out the doubling back setup
		
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = 'Issue';
		$data['back_btn'] = array ('link' => site_url().'/menu/warehouse', 'text' => $this->lang->line('m_warehouse'),);
		$data['content'] = array( 
																array (
																	'view' => 'wms/wms_issue_view',
																	'data' => $criteria,
																),
															);

		$data['display_footer'] = 'show';

		if ($this->form_validation->run('pallet_lookup') == FALSE)
		{		
  		$this->load->view($this->template, $data);
  	}
		else
		{
		  $this->issue();
  	}	

  	
	} //scan_issue

	function issue($pallet = '')
	{
    if($pallet == '')
    {
      $pallet_to_match = $_POST['pallet_id'];
      $goto = 'form';
    }
    else
    {
      $pallet_to_match = $pallet;
      $goto = 'list';
    }

    $data['style'] = $this->css_style;
    $data['refresh'] = $this->refresh;
    $data['back_btn'] = array ('link' => site_url().'/menu/warehouse', 'text' => $this->lang->line('m_warehouse'),);
    $data['display_footer'] = 'show';
    $data['page_title'] = 'Issue';

    $this->session->set_userdata(array('last_uri'  => uri_string(),'last_page' => $data['page_title'])); //so we can return to this page if linky clicked
    $unique = $this->wms_model->is_unique($pallet_to_match);
    $row = $unique->row();
    $pallet = $row->pallet_id; //get the full pallet in case the fragment was unique
	
      $data['content'] = array(
                              	array (
                          				'view' => 'app/message_view',
                          				'data' => '<div>'.$this->wms_model->issue($pallet).'</div>',
                          			),
    														array (
    															'view' => 'wms/wms_issue_view',
    															'data' => '',
    														),
    													);
    if($goto == 'list')
    {
      redirect('wms/onhand');  
    }
													
    $this->load->view($this->template, $data);
	} //issue
	
		function update($id)
	{
	  /*$this->access_level = (($this->session->userdata('admin') == 1) ? 'ADMIN' : 'USER');
	  if($this->access_level != 'ADMIN')
		{
			$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Access Denied!</div>');
			redirect('menu/index');
		} */
		
	  $this->load->library('form_validation');
  	$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
  	
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = "Update Pallet";
		$data['back_btn'] = array ('link' => site_url().'/wms/all', 'text' => 'All Inventory',);
		$data['display_footer'] = 'show';
		$data['display_logout'] = 'show';
		$data['message'] = $this->message;
		
		$query = $this->wms_model->show($id);
		if($query->num_rows() == 1)
		{
			$row = $query->row();
			$data['content'] = array(
																		array (
																			'view' => 'wms/wms_pallet_update_view',
																			'data' => $query,
																		),
																	);	
			
  		if ($this->form_validation->run('update_pallet') == FALSE)
  		{		
    		$this->load->view($this->template, $data);
    	}
  		else
  		{
  		  $this->save_pallet(); //$_POST['id']
    	}		
			
		}
		else
		{
		  $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg"> pallet: '.$id.' was not found.<br />Please try again</div>');
			redirect('wms/all'); //get out of here	
	  }
  	
  } //update
	
	
 	function save_pallet()
	{
		
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = "Save Pallet";
		$data['back_btn'] = array ('link' => site_url().'/wms/all', 'text' => 'All Inventory',);
		$data['display_footer'] = 'show';
		$data['display_logout'] = 'show';
		$data['message'] = $this->message;
		if(isset($_POST['save_btn']))
		{
		  if($this->wms_model->update($_POST) == 1)
			{
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Pallet Saved</div>');
				redirect('wms/all');
			} 
			else 
			{
			  $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Pallet Not Saved</div>');
			  redirect('wms/all');
		  }
	  }
	  else
	  {
	    $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Pallet Not Changed</div>');
	    redirect('wms/all');
    }
    
    //echo $message;

  } //save pallet
  

	function reset_receive($id)
	{
    $changed = $this->wms_model->reset_receive($id);
    $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.$changed.'</div>');
    redirect('wms/all/cpn/'.$changed);  
	} //reset_receive

	function reset_issue($id)
	{
    $changed = $this->wms_model->reset_issue($id);
    $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.$changed.'</div>');
    redirect('wms/all/cpn/'.$changed);   
	} //reset_issue	
	  
}

/* End of file job.php */
/* Location: ./system/application/controllers/job.php */
?>