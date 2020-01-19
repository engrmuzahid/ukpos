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
		<td id="title"><?php echo CHtml::link('Supplier Payment', array('add'))?></td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received'; ?>" class="none new">Receive</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/receiable_report'; ?>" class="none new">Receiable Report</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/received_report'; ?>" class="none new">Received Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment'; ?>" class="none new">Payment</a>  
				<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/payable_report'; ?>" class="none new">Payable Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/paid_report'; ?>" class="none new">Paid Report</a>  
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
                <th width="15%" scope="col">Shipment Id</th>
                <th width="15%" scope="col">Supplier Name</th>
                <th width="15%" scope="col">Date</th>
                <th width="20%" scope="col">Payment Mode</th>  
                <th width="15%" scope="col">Amount</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($models as $model): 
				      $supplier_id   = $model->supplier_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$supplier_id'",) ); 					 
                      $Suppliers = Supplier::model()->findAll( $q1 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                     <td><?php echo $model->chalan_id; ?></td>
                     <td><?php if(count($Suppliers)): foreach($Suppliers as $Suppliers): echo $Suppliers->name; endforeach; endif; ?></td>
                     <td><?php echo date('M d, Y', strtotime($model->payment_date)); ?></td>
                    <td><?php echo $model->payment_mode; ?></td>
                    <td><?php echo "&pound; ".number_format($model->amount, 2); ?></td>
                    <td  width="15%" style="margin-left:10px;">
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/delete/'.$model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> |
					<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/view/'.$model->id; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a>
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
