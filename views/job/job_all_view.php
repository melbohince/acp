<?php
  echo "\n<!--\n
  ***************************\n
  *** job/job_all_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th><?php echo anchor('job/all/cpn', 'PRODUCT CODE');?></th>
    <!--<th><?php echo anchor('job/all/date', 'START');?></th>-->
    <th>WANT</th> 
    <!--<th>ACTUAL</th>-->
    <th><?php echo anchor('job/all/jobit', 'JOBIT');?></th>
  </tr>

<?php $i = 0;?> 
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td> 
<?php if($row->date_planned != '0000-00-00'):?>
    <!--<td><?=date("M jS",strtotime($row->date_planned));?></td> -->
<?php else:?>
    <!--<td>tbd</td> -->
<?php endif?>
    <td><?=number_format($row->qty_want);?></td> 
    <!--<td><?=number_format($row->qty_actual);?></td> -->
    <td><?=$row->ams_ref;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>