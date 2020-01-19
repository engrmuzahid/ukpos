<?php if (count($model)): ?>
    <table border="0" width="90%"  cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-left:5px;"> 
        <tr><td colspan="8">&nbsp;</td></tr>
        <?php
        foreach ($model as $model):
            $delivery_id = $model->id;
            $customer_name = "";

            if (!empty($model->customer_id)):
                $customer_id = $model->customer_id;
                $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                $Customers = Customer::model()->findAll($q1);
                if (count($Customers)): foreach ($Customers as $Customers): $customer_name = $Customers->customer_name;
                    endforeach;
                endif;
            endif;
            ?>
            <tr>
                <td width="20%">&nbsp;<strong><?php echo 'Invoice No'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%" align="left"><?php echo $model->invoice_no; ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
                <td width="20%"><strong><?php echo 'Sale Date'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%" align="left"><?php echo date('M d, Y', strtotime($model->order_date)); ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
            </tr>        
            <tr><td colspan="8">&nbsp;</td></tr>
            <tr>
                <td width="20%" align="left" valign="top">&nbsp;<strong><?php echo 'Customer Name'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%"><?php echo $customer_name; ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
                <td width="20%"><strong><?php echo 'Sub Total'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%" colspan="6" align="left"><?php echo "&pound; " . $model->amount_sub_total; ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
            </tr>        
            <tr><td colspan="8">&nbsp;</td></tr>
            <tr>
                <td width="20%" align="left" valign="top">&nbsp;<strong><?php echo 'Discount(%)'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%"><?php echo $model->discount_ratio; ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
                <td width="20%"><strong><?php echo 'Grand Total'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%" colspan="6" align="left"><?php echo "&pound; " . $model->amount_grand_total; ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
            </tr>        
            <tr><td colspan="8">&nbsp;</td></tr>
        <?php endforeach; ?>
    </table>
    <table border="1" width="90%"  cellpadding="0" cellspacing="0" style="font:Verdana; font-size:11px;border-collapse:collapse;margin-bottom:10px; margin-left:5px;">  
        <tr><td colspan="5">&nbsp;</td></tr>
    <?php if (count($model2)): ?>
            <tr>
                <th width="15%" scope="col">Product Code</th>
                <th width="25%" scope="col">Product Name</th>
                <th width="10%" scope="col">Quantity</th>
                <th width="15%" scope="col">Unit</th>
                <th width="20%" scope="col">Total</th>
            </tr>
            <tr><td colspan="5"></td></tr>
            <?php
            $i = 1;
            $amount_sub_total = 0;
            foreach ($model2 as $data):
                $product_code = $data->product_code;

                $q3 = new CDbCriteria(array('condition' => "product_code = '$product_code'",));
                $product_names = Product::model()->findAll($q3);
                $product_name = "";
                if (count($product_names)):
                    foreach ($product_names as $product_nam): 
                        $product_name = $product_nam->product_name;
                    endforeach;
                endif;
                ?>
                <tr>
                    <td align="center"><?php echo $product_code; ?></td>
                    <td align="center"><?php echo $data->product_name != "" ? $data->product_name: $product_name; ?></td>
                    <td align="center"><?php echo $data->quantity; ?></td>
                    <td align="center"><?php echo "&pound; " . number_format($data->amount, 2); ?></td>
                    <td align="center"><?php echo "&pound; " . number_format($data->amount * $data->quantity, 2); ?></td>
                </tr>
            <?php $i = $i + 1;
        endforeach;
    endif; ?>
        <tr><td colspan="5"></td></tr>
        <tr>
            <td align="center">&nbsp;</td>
            <td align="center"><strong>Paid Amount: </strong></td><td align="center" ><?php echo "&pound; " . number_format($model->paid_amount, 2); ?></td>
            <td align="center"><strong>Due Amount: </strong></td><td align="center" ><?php $due_total = $model->amount_grand_total - $model->paid_amount;
    echo "&pound; " . number_format($due_total, 2); ?></td>
        </tr>
        <tr><td colspan="5">&nbsp;</td></tr>
    </table>
    <?php echo CHtml::beginForm(Yii::app()->request->baseUrl.'/customer/receive_add', 'post', array('id' => 'frm_soft', 'name' => 'frm_soft', 'enctype' => 'multipart/form-data')); ?>
    <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
    <?php
    $cheque_type_list = array('cash' => 'Cash', 'account pay' => 'Account Pay',);
    $common_list = array('' => '',);
    ?>
        <tr>
            <td valign="top"><strong><?php echo CHtml::label('Receive Date', 'receive_date') ?>&nbsp;&nbsp;</strong></td>
            <td><?php echo CHtml::textField('receive_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
            <td width="10%">
                <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date');  ?></div>
            </td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <td valign="top"><strong><?php echo CHtml::label('Amount', 'amount') ?>&nbsp;&nbsp;</strong></td>
            <td>
                    <?php echo CHtml::textField('amount', $due_total, array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?>
                <input type="hidden" id="original_amount" value="<?php echo $due_total?>" />
            </td>
            <td>
                <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date');  ?></div>
            </td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <td valign="top"><strong><?php echo CHtml::label('Discount', 'discount') ?>&nbsp;&nbsp;</strong></td>
            <td><?php echo CHtml::textField('discount', '0.00', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
            
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <td valign="top"><strong><?php echo CHtml::label('Payment Mode', 'receive_mode') ?>&nbsp;&nbsp;</strong></td>
            <td valign="top">
                    <?php echo CHtml::radioButton('receive_mode', '', array('value' => 0, 'class' => "receive_mode")) . " Cash"; ?>
                    <?php echo CHtml::radioButton('receive_mode', '', array('value' => 1, 'class' => "receive_mode")) . " Cheque"; ?>
                    <?php echo CHtml::radioButton('receive_mode', '', array('value' => 2, 'class' => "receive_mode")) . " Card"; ?>
                    <?php echo CHtml::radioButton('receive_mode', '', array('value' => 3, 'class' => "receive_mode")) . " Bank Transfar"; ?>
                <div id="cash_total"></div>
                <div id="check_payment_date" style="margin-top: 10px;display: none;">
                    <input type="text" name="confirm_date" id="confirm_date"  placeholder="Banking Date"  style="width:160px;"/>
                    <br/>
                </div>
                                    <br/><textarea name="notes"  placeholder="Please write comments..." rows="5" style="width:310px;padding: 5px;font-family: tahoma;"></textarea>

            </td>
            <td>
    <?php //echo CHtml::error($model,'stock_in_date');  ?>
            </td>
        </tr>
    </table>

    <table style="margin-left:20px;"> 
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="hidden"  name="customer_id"  id="customer_id" value="<?php echo $model->customer_id; ?>" />
                <input type="hidden"  name="invoice_no" id="invoice_no" value="<?php echo $model->invoice_no; ?>" />
                <input type="hidden"  name="amount_grand_total" id="amount_grand_total" value="<?php echo $model->amount_grand_total; ?>" />
                <input type="hidden"  name="paid_amount" id="paid_amount" value="<?php echo $model->paid_amount; ?>" />
                <input type="hidden"  name="cash_sell" id="cash_sell" value="<?php echo $model->cash_sell; ?>" />
    <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue', 'onclick'=>'return checkAmount()')); ?>
    <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen')); ?>
            </td>
            <td></td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
    </table>
    <?php echo CHtml::endForm() ?>    
<?php endif; ?>
