<?php
  echo "\n<!--\n
  ***************************\n
  *** cpn/cpn_line_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th>PRODUCT LINE</th>
    <th># CODES</th> 
  </tr>
  
<?php $i = 0;?> 
<?php foreach($data->result() as $row): ?>

  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?php echo anchor('cpn/show_line/'.$row->product_line, $row->product_line);?></td> 
    <td><?=number_format($row->products);?></td>
  </tr>
  
<?php $i++;?> 
<?php endforeach; ?>

</table>