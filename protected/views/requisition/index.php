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

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'requisition', 'activeTab' => 'home')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Requisition</h1></div>
				
                <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="margin-left:10px; margin-bottom:5px;">
                    <tr>
                     <td colspan="2" align="left">
                         <a href="<?php echo Yii::app()->request->baseUrl.'/index.php/requisition/add'; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/add.gif" alt="<?php echo "#"; ?>" border="0" align="absmiddle"/></a>
                         &nbsp;
                         <?php echo CHtml::link('Requisition', array('add'))?>
                     </td>
                    </tr>
				</table>

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($models)): 
					 
				?>
				<tr>
                    <th width="5%" scope="col"><input type="checkbox" name="allbox" id="allbox" onclick="checkAll()" /></th>
                    <th width="20%" scope="col">Requisition Date</th>
                    <th width="25%" scope="col">User Name</th>
                    <th width="35%" scope="col">Note</th>
                    <th width="15%" scope="col">Actions</th>
				</tr>
                <?php $i=1; foreach($models as $model): 
				      $username   = $model->requisition_submitted_by;
					  $q1 = new CDbCriteria( array( 'condition' => "username = '$username'",) ); 					 
                      $users = Users::model()->findAll( $q1 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
					<td><?php echo date('M d, Y', strtotime($model->requisition_date)); ?></td>
                    <td><?php if(count($users)): foreach($users as $users): echo $users->full_name; endforeach; endif; ?></td>
                    <td><?php echo $model->note; ?></td>
                    <td class="options-width">
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/requisition/delete/'.$model->id; ?>" title="Delete" class="delete2_icon"></a>
					<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/requisition/view/'.$model->id; ?>" title="Show" class="show_icon"></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
				<tr> <td align="right" colspan="5"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></td></tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="5" class="red-left">No Requisition Information Available.</td></div></tr>
                <?php endif; ?>
				</table> 
<!--  END #PORTLETS -->  
   </div>
