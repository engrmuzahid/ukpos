<br/><br/><br/><br/><br/>

<table id="contents">
    <tbody><tr>
            <td id="commands" colspan="3">   
                <?php echo CHtml::beginForm('', 'post', array('name' => 'frm_soft', 'enctype' => 'multipart/form-data')); ?>
                <?php
                $invoice_no = $invoice_no;
                $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
                $models = Sell::model()->findAll($cond);
                $model_products = Sell_Product::model()->findAll($cond);
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->limit = 1;
                $companys = Company::model()->findAll($criteria);
                $company = $companys[0];
                if (count($models)): foreach ($models as $posValue): endforeach;
                endif;
                ?>

                <div id="ptable3">       
                    <?php
                    $full_name = "";
                    $user_id = $posValue->user_id;
                    $cond2 = new CDbCriteria(array('condition' => "username = '$user_id'",));
                    $users = Users::model()->findAll($cond2);
                    if (count($users)): foreach ($users as $user): $full_name = $user->full_name;
                        endforeach;
                    endif;
                    ?>

                    <?php
                    if (!$posValue->cash_sell) :
                        $customer_id = $posValue->customer_id;
                        $customer_cond = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                        $CustomerValues = Customer::model()->findAll($customer_cond);
                        ?>
                        <?php if (count($CustomerValues)): ?>
                            <table border="0" width="96%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:14px;margin-bottom:10px; margin-left:10px; margin-top: 97px">
                                <?php foreach ($CustomerValues as $Customers): ?>
                                    <tr>
                                        <td width="45%" align="left">
                                            <table style="font-family:Verdana; font-size:14px; vertical-align: top">
                                                <tr><td><strong>TO</strong></td></tr>
                                                <tr><td><?php echo $Customers->business_name; ?> - <?php echo $customer_id ?> </td></tr>
                                                <tr><td><?php echo $Customers->business_street1 . ' ' . $Customers->business_street2 . ' <br>' . $Customers->business_city . '<br>' . $Customers->business_post_code; ?></td></tr>
                                                <tr><td><?php echo "Phone: " . $Customers->contact_no2; ?></td></tr>
                                            </table>         
                                        </td>
                                        <td width="50%" align="right" style=" margin-right:10px; vertical-align: top">
                                            <table style="font-family:Verdana; font-size:14px;">
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td ><span  style="font-family:Verdana; font-size:17px;"><?php echo $posValue->invoice_no ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td><span  style="font-family:Verdana; font-size:17px;"><?php echo date('M d, Y', strtotime($posValue->order_date)) ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td><span  style="font-family:Verdana; font-size:17px;"><?php echo " Served by # " . ucwords($full_name); ?></span></td>
                                                </tr>

                                            </table>          
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>
                    <?php else : ?>
                        <table border="0" width="96%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:14px;margin-bottom:10px; margin-left:10px; margin-top: 97px">
                            <tr>
                                <td width="45%" align="left">
                                    <table style="font-family:Verdana; font-size:14px; vertical-align: top">
                                        <tr><td><strong>CASH SELL</strong></td></tr>                                            
                                    </table>         
                                </td>
                                <td width="50%" align="right" style=" margin-right:10px; vertical-align: top">
                                    <table style="font-family:Verdana; font-size:17px;">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><span  style="font-family:Verdana; font-size:17px;"> <?php echo $posValue->invoice_no ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><span  style="font-family:Verdana; font-size:17px;"> <?php echo date('M d, Y', strtotime($posValue->order_date)) ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><span  style="font-family:Verdana; font-size:17px;"> <?php echo " Served by # " . ucwords($full_name); ?></span></td>
                                        </tr>

                                    </table>          
                                </td>
                            </tr>                            
                        </table>
                    <?php endif; ?>
                    <br/>
                    <table width="98%" cellpadding="2" cellspacing="3" style="margin-left:5px; border-collapse:collapse;font-family:Verdana; font-size:14px; margin-top: 70px" >
                        <?php if (count($model_products)): ?>				
                            <?php
                            $i = 1;
                            $sub_total_amount = 0;
                            $total_vat_amount = 0;
                            $offer_status = 0;
                             
                            foreach ($model_products as $posProductValue):
                                     $without_offer_amount = 0;
                                $offer_status = 0;
                                $product_code = $posProductValue->product_code;
                                $product_name = $posProductValue->product_name;
                                $_product = Product::model()->find("product_code=?", array($product_code));
                                if ($posProductValue->vat == 0) {
                                    $vat_amount = $_product->vat_on_purchase + $_product->vat_on_profit;
                                } else {
                                    $vat_amount = $posProductValue->vat;
                                }

                                $_amount = $posProductValue->amount - $vat_amount;
                                $_amount_total = $_amount * $posProductValue->quantity;

                                $without_offer_amount = $_amount_total;
                                $prod1 = new CDbCriteria(array('condition' => "product_code = '$product_code'",));
                                $pValues = Product::model()->findAll($prod1);

                                if ($posProductValue->quantity >= $pValues[0]->offer_quantity && $pValues[0]->offer_quantity > 0 && $pValues[0]->offerPrice > 0) {

                                    $extraQuantity = ($posProductValue->quantity % $pValues[0]->offer_quantity);
                                    $totalOfferPrice = (($posProductValue->quantity - $extraQuantity) / $pValues[0]->offer_quantity) * $pValues[0]->offerPrice;
                                    $escapePrice = $extraQuantity * $_amount_total;
                                    $_amount_total = $totalOfferPrice + $escapePrice;
                                    $offer_status = 1;
                                }
                                $total_vat_amount += $vat_amount * $posProductValue->quantity;
                                $sub_total_amount += $_amount_total;


                                if ($product_name == "") {
                                    $product_name = $_product->product_name;
                                }
                                ?>
                                <tr <?php if ($i % 2 == 0): ?> class="alternate-row" <?php endif; ?> style="line-height: 22px;">

                                    <td style="margin-left:2px;">
                                        <span style="width:5px; display:inline-block"><?php echo $vat_amount > 0 ? '*' : '&nbsp;'; ?></span>
                                        <?php echo $posProductValue->quantity; ?> x <?php echo ucwords($product_name); ?>                                    
                                        <?php if ($offer_status): ?>
                                            <span style="color:red;text-decoration: line-through;"><?php echo '&pound; ' . number_format($without_offer_amount, 2); ?></span>
                                        <?php endif; ?>

                                    </td>
                                    <td align="right" style="padding-right:0" ><?php echo '&pound; ' . number_format($_amount, 2); ?>&nbsp;</td>
                                    <td align="right"><?php echo '&pound; ' . number_format($_amount_total, 2); ?>&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                <?php
                                $i = $i + 1;
                            endforeach;
                        endif;
                        ?>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr>
                            <td rowspan="6" valign="middle" align="left">
                                <br/>
                                <?php
                                if ($posValue->credit_card_payment > 0 or $posValue->cheque_payment > 0):
                                    echo "Make all cards payment to<b> " . ucwords($company->company_name) . "</b>";
                                elseif ($posValue->cash_payment == 0 && $posValue->credit_card_payment == 0 && $posValue->cheque_payment == 0):
                                    echo "Make all checks payable to<b> " . ucwords($company->company_name) . "</b>";
                                else:
                                    echo "Make all cash payment to<b> " . ucwords($company->company_name) . "</b>";
                                endif;
                                ?>
                                <br>Thank you for your business!
                            </td>
                            <td align="right" style="padding-right:0"><strong>Sub Total</strong>&nbsp;</td>
                            <td align="right"><b><?php echo '&pound; ' . number_format($sub_total_amount, 2); ?>&nbsp;&nbsp;&nbsp;</b></td>
                        </tr>
                        <tr>
                            <td align="right" style="padding-right:0"><strong>Vat</strong>&nbsp;</td>
                            <td align="right"><b><?php echo '&pound; ' . number_format($total_vat_amount, 2); ?>&nbsp;&nbsp;&nbsp;</b></td>
                        </tr>
                        <tr>
                            <td align="right" style="padding-right:0"><strong>Discount</strong>&nbsp;</td>
                            <td align="right"><b><?php echo '&pound; ' . number_format($posValue->discount_ratio, 2); ?>&nbsp;&nbsp;&nbsp;</b></td>                            
                        </tr>
                        <tr>
                            <td align="right" style="padding-right:0"><strong>Total</strong>&nbsp;</td>
                            <td align="right"><b><?php echo '&pound; ' . number_format($posValue->amount_grand_total, 2); ?>&nbsp;&nbsp;&nbsp;</b></td>
                        </tr>
                        <tr>
                            <td align="right" style="padding-right:0"><strong>Paid</strong>&nbsp;</td>
                            <td align="right"><b><?php echo '&pound; ' . number_format($posValue->paid_amount, 2); ?>&nbsp;&nbsp;&nbsp;</b></td>
                        </tr>
                        <tr>
                            <td align="right" style="padding-right:5px;"><strong>Total Due</strong>&nbsp;</td>
                            <td align="right"><b><?php
                                    $due_total = $posValue->amount_grand_total - $posValue->paid_amount;
                                    echo '&pound; ' . number_format($due_total, 2);
                                    ?>&nbsp;&nbsp;&nbsp;</b></td>
                        </tr>
                    </table>  
            </td>
        </tr>
    </tbody>
</table> 