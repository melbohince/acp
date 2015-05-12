<?php
  echo "\n<!--\n
  ***************************\n
  *** wms/wms_summary_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th>WAREHOUSE</th>
    <th>QUANTITY</th>
  </tr>

<?php  if($data->num_rows() > 0) { ?>
 
	<?php foreach($data->result() as $row): ?>

	  <tr> 		
	 		<td><strong><?=$row->whse_id;?></strong></td>
	 		<td><?=number_format($row->qty);?></td>
	 	</tr>

	<?php endforeach; ?>

<?php } else { ?>
			<tr><td colspan=2>No inventory found</td></tr>
<?php }  ?>	
	
</table>
