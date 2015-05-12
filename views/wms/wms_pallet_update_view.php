<?php
  echo "\n<!--\n
  ***************************\n
  *** wms/wms_pallet_update_view ***\n
  ***************************\n-->\n";
?>
  
<?php 	
				$row = $data->row();
				$attributes = array('class' => 'input-form', 'id' => 'pallet-form', 'name' => 'pallet-form');
				$hidden = array('warehouse_id' => $row->id,
												'before_pallet_id' => $row->pallet_id,
												'before_date_received' => $row->date_received,  
												'before_date_issued' => $row->date_issued,
												);
?>
  
<?php
	$alert = $this->session->flashdata('alert');
	if(isset($alert)) {echo $alert;}
	if(isset($message)) {echo $message;}
	$message = null;
	echo validation_errors();
?>

<?=form_open('wms/update/'.$row->pallet_id); ?>

	<?= form_fieldset('Update Pallet '.$row->pallet_id); ?>

		<?php $attributes_label = array(
			'class'       => 'entry-label', 
		);
		?>
		
      <?=form_hidden('pallet_id', $row->pallet_id); ?>

		<p>
		<?=form_label('Received:', 'date_received', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'date_received',
				'id'          => 'date_received',
				'value'       => $row->date_received,
				'class'       => 'entry-field', 
				);
			?>
		<?=form_input($attributes); ?>
		</p>
		
		<p>
		<?=form_label('Issued:', 'date_issued', $attributes_label);?>

			<?php $attributes = array(
				'name'        => 'date_issued',
				'id'          => 'date_issued',
				'value'       => $row->date_issued,
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
			<?=form_submit($attributes,'Save Pallet'); ?>
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
