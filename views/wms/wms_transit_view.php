<?php
  echo "\n<!--\n
  ***************************\n
  *** wms/wms_transit_view ***\n
  ***************************\n-->\n";
  $this->obj =& get_instance();
  $this->obj->wms_mgr = (($this->obj->session->userdata('wms_mgr') == 1) ? 'YES' : 'NO');
?>

<table class="grid">
  <tr> 
    <th>STATUS</th>
    <th><?php echo anchor('wms/transit/cpn', 'ITEM');?></th> 
    <th><?php echo anchor('wms/transit/dom', 'DOM');?></th> 
    <th>QUANTITY</th>
    <th><?php echo anchor('wms/transit/pallet', 'PALLET');?></th>
    <th><?php echo anchor('wms/transit/sent', 'SENT');?></th>
  </tr>
 
<?php $i = 0;?>  
<?php foreach($data->result() as $row): ?>
  <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">

    <td><?=$row->status;?></td>
    <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td>
    <td><?=date("Y-m-d",strtotime($row->date_glued));?></td>
    <td><?=number_format($row->pallet_qty);?></td>
    <td><?=$row->pallet_id;?></td>
    <td><?=date("Y-m-d",strtotime($row->date_sent));?></td>
    <td>
      <?php if($this->obj->wms_mgr == 'YES'): ?>
            <?=form_open('wms/receive/'.$row->pallet_id);?>
    
            <?=form_hidden('id', $row->id); ?>

    
        	  <?php 
        	    $attributes = array(
                          			'name'        => 'send_btn',
                          			'id'          => 'send_btn',
                          			'class'       => 'submit-button', 
                        		);?>
            <?=form_submit($attributes,'Receive'); ?>  
        	  <?=form_close();?>
      <?php else: ?>
          &nbsp;
      <?php endif ?>
	  </td>
  </tr>

  <?php $i++;?>   
<?php endforeach; ?>

</table>