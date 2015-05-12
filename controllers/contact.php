<?php

class Contact extends CI_Controller {

	var $css_style;
	var $refresh;
	var $message;
	
	function Contact()
	{
		parent::__construct();	
		$is_logged_in = $this->session->userdata('logged_in');
		if ((!isset($is_logged_in)) || (!$is_logged_in)) {redirect('login/index/');}
		
		// $this->load->library('presentation');
		$this->refresh = ''; // $this->presentation->get_refresh(-1);
		$this->css_style = $this->session->userdata('agent_css');
		$this->template = $this->session->userdata('template');
		$this->lang->load('pages', $this->session->userdata('use_language'));
		
//log_message('error', 'Contact class called');
	}
	
	function index()
	{	
	  $this->compose();
  }
  
	function compose()
	{	
	  $this->load->library('form_validation');
	  $this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');

		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_contact');
		$data['back_btn'] = array ('link' => site_url().'/menu/', 'text' => $this->lang->line('p_home'),);
		//$data['back_btn'] = array ('link' => site_url().$this->session->userdata('last_uri'), 'text' => $this->session->userdata('last_page'),);
		$data['display_footer'] = 'show';
		$data['message'] = $this->message;
//'[ACP'.$this->session->userdata('access_filter').']'
		$data['subject'] = '';
		$data['body'] = '';
//log_message('error', 'compose() functin called subject'.$data['subject'].' body='.$data['body']);
		$data['content'] = array(																
																array (
																	'view' => 'app/contact_view',
																	'data' => $data,
																),
																
																array (
																	'view' => 'app/message_view',
																	'data' => '<br >The email message will be cc\'d to your email address.',
																),

															);

    if ($this->form_validation->run('email_message') == FALSE)
		{
		  $this->load->view($this->template, $data);
    }
    else
    {
      $this->send();
    }

	}
	
	function calloff()
	{
	  
	  $this->load->library('form_validation');
	  $this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');

		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_contact');
		//$data['back_btn'] = array ('link' => site_url().'/menu/', 'text' => $this->lang->line('p_home'),);
		$data['back_btn'] = array ('link' => site_url().$this->session->userdata('last_uri'), 'text' => $this->session->userdata('last_page'),);
		$data['display_footer'] = 'show';
		$data['message'] = $this->message;

//log_message('error', 'cpn='.$_POST['cpn'].' qty='.$_POST['qty_calloff']);
//'[ACP'.$this->session->userdata('access_filter').
		$data['subject'] = 'Calloff on '.$_POST['cpn'].' Requested';
		$data['body'] = 'Need '.$_POST['qty_calloff'].' by '.date("l, m-d-Y",time() + (7 * 24 * 60 * 60)).' delivered to ';
		$data['content'] = array(
																array (
																	'view' => 'app/call_off_view',
																	'data' => $data,
																),

																array (
																	'view' => 'app/message_view',
																	'data' => '<br >The email message will be cc\'d to your email address.',
																),
																
															);
		
/* can't get the setvalue to work and on_load generates validation errors 
    if ($this->form_validation->run('email_message') == FALSE)
		{*/
		  $this->load->view($this->template, $data);
/*    }
    else
    {
      $this->send();
    }
*/
  }
  
	function send()
	{
    $this->load->library('email');

    $this->email->from($this->config->item('email_from'), 'arkay_portal');
    $this->email->reply_to($this->session->userdata('email'), $this->session->userdata('username'));
    $this->email->to('arkay.portal@arkay.com','Distribution');
    $this->email->cc($this->session->userdata('email'), $this->session->userdata('username'));
    $this->email->bcc('bohince@gmail.com');

    $this->email->subject($_POST['prefix'].$_POST['subject']);
    $this->email->message($_POST['body']);

    if ($this->email->send())
    {
        $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Email has been sent!</div>');
        redirect('menu');
    }
    else
    {
        $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Email failed!</div>');
        log_message('error', $this->email->print_debugger());
    }

    
  }
  
  
}

/* End of file contact.php */
/* Location: ./system/application/controllers/contact.php */