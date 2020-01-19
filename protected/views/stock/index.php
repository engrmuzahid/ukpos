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

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'supplier', 'activeTab' => 'supplier')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Supplier</h1></div>
				
                <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="margin-left:10px; margin-bottom:5px;">
                    <tr>
                     <td colspan="2" align="left">
                         <a href="<?php echo Yii::app()->request->baseUrl.'/index.php/supplier/add'; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/add.gif" alt="<?php echo "#"; ?>" border="0" align="absmiddle"/></a>
                         &nbsp;
                         <?php echo CHtml::link('Supplier', array('add'))?>
                     </td>
                    </tr>
				</table>

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($models)): 
					 
				?>
				<tr>
                    <th width="5%" scope="col"><input type="checkbox" name="allbox" id="allbox" onclick="checkAll()" /></th>
                    <th width="20%" scope="col">Supplier Name</th>
                    <th width="10%" scope="col">Type</th>
                    <th width="10%" scope="col">Email</th>
                    <th width="20%" scope="col">Contact No</th>
                    <th width="10%" scope="col">Fax</th>
                    <th width="20%" scope="col">Address</th>
                    <th width="10%" scope="col">Actions</th>
				</tr>
                <?php $i=1; foreach($models as $model): 
				      $supplier_type = $model->supplier_type;
					  $q = new CDbCriteria( array( 'condition' => "id = '$supplier_type'",) ); 
                      $Type_names = Supplier_Type::model()->findAll( $q );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                    <td><?php echo CHtml::link(CHtml::encode($model->name),array('edit', 'id' => $model->id)); ?></td>
                    <td><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
                    <td><?php echo $model->email; ?></td>
                    <td><?php echo $model->phone.' '.$model->mobile; ?></td>
                    <td><?php echo $model->fax; ?></td>
                    <td><?php echo $model->address; ?></td>
                    <td class="options-width">
					<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/supplier/edit/'.$model->id; ?>" title="Edit" class="edit_icon"></a>
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/supplier/delete/'.$model->id; ?>" title="Delete" class="delete2_icon"></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
				<tr> <td align="right" colspan="8"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></td></tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="8" class="red-left">No Supplier Info Available.</td></div></tr>
                <?php endif; ?>
				</table> 
<!--  END #PORTLETS -->  
   </div>
