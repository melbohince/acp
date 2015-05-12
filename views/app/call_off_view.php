<?php
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
	// <?=form_hidden('cpn', $cpn); was below, no help
  // <?=form_hidden('qty', $qty);
?>

<?=form_open('contact/send'); //calloff/'.$cpn."/".$qty); ?>

	<?= form_fieldset('Email Message:'); ?>

    <?=form_hidden('prefix', '[ACP'.$this->session->userdata('access_filter').']'); ?>
        	        
		<?php $attributes_label = array(
			'class'       => 'entry-label', 
		);
		?>
		<p>
		<?=form_label('Subject: ', 'subject', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'subject',
				'id'          => 'subject',
				'value'       => $subject, //set_value('subject',$subject),
				'maxlength'   => '60',
				'size'        => '40',
				'class'       => 'entry-field', 
				);
				//log_message('error', 'calloff_view_input called subject'.$subject.' body='.$body);
			?>
		  <?=form_input($attributes); ?>
		  
		</p>

		<p>
		<?=form_label('Message: ', 'body', $attributes_label);?>
    </p>
 
    
    <p>
			<?php $attributes = array(
				'name'        => 'body',
				'id'          => 'body',
				'value'       => $body, //set_value('body', $body),
				'rows'        => '8',
				'cols'        => '80',
				'class'       => 'entry-field', 
				);
			?>
		  <?=form_textarea($attributes); ?>
		
		</p>


		<?php $attributes = array(
			'name'        => 'send_btn',
			'id'          => 'send_btn',
			'class'       => 'submit-button', 
			);
		?>
		
		<div class="center">
			<?=form_submit($attributes,'Send Email'); ?>
		</div>

    
    
<?php 
	form_fieldset_close(); 
  form_close();	
?>
