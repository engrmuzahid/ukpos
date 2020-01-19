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
		<td id="title">Sell Return Report</td>
        <td></td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<?php $this->renderPartial('_menu') ?>
		</td>
		<td style="width: 10px;"></td>        
		<td id="item_table">

        <!--<p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php // echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>-->
       <div id="ptable3">
			<div id="table_holder">
				<!--  start product-table ..................................................................................... -->
			   <table class="tablesorter" id="sortable_table" style="width:100%">
                <?php if(count($model)): ?>
				<tr>
                    <th>Invoice No</th>
                    <th>Date</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
					<th>Return Mode</th>
					<th>Reason</th>
					<th>Return By</th>
         		</tr>
				<tr>
                <?php $i=1; $grand_total = 0;
				
				      foreach($model as $posValue):
					  $product_code = $posValue->product_code;
					  $user_id = $posValue->user_id;
					  $payment_return = $posValue->payment_return;
					  $cond1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 	
					  $cond2 = new CDbCriteria( array( 'condition' => "username = '$user_id'",) ); 					 
                      $pros = Product::model()->findAll( $cond1 );
					  
                      $users = Users::model()->findAll( $cond2 );
					  if($payment_return == 1): $p_return = "Cash"; elseif($payment_return == 2):  $p_return = "Card"; else: $p_return = "Payable Deduction"; endif;
				 ?>
                <tr style="font-family:Verdana; font-size:11px;">
					<td width="10%"><a href="<?php echo Yii::app()->request->baseUrl.'/sell/view/'.preg_replace("/[^0-9]/", '', $posValue->invoice_no); ?>" target="_blank"><?php echo $posValue->invoice_no; ?></a></td>
                    <td width="14%"><?php echo date('M d, Y', strtotime($posValue->return_date)); ?></td>
					<td width="20%"><?php if(count($pros)): foreach($pros as $pro): echo ucwords($pro->product_name); endforeach; endif; ?></td>
                    <td width="12%"><?php  echo '&pound; '.number_format($posValue->amount, 2); ?></td>
                    <td  width="5%"><?php  echo $posValue->quantity; ?></td>
                    <td width="15%"><?php  echo '&pound; '.number_format($posValue->amount * $posValue->quantity, 2); ?></td>
                    <td width="6%"><?php echo $p_return; ?></td>
					<td  width="10%"><?php echo $posValue->reason; ?></td>
					<td  width="15%"><?php if(count($users)): foreach($users as $user): echo ucwords($user->full_name); endforeach; endif; ?></td>
               </tr>
                <?php $i = $i + 1;
				   $as = $posValue->amount * $posValue->quantity;
				  $grand_total = $grand_total + $as;
				 endforeach; ?>
                    <tr>
                    <td colspan="2">&nbsp;</td>
                    <td><strong><?php echo "Total"; ?></strong></td>
                    <td colspan="2"><strong><?php echo "&pound;. ".number_format($grand_total, 2); ?></strong></td>
		  <td colspan="4">&nbsp;</td>
                    </tr>
					
                <?php  else: ?>
				<tr><div id="message-red"><td colspan="9" class="red-left">No Sell Return Available  .. <a href="<?php echo Yii::app()->request->baseUrl.'/sell/sell_return_report/'; ?>">Search Again..</a></td></div></tr>
                <?php endif; ?>
				</table>
                </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>