<script type="text/javascript">
    function SubmitMe()
    {
        $(function () {
            $("#ptable3").jqprint();
        });

    }
</script>
<table id="contents" style="width:0px; font-size:12px;">
    <tbody><tr>
            <td id="commands" colspan="3">

                <div id="ptable3">       
                    <?php
                    $invoice_no = $invoice_no;
                    $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
                    $models = Sell::model()->findAll($cond);
                    $model_products = Sell_Product::model()->findAll($cond);
                    $criteria = new CDbCriteria();
                    $criteria->order = 'id DESC';
                    $criteria->limit = 1;
                    $companys = Company::model()->findAll($criteria);
                    ?>
                    <table border="0" width="250" align="center" cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:10px;">
                        <?php if (count($companys)): foreach ($companys as $company): ?>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr>
                                    <td colspan="2" align="center" style="font-size:10.5px;">
                                        <span style="font-size:15.5px;font-weight: bold;"><?php echo ucwords($company->company_name); ?></span>  <br/>
                                        <?php echo $company->address . "<br/> " . $company->contact_no . ". <br/> " . $company->email_address . ".<br/> " . $company->website; ?>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>
                        <?php if (count($models)): foreach ($models as $posValue): ?>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr><td colspan="2">
                                        <table width="98%" cellpadding="0" cellspacing="0" style="margin-left:5px;" >
                                            <?php if (count($model_products)): ?>
                                                <tr>
                                                    <td width="50%" scope="col"><strong>Name</strong></td>
                                                    <th width="25%" scope="col">Unit</th>
                                                    <th width="25%" scope="col" style="float: right;margin-right: 18px;">Total</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><hr></th>
                                                </tr>

                                                <?php
                                                $i = 1;
                                                $sub_total_amount = 0;
                                                $without_offer_amount = 0;
                                                $total_vat_amount = 0;
                                                $offer_status = 0;
                                                foreach ($model_products as $posProductValue):
                                                    $offer_status = 0;
                                                    $product_code = $posProductValue->product_code;
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
                                                    // print_r($pValues[0]->product_name);
                                                    // exit();
                                                    if ($posProductValue->quantity >= $pValues[0]->offer_quantity && $pValues[0]->offer_quantity > 0 && $pValues[0]->offerPrice > 0) {

                                                        $extraQuantity = ($posProductValue->quantity % $pValues[0]->offer_quantity);
                                                        $totalOfferPrice = (($posProductValue->quantity - $extraQuantity) / $pValues[0]->offer_quantity) * $pValues[0]->offerPrice;
                                                        $escapePrice = $extraQuantity * $_amount_total;
                                                        $_amount_total = $totalOfferPrice + $escapePrice;

                                                        $offer_status = 1;
                                                    }
                                                    $total_vat_amount += $vat_amount * $posProductValue->quantity;
                                                    $sub_total_amount += $_amount_total;
                                                    ?>
                                                    <tr <?php if ($i % 2 == 0): ?> class="alternate-row" <?php endif; ?> style="font-size:11px">
                                                        <td>
                                                            <span style="width:5px; display:inline-block"><?php echo $posProductValue->vat > 0 ? '*' : '&nbsp;'; ?></span>
                                                            <?php echo " " . $posProductValue->quantity . ' X ' . ucwords(substr($_product->product_name, 0, 30)); ?>
                                                            <?php if($offer_status): ?>
                                                             <span style="color:red;text-decoration: line-through;"><?php echo '&pound; ' . number_format($without_offer_amount, 2); ?></span>
                                                            <?php endif; ?>

                                                        </td>
                                                        <td align="center" ><?php echo '&pound; ' . number_format($_amount, 2); ?></td>
                                                        <td align="right" style="margin-right:5px;"><?php echo '&pound; ' . number_format($_amount_total, 2); ?>&nbsp;</td>
                                                    </tr>
                                                    <?php
                                                    $i = $i + 1;
                                                endforeach;
                                            endif;
                                            ?>
                                            <tr>
                                                <td colspan="3"><hr></th>
                                            </tr>       
                                            <tr style="font-size:11px">
                                                <td colspan="1" align="left">
                                                    <?php echo count($model_products) . " ITEMS SOLD "; ?> 
                                                </td> <td  align="right">Sub Total &nbsp;&nbsp;</td>
                                                <td align="right"><?php echo '&pound; ' . number_format($sub_total_amount, 2); ?>&nbsp;</td>
                                            </tr>
                                            <tr style="font-size:11px">
                                                <td colspan="2" align="right">Vat &nbsp;&nbsp;</td>
                                                <td align="right"><?php echo '&pound; ' . number_format($total_vat_amount, 2); ?>&nbsp;</td>
                                            </tr>
                                            <tr style="font-size:11px">
                                                <td colspan="2" align="right">Discount &nbsp;&nbsp;</td>
                                                <td align="right"><?php echo '&pound; ' . number_format($posValue->discount_ratio, 2); ?>&nbsp;</td>
                                            </tr>
                                            <tr style="font-size:11px;font-weight: bold;">
                                                <td colspan="2" align="right">TOTAL &nbsp;&nbsp;</td>
                                                <td align="right"><?php echo '&pound; ' . number_format($posValue->amount_grand_total, 2); ?>&nbsp;</td>
                                            </tr>
                                            <tr style="font-size:11px">
                                                <td colspan="2" align="right">Paid &nbsp;&nbsp;</td>
                                                <td align="right"><?php echo '&pound; ' . number_format($posValue->paid_amount, 2); ?>&nbsp;</td>
                                            </tr>
                                            <?php
                                            $due_total = $posValue->amount_grand_total - $posValue->paid_amount;
                                            if ($due_total > 0):
                                                ?>
                                                <tr style="font-size:11px">
                                                    <td colspan="2" align="right">Total Due &nbsp;&nbsp;</td>
                                                    <td align="right"> - <?php echo '&pound; ' . number_format($due_total, 2); ?>&nbsp;</td>
                                                </tr>
                                                <?php
                                            else:
                                                $change_total = $posValue->paid_amount - $posValue->amount_grand_total;
                                                ?>
                                                <tr style="font-size:11px">
                                                    <td colspan="2" align="right">Total Change &nbsp;&nbsp;</td>
                                                    <td align="right"><?php echo '&pound; ' . number_format($change_total, 2); ?>&nbsp;</td>
                                                </tr>
                                            <?php endif; ?>
                                            <tr><td colspan="3">&nbsp;</td></tr>
                                        </table>          
                                    </td></tr>

                                <tr>
                                    <td colspan="2" align="center">        
                                        <img src="<?php echo Yii::app()->request->baseUrl . '/public/'; ?>barcode.php?barcode=<?php echo $posValue->invoice_no; ?>&width=250&height=45"> 
                                    </td>
                                </tr>
                                <?php
                                $full_name = "";
                                $user_id = $posValue->user_id;
                                $cond2 = new CDbCriteria(array('condition' => "username = '$user_id'",));
                                $users = Users::model()->findAll($cond2);
                                if (count($users)): foreach ($users as $user): $full_name = $user->full_name;
                                    endforeach;
                                endif;
                                ?>
                                <tr>
                                    <td colspan="2" align="center"><?php echo date('M d, Y', strtotime($posValue->order_date)); ?> <?php echo " | " . ucwords($full_name); ?>  </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">Thank you for your custom </td>
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>
                        <tr><td colspan="2">&nbsp;</td></tr>
                    </table>

            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
<script type="text/javascript">
    SubmitMe();
</script>
