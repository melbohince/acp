<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- desktop template -->
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title><?=$this->config->item('app_title')?></title>
  
    <link href="<?=base_url()?>system/application/favicon.ico" rel="icon" type="image/x-icon" />
    <link href="<?=base_url()?>system/application/css/reset-fonts-grids.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>system/application/css/base.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>system/application/css/<?=$style?> "rel="stylesheet" type="text/css" />

  <!-- 
    <script language="JavaScript" src=<?='"'.base_url().'system/application/cal/calendar_us.js">'?></script> 
    <link href="<?=base_url()?>system/application/cal/calendar.css" rel="stylesheet" type="text/css" />
  -->
		
    <?=$refresh; echo "\n";?>
 </head>
	
<?php echo "\n";?>
 <body>
	
   <div class="toolbar">
     <h1 id="pageTitle"><?=$page_title?></h1>

     <?php if(isset($back_btn)): ?>
  <a id="backButton" class="button" href="<?=$back_btn['link']?>"><?=$back_btn['text']?></a>
     <?php endif;?>

     <?php if(!isset($display_logout)): ?>
  <a class="button" href=<?=base_url().'index_portal.php/login/logout'?>>Logout</a>
     <?php endif; echo "\n";?>
  </div>


			<?php foreach($content as $segment): ?>
				<?php $segment_data['data'] = $segment['data'];?>
				<?php $this->load->view($segment['view'], $segment_data);?>
			<?php endforeach;?>
			
<?php echo "\n";?>

<?php if($display_footer == "show"): ?>
<hr/><?php echo "\n";?>
  <div id="footer">
    <p><?php echo "\n";?>
  ::  <?php echo anchor('menu/', $this->lang->line('p_home'));echo "\n";?>
  ::  <?php echo anchor('help/'.strtolower(str_replace(' ','_',$page_title)), $this->lang->line('p_help'));echo "\n";?>  ::  <?php echo anchor('contact', $this->lang->line('f_contact'));echo "\n";?>  ::
    </p>
  </div>
<?php endif; ?>

<p style="float:left;"><img src="<?=base_url()?>system/application/images/arkay-logo-on-aliceblue.png" width="200" height="57" alt="Arkay Packaging Logo" /></p>
    
 </body>
</html>
