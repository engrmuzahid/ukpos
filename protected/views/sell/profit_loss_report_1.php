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
		<td id="title">Profit / Loss Report</td>
        <td></td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell'; ?>" class="none new">Home</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/profit_loss_report'; ?>" class="none new">Profit / Loss Report</a>    
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell/report'; ?>" class="none new">Sell Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/daily_sell_report'; ?>" class="none new">Daily Sell Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_in/min_stockout_report'; ?>" class="none new">Min Stock Out Report</a> 
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell/sell_return'; ?>" class="none new">Sell Return</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/sell_return_report'; ?>" class="none new">Sell Return Report</a>  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td id="item_table">

       <div id="ptable3">
			<div id="table_holder">
                <p style="font-size:18px;">Profit / Loss Report<?php if(!empty($start_date)): echo " - From ".date('M d', strtotime($start_date))." to ".date('M d', strtotime($end_date)); endif; ?>
               <span style="margin-left:250px;"> <input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></span>
                </p>
				<p>&nbsp;</p>
                <!--  start product-table ..................................................................................... -->
			   <table class="tablesorter" id="sortable_table" style="width:100%">
                <?php $con = count($model); if(count($model)): ?>
				<tr>
                    <th width="30%" scope="col">Item Name</th>
                    <th width="10%" scope="col">Qty Sold</th>
                    <th width="20%" scope="col">Purchase Amount(&pound;)</th>
                    <th width="20%" scope="col">Sell Amount(&pound;)</th>
                    <th width="5%" scope="col">Vat(&pound;)</th>
                    <th width="15%" scope="col">Profit(&pound;)</th>
         		</tr>
                <?php 
				 $i=1; $Total_qty = 0; $Total_purchase = 0; $Total_sell = 0; $Total_profit = 0;	$Total_vat = 0;				  			 
				 foreach($model as $posValue):
				 $product_code   = $posValue->product_code;
				 
                                 if($start_date && $end_date)
                                    $cond1        = new CDbCriteria( array( 'condition' => "product_code = '$product_code' && invoice_no IN (select invoice_no from sell_order WHERE order_date >= '$start_date' AND order_date <= '$end_date' AND customer_id=0)",) );
                                 elseif($start_date && !$end_date) 
                                     $cond1        = new CDbCriteria( array( 'condition' => "product_code = '$product_code' && invoice_no IN (select invoice_no from sell_order WHERE order_date = '$start_date' AND customer_id=0)",) );
				 $pValues      = Sell_Product::model()->findAll( $cond1 );
		      
			   // code for average purchase cost calculation
			     $current_date        = date('Y-m-d  H:i:s', time());
				 $purchase_date_range = strftime("%Y-%m-%d", strtotime("$current_date -30 day"));
				
				 $cond2          = new CDbCriteria( array( 'condition' => "product_code = '$product_code' && purchase_date >= '$purchase_date_range' && purchase_date <= '$current_date'",) ); 						  				 
				 $purchaseValues = Purchase_Product::model()->findAll( $cond2 );
                 if(empty($purchaseValues)):				
				 $criteria = new CDbCriteria();
		         $criteria->condition = "product_code = '$product_code'";
				 $criteria->order = 'id DESC';
				 $criteria->limit = 1;
				 $purchaseValues  = Purchase_Product::model()->findAll($criteria);				 
				 endif;
				 
				  $TPqty = 0; $TPamount = 0;
				  if(count($purchaseValues)): foreach($purchaseValues as $purValue):
				     $TPqty          = $TPqty + $purValue->quantity;
				     $TPamount_total = $purValue->product_price * $purValue->quantity;
				     $TPamount       = $TPamount + $TPamount_total;
				   endforeach;
				   else:
						 $criteria2 = new CDbCriteria();
						 $criteria2->condition = "product_code = '$product_code'";
						 $criteria2->order = 'id DESC';
						 $criteria2->limit = 1;
						 $purchaseValues  = Product::model()->findAll($criteria2);	
						  
						  if(count($purchaseValues)): foreach($purchaseValues as $purValue):
							 $TPqty          = 1;
							 $TPamount       = $purValue->purchase_cost;
						   endforeach;endif;
				    endif;	 
				 
				 @$unitPCost = $TPamount / $TPqty;
				 
				 if(count($pValues)):
				  // code for sal total
				  $Tqty = 0; $Tsamount = 0; $Vamount = 0;
				  foreach($pValues as $pValue):
				     $Tqty     = $Tqty + $pValue->quantity;
				     $Tsamount = $Tsamount + $pValue->amount_total;
					  $vat_pp  = $pValue->vat;
					  
					  $vat = ($pValue->amount_total * $vat_pp) / 100;
                      $Vamount = $Vamount + $vat;
					  
					 $product_code = $pValue->product_code;
					  $q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 
                      $Products   = Product::model()->findAll( $q1 );
					  $product_name = "";					  
					   if(count($Products)): foreach($Products as $Products): $product_name = $Products->product_name; endforeach; endif;
				   endforeach;	
				   // total purchase price and profit
				   $Tpurchase_amount =  $unitPCost * $Tqty;
				   $prof_amount = $Tsamount - $Tpurchase_amount;
				   if($prof_amount < 0): $style = "style='color:#FF0000'"; else: $style = "style='color:#12B203'"; endif;

				 ?>
				<tr style="font-family:Verdana; font-size:11px;">
                    <td width="30%" scope="col"><?php echo ucwords($product_name); ?></td>
                    <td width="10%" scope="col"><?php echo $Tqty; ?></td>
                    <td width="20%" scope="col"><?php echo $Tpurchase_amount; ?></td>
				    <td width="20%" scope="col"><?php echo $Tsamount; ?></td>
                    <td width="5%" scope="col"><?php echo $Vamount; ?></td>
                    <td <?php echo $style; ?> width="15%" scope="col"><?php echo $prof_amount; ?></td>
         		</tr>
                <?php endif; ?>
                
               <?php $i = $i + 1; 
			     $Total_qty = $Total_qty + $Tqty;
				 $Total_vat = $Total_vat + $Vamount;
				 $Total_purchase = $Total_purchase + $Tpurchase_amount;
				 $Total_sell = $Total_sell + $Tsamount;
				 $Total_profit = $Total_profit + $prof_amount;
				 if($Total_profit < 1): $style2 = "style='color:#FF0000'"; else: $style2 = "style='color:#12B203'"; endif;
				 endforeach;
				 ?>
				<tr style="font-family:Verdana; font-size:11px;">
                    <td align="right"><strong>&nbsp;</strong></td>
                    <td align="left"><strong><?php echo $Total_qty; ?></strong></td>
                    <td align="left"><strong><?php echo number_format($Total_purchase, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($Total_sell, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($Total_vat, 2); ?></strong></td>
                    <td <?php echo $style; ?> align="left"><strong><?php echo number_format($Total_profit, 2); ?></strong></td>
        		</tr>
				<?php
				 else: ?>
				<tr><div id="message-red"><td colspan="6" class="red-left">No Record Available Yet .. </td></div></tr>
                <?php endif; ?>
				</table> 
                </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
