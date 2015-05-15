<?php
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
?>
<?=form_open('login/add'); ?>

	<?= form_fieldset('Create a new user'); ?>

		<?php $attributes_label = array(
			'class'       => 'entry-label', 
		);
		?>
		
		<p>
		<?=form_label('Username:', 'username', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'username',
				'id'          => 'username',
				'value'       => set_value('username'),
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
				'value'       => set_value('email'),
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
				'value'       => set_value('access_filter'),
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
				'value'       => '0',
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
				'value'       => '0',
				'maxlength'   => '1',
				'size'        => '1',
				'class'       => 'entry-field', 
				);
			?>
		<?=form_input($attributes); ?>
		</p>
    
    <br>
           
		<?php $attributes = array(
			'name'        => 'save_btn',
			'id'          => 'save_btn',
			'class'       => 'submit-button', 
			);
		?>
		<div class="center">
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
