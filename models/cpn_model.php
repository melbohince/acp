<?php

class Cpn_model extends CI_Model {

    var $cpn   = '';
    var $cpn_to_match = '';
    var $line_to_match = '';
    var $sql    = '';
    private static $access_where = '';
    
    function Cpn_model()
    {
        // Call the Model constructor
        parent::__construct();
				$this->load->database($this->session->userdata('database'));
				self::$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
    }
    
    function all($access_where)
    {
        //$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
        $sql = "select * from item_masters ";
        $sql .= "where product_code != '' ".self::$access_where." order by product_code";
    	  return $this->db->query($sql);
    }

    function show_inventory($cpn)
    {
				$sql = "select product_line, product_code, description, qty_onhand, qty_certification, ";
				$sql .= "qty_wip, qty_open_order, qty_scheduled, last_update, packing_spec, historic_orders ";
				$sql .= "from item_masters ";
				$sql .= "where product_code  = ? ".self::$access_where; //add access_filter = 
				$sql .= "order by product_code" ;
        return $this->db->query($sql, $cpn);
    }
    


		function is_unique($cpn_to_match)
		{
			$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
		  $sql = "select distinct product_code, qty_onhand, qty_scheduled, description from item_masters ";
		  $sql .= "where product_code like '%".$cpn_to_match."%'".self::$access_where;
		  $sql .= "order by product_code limit 220";
	    return $this->db->query($sql);
	  }

		function find($cpn_to_match)
		{
		  // see if the $cpn_to_match will only find one cpn
      $sql = "select product_code, product_line, qty_onhand, qty_certification, last_update, description from item_masters ";
      $sql .= "where product_code = ? ".self::$access_where." order by product_code";
  	  return $this->db->query($sql, $cpn_to_match);
		}
		
		function is_unique_line($line_to_match)
		{
		  $sql = "select distinct product_line from item_masters where product_line like '%".$line_to_match."%' ".self::$access_where."limit 10";
	    return $this->db->query($sql);
	  }

    function show_inventory_by_line($line)
    {
				$sql = "select product_line, product_code, description, qty_onhand, qty_certification, ";
				$sql .= "qty_wip, qty_open_order, qty_scheduled, last_update ";
				$sql .= "from item_masters ";
				$sql .= "where product_line  = ? ".self::$access_where; //add access_filter = 
				$sql .= "order by product_line, product_code" ;
        return $this->db->query($sql, $line);
    }
    	  
    function show_product_lines($line)
    {
				$sql = "select product_line, count(product_code) as products ";
				$sql .= "from item_masters ";
				$sql .= "where product_line  like '%".$line."%'".self::$access_where; //add access_filter = 
				$sql .= "group by product_line order by product_line" ;
        return $this->db->query($sql, $line);
    }
		
		function find_by_line($line_to_match)
		{
		  // see if the $cpn_to_match will only find one cpn
      $sql = "select product_code, product_line, qty_onhand, qty_certification, last_update, description from item_masters ";
      $sql .= "where product_line like '%".$line_to_match."%'".self::$access_where." order by product_code";
  	  return $this->db->query($sql);
		}

		function find_by_desc($desc_to_match)
		{
      $sql = "select product_code, product_line, qty_onhand, qty_certification, qty_scheduled, last_update, description from item_masters ";
      $sql .= "where description like '%".$desc_to_match."%'".self::$access_where." order by product_code";
  	  return $this->db->query($sql);
		}
				
		function shortages($sort)
		{
      $sql = "select product_code, product_line, qty_onhand, qty_open_order, packing_spec ";
      $sql .= "from item_masters ";
      $sql .= "where (qty_onhand + qty_wip) <  qty_open_order ".self::$access_where;
      $sql .= $this->_sortby($sort);
  	  return $this->db->query($sql);
		}

		function can_ship($sort)
		{
      $sql = "select product_code, product_line, qty_onhand, qty_open_order, packing_spec ";
      $sql .= "from item_masters ";
      $sql .= "where qty_onhand >=  qty_open_order and qty_onhand != 0 ".self::$access_where;
      $sql .= $this->_sortby($sort);
  	  return $this->db->query($sql);
		}
		
		function _sortby($sort = '')
		{
      if($sort == 'cpn')
			{
			  return "order by product_code" ;
		  }
		  elseif ($sort == 'line')
		  {
			  return "order by product_line, product_code" ;
		  }
		  elseif ($sort == 'qty_on_hand')
		  {
			  return "order by qty_onhand desc, product_code" ;
		  }
		  elseif ($sort == 'qty_on_order')
		  {
			  return "order by qty_open_order desc, product_code" ;
		  }
		  else
		  {
			  return "order by product_code" ;
		  }	   
    }
				
}

?>