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
<div style="width:700px;border: 10px solid #ccc;margin: 0 auto;background: #FFF;padding: 15px;min-height: 500px;position: relative;" class="popup-basic admin-form mfp-with-anim mfp-hide" id="customer_note">

    <h3 style="margin-bottom:15px;">Dept Collection Note <span style="background: #468AF8;border-radius: 4px;margin-left: 10px;padding: 5px 20px;color: #FFF;" id='showFrm' ><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" width="24" alt="Add Note">  Add Note</span></h3>
   <hr/>
    <form method="post" id="add_frm" action="#">
        <div style="position: relative;width: 100%;" id='errorDiv'>

        </div>
 <div style="width: 100%;min-height: 250px;padding-top: 15px;display: none;" id="addNoteDiv">

            <input type="hidden" id="customer_id" name="Note[customer_id]" value="0"> 
            <input type="text" id="payment_date" placeholder="Promise Date" class='datafield' name="Note[payment_date]" style="font-size: 15px;height: 35px; width: 200px;padding-left: 10px;float: left;margin-bottom: 10px;" value='<?php echo date("Y-m-d"); ?>'> 
            <textarea name="Note[notes]" rows="4"  placeholder="Write some note..." class='datafield' style="width:95%;padding: 15px;font-family: tahoma;font-style: italic;"></textarea>
            <a id='addNote' style="cursor: pointer;padding: 12px;width: 200px;text-align: center;float: right;background: #06c;color: #FFF;border: 0px;margin-right: 0px;margin-top: 10px;" > SUBMIT NOTE </a> 

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
            <td id="title">Debt Report  </td>
        </tr>
    </tbody>
</table>
<table id="title_bar">
    <tbody>
        <tr>
            <td>
                <p style="margin-bottom: 5px;width: 140px;padding: 25px;font-size: 20px;line-height: 25px;float: right;text-align: center;background:#31b0d5;color: #FFF;border-radius: 10px;"> CUSTOMERS <br><?php echo $cus_count; ?></p>
            </td> 
            <td>
                <p style="margin-bottom: 5px;width: 140px;padding: 25px 25px 15px 25px;font-size: 17px;line-height: 25px;float: right;text-align: left;background:#337ab7;color: #FFF;border-radius: 10px;">
                    A: £<?php echo number_format($weekly_acc_sell, 2); ?><br>
                    C: £<?php echo number_format($weekly_cash_sell, 2); ?>
                    <span style="font-size:11px;float: right;line-height: 0px;margin-top: 10px;">Last 7days sale</span>
                </p>

            </td> 
            <td>
                <p style="margin-bottom: 5px;width: 140px;padding: 25px;font-size: 20px;line-height: 25px;float: right;text-align: center;background:#449d44;color: #FFF;border-radius: 10px;"> <span style="font-size:13px;"> LAST 7DAYS INCOME </span> <br>£<?php echo number_format($weekly_income,2); ?></p>
            </td> 
            <td>
                <p style="margin-bottom: 5px;width: 140px;padding: 25px 25px 15px 25px;font-size: 17px;line-height: 25px;float: right;text-align: left;background:#ec971f;color: #FFF;border-radius: 10px;">
                    A: £<?php echo number_format($acc_balance, 2); ?><br>
                    C: £<?php echo number_format($cash_sell_balance, 2); ?>
                    <span style="font-size:11px;float: right;line-height: 0px;margin-top: 10px;"> Itemised due </span>
                </p>
            </td> 
            <td>
                <p style="margin-bottom: 5px;width: 140px;padding: 25px;font-size: 20px;line-height: 25px;float: right;text-align: center;background:#c9302c;color: #FFF;border-radius: 10px;">TOTAL DUE <br>£<?php echo number_format($total_due, 2); ?></p>
            </td> 

        </tr>
    </tbody>
</table>

