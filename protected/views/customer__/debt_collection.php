<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            cellColorScheme: "armygreen",
            target: "payment_date",
            dateFormat: "%Y-%m-%d",
        });
    };
</script>
<script type="text/javascript">

    $(function () {
        $(".show_note").live('click', function (e) {
            e.preventDefault();
            var cus_id = $(this).attr("data-id");
            $('#addNoteDiv').hide();
            $("#errorDiv").html("");
            var url = '<?php echo Yii::app()->request->baseUrl . '/customer/customernotes'; ?>';
            $.post(url, {customer_id: cus_id}, function (resp) {
                $("#pre_customer_comments").html(resp);
                $("#customer_id").val(cus_id);
                $.magnificPopup.open({
                    type: 'inline',
                    items: {
                        src: "#customer_note"
                    },
                    callbacks: {
                        beforeOpen: function (e) {
                            this.st.mainClass = "mfp-rotateLeft";
                        }
                    },
                    midClick: true
                });
            });

        });

        $("#showFrm").live('click', function (e) {
            e.preventDefault();
            $("#errorDiv").html("");
            $(".datafield").val("");
            $('#addNoteDiv').toggle();
        });


        $("#addNote").live('click', function (e) {
            e.preventDefault();
            var error = 0;
            $(".datafield").each(function (e) {
                if ($(this).val() == "") {
                    error = 1;
                }

            });
            if (error == 1) {
                $("#errorDiv").html('<h3 style="color:#900000">Please enter date and write the note.</h3>');
            } else {
                var data = $("#add_frm").serialize();
                var url = '<?php echo Yii::app()->request->baseUrl . '/customer/add_note'; ?>';
                $.post(url, data, function (resp) {
                    if (resp != "DONE") {
                        $("#errorDiv").html('<h3 style="color:#900000">' + resp + '</h3>');

                    } else {
                        $("#addNoteDiv").hide();
                        $("#errorDiv").html('<h3 style="color:green"> Successfully added your Note.</h3>');
                        $("#pre_customer_comments").html("Loading...");
                        var cus_id = $("#customer_id").val();
                        var url = '<?php echo Yii::app()->request->baseUrl . '/customer/customernotes'; ?>';
                        $.post(url, {customer_id: cus_id}, function (resp) {
                            $("#pre_customer_comments").html(resp);


                        });
                    }
                });
            }
        });

    });

</script>
<div style="width:700px;margin: 0 auto;background: #FFF;padding: 15px;min-height: 500px;position: relative;" class="popup-basic admin-form mfp-with-anim mfp-hide" id="customer_note">

    <h3 style="margin-bottom:15px;">Dept Collection Note <span style="background: #0066cc;border-radius: 10px;margin-left: 10px;padding: 5px 20px;color: #FFF;" id='showFrm' ><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" width="24" alt="Add Note">  Add Note</span></h3>
    <form method="post" id="add_frm" action="#">
        <div style="width: 100%;min-height: 250px;padding-top: 15px;display: none;" id="addNoteDiv">

            <input type="hidden" id="customer_id" name="Note[customer_id]" value="0"> 
            <input type="text" id="payment_date" placeholder="Promise Date" class='datafield' name="Note[payment_date]" style="font-size: 15px;height: 35px; width: 200px;padding-left: 10px;float: left;margin-bottom: 10px;" value='<?php echo date("Y-m-d"); ?>'> 
            <textarea name="Note[notes]" rows="4"  placeholder="Write some note..." class='datafield' style="width:95%;padding: 15px;font-family: tahoma;font-style: italic;"></textarea>
            <a id='addNote' style="cursor: pointer;padding: 12px;width: 200px;text-align: center;float: right;background: #06c;color: #FFF;border: 0px;margin-right: 0px;margin-top: 10px;" > SUBMIT NOTE </a> 
        </div>
        <div style="position: relative;width: 100%;" id='errorDiv'>
        </div>
        <div style="position: relative;width: 100%;" id='pre_customer_comments'>
        </div>
    </form> 
