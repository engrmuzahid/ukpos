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

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'expense_info', 'activeTab' => 'expense_name')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Expense Name</h1></div>
				
                <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="margin-left:10px; margin-bottom:5px;">
                    <tr>
                     <td colspan="2" align="left">
                         <a href="<?php echo Yii::app()->request->baseUrl.'/expense_name/add'; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/add.gif" alt="<?php echo "#"; ?>" border="0" align="absmiddle"/></a>
                         &nbsp;
                         <?php echo CHtml::link('Expense Name', array('add'))?>
                     </td>
                    </tr>
				</table>

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($models)): ?>
				<tr>
                    <th width="5%" scope="col"><input type="checkbox" name="allbox" id="allbox" onclick="checkAll()" /></th>
                    <th width="20%" scope="col">Expense Type</th>
                    <th width="20%" scope="col">Expense Name</th>
                    <th width="15%" scope="col">Created Date</th>
                    <th width="15%" scope="col">Modified Date</th>
                    <th width="15%" scope="col">Actions</th>
				</tr>
                <?php $i=1; foreach($models as $model):
				      $expense_type_id = $model->expense_type_id;
					  $cond = new CDbCriteria( array( 'condition' => "id = '$expense_type_id'",) ); 
                      $expenseTypes = Expense_Type::model()->findAll( $cond );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                    <td><?php if(count($expenseTypes)): foreach($expenseTypes as $expenseTypes): echo $expenseTypes->expense_type_name; endforeach; endif; ?></td>
                    <td><?php echo CHtml::link(CHtml::encode($model->expense_name),array('edit', 'id' => $model->id)); ?></td>
                    <td><?php if(!empty($model->created)): echo date('M d, Y', strtotime($model->created));endif; ?></td>
					<td><?php if(!empty($model->modified)): echo date('M d, Y', strtotime($model->modified));endif; ?></td>
                    <td class="options-width">
					<a href="<?php echo Yii::app()->request->baseUrl.'/expense_name/edit/'.$model->id; ?>" title="Edit" class="edit_icon"></a>
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/expense_name/delete/'.$model->id; ?>" title="Delete" class="delete2_icon"></a>
					</td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
				<tr> <td align="right" colspan="6"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></td></tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="6" class="red-left">No Expense Available.</td></div></tr>
                <?php endif; ?>
				</table> 
<!--  END #PORTLETS -->  
   </div>
