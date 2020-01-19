
<table>
    <tbody>
        <tr>

            <td style="width: 10px;"></td>        
            <td id="item_table">

                               
        <p align="right" style="margin-right:45px;">    
            <span id="msg_delete" style="float: left;color: green">
                        
                    </span> 
            <input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  />
            <input type="image" id="delete_all_invoice" width="24px" src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="delete selected report" title="Delete Selected Report"  />
        </p>
       <div id="ptable3">
           <form id="frmReport">
			<div id="table_holder">
				<!--  start product-table ..................................................................................... -->
			   <table class="tablesorter" id="sortable_table" style="width:100%">
                <?php if(count($model)): ?>
				<tr>
                                    <th><input type="checkbox" id="select_all" /></th>
                    <th>Invoice No</th>
                    <th>Payment Mode</th>
                    <th>Amount Total(&pound;)</th>
                    <th>Paid Total(&pound;)</th>
					<th>Due Total(&pound;)</th>
                    <th>&nbsp;</th>
         		</tr>
                <?php 
				 $i=1; $grand_total = 0; $paid_sub = 0; $due_sub = 0;				  			 
				 foreach($model as $posValue):
				     $payment_mode = "";
					 if(!empty($payment_mode) && ($posValue->cash_payment >= 1)): $payment_mode .= ", Cash "; elseif(empty($payment_mode) && ($posValue->cash_payment >= 1)): $payment_mode .= "Cash "; endif;
					 if(!empty($payment_mode) && ($posValue->cheque_payment >= 1)): $payment_mode .= ", Cheque "; elseif(empty($payment_mode) && ($posValue->cheque_payment >= 1)): $payment_mode .= "Cheque "; endif;
					 if(!empty($payment_mode) && ($posValue->credit_card_payment >= 1)): $payment_mode .= ", Card "; elseif(empty($payment_mode) && ($posValue->credit_card_payment >= 1)): $payment_mode .= "Card "; endif;
				    $due_amount = $posValue->amount_grand_total - $posValue->paid_amount;
				 ?>
				<tr style="font-family:Verdana; font-size:11px;" id="row_<?php echo $posValue->invoice_no ?>">
                                    <td><input class="invoice_ids" type="checkbox" name="invoice_ids[]" data-amount="<?php echo number_format($posValue->amount_grand_total, 2, '.', ''); ?>" value="<?php echo $posValue->invoice_no; ?>" /></td>
					<td><?php echo $posValue->invoice_no; ?></td>
                    <td><strong><?php echo $payment_mode; ?></strong></td>
					<td><strong><?php echo number_format($posValue->amount_grand_total, 2); ?></strong></td>
					<td><strong><?php echo number_format($posValue->paid_amount, 2); ?></strong></td>
					<td><strong><?php echo number_format($due_amount, 2); ?></strong></td>
                    <td width="10%" style="margin-left:10px;">
					 <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/sell/delete/'.$posValue->invoice_no; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> | 
					 <a target="_blank" href="<?php echo Yii::app()->request->baseUrl.'/index.php/sell/view/'.$posValue->invoice_no; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a>
                    </td>
        		</tr>
                
               <?php $i = $i + 1;
					$grand_total  = $grand_total + $posValue->amount_grand_total;
					$paid_sub     = $paid_sub + $posValue->paid_amount;
					$due_sub      = $due_sub + $due_amount;
				 endforeach;
				 ?>
				<tr>
                                    <td>
                                            <input type="hidden" id="total_amount" value="<?php echo number_format($sell_info->total_amount, 2, '.', '') ?>" />
                                            <input type="hidden" id="paid_amount" value="<?php echo number_format($sell_info->total_paid_amount, 2, '.', ''); ?>" />
                                            <input type="hidden" id="due_amount" value="<?php echo number_format($sell_info->total_amount-$sell_info->total_paid_amount, 2, '.', ''); ?>" />
                                        </td>
<!--					<td align="right" colspan="2"><strong>Total (&pound;) :&nbsp;&nbsp;<strong></td>
                    <td align="left"><strong><?php echo number_format($grand_total, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($paid_sub, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($due_sub, 2); ?></strong></td>
					<td>&nbsp;</td>-->
        		</tr>
                
				<?php
				 else: ?>
				<tr><div id="message-red"><td colspan="8" class="red-left">No Sell Available Yet .. </td></div></tr>
                <?php endif; ?>
				</table> 
                        
                                
                </div>
               </form>
           
           <div id="pagination"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></div>
       </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
  
