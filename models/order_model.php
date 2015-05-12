<?php

class Order_model extends CI_Model {

    var $cpn   = '';
    var $cpn_to_match = '';
    var $sql    = '';
    private static $access_where = '';

    function Order_model()
    {
        // Call the Model constructor
        parent::__construct();
				$this->load->database($this->session->userdata('database'));
				self::$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
    }
    
    function all($sort)
    {
				$sql = "select * ";
				$sql .= "from orders ";
				$sql .= "where 1 ".self::$access_where; 
				$sql .= $this->_sortby($sort);
				return $this->db->query($sql);

    }

    function open($sort)
    {
				$sql = "select * ";
				$sql .= "from orders ";
				$sql .= "where qty_open > 0 ".self::$access_where; 
				$sql .= $this->_sortby($sort);
				return $this->db->query($sql);

    }
    
		function is_unique($po_to_match)
		{
		  $sql = "select distinct po_number, product_line, product_code, billto, qty_ordered, qty_open, ams_ref from orders where po_number like '%".$po_to_match."%'".self::$access_where." order by po_number, product_code limit 220";
	    return $this->db->query($sql);
	  }
	  
		function find($po_to_match)
		{
      $sql = "select * from orders ";
      $sql .= "where po_number = ? ".self::$access_where." order by po_number, product_code";
  	  return $this->db->query($sql, $po_to_match);
		}
		
		function show_order($po)
    {
				$sql = "select * ";
				$sql .= "from orders ";
				$sql .= "where po_number  = ? ".self::$access_where; //add access_filter = 
				$sql .= "order by date_opened" ;
        return $this->db->query($sql, $po);
    }
    
    function show_orders($cpn)
    {
				$sql = "select * ";
				$sql .= "from orders ";
				$sql .= "where product_code  = ? ".self::$access_where; //add access_filter = 
				$sql .= "order by billto, po_number" ;
        return $this->db->query($sql, $cpn);
    }


    function _sortby($sort = '')
    {
      if($sort == 'billto')
			{
			   return "order by billto, product_code" ;
		  }
		  elseif ($sort == 'po')
		  {
			  return "order by po_number, product_code" ;
		  }
		  elseif ($sort == 'line')
		  {
			  return  "order by product_line, product_code, po_number" ;
		  }
		  elseif ($sort == 'cpn')
		  {
			  return  "order by product_code, po_number" ;
		  }
		  elseif ($sort == 'qty_open')
		  {
			  return  "order by qty_open desc, product_code" ;
		  }
		  elseif ($sort == 'order_num')
		  {
			  return  "order by ams_ref" ;
		  }
		  else
		  {
			  return  "order by billto, po_number, product_code" ;
		  }
    }
    
}

?>