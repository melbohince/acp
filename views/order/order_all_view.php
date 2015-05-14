<?php
  echo "\n<!--\n
  ***************************\n
  *** order/order_all_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th><?php echo anchor('order/all/billto', 'BILL TO');?></th>
    <th><?php echo anchor('order/all/po', 'PO NUMBER');?></th>
    <th><?php echo anchor('order/all/cpn', 'PRODUCT CODE');?></th>
    <th><?php echo anchor('order/all/line', 'PRODUCT LINE');?></th>
    <th>ORDERED</th> 
    <th><?php echo anchor('order/all/qty_open', 'OPEN');?></th>
    <th><?php echo anchor('order/all/order_num', 'ORDER NO');?></th>
  </tr>

<?php $i = 0;?>   
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?=$row->billto;?></td> 
    <td><?=$row->po_number;?></td>
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td> 
    <td><?=$row->product_line;?></td> 
    <td class="rite"><?=number_format($row->qty_ordered);?></td> 
    <td class="rite"><?=number_format($row->qty_open);?></td> 
    <td><?=$row->ams_ref;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>