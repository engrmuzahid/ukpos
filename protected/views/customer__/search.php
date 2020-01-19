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
		<td id="title"><?php echo CHtml::link('Customer', array('add'))?></td>
		<td id="title_search">
             <?php echo CHtml::beginForm(Yii::app()->request->baseUrl.'/customer/search','post')?>		
                    <?php echo CHtml::textField('customer_name', '', array('style' => 'width:150px; height:15px;border:1px solid #CCC;'))?>             
             <?php echo CHtml::endForm(); ?>             
		</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<?php $this->renderPartial('/b2b_sell/_menu') ?>
		</td>
		<td style="width: 10px;"></td>        
		<td id="item_table">
			  <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
                <div class="message">
                    <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                </div>
             <?php endif; ?> 

			<div id="table_holder">
            
			<table class="tablesorter" id="sortable_table" style="width:100%">
            <?php  if(count($models)): ?>
            <thead>
            <tr>
                <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                <th>Customer </th>
                <th>Business Name</th>
                <th>Contact No</th> 
                <th class="rightmost header">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach($models as $model): ?>
            <tr style="font:Verdana; font-size:11px">
                <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                <td width="25%"><?php echo CHtml::link(CHtml::encode($model->customer_name."-".$model->id),array('edit', 'id' => $model->id)); ?><br/><?php echo $model->email_address; ?></td>
                    <td width="25%"><?php echo $model->business_name; ?></td>
                    <td width="18%"><?php echo $model->contact_no1.' '.$model->contact_no2; ?></td>
                  
                    <td width="12%" style="margin-left:10px;">
					<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/customer/edit/'.$model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a> | 
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/customer/delete/'.$model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> | 
					<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/customer/view/'.$model->id; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a>
                    </td>
            </tr>
             <?php endforeach; endif; ?>
           </tbody>
           </table>
          </div>
		 
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