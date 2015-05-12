<?php
  echo "\n<!--\n
  ***************************\n
  *** wms/wms_onhand_view ***\n
  ***************************\n-->\n";
  $this->obj =& get_instance();
  $this->obj->wms_mgr = (($this->obj->session->userdata('wms_mgr') == 1) ? 'YES' : 'NO');
?>

<table class="grid">
  <tr> 
    <th>WAREHOUSE</th>
    <th>STATUS</th>
    <th><?php echo anchor('wms/onhand/cpn', 'ITEM');?></th> 
    <th><?php echo anchor('wms/onhand/dom', 'DOM');?></th> 
    <th>QUANTITY</th>
    <th><?php echo anchor('wms/onhand/pallet', 'PALLET');?></th>
    <th><?php echo anchor('wms/onhand/received', 'RECEIVED');?></th>
  </tr>
 
<?php $i = 0;?>  
<?php foreach($data->result() as $row): ?>
  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <td><?=$row->whse_id;?></td>
    <td><?=$row->status;?></td>
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td>
    <td><?=date("Y-m-d",strtotime($row->date_glued));?></td>
    <td><?=number_format($row->pallet_qty);?></td>
    <td><?=$row->pallet_id;?></td>
    
    <?php if(is_null($row->date_received)||($row->date_received=='0000-00-00 00:00:00')):?>
      <td>&nbsp;</td>
    <?php else:?>
      <td><?=date("Y-m-d",strtotime($row->date_received));?></td>
    <?php endif?>
    
    <td>
      <?php if($this->obj->wms_mgr == 'YES'): ?>
              <?=form_open('wms/issue/'.$row->pallet_id);?>
    
              <?=form_hidden('id', $row->id); ?>

    
          	  <?php 
          	    $attributes = array(
                            			'name'        => 'send_btn',
                            			'id'          => 'send_btn',
                            			'class'       => 'submit-button', 
          		);?>
              <?=form_submit($attributes,'Issue'); ?>  
          	  <?=form_close();?>
          	  
      <?php else: ?>
          &nbsp;
      <?php endif ?>
	  </td>
  </tr>

<?php $i++;?>   
<?php endforeach; ?>

</table>