<?php 
		$attributes = array(
		'name'        => 'shipto',
		'id'          => 'shipto',
		'value'       => $data[0],
		'maxlength'   => '30',
		'size'        => '20',
		'class'       => 'entry-field', 
		);
?>
<p>
	<?=form_input($attributes); ?>