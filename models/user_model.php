<?php

class User_model extends CI_Model {

    function User_model()
    {
        // Call the Model constructor
        parent::__construct();
    }

	  function validate($form_data, $style, $template)
	  {
			$username = $form_data['username'];
			$pwd = $form_data['password'];
			$use_db = ''; //use the config file
			if(isset($form_data['lang_cb']))
			{
				$lang = 'spanish';
			} else {
				$lang = 'english';
			}
			
      $this->load->database($use_db);
			$sql = "select id, user_name, access_filter, email, admin_indicator, wms_indicator, use_counter from users ";
      $sql .= "where user_name = '".$username."' and password = '".md5($pwd)."'";
    	$user = $this->db->query($sql);

		  if($user->num_rows() == 1) 
	   	{
				$user_record = $user->row();
				
					$cookie_data = array(
																'username'  => $user_record->user_name,
																'access_filter' => $user_record->access_filter,
																'admin' => $user_record->admin_indicator,
																'wms_mgr' => $user_record->wms_indicator,
																'email' => $user_record->email,
																'logged_in' => TRUE,
																'agent_css' => $style,
																'template' => $template,
																'database'	=> $use_db,
																'use_language'	=> $lang,
																'last_uri'  => 'menu',
																'last_page' => 'Home',
																'prior_uri'  => '',
																'prior_page' => '',
					               );

					$this->session->set_userdata($cookie_data);
			
    			$data = array(
    							'use_counter' => $user_record->use_counter + 1,
    							'last_used' => date("Y-m-d : H:i:s", time()),
                 );		

    			$this->db->where('id', $user_record->id);
    			$this->db->update('users', $data);
    						
					return TRUE;
					
				//} else { //password is wrong
				//	$this->session->sess_destroy();
				//	return FALSE;	
				//} //pwd
				
			} else { //user not found
				$this->session->sess_destroy();
				return FALSE;
			} //login_id
			
	  } //validate
	  
	  function update($form_data)
	  { 
			$data = array(
							'user_name' => $form_data['username'],
							'password' => md5($form_data['password']),
							'email' => $form_data['email'],
							'access_filter' => $form_data['access_filter'],
							'admin_indicator' => $form_data['admin_indicator'],
							'wms_indicator' => $form_data['wms_indicator'],
             );
      $this->load->database($this->session->userdata('database'));       
      $sql = "select user_name from users ";
      $sql .= "where user_name = '".$form_data['username']."'";
    	$user = $this->db->query($sql);
    	
    	if($user->num_rows() == 1) 
    	{
				$this->db->where('user_name', $form_data['username']);
				$this->db->update('users', $data);
  	  }
  	  else  //insert
  	  {
    	  $this->db->insert('users', $data);
	    }
    	
    	return $this->db->affected_rows();
    }
    
	  function all()
	  {   
	    $this->load->database($this->session->userdata('database'));          
      $sql = "select * from users ";
      $sql .= "where 1 ";
      $sql .= "order by user_name" ;
    	return $this->db->query($sql);  	
    }//all
    
    function delete($id)
	  {    
	    $this->load->database($this->session->userdata('database'));         
      $sql = "delete from users ";
      $sql .= "where id = ? ";
    	return $this->db->query($sql, $id);  	
    }//all
    
    function show($id)
	  { 
	    $this->load->database($this->session->userdata('database'));            
      $sql = "select * from users ";
      $sql .= "where id = ? ";
    	return $this->db->query($sql, $id);  	
    }//show
    
    function show_by_username($username)
	  { 
	    $this->load->database($this->session->userdata('database'));            
      $sql = "select * from users ";
      $sql .= "where user_name = ? ";
    	return $this->db->query($sql, $username);  	
    }//show
    
}

?>
