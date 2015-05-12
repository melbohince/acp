<?php
  echo "\n<!--\n
  ***************************\n
  *** cpn/cpn_liability_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th><?php echo anchor('cpn/can_ship/cpn', 'PRODUCT CODE');?></th>
    <th><?php echo anchor('cpn/can_ship/line', 'PRODUCT LINE');?></th>
    <th><?php echo anchor('cpn/can_ship/qty_on_hand', 'ON HAND');?></th> 
    <th><?php echo anchor('cpn/can_ship/qty_on_order', 'OPEN ORDER');?></th>
    <th>PACKING SPEC</th>
  </tr>
  
<?php $i = 0;?> 
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td> 
    <td><?=$row->product_line;?></td>
    <td><?=number_format($row->qty_onhand);?></td>
    <td><?=number_format($row->qty_open_order);?></td>
    <td><?=$row->packing_spec;?></td>
  </tr>

<?php $i++;?> 
<?php endforeach; ?>

</table>