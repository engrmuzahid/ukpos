
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'received_delivery', 'activeTab' => 'home')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Received Product</h1></div>

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($model)): 
					 
				?>
				<tr>
                    <th width="20%" scope="col">Storage Period</th>
                    <th width="15%" scope="col">Warehouse</th>
                    <th width="20%" scope="col">Party Name</th>
                    <th width="20%" scope="col">Note</th>
                    <th width="10%" scope="col">Charge</th>
                    <th width="15%" scope="col">Actions</th>
				</tr>
                <?php $i=1; foreach($model as $model): 
				      $storage_party_id   = $model->storage_party_id;
				      $warehouse_id       = $model->warehouse_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$storage_party_id'",) ); 	
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$warehouse_id'",) ); 					 
                      $Sparties = Storage_Party::model()->findAll( $q1 );
                      $Compartments = Compartment::model()->findAll( $q2 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
                    <td><?php echo date('M d, Y', strtotime($model->received_from_date)).' To '.date('M d, Y', strtotime($model->received_to_date)); ?></td>
					<td><?php if(count($Compartments)): foreach($Compartments as $Compartment): echo $Compartment->warehouse_name; endforeach; endif; ?></td>
                    <td><?php if(count($Sparties)): foreach($Sparties as $Sparty): echo $Sparty->party_name; endforeach; endif; ?></td>
                    <td><?php echo $model->note; ?></td>
                    <td><?php echo "TK. ".$model->total_charge; ?></td>
                    <td class="options-width">
					<a href="<?php echo Yii::app()->request->baseUrl.'/receive_delivery/view/'.$model->id; ?>" title="Show" class="show_icon"></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="5" class="red-left">No Delivery Information Available.</td></div></tr>
                <?php endif; ?>
				</table> 
<!--  END #PORTLETS -->  
   </div>
