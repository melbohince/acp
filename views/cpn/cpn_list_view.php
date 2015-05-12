<?php
  echo "\n<!--\n
  ***************************\n
  *** cpn/cpn_list_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th>PRODUCT CODE</th>
    <th>ON HAND</th> 
    <th>RELEASED</th> 
  </tr>

<?php $i = 0;?>   
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td> 
    <td><?=number_format($row->qty_onhand);?></td>
    <td><?=number_format($row->qty_scheduled);?></td>
  </tr>
  
  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td colspan=3><?=$row->description;?></td>
  </tr>
  
  <tr>
    <td colspan=3>&nbsp;</td>
  </tr>
 
<?php $i++;?>  
<?php endforeach; ?>

</table>