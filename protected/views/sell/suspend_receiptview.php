    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>

<table id="contents">
	<tbody><tr>
		<td id="commands" colspan="3">

        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
       <?php 
		 $criteria = new CDbCriteria(); $criteria->order = 'id DESC'; $criteria->limit = 1; $companys = Company::model()->findAll($criteria);	
		 if(count($models)): foreach($models as $posValue):  endforeach; endif;    
	   ?>
        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:11px;margin-bottom:10px; margin-left:10px;">
        <?php if(count($companys)): foreach($companys as $company):?>
        <tr>
         <td width="10%" rowspan="2" valign="top"><img src="<?php echo Yii::app()->request->baseUrl.'/public/photos/company/'.$company->company_logo; ?>" height="70" alt=""  /></td>
         <td width="55%"><h2><?php echo ucwords($company->company_name); ?></h2></td>
         <td width="35%">&nbsp;</td>
        </tr>
        <tr>
         <td width="55%">
         <table style="font-family:Verdana; font-size:11px;">
         <tr>
         <td><p style="margin-right:30px;"><?php echo $company->address."<br/> ".$company->contact_no.". <br/> ".$company->email_address.".<br/> ".$company->website; ?></p></td>        
         </tr>
         </table>         
         </td>
         <td width="35%">&nbsp;</td>
        </tr>
        <?php endforeach; endif; ?>
        </table>
       
        <?php 
		 $customer_id = $posValue->customer_id;
		 
		 $customer_cond = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 						  				 
		 $CustomerValues = Customer::model()->findAll( $customer_cond );
		?>
        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:11px;margin-bottom:10px; margin-left:10px;">
       
        <tr>
         <td width="50%" align="left">
          <?php if(count($CustomerValues)): ?>
         <table style="font-family:Verdana; font-size:11px;">
          <?php foreach($CustomerValues as $Customers):?>
         <tr><td><strong>TO</strong></td></tr>
         <tr><td><?php echo $Customers->customer_name; ?></td></tr>
         <tr><td><?php echo $Customers->business_name; ?></td></tr>
         <tr><td><?php echo $Customers->business_street1.' '.$Customers->business_street2.' <br>'.$Customers->business_city.'<br>'.$Customers->business_post_code; ?></td></tr>
         <tr><td><?php echo "Phone: ".$Customers->contact_no2; ?></td></tr>
          <?php endforeach; ?>      
         </table>   
         <?php endif; ?>
         </td>
         <td width="50%" align="right" style=" margin-right:10px;">
             <table style="font-family:Verdana; font-size:11px;">
             <tr><td><h3>SALES INVOICE</h3></td></tr>
             <tr>
             <td><p style="margin-right:30px;"><?php echo "Date: ".date('M d, Y', strtotime($posValue->order_date)); ?></p></td>        
             </tr>
             </table>          
         </td>
        </tr>
       
        </table>

				<table width="90%" cellpadding="2" cellspacing="3" border="1" style="margin-left:5px; border-collapse:collapse;font-family:Verdana; font-size:11px;" >
                <?php if(count($model_products)): ?>
				<tr>
                    <td width="5%"  align="left">&nbsp;<strong>QTY</strong></td>
                    <td width="55%" align="left">&nbsp;<strong>DESCRIPTION</strong></td>
                    <td width="20%" align="right"><strong>UNIT PRICE</strong>&nbsp;</td>
                    <td width="20%" align="right"><strong>TOTAL</strong>&nbsp;</td>
				</tr>
                <?php   
				       $i = 1;
					   foreach($model_products as $posProductValue):
						  $product_code   = $posProductValue->product_code;
						  $prod1        = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 
						  				 
						  $pValues = Product::model()->findAll( $prod1 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
                    <td align="left" style="margin-left:2px;">&nbsp;<?php echo $posProductValue->quantity; ?></td>
					<td style="margin-left:2px;">&nbsp;<?php if(count($pValues)): foreach($pValues as $pValue ): echo ucwords($pValue->product_name); endforeach; endif; ?></td>
                    <td align="right" style="margin-right:5px;" ><?php echo '&pound; '.number_format($posProductValue->amount, 2); ?>&nbsp;</td>
					<td align="right" style="margin-right:5px;"><?php echo '&pound; '.number_format($posProductValue->amount_total, 2); ?>&nbsp;</td>
                </tr>
                <?php $i = $i + 1; endforeach; endif; ?>
				<tr>
                   <td rowspan="5" valign="middle" colspan="2" align="left"><br>Thank you for your business!</td>
					<td align="right" style="margin-right:5px;">Sub Total&nbsp;</td>
					<td align="right" style="margin-right:5px;"><?php echo '&pound; '.number_format($posValue->amount_sub_total, 2); ?>&nbsp;</td>
                </tr>
				<tr>
					<td align="right" style="margin-right:5px;">Vat&nbsp;</td>
					<td align="right"><?php echo '&pound; '.number_format($posValue->vat_total, 2); ?>&nbsp;</td>
                </tr>
				<tr>
					<td align="right" style="margin-right:5px;">Total&nbsp;</td>
					<td align="right"><?php echo '&pound; '.number_format($posValue->amount_grand_total, 2); ?>&nbsp;</td>
                </tr>
     		</table> 
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
