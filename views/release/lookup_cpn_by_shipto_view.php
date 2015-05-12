<?php
  echo "\n<!--\n
  ***************************\n
  *** release/lookup_cpn_by_shipto_view ***\n
  ***************************\n-->\n";
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
?>

<?=form_open('release/lookup_cpn_by_shipto'); ?>
	<?=form_fieldset($this->lang->line('m_shipto').':'); ?>


		
  		<?php
  			$attributes = 'id="shipto" class="entry-field"';											
  		?>
  		<?=form_dropdown('shipto',$data,'0',$attributes)?>
		
  		<?php $attributes = array(
  			'name'        => 'find_btn',
  			'id'          => 'find_btn',
  			'class'       => 'submit-button', 
  			);
  		?>
    </p>
		<div>
			<?=form_submit($attributes,'Search'); ?>
		</div>
<br />


	<?=form_fieldset_close();?>
<?=form_close();?>

