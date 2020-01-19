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

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'expense_info', 'activeTab' => 'office_expense')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Office Expense Info</h1></div>
				
                <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="margin-left:10px; margin-bottom:5px;">
                    <tr>
                     <td colspan="2" align="left">
                         <a href="<?php echo Yii::app()->request->baseUrl.'/office_expense/add'; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/add.gif" alt="<?php echo "#"; ?>" border="0" align="absmiddle"/></a>
                         &nbsp;
                         <?php echo CHtml::link('Office Expense', array('add'))?>
                     </td>
                    </tr>
				</table>

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($models)): 
					 
				?>
				<tr>
                    <th width="5%" scope="col"><input type="checkbox" name="allbox" id="allbox" onclick="checkAll()" /></th>
                    <th width="15%" scope="col">Type</th>
                    <th width="15%" scope="col">Name</th>
                    <th width="15%" scope="col">Voucher No</th>
                    <th width="15%" scope="col">Date</th>
                    <th width="10%" scope="col">Mode</th>
                    <th width="10%" scope="col">Amount</th>
                    <th width="15%" scope="col">Actions</th>
				</tr>
                <?php $i=1; foreach($models as $model): 
				      $expense_type_id   = $model->expense_type_id;
				      $expense_name_id   = $model->expense_name_id;
					  $cond1 = new CDbCriteria( array( 'condition' => "id = '$expense_type_id'",) ); 
					  $cond2 = new CDbCriteria( array( 'condition' => "id = '$expense_name_id'",) ); 					 
                      $expenseTypes = Expense_Type::model()->findAll( $cond1 );
                      $expenseNames = Expense_Name::model()->findAll( $cond2 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                    <td><?php if(count($expenseTypes)): foreach($expenseTypes as $expenseTypes): echo $expenseTypes->expense_type_name; endforeach; endif; ?></td>
                    <td><?php if(count($expenseNames)): foreach($expenseNames as $expenseNames): echo $expenseNames->expense_name; endforeach; endif; ?></td>
                     <td><?php echo $model->voucher_no; ?></td>
                     <td><?php echo date('M d, Y', strtotime($model->expense_date)); ?></td>
                    <td><?php echo ucwords($model->payment_mode); ?></td>
                    <td><?php echo $model->amount; ?></td>
                    <td class="options-width">
					<!--<a href="<?php echo Yii::app()->request->baseUrl.'/office_expense/edit/'.$model->id; ?>" title="Edit" class="edit_icon"></a>-->
                    <a href="<?php echo Yii::app()->request->baseUrl.'/office_expense/view/'.$model->id; ?>" title="Show" class="show_icon"></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
				<tr> <td align="right" colspan="8"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></td></tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="8" class="red-left">No Office Expense Available.</td></div></tr>
                <?php endif; ?>
				</table> 
<!--  END #PORTLETS -->  
   </div>
