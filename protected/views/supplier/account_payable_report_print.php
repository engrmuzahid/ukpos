<style>
    body {
        font-family: Tahoma, serif;
        background: none;
        color: black;
        /*        width: 595px;*/
        margin:0 auto;
        padding-top: 10px;
    }
    #page {
        width: 100%;
        margin: 0; padding: 0;
        background: none;
    } 
    .entry a:after {
        content: " [" attr(href) "] ";
    }
    *{
        margin: 0px;
        padding: 0px;
    }    
</style>
<?php
$criteria = new CDbCriteria();
$criteria->order = 'id DESC';
$criteria->limit = 1;
$companys = Company::model()->findAll($criteria);
?>
<table border="0" width="95%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:11px;margin-bottom:10px; margin-left:10px;">
    <?php if (count($companys)): foreach ($companys as $company): ?>
            <tr>
                <td width="10%" rowspan="2" valign="top"><img src="<?php echo Yii::app()->request->baseUrl . '/public/photos/company/' . $company->company_logo; ?>" height="70" alt=""  /></td>
                <td width="55%">
                    <p style="margin-right:30px;"><font style="font-size:15px; font-weight:bold;"><?php echo ucwords($company->company_name); ?></font><br />
                        <?php echo $company->address . "<br/> " . $company->contact_no . ". <br/> " . $company->email_address . ".<br/> " . $company->website; ?></p>
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
            <tr>
                <td width="55%" valign="top">
                    <table style="font-family:Verdana; font-size:11px;">
                        <tr>
                            <td>&nbsp;</td>        
                        </tr>
                    </table>         
                </td>
                <td width="35%">&nbsp;</td>
            </tr>
            <?php
        endforeach;
    endif;
    ?>
</table>
 <table class="tablesorter" id="sortable_table" style="width:100%">
                        <?php if (count($model)): ?>
                            <thead>
                                <tr>
                                    <th width="12%" scope="col">Shipment Id</th>
                                    <th width="18%" scope="col">Supplier Name</th>
                                    <th width="12%" scope="col">Date</th>
                                    <th width="20%" scope="col">Total Amount</th>
                                    <th width="18%" scope="col">Paid Amount</th>
                                    <th width="10%" scope="col">Due</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $grand_total = 0;
                                $pay_total = 0;
                                $due_total = 0;

                                foreach ($model as $posValue):
                                    //   print_r($posValue->note);
                                    //exit();
                                    $supplier_id = $posValue->supplier_id;
                                    $q1 = new CDbCriteria(array('condition' => "id = '$supplier_id'",));
                                    $suppliers = Supplier::model()->findAll($q1);
                                    if (count($suppliers)): foreach ($suppliers as $supplier): $supplier_name = $supplier->name;
                                        endforeach;
                                    else: $supplier_name = "";
                                    endif;

                                    $due = $posValue->price_grand_total - $posValue->paid_amount;
                                    if ($due > 0):
                                        $grand_total += $posValue->price_grand_total;
                                        $pay_total += $posValue->paid_amount;
                                        $due_total += $due;
                                        ?>
                                        <tr style="font:Verdana; font-size:11px;">
                                            <td><?php echo $posValue->chalan_id; ?></td>
                                            <td class="payable_report"><?php echo $supplier_name; ?>            </td>
                                            <td><?php echo date('M d, Y', strtotime($posValue->purchase_date)); ?></td>
                                            <td><?php echo '&pound; ' . number_format($posValue->price_grand_total, 2); ?></td>
                                            <td><?php echo '&pound; ' . number_format($posValue->paid_amount, 2); ?></td>
                                            <td><?php echo '&pound; ' . number_format($due, 2); ?></td>
                                            
                                        </tr>
                                        <?php
                                    endif;
                                    $i = $i + 1;

                                endforeach;
                                ?>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                    <td><strong><?php echo "Total &pound; " . number_format($grand_total, 2); ?></strong></td>
                                    <td><strong><?php echo "Total &pound; " . number_format($pay_total, 2); ?></strong></td>
                                    <td colspan="2"><strong><?php echo "Total &pound; " . number_format($due_total, 2); ?></strong></td>
                                </tr>
                            <?php else: ?>
                                <tr><div id="message-red"><td colspan="7" class="red-left">No Payable Amount Available Yet</td></div></tr>
                        <?php endif; ?>
                    </table> 