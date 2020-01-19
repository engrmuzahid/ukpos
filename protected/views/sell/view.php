<script>
    $(function () {
        $("#print_button2").click(function () {
            $("#ptable3").jqprint();
        });
    });
</script>

<table id="contents">
    <tbody><tr>
            <td id="commands" colspan="3">

                <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
                <div id="ptable3">
                    <?php
                    $criteria = new CDbCriteria();
                    $criteria->order = 'id DESC';
                    $criteria->limit = 1;
                    $companys = Company::model()->findAll($criteria);
                    if (count($models)): 
                        foreach ($models as $posValue): 
                        endforeach;
                    endif;
                    ?>
                    <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:11px;margin-bottom:10px; margin-left:10px;">
                                    <?php if (count($companys)): foreach ($companys as $company): ?>
                                <tr>
                                    <td width="10%" rowspan="2" valign="top"><img src="<?php echo Yii::app()->request->baseUrl . '/public/photos/company/' . $company->company_logo; ?>" height="70" alt=""  /></td>
                                    <td width="55%">
                                        <p style="margin-right:30px;"><font style="font-size:15px; font-weight:bold;"><?php echo ucwords($company->company_name); ?></font><br />
        <?php echo $company->address . "<br/> " . $company->contact_no . ". <br/> " . $company->email_address . ".<br/> " . $company->website; ?></p>
                                    </td>
                                    <td width="35%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="55%" valign="top">
                                        <table style="font-family:Verdana; font-size:11px;">
                                            <tr>
                                                <td>&nbsp;</td>        
                                            </tr>
                                        </table>         
                                    </td>
                                    <td width="35%" align="right">
                                        <table  border="1" style="border-collapse:collapse;font-family:Verdana; font-size:6px;">
                                            <tr>
                                                <td>
                                                    <p style="margin:5px 5px 5px 5px;">
                                                        No claims of these goods can be entertained unless notified to our office within 24 hours. We remain owners of the goods until complete payment has been made. CONDITION OF SALE: While all goods are believed to be sound and merchantable NO WARRANTY is given or to be implied on any sale.<br />

                                                        Any cheque paid to Sylhet cash &amp; carry and not honoured by drawer Bank, the customer shall be subject to a charge of &pound;27.50 for cheque representation; an additional &pound;35 will be charged for cheques referred to drawer.
                                                    </p>
                                                </td>        
                                            </tr>
                                        </table>         
                                    </td>
                                </tr>
                        <?php endforeach;
                    endif; ?>
                    </table>

                    <?php
                    $customer_id = $posValue->customer_id;

                    $customer_cond = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                    $CustomerValues = Customer::model()->findAll($customer_cond);
                    ?>
<?php if (count($CustomerValues)): ?>
                        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:11px;margin-bottom:10px; margin-left:10px;">
    <?php foreach ($CustomerValues as $Customers): ?>
                                <tr>
                                    <td width="50%" align="left">
                                        <table style="font-family:Verdana; font-size:11px;">
                                            <tr><td><strong>TO</strong></td></tr>
                                            <tr><td><?php echo $Customers->business_name; ?></td></tr>
                                            <tr><td><?php echo $Customers->business_street1 . ' ' . $Customers->business_street2 . ' <br>' . $Customers->business_city . '<br>' . $Customers->business_post_code; ?></td></tr>
                                            <tr><td><?php echo "Phone: " . $Customers->contact_no2; ?></td></tr>
                                        </table>         
                                    </td>
                                    <td width="50%" align="right" style=" margin-right:10px;">
                                        <table style="font-family:Verdana; font-size:11px;">
                                            <tr><td><h3>SALES INVOICE</h3></td></tr>
                                            <tr>
                                                <td><p style="margin-right:30px;"><?php echo "Invoice # " . $posValue->invoice_no . "<br/>Date: " . date('M d, Y', strtotime($posValue->order_date)); ?></p></td>        
                                            </tr>
                                        </table>          
                                    </td>
                                </tr>
    <?php endforeach; ?>
                        </table>
<?php endif; ?>
                    <table width="90%" cellpadding="2" cellspacing="3" border="1" style="margin-left:5px; border-collapse:collapse;font-family:Verdana; font-size:11px;" >
