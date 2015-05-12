<?php

class Help extends CI_Controller {

	var $css_style;
	
	function Help()
	{
		parent::__construct();	
		$is_logged_in = $this->session->userdata('logged_in');
		if ((!isset($is_logged_in)) || (!$is_logged_in)) {redirect('login/index/');}
		
		$this->refresh =  ''; //$this->presentation->get_refresh(-1);
		$this->css_style = $this->session->userdata('agent_css');
		$this->template = $this->session->userdata('template');
		$this->lang->load('help', $this->session->userdata('use_language'));
		
	}
		
	function index()
	{
		$this->main_help();
	}
	
	function main_help() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/menu/', 'text' => $this->lang->line('p_home'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => '<span style="float:left;"><img src="'.base_url().'system/application/images/arkay-logo-on-aliceblue.png" width="200" height="57" alt="screenshot" /></span>',
																),
																array (
																	'view' => 'app/message_view',
																	'data' => '<span style="font-size: 175%;"><br /><br />'.$this->lang->line('h_00').'</span>',
																),
																																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_01'),//'Arkay\'s Portal was created to assist our customers in rapidly obtaining the status of products ordered.',
																),

																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_02'),//'Just click on the menus and underlined links to navigate through the website.',
																),

																array (
																	'view' => 'app/message_text_view',
																	'data' => '<table style = "border-style:none;">
																	<tr><td style = "border-style:none;"><img src="'.base_url().'system/application/images/screenshots/acp-main-menu.png" width="233" height="303" alt="screenshot" /></td><td class="elderview" style="vertical-align: text-top;border-style:none;padding:0;margin:0;">'.$this->lang->line('h_03').'</td></tr>
																	<tr><td style = "border-style:none;"><img src="'.base_url().'system/application/images/screenshots/acp-find-menu.png" width="233" height="303" alt="screenshot" /></td><td class="elderview" style="vertical-align: text-top;border-style:none;padding:0;margin:0;">'.$this->lang->line('h_04').'</td></tr>
																	<tr><td style = "border-style:none;"><img src="'.base_url().'system/application/images/screenshots/acp-reports-menu.png" width="233" height="303" alt="screenshot" /></td><td class="elderview" style="vertical-align: text-top;border-style:none;padding:0;margin:0;">'.$this->lang->line('h_05').'</td></tr>
																	</table>',
																),

																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_06'),//'Helpful hints are noted below:',
																),
																																
																array (
																	'view' => 'app/message_text_view',
																	'data' => '<ul>

 <li class="elderview"> &#x2192; '.$this->lang->line('h_07').'<span style="float:right"><img src="'.base_url().'system/application/images/screenshots/acp-return-btn.png" width="233" height="47" alt="screenshot" /></span></li>
 <li class="elderview"> &#x2192; '.$this->lang->line('h_08').'</li>
 <li class="elderview"> &#x2192; '.$this->lang->line('h_09').'<span style="display:inline"><img src="'.base_url().'system/application/images/screenshots/acp-lookup.png" width="214" height="168" alt="screenshot" /></span></li>
 <li class="elderview"> &#x2192; '.$this->lang->line('h_10').'<span style="display:inline"><img src="'.base_url().'system/application/images/screenshots/acp-footer.png" width="233" height="29" alt="screenshot" /></span></li>
 <li class="elderview"> &#x2192; '.$this->lang->line('h_11').'<span style="display: inline"><img src="'.base_url().'system/application/images/screenshots/acp-logout-btn.png" width="60" height="40" alt="screenshot" /></span></li>  
</ul>',
																),

																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_12'),//'Here is a table of contents for the page specific Help system:',
																),
																																
                                array (
																	'view' => 'app/message_text_view',
																	'data' => '<ul>
 <li class="elderview">'.anchor('help/find', $this->lang->line('p_find')).'</li>
 <li class="elderview">'.anchor('help/reports', $this->lang->line('p_reports')).'</li>
 <li class="elderview">'.anchor('help/jobs', $this->lang->line('p_jobs')).'</li>
 <li class="elderview">'.anchor('help/orders', $this->lang->line('p_orders')).'</li>
 <li class="elderview">'.anchor('help/releases', $this->lang->line('p_releases')).'</li>
 <li class="elderview">'.anchor('help/shipments', $this->lang->line('p_shipments')).'</li>
 <li class="elderview">'.anchor('help/product_code', $this->lang->line('p_product_code')).'</li>
 <li class="elderview">'.anchor('help/can_ship', $this->lang->line('p_can_ship')).'</li>
 <li class="elderview">'.anchor('help/shortages', $this->lang->line('p_shortages')).'</li>
 <li class="elderview">'.anchor('help/look_up', $this->lang->line('p_lookup')).'</li>
</ul>',
																),															
																
															);


    $this->load->view($this->template, $data);
	} //main
	
	function jobs() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_13'),//'Open Jobs Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_14'),//'Open Jobs page shows active job items that have not been marked as complete by the Glue department. ',
																),

															);


    $this->load->view($this->template, $data);
	} //job

	function orders() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_15'),//'Open Orders Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_16'),//'The Open Orders page shows firm Purchase Orders that have not been closed. ',
																),

															);


    $this->load->view($this->template, $data);
	} //roders
	
	function releases() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_17'),//'Open Releases Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_18'),//'The Open Releases page shows scheduled <strong>firm</strong> delivery plans. ',
																),

															);


    $this->load->view($this->template, $data);
	} //releases
	
	function shipments() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_19'),//'Shipments Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_20'),//'The Shipments page shows items that have been shipped in the past two weeks. ',
																),

															);


    $this->load->view($this->template, $data);
	} //releases

	function product_code() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_21'),//'Product Code Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_22'),//'The Product Code page shows detailed information about a single item, including its product line, description, quantity on hand and in certification, quantity of open jobs, quantity on open orders, and the quantity of outstanding releases. ',
																),

																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_23'),//'The "Last Update" date and time is when this data was last refreshed. ',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_24'),//'When appropriate there will be buttons besides the quantities. The "Call Off" button appears when the on hand quantity exceeds the released quantity and will prepare an email message when clicked that you can send. A "List" button will cause the display of the details that account for that quantity.',
																),
																
															);


    $this->load->view($this->template, $data);
	} //product code
	
	function find() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = 'Help';
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => 'Help',);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_25'),//'Find Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_26'),//'The Find menu gives you several options to find the status of products that you have ordered. ',
																),

																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_27'),//'Use the <strong>Product Code</strong> option to find an individual item or any that match the value you type in the look up box. ',
																),

																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_28'),//'Use the <strong>Product Line</strong> option to find an items of a product line or any that match the value you type in the look up box. ',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_29'),//'Use the <strong>Purchase Orders</strong> option to find specific orders that are still open. ',
																),
															);


    $this->load->view($this->template, $data);
	} //inventory
	
	function reports() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_30'),//'Reports Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_31'),//'The Reports menu gives you several options to find the status of products that you have ordered. Clicking on an underlined report column label will sort by that column.',
																),

																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_32'),//'Use <strong>Jobs</strong> Reports active Jobs items that have not been marked as complete by the Glue department. ',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_33'),//'Use <strong>Orders</strong> Reports firm Purchase Orders that have not been closed. ',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_34'),//'Use <strong>Releases</strong> Reports Open Releases page shows scheduled <strong>firm</strong> delivery plans. ',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_35'),//'Use <strong>Shipments</strong> Reports Shipments of the past two weeks. ',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_36'),//'Use <strong>Can Ship</strong> Reports all product codes that are currently in stock at the Arkay Warehouse. ',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_37'),//'Use <strong>Shortages</strong> Reports all product codes where inventory plus work in process will not meet order quantities. ',
																),

															);


    $this->load->view($this->template, $data);
	} //reports
	
	
	function can_ship() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_38'),//'Can Ship Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_39'),//'The Can Ship page will list all the items that currently are in stock at the Arkay warehouse. ',
																),
																
															);


    $this->load->view($this->template, $data);
	} //can ship

	function shortages() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_40'),//'Shortages Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_41'),//'The Shortages page will list all the items that cannot meet order quantity. ',
																),
																
															);


    $this->load->view($this->template, $data);
	} //shortages
		
	function look_up() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_42'),//'Look Up Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_43'),//'Enter the value that wish to search for and click the "Search" button. You may enter a partial value, it will look for items that contain the letter or numbers that you type. ',
																),
																
															);


    $this->load->view($this->template, $data);
	} //look up
	
	function settings() // called by index
	{
		$data['style'] = $this->css_style;
		$data['refresh'] = $this->refresh;
		$data['page_title'] = $this->lang->line('p_help');
		$data['back_btn'] = array ('link' => site_url().'/help/', 'text' => $this->lang->line('p_help'),);
		$data['display_footer'] = 'show';


		$data['content'] = array(
																array (
																	'view' => 'app/message_view',
																	'data' => $this->lang->line('h_44'),//'Settings Help',
																),
																
																array (
																	'view' => 'app/message_text_view',
																	'data' => $this->lang->line('h_45'),//'The Settings menu has options that you can use to change your password, your email, and other profile settings. ',
																),
																
															);


    $this->load->view($this->template, $data);
	} //look up
		
}

/* End of file help.php */
/* Location: ./system/application/controllers/help.php */
?>