<?php 	
				$row = $data->row();
				$attributes = array('class' => 'input-form', 'id' => 'user-form', 'name' => 'input-form');
				$hidden = array('case_id' => $row->id,
												'before_username' => $row->user_name,
												'before_password' => $row->password,  //encryped
												'before_email' => $row->email,
												'before_access' => $row->access_filter,
												'before_admin' => $row->admin_indicator,
												'before_wms' => $row->wms_indicator,
												);
?>
  
<?php
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
?>
<?=form_open('login/update/'.$row->id); ?>

	<?= form_fieldset('Updata a user'); ?>

		<?php $attributes_label = array(
			'class'       => 'entry-label', 
		);
		?>
		
		<p>
		<?=form_label('Username:', 'username', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'username',
				'id'          => 'username',
				'value'       => $row->user_name,
				'maxlength'   => '60',
				'size'        => '22',
				'class'       => 'entry-field', 
				);
			?>
		<?=form_input($attributes); ?>
		</p>

		<p>
		<?=form_label('Password:&nbsp;', 'password', $attributes_label);?>

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

		<p>
		<?=form_label('Email:', 'email', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'email',
				'id'          => 'email',
				'value'       => $row->email,
				'maxlength'   => '80',
				'size'        => '22',
				'class'       => 'entry-field', 
				);
			?>
		<?=form_input($attributes); ?>
		</p>
		
		<p>
		<?=form_label('Access Filter:', 'access_filter', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'access_filter',
				'id'          => 'access_filter',
				'value'       => $row->access_filter,
				'maxlength'   => '5',
				'size'        => '5',
				'class'       => 'entry-field', 
				);
			?>
		<?=form_input($attributes); ?>
		</p>

		<p>
		<?=form_label('Administrator:', 'admin_indicator', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'admin_indicator',
				'id'          => 'admin_indicator',
				'value'       => $row->admin_indicator,
				'maxlength'   => '1',
				'size'        => '1',
				'class'       => 'entry-field', 
				);
			?>
		<?=form_input($attributes); ?>
		</p>
		
		<p>
		<?=form_label('Warehouse Mgr:', 'wms_indicator', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'wms_indicator',
				'id'          => 'wms_indicator',
				'value'       => $row->wms_indicator,
				'maxlength'   => '1',
				'size'        => '1',
				'class'       => 'entry-field', 
				);
			?>
		<?=form_input($attributes); ?>
		</p>
		
    <br />
           
		<?php $attributes = array(
			'name'        => 'save_btn',
			'id'          => 'save_btn',
			'class'       => 'submit-button', 
			);
		?>
		<div>
			<?=form_submit($attributes,'Save User'); ?>
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
						

<?php 
	form_fieldset_close(); 
	form_close();
?>
