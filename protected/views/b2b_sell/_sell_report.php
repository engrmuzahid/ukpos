    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>
<table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">B2B Sell Report</td>
        <td></td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
    			<a href="<?php echo Yii::app()->request->baseUrl.'/customer'; ?>" class="none new">Customer</a>  
				<a href="<?php echo Yii::app()->request->baseUrl.'/customer/receiable_report'; ?>" class="none new">Receivable Report</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/customer/received_report'; ?>" class="none new">Received Report</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/b2b_sell'; ?>" class="none new">B2B Sell Home</a>
                <a href="<?php echo Yii::app()->request->baseUrl.'/customer/b2breport'; ?>" class="none new">B2B Invoice List</a>                  
    			<a href="<?php echo Yii::app()->request->baseUrl.'/b2b_sell/profit_loss_report'; ?>" class="none new">B2B Profit / Loss Report</a>    
				<a href="<?php echo Yii::app()->request->baseUrl.'/b2b_sell/report'; ?>" class="none new">B2B Sell Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/b2b_sell/daily_sell_report'; ?>" class="none new">B2B Daily Sell Report</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/b2b_sell/sell_return'; ?>" class="none new">B2B Sell Return</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/b2b_sell/sell_return_report'; ?>" class="none new">B2B Sell Return Report</a> 
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td id="item_table">

        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
			<div id="table_holder">
				<!--  start product-table ..................................................................................... -->
			   <table class="tablesorter" id="sortable_table" style="width:100%">
                <?php if(count($model)): ?>
				<tr>
                    <th>Invoice No</th>
                    <th>Cusomer Name</th>
                    <th>Payment Mode</th>
                    <th>Amount Total(&pound;)</th>
                    <th>Paid Total(&pound;)</th>
					<th>Due Total(&pound;)</th>
                    <th>&nbsp;</th>
         		</tr>
                <?php 
				 $i=1; $grand_total = 0; $paid_sub = 0; $due_sub = 0;			  			 
				 foreach($model as $posValue):
				     $payment_mode = "";
					 if(!empty($payment_mode) && ($posValue->cash_payment >= 1)): $payment_mode .= ", Cash "; elseif(empty($payment_mode) && ($posValue->cash_payment >= 1)): $payment_mode .= "Cash "; endif;
					 if(!empty($payment_mode) && ($posValue->cheque_payment >= 1)): $payment_mode .= ", Cheque "; elseif(empty($payment_mode) && ($posValue->cheque_payment >= 1)): $payment_mode .= "Cheque "; endif;
					 if(!empty($payment_mode) && ($posValue->credit_card_payment >= 1)): $payment_mode .= ", Card "; elseif(empty($payment_mode) && ($posValue->credit_card_payment >= 1)): $payment_mode .= "Card "; endif;

					$customer_id = $posValue->customer_id;
					$customer_name = "";
					if(!empty($customer_id)):			
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 					 
                      $customers = Customer::model()->findAll( $q1 );
					if(count($customers)): foreach($customers as $customer): $customer_name = $customer->customer_name; endforeach; endif;
					endif;
				    $due_amount = $posValue->amount_grand_total - $posValue->paid_amount;
				 ?>
				<tr style="font-family:Verdana; font-size:11px;">
					<td><?php echo $posValue->invoice_no; ?></td>
					<td><?php echo $customer_name; ?></td>
                    <td><strong><?php echo $payment_mode; ?></strong></td>
					<td><strong><?php echo number_format($posValue->amount_grand_total, 2); ?></strong></td>
					<td><strong><?php echo number_format($posValue->paid_amount, 2); ?></strong></td>
					<td><strong><?php echo number_format($due_amount, 2); ?></strong></td>
                    <td width="10%" style="margin-left:10px;">
					 <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/delete/'.$posValue->invoice_no; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> | 
					 <a target="_blank" href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/view/'.$posValue->invoice_no; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a>
                    </td>
        		</tr>
                
               <?php $i = $i + 1;
					$grand_total  = $grand_total + $posValue->amount_grand_total;
					$paid_sub     = $paid_sub + $posValue->paid_amount;
					$due_sub      = $due_sub + $due_amount;
				 endforeach;
				 ?>
				<tr>
					<td align="right" colspan="3"><strong>Total (&pound;) :&nbsp;&nbsp;<strong></td>
                    <td align="left"><strong><?php echo number_format($grand_total, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($paid_sub, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($due_sub, 2); ?></strong></td>
					<td>&nbsp;</td>
        		</tr>
                
				<?php
				 else: ?>
				<tr><div id="message-red"><td colspan="9" class="red-left">No Sell Available Yet .. </td></div></tr>
                <?php endif; ?>
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
