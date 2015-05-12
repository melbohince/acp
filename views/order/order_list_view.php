<?php
  echo "\n<!--\n
  ***************************\n
  *** order/order_list_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th>BILL TO<sup>1</sup></th>
    <th>PO NUMBER<sup>2</sup></th> 
    <th>PRODUCT LINE</th>
    <th>ORDERED</th>
    <th>OPEN</th>
    <th>PLACED</th>
    <th>ORDERLINE</th>
  </tr>
 
<?php $i = 0;?>  
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>"> 
    <td><?=$row->billto;?></td>
    <td><?=$row->po_number;?></td>
    <td><?=$row->product_line;?></td> 
    <td><?=number_format($row->qty_ordered);?></td> 
    <td><?=number_format($row->qty_open);?></td> 
    <td><?=$row->date_opened;?></td>
    <td><?=$row->ams_ref;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>