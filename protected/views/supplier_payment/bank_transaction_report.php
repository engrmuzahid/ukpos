
    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'paid_report', 'activeTab' => 'bank_report')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
        <div id="ptable3">
        <div style="margin-left:5px;"><h1>Bank Paid Report</h1></div>

              <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
               <?php if(count($model)): ?>
                <thead>
                  <tr>
                    <th width="5%" scope="col">SL</th>
                    <th width="10%" scope="col">Invoice No</th>
                    <th width="20%" scope="col">Transaction Date</th>
                    <th width="20%" scope="col">Bank Name</th>
                    <th width="20%" scope="col">Account No</th>
                    <th width="10%" scope="col">Mode</th>
                    <th width="15%" scope="col">Amount</th>
                  </tr>
                </thead>
                <tbody>
                <?php $i=1; $grand_total = 0;
				
				      foreach($model as $posValue):
					  $status  = $posValue->status;
					  $bank_id    = $posValue->bank_id;
					  $account_no = $posValue->account_no;
					  if($status == 'debit'): $status = "Received"; elseif($status == 'credit'): $status = "Received"; else: $status = ""; endif;
					 
					  $cond1 = new CDbCriteria( array( 'condition' => "id = '$bank_id'",) ); 					 
					  $cond2 = new CDbCriteria( array( 'condition' => "id = '$account_no'",) ); 					 
				      $banks      = Bank_Info::model()->findAll( $cond1 );
				      $accountnos = Bank_Account::model()->findAll( $cond2 );
				 ?>
                <tr>
					<td><?php echo $i; ?></td>
                    <td><?php  echo $posValue->invoice_no; ?></td>
					<td><?php echo date('M d, Y', strtotime($posValue->transaction_date)); ?></td>
                     <td><?php if(count($banks)): foreach($banks as $bank): echo $bank->bank_name; endforeach; endif; ?></td>
                     <td><?php if(count($accountnos)): foreach($accountnos as $accountno): echo $accountno->account_no; endforeach; endif; ?></td>
                    <td><?php  echo $status; ?></td>
                    <td><?php  echo '&pound; '.number_format($posValue->amount, 2); ?></td>
               </tr>
                <?php $i = $i + 1;
				  $grand_total = $grand_total + $posValue->amount;
				 endforeach; ?>
                    <tr>
                    <td colspan="5">&nbsp;</td>
                    <td align="right"><strong><?php echo "Total"; ?></strong>&nbsp;&nbsp;</td>
                    <td><strong><?php echo "&pound; ".number_format($grand_total, 2); ?></strong></td>
                    </tr>
                <?php  else: ?>
				<tr><div id="message-red"><td colspan="7" class="red-left">No Transaction Amount Available Yet .. <a href="<?php echo Yii::app()->request->baseUrl.'/supplied_payment/banktrans_report/'; ?>">Search Again..</a></td></div></tr>
                <?php endif; ?>
				</table>
          </div>
<!--  END #PORTLETS -->  
   </div>
