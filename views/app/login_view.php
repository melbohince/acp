<?php
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
?>

<div id="login-container">
<?php $attributes = array('id' => 'login_form', 'name' => 'login_form'); ?>    
<?=form_open('login/index', $attributes); ?>

	<?= form_fieldset('Please log in:<br>Abra una sesi&oacute;n por favor:'); ?>

  <div>  
  		<?php $attributes_label = array(
  			'class'       => 'entry-label', 
  		);
  		?>
  		<?=form_label('Email:', 'username', $attributes_label);?>

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

  </div>  
    
  <div id="pwd">  
    <label><input type="checkbox" name="lang_cb" id="language" value="">&nbsp;Espa&ntilde;ol</label>
    
    <?php $attributes = array(
        'name'        => 'login_btn',
        'id'          => 'login_btn',
        'class'       => 'submit-button', 
      );
    ?>

    <?=form_submit($attributes,'Log in'); ?>

    
  </div>
      


   
    <p class="version" id="version"><em>Version beta-20150514.00</em></p>


    <?php 
      form_fieldset_close(); 
      form_close();
    ?>
  </fieldset>
</form>

</div>
  <script type="text/javascript">
    document.login_form.username.focus();
  </script>