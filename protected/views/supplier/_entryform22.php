         
<?php if (count($model)): ?>
    <table border="0" width="90%"  cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-left:5px;"> 
        <tr><td colspan="8">&nbsp;</td></tr>
        <?php
        foreach ($model as $model):
            $supplier_id = $model->supplier_id;
            $delivery_id = $model->id;
            $q1 = new CDbCriteria(array('condition' => "id = '$supplier_id'",));
            $q2 = new CDbCriteria(array('condition' => "delivery_id = '$delivery_id'",));
            $Suppliers = Supplier::model()->findAll($q1);
            ?>
            <tr>
                <td width="20%">&nbsp;<strong><?php echo 'Supplier Invoice'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%" align="left"><?php echo $model->chalan_id; ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
                <td width="20%"><strong><?php echo 'Purchase Date'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%" align="left"><?php echo date('M d, Y', strtotime($model->purchase_date)); ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
            </tr>        
            <tr><td colspan="8">&nbsp;</td></tr>
            <tr>
                <td width="20%" align="left" valign="top">&nbsp;<strong><?php echo 'Supplier Name'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%"><?php if (count($Suppliers)): foreach ($Suppliers as $Suppliers): echo $Suppliers->name;
                endforeach;
            endif; ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
                <td width="20%"><strong><?php echo 'Note'; ?></strong><span class="markcolor"></span></td>
                <td width="5%" align="center" valign="top">:</td>
                <td width="20%" colspan="6" align="left"><?php echo $model->note; ?></td>
                <td width="5%" align="center" valign="top">&nbsp;</td>
            </tr>        
            <tr><td colspan="8">&nbsp;</td></tr>
    <?php endforeach; ?>
    </table>
    <table border="1" width="90%"  cellpadding="0" cellspacing="0" style="border-collapse:collapse;font:Verdana; font-size:11px;border-collapse:collapse;margin-bottom:10px; margin-left:5px;">  
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
        if (count($model2)): foreach ($model2 as $data):
                $product_code = $data->product_code;

                $q3 = new CDbCriteria(array('condition' => "product_code = '$product_code'",));
                $product_names = Product::model()->findAll($q3);
                $product_name = "";
                if (count($product_names)): foreach ($product_names as $product_names): $product_name = $product_names->product_name;
                    endforeach;
                endif;
                ?>
                <tr>
                    <td align="center"><?php echo $product_code; ?></td>
                    <td align="center"><?php echo $product_name; ?></td>
                    <td align="center"><?php echo $data->quantity; ?></td>
                    <td align="center"><?php echo "&pound; " . number_format($data->product_price, 2); ?></td>
                    <td align="center"><?php echo "&pound; " . number_format($data->product_price * $data->quantity, 2); ?></td>
                </tr>
            <?php
            $i = $i + 1;
            $pree_amount = $data->product_price * $data->quantity;
            $amount_sub_total = $amount_sub_total + $pree_amount;
        endforeach;
    endif;
    ?>
        <tr><td colspan="5">&nbsp;</td></tr>
        <tr>
            <td align="center">
                <strong>Total: </strong><?php echo "&pound; " . number_format($amount_sub_total, 2); ?><br/>
                <strong>Discount: </strong><?php echo "&pound; " . number_format($model->discount, 2); ?> <br/>
            </td>
            <td align="center">
                <strong>Grand Total: </strong><?php echo "&pound; " . number_format($model->price_grand_total, 2); ?>
            </td>
            <td>&nbsp;</td>
            <td align="center"><strong>Paid Amount: </strong><?php echo "&pound; " . number_format($model->paid_amount, 2); ?></td>
            <td align="center"><strong>Due Amount: </strong><?php $due_total = $model->price_grand_total - $model->paid_amount;
    echo "&pound; " . number_format($due_total, 2); ?></td>
        </tr>
    </table>
    <?php echo CHtml::beginForm(Yii::app()->request->baseUrl . '/supplier/pay_add', 'post', array('id' => 'frm_soft', 'name' => 'frm_soft', 'enctype' => 'multipart/form-data')); ?>
    <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
        <tr>
            <td valign="top"><strong><?php echo CHtml::label('Payment Date', 'payment_date') ?>&nbsp;&nbsp;</strong></td>
            <td>
                <input style="width:200px;height:25px;border:1px solid #CCC;" value="<?php echo date("Y-m-d",  strtotime("NOW")); ?>" name="payment_date" id="payment_date" type="text">
                
           </td>
            <td width="10%">
                <div class="markcolor"></div> 
            </td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <td valign="top"><strong><?php echo CHtml::label('Amount', 'amount') ?>&nbsp;&nbsp;</strong></td>
            <td><?php echo CHtml::textField('amount', $due_total, array('style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onKeyUp' => 'getamount_value()')) ?>
                <input type="hidden" id="original_amount" value="<?php echo $due_total ?>" />
                <div id="amount_error" class="markcolor"><?php //echo CHtml::error($model,'stock_in_date');  ?></div>
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
            <td valign="top"><strong><?php echo CHtml::label('Payment Mode', 'payment_mode') ?>&nbsp;&nbsp;</strong></td>
            <td valign="top">
                <input id="payment_mode" class="payment_mode" value="0" checked name="payment_mode" type="radio"> Cash 
     <?php echo CHtml::radioButton('payment_mode', '', array('class' => "payment_mode", 'value' => 1)) . " Cheque"; ?>
    <?php echo CHtml::radioButton('payment_mode', '', array('class' => "payment_mode", 'value' => 2)) . " Card"; ?>

    <?php echo CHtml::radioButton('payment_mode', '', array('class' => "payment_mode", 'value' => 3)) . " Bank Transfer"; ?>

                <div id="cash_total"></div>
               <?php 
                        $bank_info = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('bank_info')->queryAll();
                
                ?>
                
                <div id="check_payment_date" style="margin-top: 10px;display: none;">
                    
                    <input type="text" name="confirm_date" id="confirm_date"  placeholder="Issued Date"  style="width:160px;"/>
                    <br/><br/>
                    <select name="bank_id" style="width:170px;height: 30px;">
                        <?php foreach ($bank_info as $_info): ?>
                        <option value="<?php echo $_info['id']?>"><?php echo $_info['bank_name']?> </option>                    
                        <?php endforeach; ?>
                    </select>
                  
                      </div>
                  <br/> 
                  <textarea name="notes"  placeholder="Notes" rows="5" style="width:310px;padding: 5px;font-family: tahoma;"></textarea>
             
            </td>
            <td>
    <?php //echo CHtml::error($model,'stock_in_date');  ?>
            </td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>

        <tr>
            <th>&nbsp;</th>
            <td valign="top">
                <input type="hidden" id="t_balance"  name="t_balance" value="" />
                <input type="hidden"  name="supplier_id" id="supplier_id" value="<?php echo $model->supplier_id; ?>" />
                <input type="hidden"  name="chalan_id" id="chalan_id" value="<?php echo $model->chalan_id; ?>" />
                <input type="hidden"  name="price_grand_total" id="price_grand_total" value="<?php echo $model->price_grand_total; ?>" />
                <input type="hidden"  name="paid_amount" id="paid_amount" value="<?php echo $model->paid_amount; ?>" />
    <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue')); ?>
    <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen')); ?>
            </td>
            <td></td>
        </tr>
    </table>
    <?php echo CHtml::endForm() ?>    
<?php endif; ?>
