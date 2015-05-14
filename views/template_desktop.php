<!DOCTYPE html>   
<html lang="en">
<head>
    <!-- desktop template 
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title><?=$this->config->item('app_title')?></title>
    <meta name="webapp prototype" content="">
    <meta name="Mel Bohince" content="">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    
    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="<?=base_url()?>system/application/css/normalize.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>system/application/css/skeleton.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>system/application/css/<?=$style?> "rel="stylesheet" type="text/css"> 

    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– 
    <link rel="icon" type="image/png" href="images/favicon.png"> -->
    <link rel="icon" type="image/x-icon" href="<?=base_url()?>system/application/favicon.ico">
  
    <!-- Scripts
    –––––––––––––––––––––––––––––––––––––––––––––––––– 
    <script language="JavaScript" src=<?='"'.base_url().'system/application/cal/calendar_us.js">'?></script> 
    <link href="<?=base_url()?>system/application/cal/calendar.css" rel="stylesheet" type="text/css" >
    -->
        
        
		
    <?=$refresh; echo "\n";?>
 </head>
	
<?php echo "\n";?>
 <body>
  <!-- Toolbar
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
   <div class="toolbar">
     <h1 id="pageTitle"><?=$page_title?></h1>

     <?php if(isset($back_btn)): ?>
  <a id="backButton" class="button" href="<?=$back_btn['link']?>"><?=$back_btn['text']?></a>
     <?php endif;?>

     <?php if(!isset($display_logout)): ?>
  <a class="button" href=<?=base_url().'index_portal.php/login/logout'?>>Logout</a>
     <?php endif; echo "\n";?>
  </div>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">

			<?php foreach($content as $segment): ?>
				<?php $segment_data['data'] = $segment['data'];?>
				<?php $this->load->view($segment['view'], $segment_data);?>
			<?php endforeach;?>
			
<?php echo "\n";?>

  </div>
  
  <!-- Footer
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
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
