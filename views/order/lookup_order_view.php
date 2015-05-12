<?php
  echo "\n<!--\n
  ***************************\n
  *** order/lookup_order_view ***\n
  ***************************\n-->\n";
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
?>

<?php $attributes = array('id' => 'lookup_form', 'name' => 'lookup_form'); ?>
<?=form_open('order/lookup', $attributes); ?>
	<?=form_fieldset($this->lang->line('m_purchase_orders').':'); ?>

		<?php 
				$attributes = array(
				'name'        => 'po_number',
				'id'          => 'po_number',
				'value'       => $data,
				'maxlength'   => '30',
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
			<?=form_submit($attributes,'Find'); ?>
		</div>


	<?=form_fieldset_close();?>
<?=form_close();?>

<script type="text/javascript">
  document.lookup_form.po_number.focus();
</script>