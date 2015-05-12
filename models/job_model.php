<?php

class Job_model extends CI_Model {

    var $cpn   = '';
    var $sql    = '';
    private static $access_where = '';

    function Job_model()
    {
        // Call the Model constructor
        parent::__construct();
				$this->load->database($this->session->userdata('database'));
				self::$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
    }
    
    function all($sort)
    {
				$sql = "select * ";
				$sql .= "from jobs ";
				$sql .= "where 1 ".self::$access_where; 
				
				if($sort == 'jobit')
				{
				  $sql .= "order by ams_ref" ;
			  }
			  elseif ($sort == 'date')
			  {
				  $sql .= "order by date_planned, product_code" ;
			  }
			  elseif ($sort == 'cpn')
			  {
				  $sql .= "order by product_code, date_planned" ;
			  }
			  else
			  {
				  $sql .= "order by product_code, date_planned" ;
			  }
				return $this->db->query($sql);

    }

    function show_jobs($cpn)
    {
				$sql = "select product_code, date_planned, qty_want, qty_actual, ams_ref ";
				$sql .= "from jobs ";
				$sql .= "where product_code  = ? ".self::$access_where; //add access_filter = 
				$sql .= "order by date_planned" ;
        return $this->db->query($sql, $cpn);
    }


}

?>