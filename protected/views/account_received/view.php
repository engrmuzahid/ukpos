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
		<td id="title">Received Account Details</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received'; ?>" class="none new">Receive</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/receiable_report'; ?>" class="none new">Receivable Report</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/received_report'; ?>" class="none new">Received Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment'; ?>" class="none new">Payment</a>  
				<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/payable_report'; ?>" class="none new">Payable Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/paid_report'; ?>" class="none new">Paid Report</a>  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td>
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
		<?php   if(count($models)): foreach($models as $model):
				      $bank_id           = $model->d_bank_id;
				      $account_no        = $model->d_account_no;
				      $customer_id       = $model->customer_id;
					 
					  $cond3 = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 
					  $cond4 = new CDbCriteria( array( 'condition' => "id = '$bank_id'",) ); 
					  $cond5 = new CDbCriteria( array( 'condition' => "id = '$account_no'",) ); 
					  
                      $Customers = Customer::model()->findAll( $cond3 );
                      $bankNames = Bank_Info::model()->findAll( $cond4 );
                      $accountNames = Bank_Account::model()->findAll( $cond5 );
		  ?>
       <table border="0" width="90%"  cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-right:15px;">  
        <tr>
        <td width="20%"><strong><?php echo 'Invoice No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo $model->invoice_no; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Customer Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php if(count($Customers)): foreach($Customers as $Customers): echo $Customers->customer_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Received Date'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo date('M d, Y', strtotime($model->receive_date)); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Received Mode'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo $model->receive_mode; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%"><strong><?php echo 'Amount'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo "&pound; ".number_format($model->amount, 2); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
       <?php if($model->receive_mode =='bank'): ?>
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'From Bank Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo $model->r_bank_name; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'From Cheque No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo $model->r_cheque_no;  ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>  
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'From Cheque Date'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo date('M d, Y', strtotime($model->r_cheque_date)); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>    

        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Deposit Bank Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php if(count($bankNames)): foreach($bankNames as $bankNames): echo $bankNames->bank_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Deposit Account No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php if(count($accountNames)): foreach($accountNames as $accountNames): echo $accountNames->account_no; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <?php endif; ?>       
        </table>
       <?php endforeach; endif; ?>

		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
