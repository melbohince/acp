<?php
  echo "\n<!--\n
  ***************************\n
  *** cpn/cpn_shortage_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th><?php echo anchor('cpn/shortages/cpn', 'PRODUCT CODE');?></th>
    <th><?php echo anchor('cpn/shortages/line', 'PRODUCT LINE');?></th>
    <th><?php echo anchor('cpn/shortages/qty_on_hand', 'ON HAND');?></th> 
    <th><?php echo anchor('cpn/shortages/qty_on_order', 'OPEN ORDER');?></th>
    <th>PACKING SPEC</th>
  </tr>
 
<?php $i = 0;?>  
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td> 
    <td><?=$row->product_line;?></td>
    <td class="rite"><?=number_format($row->qty_onhand);?></td>
    <td class="rite"><?=number_format($row->qty_open_order);?></td>
    <td><?=$row->packing_spec;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>