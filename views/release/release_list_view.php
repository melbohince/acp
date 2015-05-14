<?php
  echo "\n<!--\n
  ***************************\n
  *** release/release_list_view ***\n
  ***************************\n-->\n";
?>
<table class="grid">
  <tr> 
    <th>PRODUCT LINE</th>
    <th>SHIP TO</th>
    <th>QUANTITY</th> 
    <th>SHIP ON<sup>1</sup></th>
    <th>DOCK</th>
    <th>PO.REL</th>
  </tr>

<?php $i = 0;?>   
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?=$row->product_line;?></td> 
    <td><?=$row->shipto;?></td> 
    <td class="rite"><?=number_format($row->qty_sched);?></td> 
    
<?php if($row->date_sched != '0000-00-00'):?>
    <td><?=date("M jS",strtotime($row->date_sched));?></td> 
<?php else:?>
    <td>tbd</td> 
<?php endif?>
 
<?php if($row->date_dock != '0000-00-00'):?>
    <td><?=date("M jS",strtotime($row->date_dock));?></td> 
<?php else:?>
    <td>tbd</td> 
<?php endif?>  
    <td><?=$row->reference;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>