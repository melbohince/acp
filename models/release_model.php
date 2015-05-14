<?php

class Release_model extends CI_Model {

    var $cpn   = '';
    var $cpn_to_match = '';
    var $sql    = '';
    private static $access_where = '';
    
    function Release_model()
    {
        // Call the Model constructor
        parent::__construct();
				$this->load->database($this->session->userdata('database'));
				self::$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'));
    }
    
    function all($sort)
    {
				$sql = "select * ";
				$sql .= "from releases ";
				$sql .= "where 1 ".self::$access_where; 
				$sql .= $this->_sortby($sort);

				return $this->db->query($sql);

    }
    
    function open($sort)
    {
				$sql = "select * ";
				$sql .= "from releases ";
				$sql .= "where (qty_actual is null "; 
				$sql .= "or qty_actual = 0) ".self::$access_where; 
				$sql .= $this->_sortby($sort);
				return $this->db->query($sql);

    }
    
    function shipped($sort)
    {
				$sql = "select * ";
				$sql .= "from releases ";
				$sql .= "where qty_actual > 0 ".self::$access_where; 
				$sql .= $this->_sortby($sort);
				return $this->db->query($sql);

    }

    function show_releases($cpn)
    {
				$sql = "select product_line, shipto, qty_sched, date_sched, date_dock, reference ";
				$sql .= "from releases ";
				$sql .= "where product_code  = ? "; //add access_filter = 
				$sql .= "and ( qty_actual is null "; 
				$sql .= "or qty_actual  = 0 )".self::$access_where; 
				$sql .= "order by date_sched" ;
        return $this->db->query($sql, $cpn);
    }

    function find_cpn_by_shipto($shipto_to_match)
    {
        self::$access_where = $this->allowed_access->limit_access($this->session->userdata('access_filter'),'r.');
				$sql = "select distinct r.product_code as product_code, r.shipto as shipto, ";
				$sql .= "i.qty_onhand as qty_onhand, i.description as description, i.qty_scheduled as qty_scheduled ";
				$sql .= "from releases r join item_masters i on r.product_code = i.product_code ";
				$sql .= "where r.shipto like '%".$shipto_to_match."%'".self::$access_where; 
				$sql .= "order by r.product_code" ;
				return $this->db->query($sql);

    }
    
    function shipto_locations()
    {
      	$sql = "select shipto ";
				$sql .= "from releases ";
				$sql .= "where 1 ".self::$access_where; 
				$sql .= "order by shipto" ;
				return $this->db->query($sql);
    }

    function shipto_destinations()
    {
      	$sql = "select distinct shipto ";
				$sql .= "from releases ";
				$sql .= "where 1 ".self::$access_where; 
				$sql .= "order by shipto" ;
				return $this->db->query($sql);
    }
    
    function _sortby($sort = '')
    {
    		if($sort == 'shipto')
				{
				  return "order by shipto, product_code" ;
			  }
			  elseif ($sort == 'scheduled')
			  {
				  return "order by date_sched, product_code" ;
			  }
			  elseif ($sort == 'cpn')
			  {
				  return "order by product_code, date_sched" ;
			  }
			  elseif ($sort == 'line')
			  {
				  return "order by product_line, product_code, date_sched" ;
			  }
			  elseif ($sort == 'dock')
			  {
				  return "order by date_dock, product_code" ;
			  }
			  elseif ($sort == 'shipped')
			  {
				  return "order by date_shipped desc, product_code" ;
			  }
			  elseif ($sort == 'release_num')
			  {
				  return "order by ams_ref" ;
			  }
			  elseif ($sort == 'refer')
			  {
				  return "order by reference, product_code" ;
			  }
			  else
			  {
				  return "order by shipto, date_sched, product_code" ;
			  }
   } //sortby
   
}

?>