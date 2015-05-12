<?php
  echo "\n<!--\n
  ***************************\n
  *** release/release_list_view ***\n
  ***************************\n-->\n";
?>
<table class="grid">
  <tr> 
    <th>SCHEDULED<sup>1</sup></th>
    <th>PRODUCT LINE</th>
    <th>SHIP TO</th>
    <th>QUANTITY</th> 
    <th>DOCK</th>
    <th>RELEASE NO</th>
  </tr>

<?php $i = 0;?>   
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
<?php if($row->date_sched != '0000-00-00'):?>
    <td><?=date("M jS",strtotime($row->date_sched));?></td> 
<?php else:?>
    <td>tbd</td> 
<?php endif?>
    <td><?=$row->product_line;?></td> 
    <td><?=$row->shipto;?></td> 
    <td><?=number_format($row->qty_sched);?></td>  
<?php if($row->date_dock != '0000-00-00'):?>
    <td><?=date("M jS",strtotime($row->date_dock));?></td> 
<?php else:?>
    <td>tbd</td> 
<?php endif?>  
    <td><?=$row->ams_ref;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>