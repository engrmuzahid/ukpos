
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'requisition', 'activeTab' => 'report')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Requisition</h1></div>
				

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($model)): 
					 
				?>
				<tr>
                    <th width="25%" scope="col">Requisition Date</th>
                    <th width="25%" scope="col">User Name</th>
                    <th width="35%" scope="col">Note</th>
                    <th width="15%" scope="col">Actions</th>
				</tr>
                <?php $i=1; foreach($model as $model): 
				      $username   = $model->requisition_submitted_by;
					  $q1 = new CDbCriteria( array( 'condition' => "username = '$username'",) ); 					 
                      $users = Users::model()->findAll( $q1 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><?php echo date('M d, Y', strtotime($model->requisition_date)); ?></td>
                    <td><?php if(count($users)): foreach($users as $users): echo $users->full_name; endforeach; endif; ?></td>
                    <td><?php echo $model->note; ?></td>
                    <td class="options-width">
					<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/requisition/view/'.$model->id; ?>" title="Show" class="show_icon"></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="4" class="red-left">No Requisition Information Available.</td></div></tr>
                <?php endif; ?>
				</table> 
<!--  END #PORTLETS -->  
   </div>
