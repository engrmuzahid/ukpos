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
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/receiable_report'; ?>" class="none new">Receiable Report</a>
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
				      $bank_id           = $model->bank_id;
				      $account_no        = $model->account_no;
				      $supplier_id       = $model->supplier_id;
					 
					  $cond3 = new CDbCriteria( array( 'condition' => "id = '$supplier_id'",) ); 
					  $cond4 = new CDbCriteria( array( 'condition' => "id = '$bank_id'",) ); 
					  $cond5 = new CDbCriteria( array( 'condition' => "id = '$account_no'",) ); 
					  
                      $Suppliers = Supplier::model()->findAll( $cond3 );
                      $bankNames = Bank_Info::model()->findAll( $cond4 );
                      $accountNames = Bank_Account::model()->findAll( $cond5 );
		  ?>
       <table border="0" width="90%"  cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:15px;">  
        <tr>
        <td width="20%"><strong><?php echo 'Shipment Id'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo $model->chalan_id; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Supplier Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php if(count($Suppliers)): foreach($Suppliers as $Suppliers): echo $Suppliers->name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Payment Date'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo date('M d, Y', strtotime($model->payment_date)); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Payment Mode'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo $model->payment_mode; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%"><strong><?php echo 'Amount'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo "&pound; ".number_format($model->amount, 2); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
       <?php if($model->payment_mode =='bank'): ?>
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Bank Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php if(count($bankNames)): foreach($bankNames as $bankNames): echo $bankNames->bank_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Account No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php if(count($accountNames)): foreach($accountNames as $accountNames): echo $accountNames->account_no; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Cheque Type'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo $model->cheque_type; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Cheque No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo $model->cheque_no; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr> 
        <?php endif; ?>       
        </table>
       <?php endforeach; endif; ?>

		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
