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
		<td id="title">Account Receiable Report</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received'; ?>" class="none new">Receive</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/receiable_report'; ?>" class="none new">Receivable Report</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/received_report'; ?>" class="none new">Received Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment'; ?>" class="none new">Payment</a>  
				<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/payable_report'; ?>" class="none new">Payable Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/paid_report'; ?>" class="none new">Paid Report</a>  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td id="item_table">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
			<div id="table_holder">
            
			<table class="tablesorter" id="sortable_table">
               <?php if(count($model)): ?>
                <thead>
                  <tr>
                    <th width="10%" scope="col">Invoice No</th>
                    <th width="20%" scope="col">Cusomer Name</th>
                    <th width="10%" scope="col">Date</th>
                    <th width="20%" scope="col">Total Amount</th>
                    <th width="20%" scope="col">Paid Amount</th>
                    <th width="10%" scope="col">Due</th>
                    <th width="10%" scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php $i=1; $grand_total = 0; $pay_total = 0; $due_total = 0;
				
				      foreach($model as $posValue):
					  $customer_id = $posValue->customer_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 					 
                      $customers = Customer::model()->findAll( $q1 );
					  if(count($customers)): foreach($customers as $customer): $customer_name = $customer->customer_name; endforeach; else:  $customer_name = ""; endif;
				 ?>
                <tr>
					<td><a href="<?php echo Yii::app()->request->baseUrl.'/sell/view/'.preg_replace("/[^0-9]/", '', $posValue->invoice_no); ?>" target="_blank"><?php echo $posValue->invoice_no; ?></a></td>
					<td><?php echo $customer_name; ?></td>
					<td><?php echo date('M d, Y', strtotime($posValue->order_date)); ?></td>
                    <td><?php  echo '&pound; '.number_format($posValue->amount_grand_total, 2); ?></td>
                    <td><?php  echo '&pound; '.number_format($posValue->paid_amount, 2); ?></td>
                    <td><?php $due = $posValue->amount_grand_total - $posValue->paid_amount; echo '&pound; '.number_format($due, 2); ?></td>
                    <td><?php echo ucwords($posValue->status); ?></td>
               </tr>
                <?php $i = $i + 1;
				  $grand_total = $grand_total + $posValue->amount_grand_total;
				  $pay_total   = $pay_total + $posValue->paid_amount;
				  $due_total   = $due_total + $due;
				 endforeach; ?>
                    <tr>
                    <td colspan="3">&nbsp;</td>
                    <td><strong><?php echo "Total &pound; ".number_format($grand_total, 2); ?></strong></td>
                    <td><strong><?php echo "Total &pound; ".number_format($pay_total, 2); ?></strong></td>
                    <td colspan="2"><strong><?php echo "Total &pound; ".number_format($due_total, 2); ?></strong></td>
                    </tr>
                <?php  else: ?>
				<tr><div id="message-red"><td colspan="7" class="red-left">No Receiable Amount Available Yet .. <a href="<?php echo Yii::app()->request->baseUrl.'/account_received/receiable_report/'; ?>">Search Again..</a></td></div></tr>
                <?php endif; ?>
				</table> 
          </div>
          </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
