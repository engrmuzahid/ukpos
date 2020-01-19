<table>
    <tbody>
        <tr>
            <td style="width: 10px;"></td>        
            <td id="item_table">
                <div style="width: 100%;float: left">
                    <div style="width: 60%;float: left;padding-top: 10px;" id="errorDiv"></div>
                    <div style="width: 40%;float: right;text-align: right;">
                                 <?php if ($customer_id > 0): ?>
        
                        <input type="image" style="height: 32px;" id="send_email_btn" src="<?php echo Yii::app()->request->baseUrl . '/public/images/email.png'; ?>" alt="Email" title="Email"  />
                        <input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print report" title="Print Report" />
                        <?php if ($is_online == "7"): ?>
                            <input type="image" id="delete_all_invoice"  style="height: 32px;" src="<?php echo Yii::app()->request->baseUrl . '/public/images/delete.png'; ?>" alt="delete selected report" title="Delete Selected Report"  />
                        <?php endif; ?>             
         <?php endif; ?>
                    </div>
                </div>
                <div style="clear: both"></div>

                <div id="ptable3">
                    <form id="frmReport">
                        <div id="table_holder">
                            <!--  start product-table ..................................................................................... -->
                            <table class="tablesorter" id="sortable_table" style="width:100%">
                                <?php if (count($model)): ?>
                                    <tr>
                                        <th><input type="checkbox" id="select_all" /></th>
                                        <th>Invoice No</th>
                                        <th>Customer Name</th>
                                        <th>Method</th>
                                        <th>Amount Total(&pound;)</th>
                                        <th>Paid Total(&pound;)</th>
                                        <th>Due Total(&pound;)</th>
                                        <th style="width:85px">&nbsp;</th>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    $grand_total = 0;
                                    $paid_sub = 0;
                                    $due_sub = 0;
                                    foreach ($model as $posValue):

                                        $payment_mode = "";
                                        if (!empty($payment_mode) && ($posValue->cash_sell >= 1)):
                                            $payment_mode .= ", Cash ";
                                        elseif (empty($payment_mode) && ($posValue->cash_sell >= 1)):
                                            $payment_mode .= "Cash ";
                                        endif;

                                        $payment_method = "";
                                        if (!empty($payment_method) && ($posValue->cash_payment >= 1)): $payment_method .= ", Cash ";
                                        elseif (empty($payment_method) && ($posValue->cash_payment >= 1)): $payment_method .= "Cash ";
                                        endif;
                                        if (!empty($payment_method) && ($posValue->cheque_payment >= 1)): $payment_method .= ", Cheque ";
                                        elseif (empty($payment_method) && ($posValue->cheque_payment >= 1)): $payment_method .= "Cheque ";
                                        endif;
                                        if (!empty($payment_method) && ($posValue->credit_card_payment >= 1)): $payment_method .= ", Card ";
                                        elseif (empty($payment_method) && ($posValue->credit_card_payment >= 1)): $payment_method .= "Card ";
                                        endif;



                                        $customer_id = $posValue->customer_id;
                                        $customer_name = "";
                                        if (!empty($customer_id)):
                                            $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                                            $customers = Customer::model()->findAll($q1);
                                            if (count($customers)): foreach ($customers as $customer): $customer_name = $customer->customer_name;
                                                endforeach;
                                            endif;
                                        endif;
                                        $due_amount = $posValue->amount_grand_total - $posValue->paid_amount;
                                        ?>
                                        <tr style="font-family:Verdana; font-size:11px;" id="row_<?php echo $posValue->invoice_no ?>">
                                            <td>
                                                <input type="hidden" name="customer_ids[]" value="<?php echo $customer_id ?>" />
                                                <input class="invoice_ids" type="checkbox" name="invoice_ids[]" data-amount="<?php echo number_format($posValue->amount_grand_total, 2, '.', ''); ?>" value="<?php echo $posValue->invoice_no; ?>"  customer_data="<?php echo $customer_id; ?>" />
                                            </td>
                                            <td><?php echo $posValue->invoice_no; ?></td>
                                            <td><?php echo $customer_name; ?></td>
                                            <td><strong><?php echo $payment_method; ?></strong></td>
                                            <td><strong><?php echo number_format($posValue->amount_grand_total, 2); ?></strong></td>
                                            <td><strong><?php echo number_format($posValue->paid_amount, 2); ?></strong></td>
                                            <td><strong><?php echo number_format($due_amount, 2); ?></strong></td>
                                            <td style="margin-left:10px;">
                                                <?php if ($is_online == "7"): ?>
                                                    <a class="delete" data-id="<?php echo $posValue->invoice_no ?>" href="<?php echo Yii::app()->request->baseUrl . '/index.php/b2b_sell/deleteAll?invoice_no=' . $posValue->invoice_no; ?>" title="Delete"><img style="height: 16px;" src="<?php echo Yii::app()->request->baseUrl . '/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> | 
                                                <?php endif; ?>
                                                <a target="_blank" href="<?php echo Yii::app()->request->baseUrl . '/index.php/b2b_sell/view/' . $posValue->invoice_no; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a> | 
                                                <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/b2b_sell/reorder/' . $posValue->invoice_no; ?>" title="Show"><img width="16" src="<?php echo Yii::app()->request->baseUrl . '/public/images/reorder.jpg'; ?>" alt="Show" title="Show" border="0" /></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i = $i + 1;
                                        $grand_total = $grand_total + $posValue->amount_grand_total;
                                        $paid_sub = $paid_sub + $posValue->paid_amount;
                                        $due_sub = $due_sub + $due_amount;
                                    endforeach;
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" id="total_amount" value="<?php echo number_format($sell_info->total_amount, 2, '.', '') ?>" />
                                            <input type="hidden" id="paid_amount" value="<?php echo number_format($sell_info->total_paid_amount, 2, '.', ''); ?>" />
                                            <input type="hidden" id="due_amount" value="<?php echo number_format($sell_info->total_amount - $sell_info->total_paid_amount, 2, '.', ''); ?>" />
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr><div id="message-red"><td colspan="9" class="red-left">No Sell Available Yet .. </td></div></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </form>
                </div>
                <div id="pagination"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></div>

                <br/>

            </td>
        </tr>
    </tbody>
</table>



<div id="print_table_holder" style="display: none">


                        </div>