<?php if (count($model_products)): ?>
                            <tr>
                                <td width="5%"  align="left">&nbsp;<strong>QTY</strong></td>
                                <td width="55%" align="left">&nbsp;<strong>DESCRIPTION</strong></td>
                                <td width="20%" align="right"><strong>UNIT PRICE</strong>&nbsp;</td>
                                <td width="20%" align="right"><strong>TOTAL</strong>&nbsp;</td>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($model_products as $posProductValue):
                                  $without_offer_amount = 0;
                                $offer_status = 0;
                                $product_code = $posProductValue->product_code;
                            
                                $_product = Product::model()->find("product_code=?", array($product_code));
                                
                                 
                                 $vat_amount = $posProductValue->vat;
                                $_amount = $posProductValue->amount - $vat_amount;
                                $_amount_total = $_amount * $posProductValue->quantity;

                                $without_offer_amount = $_amount_total; 

                                if ($posProductValue->quantity >= $_product->offer_quantity && $_product->offer_quantity > 0 && $_product->offerPrice > 0) {

                                    $extraQuantity = ($posProductValue->quantity % $_product->offer_quantity);
                                    $totalOfferPrice = (($posProductValue->quantity - $extraQuantity) / $_product->offer_quantity) * $_product->offerPrice;
                                    $escapePrice = $extraQuantity * $_amount_total;
                                    $_amount_total = $totalOfferPrice + $escapePrice;
                                    $offer_status = 1;
                                }
                                
                                
                                ?>
                                <tr <?php if ($i % 2 == 0): ?> class="alternate-row" <?php endif; ?>>
                                    <td align="left" style="margin-left:2px;">&nbsp;<?php echo $posProductValue->quantity; ?></td>
                                    <td style="margin-left:2px;">&nbsp;<?php  
                                        echo ucwords($_product->product_name);
                                         ?>
                                      

                                    </td>
                                    <td align="right" style="margin-right:5px;" ><?php echo '&pound; ' . number_format($posProductValue->amount, 2); ?>&nbsp;</td>
                                    
                                    
                                    
                                    <td align="right" style="margin-right:5px;">
                                              <?php if ($offer_status): ?>
                                            <span style="color:red;text-decoration: line-through;float: left;padding-left: 10px;"><?php echo '&pound; ' . number_format($without_offer_amount, 2); ?></span>
                                        <?php endif; ?><?php echo '&pound; ' . number_format($_amount_total, 2); ?>&nbsp;</td>
                                
                                
                                
                                </tr>
                                        <?php $i = $i + 1;
                                    endforeach;
                                endif; ?>
                        <tr>
                            <td rowspan="5" valign="middle" colspan="2" align="left">
                                <br />
<?php
if ($posValue->credit_card_payment > 0 or $posValue->cheque_payment > 0):
    echo "Make all cards payment to<b> " . ucwords($company->company_name) . "</b>";
elseif ($posValue->cash_payment == 0 && $posValue->credit_card_payment == 0 && $posValue->cheque_payment == 0):
    echo "Make all checks payable to<b> " . ucwords($company->company_name) . "</b>";
else: echo "Make all cash payment to<b> " . ucwords($company->company_name) . "</b>";
endif;
?>
                                <br>Thank you for your business!
                            </td>
                            <td align="right" style="margin-right:5px;"><strong>Sub Total</strong>&nbsp;</td>
                            <td align="right" style="margin-right:5px;"><?php echo '&pound; ' . number_format($posValue->amount_sub_total, 2); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right" style="margin-right:5px;"><strong>Vat</strong>&nbsp;</td>
                            <td align="right"><?php echo '&pound; ' . number_format($posValue->vat_total, 2); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right" style="margin-right:5px;"><strong>Total</strong>&nbsp;</td>
                            <td align="right"><?php echo '&pound; ' . number_format($posValue->amount_grand_total, 2); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right" style="margin-right:5px;"><strong>Paid</strong>&nbsp;</td>
                            <td align="right"><?php echo '&pound; ' . number_format($posValue->paid_amount, 2); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right" style="margin-right:5px;"><strong>Total Due</strong>&nbsp;</td>
                            <td align="right"><?php $due_total = $posValue->amount_grand_total - $posValue->paid_amount;
echo '&pound; ' . number_format($due_total, 2);
?>&nbsp;</td>
                        </tr>
                    </table> 
                  
                    
                    <p>&nbsp;</p>
                    <table border="1" width="80%" cellspacing="0"  style="border-collapse:collapse; font-family:Verdana; font-size:11px;border-style:dashed; margin-left:5px;">
                        <tr height="10">
                            <td align="center" width="35%">DRIVER NAME</td>
                            <td align="center" width="15%">AMOUNT</td>
                            <td align="center" width="15%">INVOICE</td>
                            <td align="center" width="15%">DATE</td>
                            <td align="center" width="20%">CUSTOMER SIGN</td>
                        </tr>
                        <tr height="15">
                            <td align="center" width="35%">&nbsp;</td>
                            <td align="center" width="15%">&nbsp;</td>
                            <td align="center" width="15%">&nbsp;</td>
                            <td align="center" width="15%">&nbsp;</td>
                            <td align="center" width="20%">&nbsp;</td>
                        </tr>
                    </table>
            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
