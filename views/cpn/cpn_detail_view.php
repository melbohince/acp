<?php
  echo "\n<!--\n
  ***************************\n
  *** cpn/cpn_detail_view ***\n
  ***************************\n-->\n";
?>

<table class="grid">
  <tr> 
    <th>PRODUCT CODE</th>
    <th>PRODUCT LINE</th> 
    <th>PACKING SPEC</th> 
  </tr>

<?php  if($data->num_rows() > 0) { ?>
 
	<?php foreach($data->result() as $row): ?>

	  <tr> 		
	 		<td><strong><?=$row->product_code;?></strong></td>
	 		<td><?=$row->product_line;?></td>
	 		<td><?=$row->packing_spec?></td>
	 	</tr>
	 	
	 	<tr>
  	  <td colspan=3><?=$row->description?></td>
  	</tr>
  	
  	<tr>
	    <th>ON HAND</th> <td class="rite"><strong><?=number_format($row->qty_onhand)?></strong></td> 
	    
	      <?php  if(($row->qty_onhand-$row->qty_scheduled) > 0) { ?>
    	        <td>
        	        <?=form_open('contact/calloff/');?>
        	        
        	        <?=form_hidden('cpn', $row->product_code); ?>
        	        <?=form_hidden('qty_calloff', number_format($row->qty_onhand - $row->qty_scheduled)); ?>
        	        
            		  <?php 
            		    $attributes = array(
                                			'name'        => 'send_btn',
                                			'id'          => 'send_btn',
                                			'class'       => 'submit-button', 
            			);?>
                  <?=form_submit($attributes,'Call Off'); ?>  
              	  <?=form_close();?>
          	  </td>
        <?php } else { ?>
              <td>&nbsp;</td>
        <?php }  ?>	

	  </tr>
	  
	  <tr> 
	    <th>CERTIFICATION</th> <td class="rite"><strong><?=number_format($row->qty_certification)?></strong></td> <td>&nbsp;</td>
    </tr>

	  <tr> 
	    <th>OPEN JOBS</th> <td class="rite"><strong><?=number_format($row->qty_wip)?></strong></td> 
      <?php  if($row->qty_wip > 0) { ?>
        <td>
        	        <?=form_open('job/show/'.$row->product_code);?> 
            		  <?php 
            		    $attributes = array(
                                			'name'        => 'list1_btn',
                                			'id'          => 'list1_btn',
                                			'class'       => 'submit-button', 
            			);?>
                  <?=form_submit($attributes,'List'); ?>  
              	  <?=form_close();?>        
        </td>
      <?php } else { ?>
        <td>&nbsp;</td>
      <?php }  ?>	
    </tr>

	  <tr> 
	    <th>OPEN ORDERS</th> <td class="rite"><strong><?=number_format($row->qty_open_order)?></strong></td> 
	    <?php  if($row->qty_open_order > 0) { ?>
        <td>
        	        <?=form_open('order/show/'.$row->product_code);?> 
              		  <?php 
              		    $attributes = array(
                                  			'name'        => 'list2_btn',
                                  			'id'          => 'list2_btn',
                                  			'class'       => 'submit-button', 
              			);?>
                    <?=form_submit($attributes,'List'); ?>  

              	  <?=form_close();?> 
        </td>
      <?php } elseif($row->historic_orders > 0) { ?>
          <td>
          	        <?=form_open('order/show/'.$row->product_code);?> 
                		  <?php 
                		    $attributes = array(
                                    			'name'        => 'list2_btn',
                                    			'id'          => 'list2_btn',
                                    			'class'       => 'submit-button', 
                			);?>
                      <?=form_submit($attributes,'History'); ?>  

                	  <?=form_close();?> 
          </td>
      <?php } else { ?>
        <td>&nbsp;</td>
      <?php }  ?>	
    </tr>

	  <tr> 
	    <th>RELEASED</th> <td class="rite"><strong><?=number_format($row->qty_scheduled)?></strong></td> 
	    <?php  if($row->qty_scheduled > 0) { ?>
        <td>
        	        <?=form_open('release/show/'.$row->product_code);?> 
            		  <?php 
            		    $attributes = array(
                                			'name'        => 'list3_btn',
                                			'id'          => 'list3_btn',
                                			'class'       => 'submit-button', 
            			);?>
                  <?=form_submit($attributes,'List'); ?>  
              	  <?=form_close();?> 
        </td>
      <?php } else { ?>
        <td>&nbsp;</td>
      <?php }  ?>		    
    </tr>
        
	<?php endforeach; ?>

<?php } else { ?>
			<tr><td>Not Found</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<?php }  ?>	
	
</table>

<?php  if($data->num_rows() > 0):?>
<?php $this->local_eastern_time = unix_to_human(mysql_to_unix($row->last_update)+(60*60*3)); //convert pacific (server) time to eastern}  ?>
<p style="font-size:90%;">	
  <em>Last Update: <?=$this->local_eastern_time;?> UTC -5</em>
</p>
<?php  endif ?>