</div>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Debt Collection Report  </td>
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
        <input type="hidden" name="end_date" value="<?php echo $end_date; ?>">
    </form>
    <td id="item_table">

        <div style="clear: both"></div>
        <div id="ptable3">
            <div id="table_holder">
                <form id="reciveInvoice" method="post" action="<?php echo Yii::app()->request->baseUrl . '/customer/bulk_receive/' ?>">
                    <table class="tablesorter" id="sortable_table" style="width:100%">
                        <thead>
                            <tr>
                                <th width="30%" scope="col">Customer</th>                                                                                    
                                <th width="20%" scope="col">Phone</th>
                                <th width="20%" scope="col">Due</th>
                                <th width="15%" scope="col">Payment Date</th>
                                <th width="15%" scope="col">&nbsp;</th>
                            </tr>
                        </thead>
                        <?php if (count($model)): ?>
                            <?php
                            $i = 1;
                            $grand_total = 0;
                            $pay_total = 0;
                            $due_total = 0;
                            foreach ($model as $customer_id => $posValues):
                                //    echo '<pre>';
                                //  print_r($posValues);
                                // exit();

                                $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                                $customers = Customer::model()->findAll($q1);
                                if (count($customers)):
                                    foreach ($customers as $customer):
                                        $customer_name = $customer->customer_name;
                                        $customer_mobile = $customer->contact_no1;
                                    endforeach;
                                else:
                                    $customer_name = "";
                                    $customer_mobile = "";
                                endif;
                                $pay_date = $accountSummary[$customer_id]['payment_date'] ? date("d/m/Y",strtotime($accountSummary[$customer_id]['payment_date'])):"N/A";
                                
                                ?>
                                <tbody>
                                    <?php  if($pay_date != 'N/A' && $accountSummary[$customer_id]['payment_date'] < date('Y-m-d',strtotime("NOW"))): ?>
                                    <tr style="background:#900000;color: #FFF;">
                                        <td style="cursor: pointer" onclick="$('.details_<?php echo $customer_id ?>').toggle()"><?php echo $customer_name ?></td>
                                        <td><?php echo $customer_mobile; ?></td>
                                        <td>&pound;<?php echo number_format($accountSummary[$customer_id]['total'] - $accountSummary[$customer_id]['paid'], 2) ?></td>
                                        <td><?php  echo $pay_date;  ?></td>
                                        <td  data-id="<?php echo $customer_id ?>" class="show_note" style="cursor: pointer"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="Note" width="16">  </td>
                                    </tr>
                                    <?php else: ?>
                                      <tr>
                                        <td style="cursor: pointer" onclick="$('.details_<?php echo $customer_id ?>').toggle()"><?php echo $customer_name ?></td>
                                        <td><?php echo $customer_mobile; ?></td>
                                        <td>&pound;<?php echo number_format($accountSummary[$customer_id]['total'] - $accountSummary[$customer_id]['paid'], 2) ?></td>
                                        <td><?php  echo $pay_date;  ?></td>
                                        <td  data-id="<?php echo $customer_id ?>" class="show_note" style="cursor: pointer"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="Note" width="16">  </td>
                                    </tr>
                                    
                                    <?php endif; ?>
                                </tbody>

                                <tbody class="details_<?php echo $customer_id; ?>" style="display: none">
                                    <tr>
                                        <th width="15%" scope="col" style="background: #06c !important;">Invoice No</th>                                                
                                        <th width="20%" scope="col" style="background: #06c !important;">Date</th>
                                        <th width="20%" scope="col" style="background: #06c !important;">Total Amount</th>
                                        <th width="10%" scope="col" style="background: #06c !important;">Paid Amount</th>
                                        <th width="15%" scope="col" style="background: #06c !important;">Due</th>
                                    </tr>
        <?php foreach ($posValues as $posValue): ?>


                                        <tr style="font:Verdana; font-size:11px">
            <?php
            $due = $posValue->amount_grand_total - $posValue->paid_amount;
            ?>
                                            <td>  
                                                <a href="<?php echo Yii::app()->request->baseUrl . '/sell/view/' . preg_replace("/[^0-9]/", '', $posValue->invoice_no); ?>"
                                                   target="_blank"><?php echo $posValue->invoice_no; ?> <?php echo $posValue->cash_sell == 1 ? " (CASH)":" (ACCOUNT)" ?></a>
                                            </td>                                            
                                            <td><?php echo date('M d, Y', strtotime($posValue->order_date)); ?></td>
                                            <td><?php echo '&pound; ' . number_format($posValue->amount_grand_total, 2); ?></td>
                                            <td><?php echo '&pound; ' . number_format($posValue->paid_amount, 2); ?></td>
                                            <td><a href="<?php echo Yii::app()->request->baseUrl . '/customer/receive_add/' . $posValue->invoice_no; ?>" target="_blank" <?php  if($posValue->cash_sell != 1): ?> style="background:#06c;color: #FFF;" <?php else: ?> style="background: #FFD324;color: #000;" <?php endif; ?>>
                                                <?php echo '&pound; ' . number_format($due, 2); ?></a></td>

                                        </tr>
            <?php
            $i = $i + 1;
            $grand_total = $grand_total + $posValue->amount_grand_total;
            $pay_total = $pay_total + $posValue->paid_amount;
            $due_total = $due_total + $due;

        endforeach;
        ?>
                                </tbody>



    <?php endforeach; ?>   
                            <tr>
                                <td>&nbsp;</td>
                                <td><strong><?php echo "Total &pound; " . number_format($grand_total, 2); ?></strong></td>
                                <td><strong><?php echo "Total &pound; " . number_format($pay_total, 2); ?></strong></td>
                                <td colspan="2"><strong><?php echo "Total &pound; " . number_format($due_total, 2); ?></strong></td>
                            </tr>
<?php else: ?>
                            <tr><div id="message-red"><td colspan="7" class="red-left">No Receiable Amount Available Yet </td></div></tr>
                        <?php endif; ?>

                    </table> 
                </form>
            </div>
        </div>
    </td>
</tr>
</tbody></table>
<div id="feedback_bar"></div>
