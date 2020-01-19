    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>

<table id="contents">
	<tbody><tr>
		<td id="commands" colspan="3" style="font-family:Verdana; font-size:11px;">

        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
       <?php 
		 $criteria = new CDbCriteria(); $criteria->order = 'id DESC'; $criteria->limit = 1; $companys = Company::model()->findAll($criteria);	   
	   ?>
        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:10px;">
        <?php if(count($companys)): foreach($companys as $company):?>
        <tr>
         <td width="10%" rowspan="2" valign="top"><img src="<?php echo Yii::app()->request->baseUrl.'/public/photos/company/'.$company->company_logo; ?>" height="70" alt=""  /></td>
         <td width="55%"><h2><?php echo ucwords($company->company_name); ?></h2></td>
         <td width="35%"><h1>INVOICE</h1></td>
        </tr>
        <tr>
         <td width="55%">
         <table>
         <tr>
         <td><p style="margin-right:30px;"><?php echo $company->address."<br/> ".$company->contact_no.". <br/> ".$company->email_address.".<br/> ".$company->website; ?></p></td>        
         </tr>
         </table>         
         </td>
         <td width="35%">
             <table>
             <tr>
             <td><?php if(count($models)): foreach($models as $posValue): ?><p style="margin-right:30px;"><?php echo "Date: ".date('M d, Y', strtotime($posValue->order_date))."<br/>Invoice # ".$posValue->invoice_no; ?></p><?php endforeach; endif; ?></td>        
             </tr>
             </table>          
         </td>
        </tr>
        <?php endforeach; endif; ?>
        <tr><td colspan="3"><hr color="#CCCCCC" size="1" /></td></tr>
        </table>
       
        <?php 
		 $customer_id = $posValue->customer_id;
		 $customer_cond = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 						  				 
		 $CustomerValues = Customer::model()->findAll( $customer_cond );
		?>
        <?php if(count($CustomerValues)): ?>
        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:100px;">
        <?php foreach($CustomerValues as $Customers):?>
        <tr>
         <td width="50%" align="left">
         <table>
         <tr><td><strong>TO</strong></td></tr>
         <tr><td><?php echo $Customers->customer_name; ?></td></tr>
         <tr><td><?php echo $Customers->business_name; ?></td></tr>
         <tr><td><?php echo $Customers->email_address; ?></td></tr>
         <tr><td><?php echo $Customers->contact_no2; ?></td></tr>
         <tr><td><?php echo $Customers->business_street1.', '.$Customers->business_street2.', <br>'.$Customers->business_city.', '.$Customers->business_state.', '.$Customers->business_post_code.', '.$Customers->business_country; ?></td></tr>
         </table>         
         </td>
         <td width="50%" align="left">
             <table>
                 <tr><td><strong>SHIP TO</strong></td></tr>
                 <tr><td><?php echo $Customers->customer_name; ?></td></tr>
                 <tr><td><?php echo $Customers->business_name; ?></td></tr>
                 <tr><td><?php echo $Customers->email_address; ?></td></tr>
                 <tr><td><?php echo $Customers->contact_no1; ?></td></tr>
                 <tr><td><?php echo $Customers->home_street1.', '.$Customers->home_street2.',<br> '.$Customers->home_city.', '.$Customers->home_state.', '.$Customers->home_post_code.', '.$Customers->home_country; ?></td></tr>
             </table>          
         </td>
        </tr>
        <?php endforeach; ?>
        </table>
        <?php endif; ?>
				<table width="90%" cellpadding="2" cellspacing="3" border="1" style="margin-left:5px;" >
                <?php if(count($model_products)): ?>
				<tr>
                    <th width="10%" scope="col">SL No</th>
                    <th width="40%" scope="col">Product Name</th>
                    <th width="10%" scope="col">Qty</th>
                    <th width="20%" scope="col">Unit</th>
                    <th width="20%" scope="col">Total</th>
				</tr>
                <?php   
				       $i = 1;
					   foreach($model_products as $posProductValue):
						  $product_id   = $posProductValue->product_id;
				          $shop_id      = $posProductValue->shop_id;
						  $prod1        = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 
					      $q1 = new CDbCriteria( array( 'condition' => "id = '$shop_id'",) ); 	
						  				 
						  $pValues = Product::model()->findAll( $prod1 );
                          $Shops   = Warehouse::model()->findAll( $q1 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td align="center"><?php echo $i; ?></td>
					<td><?php if(count($pValues)): foreach($pValues as $pValue ): echo ucwords($pValue->product_name); endforeach; endif; ?></td>
                    <td align="center"><?php echo $posProductValue->quantity; ?></td>
                    <td align="center" ><?php echo '&pound; '.number_format($posProductValue->amount, 2); ?></td>
					<td align="right" style="margin-right:5px;"><?php echo '&pound; '.number_format($posProductValue->amount_total, 2); ?>&nbsp;</td>
                </tr>
                <?php $i = $i + 1; endforeach; endif; ?>
				<tr>
					<td colspan="4" align="right">Amount Sub Total &nbsp;&nbsp;</td>
					<td align="right"><?php echo '&pound; '.number_format($posValue->amount_sub_total, 2); ?>&nbsp;</td>
                </tr>
				<tr>
					<td colspan="4" align="right">Vat &nbsp;&nbsp;</td>
					<td align="right"><?php echo '&pound; '.number_format($posValue->vat_total, 2); ?>&nbsp;</td>
                </tr>
				<tr>
					<td colspan="4" align="right">Total &nbsp;&nbsp;</td>
					<td align="right"><?php echo '&pound; '.number_format($posValue->amount_grand_total, 2); ?>&nbsp;</td>
                </tr>
				<tr>
					<td colspan="4" align="right">Paid &nbsp;&nbsp;</td>
					<td align="right"><?php echo '&pound; '.number_format($posValue->paid_amount, 2); ?>&nbsp;</td>
                </tr>
				<tr>
					<td colspan="4" align="right">Total Due &nbsp;&nbsp;</td>
					<td align="right"><?php $due_total = $posValue->amount_grand_total - $posValue->paid_amount;
					                  echo '&pound; '.number_format($due_total, 2); ?>&nbsp;</td>
                </tr>
     		</table> 
        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:10px;">
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
        <td>        
         <?php if($posValue->credit_card_payment > 0 or $posValue->cheque_payment > 0): echo "Payment By # Card"; elseif($posValue->cash_payment == 0 && $posValue->credit_card_payment == 0 && $posValue->cheque_payment == 0): echo "Due Payment"; else: echo "Payment By # Cash"; endif; ?>
        </td>
        <td>        
        <p align="right" style="margin-right:10px;"><?php echo $Customers->customer_name; ?></p>
        <strong><p align="right" style="margin-right:10px;">Signature of Customer</p></strong>
        </td>
        <td align="right"><p align="right" style="margin-right:10px;">
		<?php
		  $user_id = $posValue->user_id;
		  $cond2 = new CDbCriteria( array( 'condition' => "username = '$user_id'",) ); 					 
		  $users = Users::model()->findAll( $cond2 );
		  
		 if(count($users)): foreach($users as $user): $full_name = $user->full_name; $user_sign = $user->user_sign; if(!empty($user_sign)): ?>
        <img src="<?php echo Yii::app()->request->baseUrl.'/public/photos/user/'.$user_sign; ?>" height="40" alt=""  /> <?php else: echo $full_name; endif; endforeach; endif; ?></p>
        <strong><p align="right" style="margin-right:10px;">Signature of User </p></strong>
        </td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        
        </table>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
