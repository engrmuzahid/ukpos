<script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery-1.8.1.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.jqprint.0.3.js"></script>
<script type="text/javascript">

    function invoice_total() {
        var total_amount = 0.0;
        $(".invoice_number").each(function (e) {
            if ($(this).attr("checked")) {
                var due = $(this).attr("data-value");
                total_amount += parseFloat(due);
            }
        });
        $("#errorDiv").html("Total selected due &pound;" + parseFloat(total_amount).toFixed(2));
    }

    $(function () {
        $("#print_button2").click(function () {

            $(".invoice_number").each(function (e) {
                $(this).attr("checked", "checked");
            });
            var data = $("#reciveInvoice").serialize();
            $.post('<?php echo Yii::app()->request->baseUrl . '/customer/bulk_print/' ?>', data, function (resp) {

                $("#printReportDiv").html(resp);
                $("#printReportDiv").jqprint();
                $("#printReportDiv").empty();
            });

        });

        $(".bulk_receive").die('click').live('click', function (e) {
            var num = 0;
            $(".invoice_number").each(function (e) {
                if ($(this).attr("checked")) {
                    num++;
                }
            });

            if (num < 1) {
                alert("Please select invoice.");
            } else {
                $("#reciveInvoice").submit();
            }
        });



        $(".bulk_print").die('click').live('click', function (e) {
            var num = 0;
            $(".invoice_number").each(function (e) {
                if ($(this).attr("checked")) {
                    num++;
                }
            });

            if (num < 1) {
                alert("Please select invoice.");
            } else {
                var data = $("#reciveInvoice").serialize();
                $.post('<?php echo Yii::app()->request->baseUrl . '/customer/bulk_print/' ?>', data, function (resp) {

                    $("#printReportDiv").html(resp);
                    $("#printReportDiv").jqprint();
                    $("#printReportDiv").empty();
                });
            }
        });

        $(".invoice_number").live('click', function (e) {
            invoice_total();
        });



        $(".select_all").die('click').live('click', function (e) {
           
            $(".invoice_number").removeAttr('checked');
            
            if ($(this).attr('checked') == true || $(this).attr('checked') == 'checked') {
                var data_id = $(this).attr('data-id');

                $(".invoice_number_" + data_id).attr('checked', 'checked');
            } else {
                $(".invoice_number_" + data_id).removeAttr('checked');
            }
             invoice_total();
        });
        $("#send_email_btn").live('click', function (e)     {
            e.preventDefault();
            $(".invoice_number").each(function (e) {
                $(this).attr("checked", "checked");
            });

            $("#errorDiv").html('<img style=";padding: 0px 10px;" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loading.gif"/>');
            var data = $("#reciveInvoice").serialize();

            var url = '<?php echo Yii::app()->request->baseUrl . '/customer/send_receiable_report'; ?>';
            $.post(url, data, function (resp) {
                $("#errorDiv").html('<p style="color:green"><Email sent successfully.</p>');
//            if (resp == "DONE1") {
//                $("#errorDiv").html('<p style="color:green"><Email sent successfully.</p>');
//            } else {
//                $("#errorDiv").html('<p style="color:red">Error occered.Please try again after sometime.</p>');
//            }
            });


            //  

        });


    });


</script>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Account Receiable Report</td>
        </tr>
    </tbody>
</table>

