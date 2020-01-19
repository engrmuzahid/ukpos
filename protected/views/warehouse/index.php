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

 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title"><?php echo CHtml::link('Shop', array('add'))?></td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/user'; ?>" class="none new">Employees</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/user/register'; ?>" class="none new">Registration</a>  
				<a href="<?php echo Yii::app()->request->baseUrl.'/station'; ?>" class="none new">Station</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/company'; ?>" class="none new">Company</a>  
    			<a href="<?php echo Yii::app()->request->baseUrl.'/warehouse'; ?>" class="none new">Shop</a>                  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td id="item_table">
			<div id="table_holder">
            
			<table class="tablesorter" id="sortable_table" style="width:100%">
            <?php  if(count($models)): ?>
            <thead>
            <tr>
                <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                <th width="40%">Shop Name</th>
                <th width="15%">Created Date</th>
                <th width="15%">Modified Date</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach($models as $model): ?>
            <tr>
                <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
					<td><?php echo CHtml::link(CHtml::encode($model->shop_name),array('edit', 'id' => $model->id)); ?></td>
					<td><?php if(!empty($model->created)): echo date('M d, Y', strtotime($model->created));endif; ?></td>
					<td><?php if(!empty($model->modified)): echo date('M d, Y', strtotime($model->modified));endif; ?></td>
                    <td width="15%" style="margin-left:10px;">
					<a href="<?php echo Yii::app()->request->baseUrl.'/warehouse/edit/'.$model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a> |
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/warehouse/delete/'.$model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a>
				   </td>
            </tr>
             <?php endforeach; endif; ?>
           </tbody>
           </table>
          </div>
		  <div id="pagination"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
    <script language="javascript">
    function confirmSubmit() {
    var agree=confirm("Are you sure to delete this record?");
    if (agree)
         return true;
    else
         return false;
    }
   </script>   

