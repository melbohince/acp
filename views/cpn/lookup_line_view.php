<?php
  echo "\n<!--\n
  ***************************\n
  *** cpn/lookup_line_view ***\n
  ***************************\n-->\n";
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
  echo "\n";
?>

<?php $attributes = array('id' => 'lookup_form', 'name' => 'lookup_form'); ?>
<?=form_open('cpn/lookup_line', $attributes); ?>
	<?=form_fieldset($this->lang->line('m_product_line').':'); ?>

		<?php 
				$attributes = array(
				'name'        => 'product_line',
				'id'          => 'product_line',
				'value'       => set_value('product_line'),
				'maxlength'   => '20',
				'size'        => '20',
				'class'       => 'entry-field', 
				);
		?>
  <p><?=form_input($attributes); ?></p>
		
		<?php $attributes = array(
			'name'        => 'find_btn',
			'id'          => 'find_btn',
			'class'       => 'submit-button', 
			);
		?>

<div>
  <?=form_submit($attributes,'Search'); ?>
</div>
<br />

<?php
  form_fieldset_close();
  form_close();
?>

  <script type="text/javascript">
    document.lookup_form.product_line.focus();
  </script>
  