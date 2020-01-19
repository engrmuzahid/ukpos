<script type="text/javascript">
$(document).ready(function()
{
    init_table_sorting();
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
});

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{
			sortList: [[1,0]],
			headers:
			{
				0: { sorter: false},
				3: { sorter: false}
			}
		});
	}
}
</script>

    <script language="javascript">
    function confirmSubmit() {
    var agree=confirm("Are you sure to delete this record?");
    if (agree)
         return true;
    else
         return false;
    }
    </script>

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'issued_delivery', 'activeTab' => 'home')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Issued Delivery</h1></div>
				
                <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="margin-left:10px; margin-bottom:5px;">
                    <tr>
                     <td colspan="2" align="left">
                         <a href="<?php echo Yii::app()->request->baseUrl.'/issued_delivery/add'; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/add.gif" alt="<?php echo "#"; ?>" border="0" align="absmiddle"/></a>
                         &nbsp;
                         <?php echo CHtml::link('Issued Delivery', array('add'))?>
                     </td>
                    </tr>
				</table>

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($models)): 
					 
				?>
				<tr>
                    <th width="5%" scope="col"><input type="checkbox" name="allbox" id="allbox" onclick="checkAll()" /></th>
                    <th width="10%" scope="col">Issued Id</th>
					<th width="15%" scope="col">Date</th>
                    <th width="15%" scope="col">Party Name</th>
                    <th width="15%" scope="col">Warehouse</th>
                    <th width="30%" scope="col">Note</th>  
                    <th width="10%" scope="col">Actions</th>
				</tr>
                <?php $i=1; foreach($models as $model): 
				      $storage_party_id   = $model->storage_party_id;
				      $warehouse_id       = $model->warehouse_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$storage_party_id'",) ); 	
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$warehouse_id'",) ); 					 
                      $Sparties = Storage_Party::model()->findAll( $q1 );
                      $Compartments = Compartment::model()->findAll( $q2 );
					 
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                    <td><?php echo $model->id; ?></td>
					<td><?php echo date('M d, Y', strtotime($model->issued_do_date)); ?></td>
                    <td><?php if(count($Sparties)): foreach($Sparties as $Sparty): echo $Sparty->party_name; endforeach; endif; ?></td>
					<td><?php if(count($Compartments)): foreach($Compartments as $Compartment): echo $Compartment->warehouse_name; endforeach; endif; ?></td>
                    <td><?php echo $model->note; ?></td>
                    <td class="options-width">
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/issued_delivery/delete/'.$model->id; ?>" title="Delete" class="delete2_icon"></a>
					<!--<a href="<?php echo Yii::app()->request->baseUrl.'/issued_delivery/edit/'.$model->id; ?>" title="Edit" class="edit_icon"></a>-->
                    <a href="<?php echo Yii::app()->request->baseUrl.'/issued_delivery/view/'.$model->id; ?>" title="Show" class="show_icon"></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
				<tr> <td align="right" colspan="7"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></td></tr>
                <?php else: ?>
					<tr><div id="message-red"><td colspan="7" class="red-left">No Delivery Information Available.</td></div></tr>
                <?php endif; ?>
				</table> 
<!--  END #PORTLETS -->  
   </div>
