    <script language="javascript">
    function confirmSubmit() {
    var agree=confirm("Are you sure to delete this record?");
    if (agree)
         return true;
    else
         return false;
    }
    </script>

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'customer', 'activeTab' => 'pending')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Pending Customer List</h1></div>
				
            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($models)): 
					 
				?>
				<tr>
                    <th width="5%" scope="col"><input type="checkbox" name="allbox" id="allbox" onclick="checkAll()" /></th>
                    <th width="20%" scope="col">Customer Name</th>
                    <th width="10%" scope="col">Type</th>
                    <th width="15%" scope="col">Email</th>
                    <th width="15%" scope="col">Contact No</th>
                    <th width="8%" scope="col">Status</th>
                    <th width="12%" scope="col">Actions</th>
				</tr>
                <?php $i=1; foreach($models as $model): 
				      $customer_type_id = $model->customer_type;
					  $q = new CDbCriteria( array( 'condition' => "id = '$customer_type_id'",) ); 
                      $Type_names = Customer_Type::model()->findAll( $q );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                    <td><?php echo CHtml::link(CHtml::encode($model->customer_name),array('edit', 'id' => $model->id)); ?></td>
                    <td><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
                    <td><?php echo $model->email_address; ?></td>
                    <td><?php echo $model->contact_no1.' '.$model->contact_no2; ?></td>
                    <td><?php echo ucwords($model->status); ?></td>
                    <td class="options-width">
					<a href="<?php echo Yii::app()->request->baseUrl.'/customer/edit/'.$model->id; ?>" title="Edit" class="edit_icon"></a>
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/customer/delete/'.$model->id; ?>" title="Delete" class="delete2_icon"></a>
					<a href="<?php echo Yii::app()->request->baseUrl.'/customer/view/'.$model->id; ?>" title="Show" class="show_icon"></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
				<tr> <td align="right" colspan="7"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></td></tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="7" class="red-left">No Customer Info Available.</td></div></tr>
                <?php endif; ?>
				</table> 
<!--  END #PORTLETS -->  
   </div>
