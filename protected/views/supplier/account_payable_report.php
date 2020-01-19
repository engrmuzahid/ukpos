<style type="text/css">
    .payable_report {
        position: relative; 
    }
    .payable_report .tooltiptext table tr td {

        color: #fff !important;
        border: 0 !important;;  
    }

    .payable_report .tooltiptext {
        visibility: hidden;
        width: 300px;
        background-color: black;
        color: #fff !important;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        margin-top:30px;
        margin-left: -130px;
        position: absolute;
        z-index: 1;
        border: 0;
    }


</style>   

<script>
    $(function () {
        $("#print_button2").die('click').live('click', function (e) {
            e.preventDefault();
            $("#print_table_holder").css('display', 'block');
            $("#print_table_holder").jqprint();
            $("#print_table_holder").css('display', 'none');

            $("#print_table_holder").empty();
//            var data = {};
//            var url = '<?php echo Yii::app()->request->baseUrl . '/supplier/print_report'; ?>';
//            
//            $.post(url, data, function (resp) {
//                $("#errorDiv").html("");
//                $("#print_table_holder").html(resp);
//                $("#print_table_holder").css('display', 'block');
//                $("#print_table_holder").jqprint();
//                $("#print_table_holder").css('display', 'none');
//
//                $("#print_table_holder").empty();
//            });

        });
    });

    $(document).ready(function () {
        $(".show_note").live('click', function (e) {
            var pcode = $(this).attr('data-id');
            if ($('#tooltiptext_' + pcode).css('visibility') != 'visible') {
                $('#tooltiptext_' + pcode).css('visibility', 'visible');
            } else {

                $('#tooltiptext_' + pcode).css('visibility', 'hidden');
            }
        });



    });

</script>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Account Payable Report</td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
            <td id="commands">
                <?php $this->renderPartial('_menu') ?>
            </td>
            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">
                <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
                <div id="table_holder">

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
                                    <th width="10%" scope="col">&nbsp;</th>
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
                                            <td><a href="<?php echo Yii::app()->request->baseUrl . '/purchase/view2/' . preg_replace("/[^0-9]/", '', $posValue->chalan_id); ?>" target="_blank"><?php echo $posValue->chalan_id; ?></a></td>
                                            <td class="payable_report"><?php echo $supplier_name; ?> 
                                                <?php if (strlen($posValue->note) > 0): ?>
                                                    <img height="16" src="<?php echo Yii::app()->request->baseUrl . '/public/images/info.png'; ?>" alt="Note" title="Note" border="0" data-id="<?php echo $posValue->id; ?>" class="show_note" style="float:right;" />

                                                    <span class="tooltiptext" id="tooltiptext_<?php echo $posValue->id; ?>"><?php echo $posValue->note; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($posValue->purchase_date)); ?></td>
                                            <td><?php echo '&pound; ' . number_format($posValue->price_grand_total, 2); ?></td>
                                            <td><?php echo '&pound; ' . number_format($posValue->paid_amount, 2); ?></td>
                                            <td><?php echo '&pound; ' . number_format($due, 2); ?></td>
                                            <td>
                                                <?php if ($due > 0): ?>
                                                    <a href="<?php echo Yii::app()->request->baseUrl . '/supplier/pay_add?chalan_id=' . $posValue->chalan_id; ?>" target="_blank">Pay Now</a>
                                                <?php endif; ?>
                                                <a class="deletePurchase" style="color: red" href="<?php echo Yii::app()->request->baseUrl . '/supplier/deletePurchase?chalan_id=' . $posValue->chalan_id; ?>">Delete</a>
                                            </td>
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
                </div>

            </td>
        </tr>
    </tbody>
</table>

<div id="print_table_holder" style="display: none">
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
    <table  width="100%" cellpadding="2" cellspacing="3" border="1" style="border-collapse:collapse;font-family:Verdana; font-size:12px !important;" >
        <?php if (count($model)): ?>
            <thead>
                <tr>
                    <th width="12%" scope="col">Id</th>
                    <th width="15%" scope="col">Supplier </th>
                    <th width="12%" scope="col">Date</th>
                    <th width="20%" scope="col">Total Amount</th>
                    <th width="18%" scope="col">Paid Amount</th>
                    <th width="12%" scope="col">Due</th> 
                    <th style="border: 0px solid;">&nbsp;</th>
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
                            <td style="border: 0px solid;"><?php echo '&pound; ' . number_format($due, 2); ?></td>
                            <td>&nbsp;</td>

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
</div>

<script>
    $(document).ready(function () {
        $(".deletePurchase").click(function (e) {
            e.preventDefault();
            var $this = $(this).parent();
            if (confirm('Are you sure, you want to delete the purchase?')) {
                $.post($(this).attr('href'), {}, function (resp) {
                    if (resp == "DONE") {
                        $this.parent().remove();
                    } else {
                        alert(resp);
                    }
                })
            }
        })
    })
</script>