<?php 	
				$row = $data->row();
				$attributes = array('class' => 'input-form', 'id' => 'user-form', 'name' => 'input-form');
				$hidden = array('case_id' => $row->id,
												'before_password' => $row->password,  //encryped
												);
?>
  
<?php
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
?>
<?=form_open('login/change_password/'); ?>

	<?= form_fieldset('Change Your Password'); ?>
	
		<?php $attributes_label = array(
			'class'       => 'entry-label', 
		);
		?>
		
		<p>
		<?=form_label('Old Password:&nbsp;', 'password', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'password',
				'id'          => 'password',
				'value'       => '',
				'maxlength'   => '16',
				'size'        => '22',
				'class'       => 'entry-field', 
				);
			?>

		<?=form_password($attributes); ?>
		</p>
		
		<p>
		<?=form_label('New Password:&nbsp;', 'password', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'new_password',
				'id'          => 'new_password',
				'value'       => '',
				'maxlength'   => '16',
				'size'        => '22',
				'class'       => 'entry-field', 
				);
			?>

		<?=form_password($attributes); ?>
		</p>
		
		<p>
		<?=form_label('Confirm Password:', 'passwordcf', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'passwordcf',
				'id'          => 'passwordcf',
				'value'       => '',
				'maxlength'   => '16',
				'size'        => '22',
				'class'       => 'entry-field', 
				);
			?>

		<?=form_password($attributes); ?>
		</p>

		
    <br />
           
		<?php $attributes = array(
			'name'        => 'save_btn',
			'id'          => 'save_btn',
			'class'       => 'submit-button', 
			);
		?>
		<div>
			<?=form_submit($attributes,'Save Password'); ?>
		</div>
		
		<?php $attributes = array(
			'name'        => 'cancel_btn',
			'id'          => 'cancel_btn',
			'class'       => 'submit-button', 
			);
		?>

		<div>
			<?=form_submit($attributes,'Cancel'); ?>
		</div>
						
    <br />
    
<?php 
	form_fieldset_close(); 
	form_close();
?>
