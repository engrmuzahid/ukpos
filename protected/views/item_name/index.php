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

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'product', 'activeTab' => 'item_name')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Item Name</h1></div>
				
                <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="margin-left:10px; margin-bottom:5px;">
                    <tr>
                     <td colspan="2" align="left">
                         <a href="<?php echo Yii::app()->request->baseUrl.'/item_name/add'; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/add.gif" alt="<?php echo "#"; ?>" border="0" align="absmiddle"/></a>
                         &nbsp;
                         <?php echo CHtml::link('Item Name', array('add'))?>
                     </td>
                    </tr>
				</table>

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($models)): 
					 
				?>
				<tr>
                    <th width="5%" scope="col"><input type="checkbox" name="allbox" id="allbox" onclick="checkAll()" /></th>
                    <th width="15%" scope="col">Category Name</th>
                    <th width="15%" scope="col">Subcategory</th>
                    <th width="15%" scope="col">Item Type</th>
                    <th width="20%" scope="col">Item Name</th>
                    <th width="15%" scope="col">Created Date</th>
                    <th width="15%" scope="col">Actions</th>
				</tr>
                <?php $i=1; foreach($models as $model): 
				      $category_id = $model->product_category_id;
				      $type_id = $model->product_type_id;
				      $item_type_id = $model->product_item_type_id;
					  
					  $q = new CDbCriteria( array( 'condition' => "id = '$category_id'",) ); 
                      $Category_names = Product_Category::model()->findAll( $q );
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$type_id'",) ); 
                      $Type_names = Product_Type::model()->findAll( $q2 );
					  $q3 = new CDbCriteria( array( 'condition' => "id = '$item_type_id'",) ); 
                      $Item_types = Product_Item::model()->findAll( $q3 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
					<td><?php if(count($Category_names)): foreach($Category_names as $Category_name): echo $Category_name->category_name; endforeach; endif; ?></td>
					<td><?php if(count($Type_names)): foreach($Type_names as $Type_name): echo $Type_name->type_name; endforeach; endif; ?></td>
					<td><?php if(count($Item_types)): foreach($Item_types as $Item_type): echo $Item_type->item_type_name; endforeach; endif; ?></td>
                    <td><?php echo CHtml::link(CHtml::encode($model->item_name),array('edit', 'id' => $model->id)); ?></td>
					<td><?php if(!empty($model->created)): echo date('M d, Y', strtotime($model->created));endif; ?></td>
                    <td class="options-width">
					<a href="<?php echo Yii::app()->request->baseUrl.'/item_name/edit/'.$model->id; ?>" title="Edit" class="edit_icon"></a>
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/item_name/delete/'.$model->id; ?>" title="Delete" class="delete2_icon"></a>
					</td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
				<tr> <td align="right" colspan="7"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></td></tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="7" class="red-left">No Product Item Available.</td></div></tr>
                <?php endif; ?>
				</table> 
<!--  END #PORTLETS -->  
   </div>
