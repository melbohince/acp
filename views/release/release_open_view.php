<?php
  echo "\n<!--\n
  ***************************\n
  *** release/release_open_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th><?php echo anchor('release/open/shipto', 'SHIP TO');?></th>
    <th><?php echo anchor('release/open/cpn', 'PRODUCT CODE');?></th>
    <th><?php echo anchor('release/open/line', 'PRODUCT LINE');?></th>
    <th>QUANTITY</th>
    <th><?php echo anchor('release/open/scheduled', 'SHIP ON');?></th>
    <th><?php echo anchor('release/open/dock', 'DOCK');?></th>
    <!--<th><?php echo anchor('release/open/release_num', 'RELEASE NO');?></th> -->
    <th><?php echo anchor('release/open/refer', 'PO.REL');?></th>
  </tr>

<?php $i = 0;?>   
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?=$row->shipto;?></td>
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td> 
    <td><?=$row->product_line;?></td> 
    <td class="rite"><?=number_format($row->qty_sched);?></td> 
<?php if($row->date_sched != '0000-00-00'):?>
    <td><?=date("m/d/y",strtotime($row->date_sched));?></td> 
<?php else:?>
    <td>tbd</td> 
<?php endif?>  

<?php if($row->date_dock != '0000-00-00'):?>
    <td><?=date("M jS",strtotime($row->date_dock));?></td> 
<?php else:?>
    <td>tbd</td> 
<?php endif?>      
    <!--<td><?=$row->ams_ref;?></td> -->
    <td><?=$row->reference;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>