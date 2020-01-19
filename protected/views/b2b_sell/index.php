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
		<td id="title">B2B Sell</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<?php $this->renderPartial('_menu') ?>
		<td style="width: 10px;"></td>        
		<td id="item_table">
			<div id="table_holder">
            
			<table class="tablesorter" id="sortable_table" style="width:100%; font-family:Verdana; font-size:11px;">
            <?php  if(count($models)): ?>
            <thead>
            <tr>
                <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                <th width="10%">Invoice No</th>
                <th width="15%">Date</th>
                <th width="20%">Cusomer Name</th>
                <th width="15%">Payment Mode</th>
                <th width="10%">Discount(%)</th>
                <th width="15%">Total Amount</th>
                <th class="rightmost header">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach($models as $posValue): 				
					$customer_id = $posValue->customer_id;
					$customer_name = "";
					if(!empty($customer_id)):			
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 					 
                      $customers = Customer::model()->findAll( $q1 );
					if(count($customers)): foreach($customers as $customer): $customer_name = $customer->customer_name; endforeach; endif;
					endif;
				     $payment_mode = "";
					 if(!empty($payment_mode) && ($posValue->cash_payment >= 1)): $payment_mode .= "Cash, "; elseif(empty($payment_mode) && ($posValue->cash_payment >= 1)): $payment_mode .= "Cash "; endif;
					 if(!empty($payment_mode) && ($posValue->cheque_payment >= 1)): $payment_mode .= "Cheque, "; elseif(empty($payment_mode) && ($posValue->cheque_payment >= 1)): $payment_mode .= "Cheque "; endif;
					 if(!empty($payment_mode) && ($posValue->credit_card_payment >= 1)): $payment_mode .= "Card, "; elseif(empty($payment_mode) && ($posValue->credit_card_payment >= 1)): $payment_mode .= "Card "; endif;
             ?>
            <tr>
                <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
					<td><a href="<?php echo Yii::app()->request->baseUrl.'/b2b_sell/view/'.preg_replace("/[^0-9]/", '', $posValue->invoice_no); ?>" target="_blank"><?php echo $posValue->invoice_no; ?></a></td>
					<td><?php echo date('M d, Y', strtotime($posValue->order_date)); ?></td>
					<td><?php echo $customer_name; ?></td>
                    <td><?php echo $payment_mode; ?></td>
                    <td><?php  echo $posValue->discount_ratio; ?></td>
                    <td><?php  echo '&pound; '.number_format($posValue->amount_grand_total, 2); ?></td>
                    <td width="15%" style="margin-left:5px;">
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/delete/'.$posValue->invoice_no; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> | 
					<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/view/'.$posValue->invoice_no; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a>
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
