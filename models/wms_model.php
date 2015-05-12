<?php

class Wms_model extends CI_Model {

    var $cpn   = '';
    var $sql    = '';
    private static $access_where = '';
    private static $user_name = '';

    function Wms_model()
    {
        // Call the Model constructor
        parent::__construct();
				$this->load->database($this->session->userdata('database'));
				self::$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
				self::$user_name = $this->session->userdata('username');
    }
    
    function onhand($sort)
    {
				$sql = "select id, whse_id, status, product_code, date_glued, pallet_qty, pallet_id, date_received ";
				$sql .= "from warehouses ";
				$sql .= "where whse_id = 'Rama' or whse_id = 'Roanoke'".self::$access_where; 
				
				if($sort == 'dom')
				{
				  $sql .= "order by date_glued, product_code" ;
			  }
			  elseif ($sort == 'cpn')
			  {
				  $sql .= "order by product_code, date_glued" ;
			  }
			  elseif ($sort == 'pallet')
			  {
				  $sql .= "order by pallet_id" ;
			  }
			  elseif ($sort == 'received')
			  {
				  $sql .= "order by date_received, product_code" ;
			  }
			  else
			  {
				  $sql .= "order by product_code, date_glued" ;
			  }
				return $this->db->query($sql);

    }//onhand

    function transit($sort)
    {
				$sql = "select id, status, product_code, date_glued, pallet_qty, pallet_id, date_sent ";
				$sql .= "from warehouses ";
				$sql .= "where whse_id = 'In-transit' ".self::$access_where; 
				
				if($sort == 'status')
				{
				  $sql .= "order by status, product_code, date_glued" ;
			  }
			  elseif ($sort == 'dom')
			  {
				  $sql .= "order by date_glued, product_code" ;
			  }
			  elseif ($sort == 'cpn')
			  {
				  $sql .= "order by product_code, date_glued" ;
			  }
			  elseif ($sort == 'pallet')
			  {
				  $sql .= "order by pallet_id, date_glued" ;
			  }
			  elseif ($sort == 'sent')
			  {
				  $sql .= "order by date_sent, pallet_id" ;
			  }
			  else
			  {
				  $sql .= "order by product_code, date_glued" ;
			  }
				return $this->db->query($sql);

    }//transit
    
    function all($sort)
    {
				$sql = "select id, status, whse_id, product_code, jobit, date_glued, pallet_id, pallet_qty, num_cases, date_sent, date_received, date_issued, bin_id ";
				$sql .= "from warehouses ";
				$sql .= "where 1 ".self::$access_where; 
				
				if($sort == 'status')
				{
				  $sql .= "order by status, product_code, date_glued" ;
			  }
			  elseif ($sort == 'jobit')
			  {
				  $sql .= "order by jobit" ;
			  }			  
			  elseif ($sort == 'dom')
			  {
				  $sql .= "order by date_glued, product_code" ;
			  }
			  elseif ($sort == 'cpn')
			  {
				  $sql .= "order by product_code, whse_id, date_glued, pallet_id" ;
			  }
			  elseif ($sort == 'pallet')
			  {
				  $sql .= "order by pallet_id" ;
			  }
			  elseif ($sort == 'sent')
			  {
				  $sql .= "order by date_sent, product_code" ;
			  }
			  elseif ($sort == 'received')
			  {
				  $sql .= "order by date_received, product_code" ;
			  }
			  elseif ($sort == 'issued')
			  {
				  $sql .= "order by date_issued, product_code" ;
			  }
			  else
			  {
				  $sql .= "order by product_code, date_glued" ;
			  }
				return $this->db->query($sql);

    }//all
    

		function is_unique($pallet_to_match)
		{
			$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
		  $sql = "select id, pallet_id, date_sent, date_received, date_issued from warehouses ";
		  $sql .= "where pallet_id like '%".$pallet_to_match."%'".self::$access_where;
		  $sql .= "order by pallet_id limit 220";
	    return $this->db->query($sql);
	  }//isunique
	  
