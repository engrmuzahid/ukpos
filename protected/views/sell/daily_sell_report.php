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
		<td id="title">Daily Sell Report<?php if(!empty($report_date)): echo "( ".date('d M, Y', strtotime($report_date))." )"; endif; ?></td>
        <td></td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell'; ?>" class="none new">Home</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/profit_loss_report'; ?>" class="none new">Profit / Loss Report</a>    
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell/report'; ?>" class="none new">Sell Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/daily_sell_report'; ?>" class="none new">Daily Sell Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_in/min_stockout_report'; ?>" class="none new">Min Stock Out Report</a> 
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell/sell_return'; ?>" class="none new">Sell Return</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/sell_return_report'; ?>" class="none new">Sell Return Report</a>  
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
                    <th width="10%">Invoice No</th>
                    <th width="20%">Payment Mode</th>
                    <th width="15%">Amount Total(&pound;)</th>
                    <th width="15">Vat Total(&pound;)</th>
                    <th width="15%">Paid Total(&pound;)</th>
					<th width="15%">Due Total(&pound;)</th>
                    <th>&nbsp;</th>
         		</tr>
                <?php 
				 $i=1; $grand_total = 0; $paid_sub = 0; $due_sub = 0; $vat_total = 0;			  			 
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
                    <td><strong><?php echo $payment_mode; ?></strong></td>
					<td><strong><?php echo number_format($posValue->amount_grand_total, 2); ?></strong></td>
                                        <td><strong><?php echo number_format($posValue->vat_total, 2); ?></strong></td>
					<td><strong><?php echo number_format($posValue->paid_amount, 2); ?></strong></td>
					<td><strong><?php echo number_format($due_amount, 2); ?></strong></td>
                    <td width="15%" style="margin-left:10px;">
					 <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/sell/delete/'.$posValue->invoice_no; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> | 
					 <a target="_blank" href="<?php echo Yii::app()->request->baseUrl.'/index.php/sell/view/'.$posValue->invoice_no; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a>
                    </td>
        		</tr>
                
               <?php $i = $i + 1;
					$grand_total  = $grand_total + $posValue->amount_grand_total;
					$paid_sub     = $paid_sub + $posValue->paid_amount;
					$due_sub      = $due_sub + $due_amount;
                                        $vat_total += $posValue->vat_total;
				 endforeach;
				 ?>
				<tr>
					<td colspan="2" align="right"><strong>Total (&pound;) :&nbsp;&nbsp;</strong></td>
                    <td align="left"><strong><?php echo number_format($grand_total, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($vat_total, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($paid_sub, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($due_sub, 2); ?></strong></td>
					<td>&nbsp;</td>
        		</tr>
                
				<?php
				 else: ?>
				<tr><div id="message-red"><td colspan="8" class="red-left">No Sell Available Yet .. </td></div></tr>
                <?php endif; ?>
				</table> 
                </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
