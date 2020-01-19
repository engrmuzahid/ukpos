<?php echo CHtml::beginForm(Yii::app()->request->baseUrl . '/sell/sell_return', 'post', array('enctype' => 'multipart/form-data')); ?>
<table align="center" width="50%" style=" margin-left:5px;margin-bottom:10px;">
    <tr><td colspan="4">&nbsp;</td></tr>
    <tr>
        <td width="10%">&nbsp;</td>
        <th width="30%" align="left"><?php echo "Invoice No"; ?><span class="markcolor">*</span></th>            
        <td width="15%" align="left"><?php echo CHtml::textField('invoice_no', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?></td>
        <td width="45%" align="left">&nbsp;&nbsp;<?php echo CHtml::submitButton('Search', array('class' => 'buttonBlue')); ?></td>
    </tr>
</table>
<?php echo CHtml::endForm(); ?>

<?php
/*
  $criteria2 = new CDbCriteria();
  $criteria2->order = 'id DESC';
  $criteria2->limit = 1;
  $modelmain = Invoice_Track::model()->findAll($criteria2);
  if(count($modelmain)): foreach($modelmain as $models): $invoice_no = $models->invoice_no; endforeach; endif;
  $cond = new CDbCriteria( array( 'condition' => "invoice_no = '$invoice_no'",) );
  $model = Sell::model()->findAll( $cond );
  $model2 = Sell_Product::model()->findAll( $cond ); */

if (isset($_POST['invoice_no'])):
    $cond = new CDbCriteria();
    $cond->condition = "invoice_no = " . $_POST['invoice_no'];

    $modell = Sell::model()->findAll($cond);

    $model2 = Sell_Product::model()->findAll($cond);
    if (count($modell)):
        ?>


        <table border="0" width="90%"  cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-left:5px; margin-right:10px;"> 
            <tr><td colspan="8">&nbsp;</td></tr>
            <?php
            foreach ($modell as $model):
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
                </tr>        
                <tr><td colspan="8">&nbsp;</td></tr>
            <?php endforeach; ?>
        </table> 

    <?php endif; ?>
    <?php if (count($model2)): ?>
        <table border="1" width="90%"  cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-left:5px; margin-right:5px;">  

            <tr>
                <th width="15%">Code</th>
                <th width="35%">Product Name</th>
                <th width="10%">Qty</th>
                <th width="15%">Unit</th>
                <th width="25%">Total</th>
            </tr>
            <tr><td colspan="6">&nbsp;</td></tr>
            <?php
            $i = 1;
            $amount_sub_total = 0;
            foreach ($model2 as $data):
                $product_code = $data->product_code;
                $q1 = new CDbCriteria(array('condition' => "product_code = '$product_code'",));

                $product_names = Product::model()->findAll($q1);

                $product_name = "";
                if (count($product_names)): foreach ($product_names as $product_names):
                        $product_name = $product_names->product_name;
                    endforeach;
                endif;
                ?>
                <tr <?php if ($i % 2 == 0): ?> class="alternate-row" <?php endif; ?>>
                    <td><?php echo $product_code; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td align="center"><?php echo $data->quantity; ?></td>
                    <td align="center"><?php echo "&pound; " . number_format($data->amount, 2); ?></td>
                    <td align="center"><?php echo "&pound; " . number_format($data->amount * $data->quantity, 2); ?></td>
                </tr>
                <?php
                $i = $i + 1;
            endforeach;
            ?>
            <tr>  
                <td align="center">Grand Total: <?php echo "&pound; " . number_format($model->amount_grand_total, 2); ?></td>
                <td align="center"><strong>Paid Total: <?php echo "&pound; " . number_format($model->paid_amount, 2); ?></td>
                <td>&nbsp;</td>
                <td align="center" colspan="2"><strong>Due Total: <?php
                        $due_total = $model->amount_grand_total - $model->paid_amount;
                        echo "&pound; " . number_format($due_total, 2);
                        ?></strong></td>
            </tr>
        </table>
    <?php endif; ?>
    <?php echo CHtml::beginForm(Yii::app()->request->baseUrl . '/sell/sellentry', 'post', array('enctype' => 'multipart/form-data')); ?>

    <table align="center" width="95%" style="margin-bottom:10px; margin-left:10px;"> 
        <tr height="25" style="font-weight:bold; margin-bottom:10px;" bgcolor="#CCCCCC">
            <td align="center" width="25%" valign="top"><?php echo CHtml::activeLabel($model, 'code') ?><span class="markcolor">*</span></td>
            <td align="center" width="25%" valign="top"><?php echo CHtml::activeLabel($model, 'quantity') ?><span class="markcolor">*</span></td>
            <td width="50%">&nbsp;</td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
            <td align="center" width="25%"><?php echo CHtml::textField('product_code2', '', array('style' => 'width:120px;height:23px;border:1px solid #CCC;')) ?></td>
            <td align="center" width="25%"><?php echo CHtml::textField('qty', '1', array('style' => 'width:120px;height:23px;border:1px solid #CCC;')) ?></td>
            <td width="50%">
                <input type="hidden" name="invoice_no2" value="<?php echo $model->invoice_no; ?>" />
                <?php echo CHtml::submitButton('Add', array('class' => 'buttonGreen')); ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::endForm() ?>    
    <?php echo CHtml::beginForm(Yii::app()->request->baseUrl . '/sell/sell_return', 'post', array('enctype' => 'multipart/form-data')); ?>
    <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
            <td colspan="3">
                <?php
                $amount_sub_total = 0;
                $username = Yii::app()->user->name;
                $cond = new CDbCriteria(array('condition' => "user_id = '$username'", 'order' => 'id DESC',));
                $cart = Sell_Return_Tempory::model()->findAll($cond);

                if (count($cart)):
                    ?>
                    <div id="cart2">
                        <table>
                            <caption>Product List</caption>
                            <thead>
                                <tr>
                                    <th>Subcategory</th>
                                    <th>Code</th>
                                    <th>Product Name</th>
                                    <th>Price + Vat</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php
                            foreach ($cart as $item):
                                $product_code = $item->product_code;
                                $q1 = new CDbCriteria(array('condition' => "product_code = '$product_code'",));
                                $q2 = new CDbCriteria(array('condition' => "invoice_no = '$model->invoice_no' && product_code = '$product_code'",));
                                $product_name = "";
                                $Type_names = "";
                                $sell_price = 0;
                                $Products = Product::model()->findAll($q1);
                                $salProducts = Sell_Product::model()->findAll($q2);
                                if (count($salProducts)): foreach ($salProducts as $salProduct):
                                        $sell_p = $salProduct->amount;
                                        $vat_pp = $salProduct->vat;
                                        $vat = ($sell_p * $vat_pp) / 100;
                                        $sell_price = $sell_p + $vat;
                                    endforeach;
                                endif;

                                if (count($Products)): foreach ($Products as $Products):
                                        $product_type_id = $Products->product_type_id;
                                        $q2 = new CDbCriteria(array('condition' => "id = '$product_type_id'",));
                                        $Type_names = Product_Type::model()->findAll($q2);
                                        $product_name = $Products->product_name;
                                    endforeach;
                                endif;
                                ?>
                                <tr>
                                    <td align="center"><?php
                                        if (count($Type_names)): foreach ($Type_names as $Type_names): echo $Type_names->type_name;
                                            endforeach;
                                        endif;
                                        ?></td>
                                    <td align="center"><?php echo $product_code; ?></td>
                                    <td align="center"><?php echo $product_name; ?></td>
                                    <td align="center"><?php echo "&pound; " . number_format($sell_price, 2); ?></td>
                                    <td align="center"><?php echo $item->quantity; ?></td>
                                    <td align="center"><?php echo "&pound; " . number_format($sell_price * $item->quantity, 2); ?></td>
                                    <td  class="remove">
                                        <?php echo CHtml::link('X', array('/sell/sellremove/' . $item->id)); ?>
                                        <?php echo CHtml::hiddenField('product_code22[]', $product_code) . CHtml::hiddenField('quantity[]', $item->quantity) . CHtml::hiddenField('price[]', $sell_price); ?>
                                    </td>
                                </tr>
                                <?php
                                $pree_amount = $sell_price * $item->quantity;
                                $amount_sub_total = $amount_sub_total + $pree_amount;
                            endforeach;
                            ?>
                            <tr><td colspan="5" align="right"><strong>Grand Total: </strong></td><td  align="center"><?php echo "&pound; " . number_format($amount_sub_total, 2); ?> <input type="hidden"  name="price_grand_total" value="<?php echo $amount_sub_total; ?>" /></td></tr>
                        </table>		
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th valign="top"><?php echo CHtml::label('Return Date', 'return_date') ?>&nbsp;&nbsp;</th>
            <td><?php echo CHtml::textField('return_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
            <td>
                <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date');      ?></div>
            </td>
        </tr>

        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th valign="top"><?php echo CHtml::label('Payment Return', 'payment_return') ?>&nbsp;&nbsp;</th>
            <td>
                <?php echo CHtml::radioButton('payment_return', 'payment_return', array('value' => 1)) . " Cash"; ?>
                <?php echo CHtml::radioButton('payment_return', '', array('value' => 2)) . " Card"; ?>            
            </td>
            <td>
                <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date');     ?></div>
            </td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th valign="top"><?php echo CHtml::label('Reason', 'reason') ?>&nbsp;&nbsp;</th>
            <td><?php echo CHtml::textField('reason', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
            <td>
                <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date');      ?></div>
            </td>
        </tr>

        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</th>
            <td valign="top">	
                <input type="hidden" name="invoice_no3" value="<?php echo $model->invoice_no; ?>" />
                <?php echo CHtml::submitButton('Sell Return', array('class' => 'buttonBlue')); ?>
                <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen')); ?>
            </td>
            <td></td>
        </tr>
    </table>
    <?php echo CHtml::endForm() ?>

<?php endif; ?>