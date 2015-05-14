<?php
  echo "\n<!--\n
  ***************************\n
  *** job/job_list_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <!--<th>START<sup>1</sup></th>-->
    <th>WANT</th> 
    <!--<th>ACTUAL</th>-->
    <th>JOBIT</th>
  </tr>
 
<?php $i = 0;?>  
<?php foreach($data->result() as $row): ?>
  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">

 <?php if($row->date_planned != '0000-00-00'):?>
   <!-- <td><?=date("m/d/y",strtotime($row->date_planned));?></td> -->
<?php else:?>
    <!--<td>tbd</td> -->
<?php endif?>

    <td class="rite"><?=number_format($row->qty_want);?></td>
    <!--<td><?=number_format($row->qty_actual);?></td>-->
    <td><?=$row->ams_ref;?></td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>