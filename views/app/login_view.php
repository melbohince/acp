<?php
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
?>

<?php $attributes = array('id' => 'login_form', 'name' => 'login_form'); ?>    
<?=form_open('login/index', $attributes); ?>

	<?= form_fieldset('Please log in:<br />Abra una sesi&oacute;n por favor:'); ?>

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
				'maxlength'   => '20',
				'size'        => '9',
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
				'size'        => '10',
				'class'       => 'entry-field', 
				);
			?>

		<?=form_password($attributes); ?>
		</p>


		<?php $attributes = array(
			'name'        => 'lang_cb',
			'checked'			=> false,
			'class'       => 'checkbox',
			);
		?>
		<div class="center">
       <label><?=form_checkbox($attributes);?>Espa&ntilde;ol</label>
    </div> 
    
    <br />
           
		<?php $attributes = array(
			'name'        => 'login_btn',
			'id'          => 'login_btn',
			'class'       => 'submit-button', 
			);
		?>
		<div class="center">
			<?=form_submit($attributes,'Log in'); ?>
		</div>

    <br />
    <br />
    <p style="style="font-size:90%;"><em>Version beta-20150514.00</em></p>

	<?php 
		form_fieldset_close(); 
	form_close();
	
?>

  <script type="text/javascript">
    document.login_form.username.focus();
  </script>