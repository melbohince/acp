<?php
  echo "\n<!--\n
  ***************************\n
  *** release/release_shipped_view ***\n
  ***************************\n-->\n";
?><table class="grid">
  <tr> 
    <th><?php echo anchor('release/shipped/shipto', 'SHIP TO');?></th>
    <th><?php echo anchor('release/shipped/shipped', 'DEPARTED');?></th>
    <th>SHIPPED</th>
    <th><?php echo anchor('release/shipped/dock', 'DOCK');?></th>
    <th>SCHEDULED</th>
    <th><?php echo anchor('release/shipped/cpn', 'PRODUCT CODE');?></th>
    <th><?php echo anchor('release/shipped/line', 'PRODUCT LINE');?></th>
    <!--<th><?php echo anchor('release/shipped/release_num', 'RELEASE');?></th> -->
    <th><?php echo anchor('release/shipped/refer', 'PO.REL');?></th>
  </tr>

<?php $i = 0;?>   
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?=$row->shipto;?></td>
<?php if($row->date_shipped != '0000-00-00'):?>
    <td><?=date("m/d/y",strtotime($row->date_shipped));?></td> 
<?php else:?>
    <td>tbd</td> 
<?php endif?> 
    <td class="rite"><?=number_format($row->qty_actual);?></td>
<?php if($row->date_dock != '0000-00-00'):?>
    <td><?=date("m/d/y",strtotime($row->date_dock));?></td> 
<?php else:?>
    <td>tbd</td> 
<?php endif?> 

<?php if($row->qty_sched == $row->qty_actual):?>
    <td class="rite"><?=number_format($row->qty_sched);?></td>
<?php else:?>
    <td class="rite variance"><?=number_format($row->qty_sched);?></td>
<?php endif?> 
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td> 
    <td><?=$row->product_line;?></td> 
    <!--<td><?=$row->ams_ref;?></td> -->
    <td><?=$row->reference;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>