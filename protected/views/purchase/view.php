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
         <td width="35%"><h1>PURCHASE INVOICE</h1></td>
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
             <td><?php if(count($models)): foreach($models as $posValue): ?><p style="margin-right:30px;"><?php echo "Date: ".date('M d, Y', strtotime($posValue->purchase_date))."<br/>Shipment No # ".$posValue->chalan_id; ?></p><?php endforeach; endif; ?></td>        
             </tr>
             </table>          
         </td>
        </tr>
        <?php endforeach; endif; ?>
        <tr><td colspan="3"><hr color="#CCCCCC" size="1" /></td></tr>
        </table>
       
        <?php 
		 $supplier_id = $posValue->supplier_id;
		 $supplier_cond = new CDbCriteria( array( 'condition' => "id = '$supplier_id'",) ); 						  				 
		 $supplierValues = Supplier::model()->findAll( $supplier_cond );
		  $q2 = new CDbCriteria( array( 'condition' => "purchase_id = '$posValue->id'",) );
		  $Pproducts = Purchase_Product::model()->findAll( $q2 );
		?>
        <?php if(count($supplierValues)): ?>
        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:100px;">
        <?php foreach($supplierValues as $suppliers):?>
        <tr>
         <td width="50%" align="left">
         <table>
         <tr><td><strong>Supplier Info</strong></td></tr>
         <tr><td><?php echo $suppliers->name; ?></td></tr>
        <?php if(!empty($suppliers->phone)):?> <tr><td><?php echo $suppliers->phone; ?></td></tr><?php endif; ?>
        <?php if(!empty($suppliers->fax)):?> <tr><td><?php echo $suppliers->fax; ?></td></tr><?php endif; ?>
        <?php if(!empty($suppliers->mobile)):?> <tr><td><?php echo $suppliers->mobile; ?></td></tr><?php endif; ?>
        <?php if(!empty($suppliers->email)):?> <tr><td><?php echo $suppliers->email; ?></td></tr><?php endif; ?>
        <?php if(!empty($suppliers->address)):?> <tr><td><?php echo $suppliers->address; ?></td></tr><?php endif; ?>
         </table>         
         </td>
         <td width="50%" align="left">&nbsp;</td>
        </tr>
        <?php endforeach; ?>
        </table>
        <?php endif; ?>
				<table width="90%" cellpadding="2" cellspacing="3" border="1" style="margin-left:5px; border-collapse:collapse;font-family:Verdana; font-size:11px;" >
                <?php if(count($Pproducts)): ?>
				<tr>
                    <th width="5%" scope="col">SL</th>
                    <th width="25%" scope="col">Product Name</th>
                    <th width="10%" scope="col">Qty</th>
                    <th width="10%" scope="col">Buy Price</th>
                    <th width="10%" scope="col">Vat</th>
                    <th width="10%" scope="col">Sell Price</th>                    
                    <th width="15%" scope="col">Total Buy</th>
                    <th width="15%" scope="col">Total Sell</th>
				</tr>
                <?php   
				       $i = 1; $pp_total = 0; $sp_total = 0; $vat_total = 0;
					   foreach($Pproducts as $posProductValue):
						  $product_code   = $posProductValue->product_code;
						  $prod1        = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 
 						  				 
						  $pValues = Product::model()->findAll( $prod1 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td align="center"><?php echo $i; ?></td>
					<td><?php if(count($pValues)): foreach($pValues as $pValue ): echo ucwords($pValue->product_name); endforeach; endif; ?></td>
                    <td align="center"><?php echo $posProductValue->quantity; ?></td>
                    <td align="center"><?php echo number_format($posProductValue->product_price, 2); ?></td>
                    <td align="center"><?php echo number_format($posProductValue->product_vat, 2); ?>%</td>
                    <td align="center"><?php echo number_format($posProductValue->sell_price, 2); ?></td>                    
                    <td align="center" ><?php $pt = $posProductValue->product_price * $posProductValue->quantity; echo '&pound; '.number_format($pt, 2); ?></td>
                    <td align="center" ><?php $st = $posProductValue->sell_price  * $posProductValue->quantity; echo '&pound; '.number_format($st, 2); ?></td>
                </tr>
                <?php 
					$pp_total = $pp_total + $pt;
					$sp_total = $sp_total + $st;
                                        $vat_total += $pt*($posProductValue->product_vat/100);
                                        
                                        
				$i = $i + 1; endforeach; endif; ?>
				<tr>
					<td colspan="6" align="right">Sub Total &nbsp;&nbsp;</td>
					<td align="center"><?php echo '&pound; '.number_format($pp_total, 2); ?>&nbsp;</td>					
                                        <td>&nbsp;</td>
                </tr>
                <tr>
					<td colspan="6" align="right">Vat Total &nbsp;&nbsp;</td>
					<td align="center"><?php echo '&pound; '.number_format($vat_total, 2); ?>&nbsp;</td>					
                                        <td>&nbsp;</td>
                </tr>
                <tr>
					<td colspan="6" align="right">Amount Total &nbsp;&nbsp;</td>
					<td align="center"><?php echo '&pound; '.number_format($posValue->price_grand_total, 2); ?>&nbsp;</td>
					<td align="center"><?php echo '&pound; '.number_format($sp_total, 2); ?>&nbsp;</td>
                </tr>
				<tr>
					<td colspan="7" align="right">Paid Total &nbsp;&nbsp;</td>
					<td align="center"><?php echo '&pound; '.number_format($posValue->paid_amount, 2); ?>&nbsp;</td>
                </tr>
				<tr>
					<td colspan="7" align="right">Total Due &nbsp;&nbsp;</td>
					<td align="center"><?php $due_total = $posValue->price_grand_total - $posValue->paid_amount;
					                  echo '&pound; '.number_format($due_total, 2); ?>&nbsp;</td>
                </tr>
     		</table> 
         <?php if(!empty($posValue->note)):?>
         <table style="margin-left:5px;">
         <tr><td><?php echo "Note: ".$posValue->note; ?></td></tr>
         </table>
         <?php endif; ?>
			</div></td></tr></tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
