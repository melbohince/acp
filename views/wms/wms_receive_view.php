<?php
  echo "\n<!--\n
  ***************************\n
  *** wms/wms_receive_view ***\n
  ***************************\n-->\n";
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
	echo "\n";
?>

<?php $attributes = array('id' => 'lookup_form', 'name' => 'lookup_form'); ?>
<?=form_open('wms/scan_receipt', $attributes); ?>
 <?=form_fieldset('Scan SSCC on Pallet Label:'); ?>

  <?php 
				$attributes = array(
				'name'        => 'pallet_id',
				'id'          => 'pallet_id',
				'value'       => $data,
				'maxlength'   => '30',
				'size'        => '30',
				'class'       => 'entry-field', 
				);
		?>
  <p><?=form_input($attributes); ?></p>
		
		<?php $attributes = array(
			'name'        => 'receive_btn',
			'id'          => 'receive_btn',
			'class'       => 'submit-button', 
			);
		?>

<div>
  <?=form_submit($attributes,'Receive'); ?>
</div>
<br />

<?php
  form_fieldset_close();
  form_close();
?>

  <script type="text/javascript">
    document.lookup_form.pallet_id.focus();
  </script>