<table id="contents">

    <tbody><tr>

            <td id="item_table" colspan="3">

                <div style="clear: both"></div>
                <div id="ptable3">
                    <div id="table_holder" style="width:100%;">
                        <form id="reciveInvoice" method="post" action="<?php echo Yii::app()->request->baseUrl . '/customer/bulk_receive/' ?>">
                            <table class="tablesorter" id="sortable_table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="20%" scope="col">Customer</th>                                                                                    
                                        <th width="10%" scope="col">Phone</th>
                                        <th width="20%" scope="col">Due</th>
                                        <th width="15%" scope="col">Total Due</th>
                                        <th width="20%" scope="col">Last Payment</th>
                                        <th width="15%"   scope="col">&nbsp;</th>
                                    </tr>
                                </thead>
                                <?php
                                if (count($customers)):
                                    foreach ($customers as $key => $cus_balance):
                                        ?>
                                        <tbody>
                                        <td><?php echo $cus_balance['name']; ?></td>
                                        <td><?php echo $cus_balance['phone']; ?></td>
                                        <td>
                                            <span style="cursor:pointer;" class="account_sell" data-type="cash" data-customer="<?php echo $key; ?>"><?php echo 'A: £' . number_format($cus_balance['acc_sell'], 2); ?></span>
                                            <br>
                                            <span style="cursor:pointer;" class="cash_sell" data-type="cash" data-customer="<?php echo $key; ?>"> <?php echo 'C: £' . number_format($cus_balance['cash_sell'], 2); ?></span>
                                        </td>
                                        <td>£<?php echo number_format($cus_balance['mainbalance'], 2); ?></td>
                                        <td><?php
                                            if (!empty($cus_balance['last_rec'])):
                                                $pay_mode = $cus_balance['last_rec']['receive_mode'];
                                                if ($pay_mode == "0") {
                                                    $pay_method = "Cash";
                                                } elseif ($pay_mode == "1") {

                                                    $pay_method = "Cheque";
                                                } elseif ($pay_mode == "2") {

                                                    $pay_method = "Card";
                                                } else {

                                                    $pay_method = "Cash";
                                                }
                                                echo '£' . number_format($cus_balance['last_rec']['amount'], 2) . '<span style="font-size:10px;"> (' . $pay_method . ')</span><br/>';
                                                ?>
                                                <span style="font-size:10px;background:<?php echo (date("Y-m-d", strtotime($cus_balance['last_rec']['receive_date'])) <= date("Y-m-d", strtotime("-28 day"))) ? "#900000;color:#FFF;" : "#FFF;"; ?>"><?php echo date("d-m-Y", strtotime($cus_balance['last_rec']['receive_date'])); ?> </span>
                                            <?php endif;
                                            ?>

                                        </td>
                                        <td style="width:80px;">

                                            <input type="image" style="height: 24px;" class="send_email_btn" data-customer="<?php echo $key; ?>"  src="<?php echo Yii::app()->request->baseUrl . '/public/images/email.png'; ?>" alt="Email" title="Email"  />
                                            <input type="image"  style="height: 24px;" class="send_sms_btn"  data-customer="<?php echo $key; ?>" data-amount="<?php echo $cus_balance['mainbalance']; ?>"   src="<?php echo Yii::app()->request->baseUrl . '/images/sms.jpg'; ?>" alt="print report" title="Print Report" />
                                            <input type="image"  style="height: 24px;" data-id="<?php echo $key ?>" class="show_note" style="cursor: pointer"   data-customer="<?php echo $key; ?>"   src="<?php echo Yii::app()->request->baseUrl . '/public/images/giftcards.png'; ?>" alt="show notes" title="show notes" />
                                 
                                        </td>
                                        </tbody>

                                    <?php endforeach; ?>   
                                    <thead>

                                    </thead>

                                <?php else: ?>
                                    <tr><div id="message-red"><td colspan="7" class="red-left">No Due Amount Available Yet </td></div></tr>
                                <?php endif; ?>

                            </table> 
                        </form>
                    </div>
                </div>
            </td>
        </tr>
    </tbody></table>
<div id="customer_popup">
</div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $(".send_email_btn").live("click", function (e){
            e.preventDefault();
            
            var customerId = $(this).attr("data-customer");
            var data = {"customerId": customerId}
            $.post('<?php echo Yii::app()->request->baseUrl . "/customer/customerEmailFrm"; ?>', data, function (resp) {
                $("#customer_popup").html(resp);
                 $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: "#customer_popup_frm"
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

         



        $(".send_sms_btn").live("click", function (e) {
            e.preventDefault();
            var customerId = $(this).attr("data-customer");
            var dataAmount = $(this).attr("data-amount");
            var data = {"customerId": customerId,"amount":dataAmount}
            $.post('<?php echo Yii::app()->request->baseUrl . "/customer/customerSendSms"; ?>', data, function (resp) {
                $("#customer_popup").html(resp);
                $.magnificPopup.open({
                    type: 'inline',
                    items: {
                        src: "#customer_popup_frm"
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



    });

</script>

