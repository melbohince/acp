<?php
  echo "\n<!--\n
  ***************************\n
  *** order/order_found_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th>BILL TO</th>
    <th>PO NUMBER</th>
    <th>PRODUCT CODE</th>
    <th>PRODUCT LINE</th>
    <th>ORDERED</th> 
    <th>OPEN</th>
    <th>ORDER NO</th>
  </tr>

<?php $i = 0;?>   
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?=$row->billto;?></td> 
    <td><?=$row->po_number;?></td>
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td> 
    <td><?=$row->product_line;?></td> 
    <td><?=number_format($row->qty_ordered);?></td> 
    <td><?=number_format($row->qty_open);?></td> 
    <td><?=$row->ams_ref;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>