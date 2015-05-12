<?php
  echo "\n<!--\n
  ***************************\n
  *** wms/wms_all_view ***\n
  ***************************\n-->\n";
  $this->obj =& get_instance();
  $this->obj->wms_mgr = (($this->obj->session->userdata('wms_mgr') == 1) ? 'YES' : 'NO');
?>

  <table class="grid">
    <tr> 
      <th><?php echo anchor('wms/all/status', 'STATUS');?></th>
      <th>WAREHOUSE</th> 
      <th><?php echo anchor('wms/all/cpn', 'PRODUCT_CODE');?></th>
      <th><?php echo anchor('wms/all/jobit', 'LOT/JOBIT');?></th>  
      <th><?php echo anchor('wms/all/dom', 'DATE_MFG');?></th> 
      <th><?php echo anchor('wms/all/pallet', 'PALLET SSCC');?></th>
      <th>QUANTITY</th>
      <th>CASES</th>
      <th><?php echo anchor('wms/all/sent', 'SENT_ON&nbsp;&nbsp;');?></th>
      <th><?php echo anchor('wms/all/receive', 'RECEIVED');?></th>
      <th><?php echo anchor('wms/all/issued', 'ISSUED&nbsp;&nbsp;&nbsp;&nbsp;');?></th>
      <th>BIN</th> <!-- <th>FROM_RK_BIN</th> -->
      <th>RESET_DATE</th>
    </tr>

  <?php $i = 0;?>  
  <?php foreach($data->result() as $row): ?>
    <tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">

      <td><?=$row->status;?></td>
      <td><?=$row->whse_id;?></td>
      <td><?php echo anchor('cpn/show/'.$row->product_code, $row->product_code);?></td>
      <td><?=$row->jobit;?></td>
      <td><?=date("Y-m-d",strtotime($row->date_glued));?></td>
      <!-- <td><?php echo anchor('wms/update/'.$row->id, $row->pallet_id);?></td> --!>
      <td><?=$row->pallet_id;?></td>
      <td><?=number_format($row->pallet_qty);?></td>
      <td><?=number_format($row->num_cases);?></td>


    <?php if(is_null($row->date_sent)||($row->date_sent=='0000-00-00 00:00:00')):?>
      <td>can ship</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
  
    <?php else:?>
      <td><?=date("Y-m-d",strtotime($row->date_sent));?></td>
      
      <?php if(is_null($row->date_received)||($row->date_received=='0000-00-00 00:00:00')):?>
        <td>in transit</td> 
        <td>&nbsp;</td>
      
      <?php else:?>
        <td><?=date("Y-m-d",strtotime($row->date_received));?></td>
      
        <?php if(is_null($row->date_issued)||($row->date_issued=='0000-00-00 00:00:00')):?>
          <td>can deliver</td>
        <?php else:?>
          <td><?=date("Y-m-d",strtotime($row->date_issued));?></td>
        <?php endif?>
      
      <?php endif?>
    
    <?php endif?>
  
  

    
      <td><?=$row->bin_id;?></td>
      
      <td>
          <?php if($this->obj->wms_mgr == 'YES'): ?>
              <?php if(is_null($row->date_received)||($row->date_received=='0000-00-00 00:00:00')): ?>
                  &nbsp;
              <?php else: ?>
                  <?=form_open('wms/reset_receive/'.$row->id);?>
              	  <?php 
              	    $attributes = array(
                                			'name'        => 'send_btn',
                                			'id'          => 'send_btn',
                                			'class'       => 'submit-button', 
              		);?>
                  <?=form_submit($attributes,'Not-Received'); ?>  
              	  <?=form_close();?>
              <?php endif?>

              <?php if(is_null($row->date_issued)||($row->date_issued=='0000-00-00 00:00:00')): ?>
                   &nbsp;
              <?php else: ?>
                  <?=form_open('wms/reset_issue/'.$row->id);?>
              	  <?php 
              	    $attributes = array(
                                			'name'        => 'send_btn',
                                			'id'          => 'send_btn',
                                			'class'       => 'submit-button', 
              		);?>
                  <?=form_submit($attributes,'Not-Issued'); ?>  
              	  <?=form_close();?>
          	  <?php endif?>
          <?php else: ?>
              &nbsp;
          <?php endif ?>
      	  
	   </td>
	   	  
    </tr>

  <?php $i++;?>   
  <?php endforeach; ?>

  </table>