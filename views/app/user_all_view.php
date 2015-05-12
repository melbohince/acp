<?php
  echo "\n<!--\n
  ***************************\n
  *** app/user_all_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <td>USER NAME</td>
    <td>EMAIL</td>
    <td>ACCESS</td> 
    <td>ADMIN</td>
    <td>USAGE</td>
    <td>LAST LOGIN</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
<?php foreach($data->result() as $row): ?>

  <tr>
    <td><?=$row->user_name;?></td>
    <td><?=$row->email;?></td> 
    <td><?=$row->access_filter;?></td>
    <td><?=$row->admin_indicator;?></td>
    <td><?=$row->use_counter;?></td>
    <td><?=$row->last_used;?></td>
    <td><?php echo anchor('login/update/'.$row->id, 'Update');?></td> 
    <td><?php echo anchor('login/delete/'.$row->id, 'Delete');?></td> 
  </tr>

  
<?php endforeach; ?>

</table>