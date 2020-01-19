
 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">Accounts Home</td>
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
		<td id="item_table">
			<div id="table_holder">
            
                <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="margin-left:10px; margin-bottom:5px;">
                    <tr>
                     <td colspan="2" align="left">
                     <?php if(count($cashmodels)): foreach($cashmodels as $cashmodel): echo "<h1>Total Cash Balance: "."&pound; ".number_format($cashmodel->amount, 2)." </h1>";  endforeach; endif; ?>
                     </td>
                    </tr>
				</table>
          </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