	  function show($id)
		{
			$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
		  $sql = "select id, pallet_id, date_sent, date_received, date_issued from warehouses ";
		  $sql .= "where id = ".$id.self::$access_where;
	    return $this->db->query($sql);
	  }//show
	  
    function receive($pallet)
    {
        $sql = "select status from warehouses where pallet_id = ? and status = 'transit'";
        $skids = $this->db->query($sql,$pallet);
        if($skids->num_rows() == 1) 
  	   	{
          $access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
  				$sql = "update warehouses set date_received = addtime(now(),'03:00:00'), status = 'received', ";
  				$sql .= "updated_by = '".self::$user_name."' ";
  				$sql .= "where pallet_id  = ? ".self::$access_where;
  				$skids = $this->db->query($sql, $pallet); 
          return $pallet.' was Received';
          
        } else {
          return $pallet.' was NOT Received';
        }
        
    }//receive
    
    function reset_receive($id)
    {
        $sql = "select id, pallet_id from warehouses where id = ?";
        $skids = $this->db->query($sql,$id);
        if($skids->num_rows() == 1) 
  	   	{
  	   	  $row = $skids->row();
          $pallet = $row->pallet_id; //get the full pallet in case the fragment was unique
          $access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
  				$sql = "update warehouses set date_received = NULL, date_issued = NULL, status = 'transit', ";
  				$sql .= "updated_by = '".self::$user_name."' ";
  				$sql .= "where id  = ? ".self::$access_where;
  				$skids = $this->db->query($sql, $id); 
          return $pallet.' was Reset to Transit';
          
        } else {
          return 'Row '.$id.' was NOT Reset';
        }
        
    }//reset_receive

    function issue($pallet)
    {
        $sql = "select status from warehouses where pallet_id = ? and status = 'received'";
        $skids = $this->db->query($sql,$pallet);
        if($skids->num_rows() == 1) 
       	{
          $access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
        	$sql = "update warehouses set date_issued = addtime(now(),'03:00:00'), status = 'issued', ";
        	$sql .= "updated_by = '".self::$user_name."' ";
        	$sql .= "where pallet_id  = ? ".self::$access_where; 
          $skids = $this->db->query($sql, $pallet);
          return $pallet.' was Issued';
            
        } else {
          return $pallet.' was NOT Issued';
        }
    }// issue
    
    function reset_issue($id)
    {
        $sql = "select id, pallet_id from warehouses where id = ?";
        $skids = $this->db->query($sql,$id);
        if($skids->num_rows() == 1) 
  	   	{
  	   	  $row = $skids->row();
          $pallet = $row->pallet_id; //get the full pallet in case the fragment was unique
          $access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
  				$sql = "update warehouses set date_issued = NULL, status = 'received', ";
  				$sql .= "updated_by = '".self::$user_name."' ";
  				$sql .= "where id  = ? ".self::$access_where;
  				$skids = $this->db->query($sql, $id); 
          return $pallet.' was Reset to Transit';
          
        } else {
          return 'Row '.$id.' was NOT Reset';
        }
        
    }//reset_issue
    
	  function update($form_data)
	  { 
			$data = array(
							'pallet_id' => $form_data['pallet_id'],
							'date_received' => $form_data['date_received'],
							'date_issued' => $form_data['date_issued'],

             );
      $this->load->database($this->session->userdata('database'));       
      $sql = "select pallet_id from warehouses ";
      $sql .= "where pallet_id = '".$form_data['pallet_id']."'";
    	$user = $this->db->query($sql);
    	
    	if($user->num_rows() == 1) 
    	{
				$this->db->where('pallet_id', $form_data['pallet_id']);
				$this->db->update('warehouses', $data);
  	  }
  	  else  //insert
  	  {
    	  $this->db->insert('warehouses', $data);
	    }
    	
    	return $this->db->affected_rows();
    }//update
    
    function cpn_summary($fgkey)
    {
				$sql = "select upper(whse_id) as whse_id, sum(pallet_qty) as qty ";
				$sql .= "from warehouses ";
				$sql .= "where product_code = '".$fgkey."' group by whse_id"; 
				return $this->db->query($sql);

    }//cpn-summary
    
}

?>