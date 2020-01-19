<script>
    $(function () {
        $("#print_button2").click(function () {
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
            <td id="title">B2B Profit / Loss Report</td>
            <td></td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">

                <div id="ptable3">
                    <div id="table_holder">
                        <p style="font-size:18px;">Profit / Loss Report<?php if (!empty($start_date)): echo " - From " . date('M d', strtotime($start_date)) . " to " . date('M d', strtotime($end_date));
                endif;
                ?>
                            <span style="margin-left:250px;"> <input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></span>
                        </p>
                        <p>&nbsp;</p>
                        <!--  start product-table ..................................................................................... -->
                        <table class="tablesorter" id="sortable_table" style="width:100%">
                            <?php $con = count($model);
                            if (count($model)):
                                ?>
                                <tr>
                                    <th width="30%" scope="col">Item Name</th>
                                    <th width="10%" scope="col">Qty Sold</th>
                                    <th width="20%" scope="col">Purchase Amount(&pound;)</th>
                                    <th width="20%" scope="col">Sell Amount(&pound;)</th>
                                    <th width="5%" scope="col">Vat(&pound;)</th>
                                    <th width="15%" scope="col">Profit(&pound;)</th>
                                </tr>
                                <?php
                                $i = 1;
                                $Total_qty = 0;
                                $Total_purchase = 0;
                                $Total_sell = 0;
                                $Total_profit = 0;
                                $Total_vat = 0;
                                foreach ($model as $posValue):
                                    $product_name = $posValue['product_name'];
                                    $Tqty = $posValue['total_sell_qty'];
                                    $Vamount = $posValue['total_vat'];
                                    $Tpurchase_amount = $posValue['total_sell_qty'] * $posValue['purchase_cost'];
                                    $Tsamount = $posValue['total_sell_amount'];
                                    $prof_amount = $Tsamount - $Tpurchase_amount;

                                    /////....Profit Calculation........//
                                    if ($Vamount > 0) {
                                        $profit_amt = ((100 * $Tsamount) / (100 + $Vamount)) - $Tpurchase_amount;
                                        $vatonprofit = ($Vamount / 100) * $profit_amt;
                                        $prof_amount = $Tsamount - ($Vamount + $vatonprofit + $Tpurchase_amount);
                                    }
                                    /////....Profit Calclation..........//

                                    if ($prof_amount < 0): $style = "style='color:#FF0000'";
                                    else: $style = "style='color:#12B203'";
                                    endif;
                                    ?>
                                    <tr style="font-family:Verdana; font-size:11px;">
                                        <td width="30%" scope="col"><?php echo ucwords($product_name); ?></td>
                                        <td width="10%" scope="col"><?php echo $Tqty; ?></td>
                                        <td width="20%" scope="col"><?php echo number_format($Tpurchase_amount, 2); ?></td>
                                        <td width="20%" scope="col"><?php echo number_format($Tsamount, 2); ?></td>
                                        <td width="5%" scope="col"><?php echo number_format($Vamount, 2); ?></td>
                                        <td <?php echo $style; ?> width="15%" scope="col"><?php echo number_format($prof_amount, 2); ?></td>
                                    </tr>

                                    <?php
                                    $i = $i + 1;
                                    $Total_qty = $Total_qty + $Tqty;
                                    $Total_vat = $Total_vat + $Vamount;
                                    $Total_purchase = $Total_purchase + $Tpurchase_amount;
                                    $Total_sell = $Total_sell + $Tsamount;
                                    $Total_profit = $Total_profit + $prof_amount;
                                    if ($Total_profit < 1): $style2 = "style='color:#FF0000'";
                                    else: $style2 = "style='color:#12B203'";
                                    endif;
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
                            <?php else: ?>
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
