<?php

class Login extends CI_Controller {

	var $css_style;
	var $template;
	var $refresh;
	var $message;
	
	function Login()
	{
		parent::__construct();	
		
		$this->load->library('presentation');
		$this->refresh = ''; //$this->presentation->get_refresh(-1); //option to refresh page, -1 is no refresh, else #seconds
		$this->css_style = $this->presentation->get_style(); //decide on css style sheet for mobile or desktop
		$this->template = $this->presentation->get_template(); //decide on webpage structure for mobile or desktop
		$this->lang->load('pages', 'english'); //established after login's check box is set and user mode runs
		//echo $this->css_style.' '.$this->template;
	}
	
	function index()
	{	
	  $this->load->library('form_validation');
	  $this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
	  
		$this->message = null;
		$data['style'] = $this->css_style;
		$data['template'] = $this->template;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = 'Arkay Portal';
		$data['back_btn'] = null;
		$data['display_footer'] = 'hide';
		$data['display_logout'] = 'hide';
		$data['message'] = $this->message;
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => 'Your information now.',
																),
																
																array (
																	'view' => 'app/login_view',
																	'data' => $data,
																),
															);

    if ($this->form_validation->run('login') == FALSE)
		{
      $this->load->view($this->template, $data);
    }
    else
    {
      $this->challenge();
    }

	}
	
	function challenge()
	{
		$this->load->model('user_model');
		if($this->user_model->validate($_POST, $this->css_style, $this->template))
		{
			redirect('menu/index/'.$_POST['username']);
		} else {
			$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">User name or password incorrect.<br />Please try again</div>');
			redirect('login/index/');
		}
  }
  
	function logout()
	{
		$was_user = str_replace(' ','_',$this->session->userdata('username'));
		$this->message = '<div id="alert"><h3 style="color:blue;">Thanks for stopping by '.$this->session->userdata('username').'.<br />Please login to continue:</h3></div>';
		$this->session->sess_destroy();
		redirect('login/relogin/'.$was_user);
	}
		
	function relogin($user = '')
	{
		$data['style'] = $this->css_style;
		$data['template'] = $this->template;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = "Arkay Portal";
		$data['back_btn'] = null;
		$data['display_footer'] = 'hide';
		$data['display_logout'] = 'hide';
		$data['message'] = $this->message;
		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $user.' Logged Out',
																),
																
																array (
																	'view' => 'app/login_view',
																	'data' => $data,
																),
															);
		
		$this->load->view($this->template, $data);
  }
 
	function add()
	{
	  $this->access_level = (($this->session->userdata('admin') == 1) ? 'ADMIN' : 'USER');
	  if($this->access_level != 'ADMIN')
		{
			$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Access Denied!</div>');
			redirect('menu/index');
		}
	  $this->load->library('form_validation');
  	$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
  	
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = "Add User";
		$data['back_btn'] = array ('link' => site_url().'/menu/administration', 'text' => 'Admin',);
		$data['display_footer'] = 'show';
		$data['display_logout'] = 'show';
		$data['message'] = $this->message;
		$data['content'] = array(																
																array (
																	'view' => 'app/user_add_view',
																	'data' => $data,
																),
															);
		
		if ($this->form_validation->run('update_user') == FALSE)
		{		
  		$this->load->view($this->template, $data);
  	}
		else
		{
		  $this->save_user();
  	}
  	
  }
    
 	function save_user()
	{
		$this->load->model('user_model');
		
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = "Save User";
		$data['back_btn'] = array ('link' => site_url().'/menu/administration', 'text' => 'Settings',);
		$data['display_footer'] = 'show';
		$data['display_logout'] = 'show';
		$data['message'] = $this->message;
		if(isset($_POST['save_btn']))
		{
		  if($this->user_model->update($_POST) == 1)
			{
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">User Saved</div>');
				redirect('menu/administration');
			} 
			else 
			{
			  $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">User Not Saved</div>');
			  redirect('menu/administration');
		  }
	  }
	  else
	  {
	    $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">User Not Changed</div>');
	    redirect('menu/administration');
    }
    
    //echo $message;

  } //save user
  
  
	function crud()
	{
	  $this->access_level = (($this->session->userdata('admin') == 1) ? 'ADMIN' : 'USER');
	  if($this->access_level != 'ADMIN')
		{
			$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Access Denied!</div>');
			redirect('menu/index');
		}
	  $this->load->library('form_validation');
  	$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
  	
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = "Users";
		$data['back_btn'] = array ('link' => site_url().'/menu/administration', 'text' => 'Admin',);
		$data['display_footer'] = 'show';
		$data['display_logout'] = 'show';
		$data['message'] = $this->message;

    $this->load->model('user_model');
	  $user_records = $this->user_model->all();
    if($user_records->num_rows() > 0) 
   	{
				$data['content'] = array(
																		array (
																			'view' => 'app/message_text_view',
																			'data' => '<br />'.anchor('login/add', 'Add new user'),
																		),
																		
																		array (
																			'view' => 'app/user_all_view',
																			'data' => $user_records,
																		),

																	);

		 } else {
				$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.'No Users were found.<br />Please try again</div>');
				redirect('menu/administration');
		 }

    $this->load->view($this->template, $data);
    
   } //crud

	function update($id)
	{
	  $this->access_level = (($this->session->userdata('admin') == 1) ? 'ADMIN' : 'USER');
	  if($this->access_level != 'ADMIN')
		{
			$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Access Denied!</div>');
			redirect('menu/index');
		}
		$this->load->model('user_model');
		
	  $this->load->library('form_validation');
  	$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
  	
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = "Update User";
		$data['back_btn'] = array ('link' => site_url().'/menu/administration', 'text' => 'Admin',);
		$data['display_footer'] = 'show';
		$data['display_logout'] = 'show';
		$data['message'] = $this->message;
		
		$query = $this->user_model->show($id);
		if($query->num_rows() == 1)
		{
			$row = $query->row();
			$data['content'] = array(
																		array (
																			'view' => 'app/user_update_view',
																			'data' => $query,
																		),
																	);	
			
  		if ($this->form_validation->run('update_user') == FALSE)
  		{		
    		$this->load->view($this->template, $data);
    	}
  		else
  		{
  		  $this->save_user(); //$_POST['id']
    	}		
			
		}
		else
		{
		  $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg"> user: '.$id.' was not found.<br />Please try again</div>');
			redirect('menu/index'); //get out of here	
	  }
  	
  } //update
     
	function delete($id)
	{
	  $this->access_level = (($this->session->userdata('admin') == 1) ? 'ADMIN' : 'USER');
	  if($this->access_level != 'ADMIN')
		{
			$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">Access Denied!</div>');
			redirect('menu/index');
		}
		
	  $this->load->library('form_validation');
  	$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
  	
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = "Users";
		$data['back_btn'] = array ('link' => site_url().'/menu/administration', 'text' => 'Admin',);
		$data['display_footer'] = 'show';
		$data['display_logout'] = 'show';
		$data['message'] = $this->message;

    $this->load->model('user_model');
	  $user_records = $this->user_model->delete($id);
		$this->session->set_flashdata('alert', '<div id="alert" class="flash-msg">'.'No Users were found.<br />Please try again</div>');
		redirect('login/crud');
   } //delete
   

	function change_password()
	{
		$this->load->model('user_model');
		
	  $this->load->library('form_validation');
  	$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
  	
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = "Change Password";
		$data['back_btn'] = array ('link' => site_url().'/menu/settings', 'text' => 'Settings',);
		$data['display_footer'] = 'show';
		$data['display_logout'] = 'show';
		$data['message'] = $this->message;
		
		$query = $this->user_model->show_by_username($this->session->userdata('username'));
		if($query->num_rows() == 1)
		{
			$row = $query->row();
			$data['content'] = array(
			
																	array (
																			'view' => 'app/message_view',
																			'data' => 'Reset Password for '.$this->session->userdata('username'),
																		),
																		
																	array (
																			'view' => 'app/user_chgpwd_view',
																			'data' => $query,
																		),
																	);	
			
  		if ($this->form_validation->run('change_password') == FALSE)
  		{		
    		$this->load->view($this->template, $data);
    	}
  		else
  		{
  		  redirect('menu/settings');//$this->save_user(); //$_POST['id']
    	}		
			
		}
		else
		{
		  $this->session->set_flashdata('alert', '<div id="alert" class="flash-msg"> user: '.$id.' was not found.<br />Please try again</div>');
			redirect('menu/index'); //get out of here	
	  }
  	
  } //change_password
    
}

/* End of file login.php */
/* Location: ./system/application/controllers/login.php */