<table id="contents">

    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('/b2b_sell/_menu') ?>
            </td>
            <td style="width: 10px;"></td>    

    <form id="reportFrm" action="#" method="post">

        <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
        <input type="hidden" name="start_date" value="<?php echo $start_date; ?>">
        <input type="hidden" name="end_date" value="<?php echo $end_date; ?>">

    </form>

    <td id="item_table">
        <div style="width: 100%;float: left">
            <div style="width: 60%;float: left;padding-top: 10px;" id="errorDiv"></div>
            <div style="width: 40%;float: right;text-align: right;">
                <?php if ($customer_id > 0): ?>
                    <input type="image" style="height: 32px;" id="send_email_btn" src="<?php echo Yii::app()->request->baseUrl . '/public/images/email.png'; ?>" alt="Email" title="Email"  />
                    <input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print report" title="Print Report" />
                <?php endif; ?>
            </div>
        </div>
        <div style="clear: both"></div>
        <div id="ptable3">
            <div id="table_holder">
                <form target="_blank"  id="reciveInvoice" method="post" action="<?php echo Yii::app()->request->baseUrl . '/customer/bulk_receive/' ?>">
                    <table class="tablesorter" id="sortable_table" style="width:100%">
                        <thead>
                            <tr>
                                <th width="30%" colspan="3" scope="col">Customer</th>                                                                                    
                                <th width="20%" scope="col">Total Amount</th>
                                <th width="15%" scope="col">Paid Amount</th>
                                <th width="30%" scope="col">Due</th>                                    
                            </tr>
                        </thead>
                        <?php if (count($model)): ?>
                            <?php
                            $i = 1;
                            $grand_total = 0;
                            $pay_total = 0;
                            $due_total = 0;
                            foreach ($model as $customer_id => $posValues):
                                $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                                $customers = Customer::model()->findAll($q1);
                                if (count($customers)):
                                    foreach ($customers as $customer):
                                        $customer_name = $customer->customer_name;
                                    endforeach;
                                else:
                                    $customer_name = "";
                                endif;
                                ?>
                                <tbody style="cursor: pointer" onclick="$('.details_<?php echo $customer_id ?>').toggle()">
                                    <tr>
                                        <td colspan="3"><?php echo $customer_name ?></td>
                                        <td>&pound;<?php echo number_format($accountSummary[$customer_id]['total'], 2) ?></td>
                                        <td>&pound;<?php echo number_format($accountSummary[$customer_id]['paid'], 2) ?></td>
                                        <td>&pound;<?php echo number_format($accountSummary[$customer_id]['total'] - $accountSummary[$customer_id]['paid'], 2) ?></td>
                                    </tr>
                                </tbody>

                                <tbody class="details_<?php echo $customer_id; ?>" style="display: none">
                                    <tr>
                                        <th width="15%" style="background: #06c !important;"  scope="col">
                                            <input type="checkbox" class="select_all" data-id="<?php echo $customer_id; ?>" />
                                            Invoice No
                                        </th>                                                
                                        <th width="15%" style="background: #06c !important;" scope="col">Date</th>
                                        <th width="20%" style="background: #06c !important;" scope="col">Total Amount</th>
                                        <th width="10%" style="background: #06c !important;" scope="col">Paid Amount</th>
                                        <th width="10%" style="background: #06c !important;" scope="col">Due</th>
                                        <th width="30%" style="background: #06c !important;" scope="col">
                                            <a href="#" class="bulk_receive" style="padding: 5px;color:#FFF;background: #0000FF;float: left;"  >Receive</a>
                                            <a href="#" id="print_button_<?php echo $customer_id; ?>" class="bulk_print" style="padding: 5px;color:#FFF;background: #006600;float: right;"  >Print</a>
                                        </th>
                                    </tr>
                                    <?php foreach ($posValues as $posValue): ?>
                                        <?php
                                        $due = $posValue->amount_grand_total - $posValue->paid_amount;
                                        if ($due > 0):
                                            ?>

                                            <tr style="font:Verdana; font-size:11px">

                                                <td>   <input type="checkbox" class="invoice_number invoice_number_<?php echo $customer_id; ?>" name="invoice_number[]" data-value="<?php echo $due; ?>" value="<?php echo $posValue->invoice_no; ?>"> <a href="<?php echo Yii::app()->request->baseUrl . '/b2b_sell/view/' . preg_replace("/[^0-9]/", '', $posValue->invoice_no); ?>" target="_blank"><?php echo $posValue->invoice_no; ?></a></td>                                            
                                                <td><?php echo date('M d, Y', strtotime($posValue->order_date)); ?></td>
                                                <td><?php echo '&pound; ' . number_format($posValue->amount_grand_total, 2); ?></td>
                                                <td><?php echo '&pound; ' . number_format($posValue->paid_amount, 2); ?></td>
                                                <td><?php
                                                    echo '&pound; ' . number_format($due, 2);
                                                    ?></td>
                                                <td> 
                                                    <a href="<?php echo Yii::app()->request->baseUrl . '/customer/receive_add/' . $posValue->invoice_no; ?>" target="_blank">Receive Now</a>

                                                </td>
                                            </tr>
                                            <?php
                                        endif;
                                        $i = $i + 1;
                                        $grand_total = $grand_total + $posValue->amount_grand_total;
                                        $pay_total = $pay_total + $posValue->paid_amount;
                                        $due_total = $due_total + $due;

                                    endforeach;
                                    ?>
                                </tbody>
    <?php endforeach; ?>  
                    </form>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td><strong><?php echo "Total &pound; " . number_format($grand_total, 2); ?></strong></td>
                        <td><strong><?php echo "Total &pound; " . number_format($pay_total, 2); ?></strong></td>
                        <td colspan="2"><strong><?php echo "Total &pound; " . number_format($due_total, 2); ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr><div id="message-red"><td colspan="7" class="red-left">No Receivable Amount Available Yet </td></div></tr>
<?php endif; ?>

                </table> 
                </form>
            </div>
        </div>
    </td>
</tr>
</tbody>
</table>
<div id="printReportDiv"></div> 
