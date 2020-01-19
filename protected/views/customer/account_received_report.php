
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Account Received Report</td>
        </tr>
    </tbody>
</table>
<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('/b2b_sell/_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">
                <div style="width: 100%;float: left">
                    <div style="width: 60%;float: left;padding-top: 10px;" id="errorDiv"></div>
                    <div style="width: 40%;float: right;text-align: right;">
                        <input type="image" style="height: 32px;" id="send_email_btn" src="<?php echo Yii::app()->request->baseUrl . '/public/images/email.png'; ?>" alt="Email" title="Email"  />
                        <input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print report" title="Print Report"  />
                    </div>
                    <div id="ptable3">
                        <div id="table_holder">
                            <form id="frmReport">
                                <table class="tablesorter" id="sortable_table" style="width:100%">
                                    <?php if (count($model)): ?>
                                        <thead>
                                            <tr> 
                                                <th><input type="checkbox" id="select_all" /></th>                                       
                                                <th width="15%" scope="col">Invoice No </th>
                                                <th width="20%" scope="col">Customer Name</th>
                                                <th width="15%" scope="col">Date</th>
                                                <th width="20%" scope="col">Receive Mode</th>
                                                <th width="30%" scope="col">Received Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $grand_total = 0;
                                            foreach ($model as $posValue):
                                                $customer_id = $posValue->customer_id;
                                                $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                                                $customers = Customer::model()->findAll($q1);
                                                if (count($customers)): foreach ($customers as $customer): $customer_name = $customer->customer_name;
                                                    endforeach;
                                                else: $customer_name = "";
                                                endif;
                                                if ($posValue->receive_mode == 0): $r_val = "cash";
                                                elseif ($posValue->receive_mode == 1): $r_val = "cheque";
                                                elseif ($posValue->receive_mode == 2): $r_val = "card";
                                                elseif ($posValue->receive_mode == 3): $r_val = "Bank";
                                                endif;
                                                ?>
                                                <tr style="font:Verdana; font-size:11px">
                                                    <td>
                                                        <input class="invoice_ids" type="checkbox" name="invoice_number[]" value="<?php echo $posValue->invoice_no; ?>" /></td>
                                                    <td><a href="<?php echo Yii::app()->request->baseUrl . '/b2b_sell/view/' . preg_replace("/[^0-9]/", '', $posValue->invoice_no); ?>" target="_blank"><?php echo $posValue->invoice_no; ?></a></td>
                                                    <td><?php echo $customer_name; ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($posValue->receive_date)); ?></td>
                                                    <td><?php echo ucwords($r_val); ?></td>
                                                    <td><?php echo '&pound; ' . number_format($posValue->amount, 2); ?></td>
                                                </tr>
                                                <?php
                                                $i = $i + 1;
                                                $grand_total = $grand_total + $posValue->amount;
                                            endforeach;
                                            ?>
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                                <td><strong><?php echo "Total"; ?></strong></td>
                                                <td><strong><?php echo "&pound; " . number_format($grand_total, 2); ?></strong></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr><div id="message-red"><td colspan="5" class="red-left">No Received Amount Available Yet .. <a href="<?php echo Yii::app()->request->baseUrl . '/customer/received_report/'; ?>">Search Again..</a></td></div></tr>
                                    <?php endif; ?>
                                </table>
                            </form>
                        </div>
                    </div>
            </td>
        </tr>
    </tbody>
</table>
<div id="print_table_holder" style="display: none"></div>
 <?php if (count($model)): ?>
<script type="text/javascript">
    $(function () {
        $("#print_button2").click(function (e) {
            e.preventDefault();
            $("#errorDiv").html('<img style=";padding: 0px 10px;" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loading.gif"/>');
            var url = '<?php echo Yii::app()->request->baseUrl . '/b2b_sell/print_report'; ?>';
            var customers = [];
            var invoices = [];
            var i = 0;
            $(".invoice_ids").each(function () {
                if ($(this).attr('checked') == true || $(this).attr('checked') == 'checked') {
                    customers[i] = <?php echo $model[0]->customer_id; ?>;
                    invoices[i] = $(this).val();
                    i++;
                }
            });

            var data = {customer_ids: JSON.stringify(customers), invoice_ids: JSON.stringify(invoices)};
           // console.log(data);
            $.post(url, data, function (resp) {
                 $("#errorDiv").html('');
       
                $("#print_table_holder").html(resp);
                $("#print_table_holder").css('display', 'block');
                $("#print_table_holder").jqprint();
                $("#print_table_holder").css('display', 'none');                
                $("#print_table_holder").empty();
            });            
           // $("#ptable3").jqprint();
        });
    });
    $(document).ready(function ()
    {

        $("#select_all").die('click').live('click', function (e) {
            if ($(this).attr('checked') == true || $(this).attr('checked') == 'checked') {
                $(".invoice_ids").attr('checked', 'checked');
            } else {
                $(".invoice_ids").removeAttr('checked');
            }
        });
        $("#send_email_btn").live('click', function (e) {
            e.preventDefault();
//        $(".invoice_number").each(function (e) {
//            $(this).attr("checked", "checked");
//        });

            $("#errorDiv").html('<img style=";padding: 0px 10px;" src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loading.gif"/>');
            var data = $("#frmReport").serialize();

            var url = '<?php echo Yii::app()->request->baseUrl . '/customer/send_receiable_report'; ?>';
            $.post(url, data, function (resp) {
                $("#errorDiv").html('<p style="color:green"><Email sent successfully.</p>');
//            if (resp == "DONE1") {
//                $("#errorDiv").html('<p style="color:green"><Email sent successfully.</p>');
//            } else {
//                $("#errorDiv").html('<p style="color:red">Error occered.Please try again after sometime.</p>');
//            }
            });
        });
    });
</script>
           <?php endif; ?>