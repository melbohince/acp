<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


class Translations {
//===========================	  
  function sscc_short($full_sscc) //$row->skid_number  //00108082920000662053
  {
   return substr($full_sscc,2,1)."...".substr($full_sscc,10); //001...0000662053
  }
	
	function sscc_full($sscc_short) //$row->skid_number  //001...0000662053
  {
   return substr($sscc_short,2,1)."0808292".substr($sscc_short,10);  //00108082920000662053
  }
  
  function sscc_readable($full_sscc) //$row->skid_number  //001...0000662053
  {
   return "(".substr($full_sscc,0,2).") ".substr($full_sscc,2,1)." ".substr($full_sscc,3,7)." ".substr($full_sscc,10,9)." ".substr($full_sscc,19);  //00108082920000662053
  }
  
  function sscc_make($apptype, $sequence)
  {
    if($apptype != '999')
    {
      return $apptype.'0808292'.str_pad($sequence,10,"0", STR_PAD_LEFT);
    }
    else
    {
      return null;
    }
  }
//===========================	
	function jobit_ams($jobit) //123451212  $row->jobit
  {
   return substr($jobit,0,5).".".substr($jobit,5,2).".".substr($jobit,7,2);  //123451212
  }
	
	function jobit_wms($jobit) //12345.12.12
  {
   return str_replace('.','',$jobit);  //123451212
  }
//===========================	
	function cpn($fg_key)
	{
		return substr($fg_key, 6, 20);
	}
	
	function cust_id($fg_key)
	{
		return substring($fg_key, 0, 5);
	}
	
 //===========================	
 	function bin_short($full_bin)
 	{
 		return substr($full_bin,2);
 	}

 	function bin_long($short_bin)
 	{
 		return "BN".$short_bin;
 	}

 //===========================	
 	function case_readable($case_id)
 	{
 		return substr($case_id,0,9).' '.substr($case_id,9,7).' '.substr($case_id,16,6);
 	} 	
 	
 	function case_make($jobit, $case_number, $qty)
 	{
 		return $jobit.str_pad($case_number,7,"0", STR_PAD_LEFT).str_pad($qty,6,"0", STR_PAD_LEFT);
 	}
} //end class


?>