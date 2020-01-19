
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
		<td id="title">Account Paid Report</td>
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
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/receiable_report'; ?>" class="none new">Receiable Report</a>
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
                    <th width="10%" scope="col">Shipment Id</th>
                    <th width="25%" scope="col">Supplier Name</th>
                    <th width="15%" scope="col">Date</th>
                    <th width="20%" scope="col">Paid Mode</th>
                    <th width="30%" scope="col">Paid Amount</th>
                  </tr>
                </thead>
                <tbody>
                <?php $i=1; $grand_total = 0;
				
				      foreach($model as $posValue):
					  $supplier_id = $posValue->supplier_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$supplier_id'",) ); 					 
                      $suppliers = Supplier::model()->findAll( $q1 );
					  if(count($suppliers)): foreach($suppliers as $supplier): $supplier_name = $supplier->name; endforeach; else:  $supplier_name = ""; endif;
				 ?>
                <tr>
					<td><a href="<?php echo Yii::app()->request->baseUrl.'/purchase/view2/'.preg_replace("/[^0-9]/", '', $posValue->chalan_id); ?>" target="_blank"><?php echo $posValue->chalan_id; ?></a></td>
					<td><?php echo $supplier_name; ?></td>
					<td><?php echo date('M d, Y', strtotime($posValue->payment_date)); ?></td>
                    <td><?php  echo ucwords($posValue->payment_mode); ?></td>
                    <td><?php  echo '&pound; '.number_format($posValue->amount, 2); ?></td>
               </tr>
                <?php $i = $i + 1;
				  $grand_total = $grand_total + $posValue->amount;
				 endforeach; ?>
                    <tr>
                    <td colspan="3">&nbsp;</td>
                    <td><strong><?php echo "Total"; ?></strong></td>
                    <td><strong><?php echo "&pound; ".number_format($grand_total, 2); ?></strong></td>
                    </tr>
                <?php  else: ?>
				<tr><div id="message-red"><td colspan="5" class="red-left">No Paid Amount Available Yet .. <a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/paid_report/'; ?>">Search Again..</a></td></div></tr>
                <?php endif; ?>
				</table>
          </div>
          </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
