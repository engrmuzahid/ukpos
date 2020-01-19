<div style="width:700px;margin: 0 auto;background: #FFF;padding: 15px;min-height: 400px;border:10px solid #ccc;" class="popup-basic admin-form mfp-with-anim mfp-hide" id="customer_popup_frm">
    <?php
    $balance = $sms_balance['credit'] - $sms_balance['debit'];

    if ($balance > 0):
        ?>

        <h3 style="text-align: center;">Available SMS Credit: <?php echo $balance; ?></h3>
        <form method="post" id="smsfrm" action="#">
            <div style="width: 50%;height: 50px;padding-top: 15px;float: left;">
                SMS TO : 
                <?php
                $inc = 1;
                foreach ($customers as $customer):
                    ?>

                    <div style="font-size: 10px;">
                        <div style="width: 40%;float: left;"><?php echo $inc . '. ' . $customer['customer_name']; ?> </div>
                        <div style="padding-left: 10px;float: left;">
                            <?php if (substr($customer['contact_no1'], 0, 2) == "07" && strlen($customer['contact_no1']) == 11): ?>
                                <?php echo $customer['contact_no1']; ?>
                                <input type="hidden" value="<?php echo $customer['contact_no1']; ?>"   name="phones[]"  >    
                            <?php endif; ?>


                            <?php if (substr($customer['contact_no2'], 0, 2) == "07" && strlen($customer['contact_no2']) == 11): ?>
                                <?php echo $customer['contact_no2']; ?>
                                <input type="hidden" value="<?php echo $customer['contact_no2']; ?>"   name="phones[]"  >    
                            <?php endif; ?>

                        </div>
                    </div>

                    <?php
                    $inc++;
                endforeach;
                ?>

            </div>
            <div style="width: 50%;padding-top: 15px;float: left;">
                <textarea name="smsText" id="smstext" rows="13" style="width: 90%;padding: 15px 5px;font-family: verdana;font-size: 12px;">We have not received your payment as agreed.  To make a payment please call us on 01912736664 
                </textarea>
            </div>

            <div style="float: right;">
                <span id="msgalert" style="color: black;" data-msgcnt="0">1 message</span>
                <span id="msglen" style="color: black;" >0 Character</span> 
            </div>

            <input type="hidden" value=""   name="customer_id"  > 

            <div  style="width: 50%;float: left;padding-top: 70px;">
                SENDER NAME :  <input type="text" value="SYLHETSHOP" class="search_customer"   name="sender" style="height: 30px; width: 200px;margin-left: 0px;padding-left: 10px;font-size: 14px;" > 

            </div>
            <div  style="width: 50%;float: right; padding-top: 55px;">

                <input type="button" value="SEND SMS" style="width:140px;float: right;cursor: pointer;" class="buttonGreen" id="ConfirmSendSmsBtn"/>
            </div>
            <input type="hidden" name="sms_count" id="sms_count" value="1"/>
        </form>
        <div id="alertDiv"></div>
    </div>
    <script>
        function check_count() {
            var limit = 160;
            var len = $('#smstext').val().length;
            if (len > 0) {
                $("#msgalert").html("1 message");
            }
            if (limit < len) {
                var calculation = parseInt((len / limit));
                calculation += 1;
                $("#msgalert").html(calculation + " message");
                $("#sms_count").val(calculation);
            }
            $("#msglen").html(len + " Character");
        }
        $(document).ready(function ()
        {

            check_count();
            
             $('#smstext').keyup(function () {
                check_count();

            });
            $("#ConfirmSendSmsBtn").die("click").live("click", function (e) {
                e.preventDefault();
                var data = $("#smsfrm").serialize();
                $.post('<?php echo Yii::app()->request->baseUrl . "/customer/SendbulkSms"; ?>', data, function (resp) {
                    if (resp == "DONE") {
                        $("#smsfrm").hide();
                        $("#alertDiv").html('<h3 style="color:green;padding:50px;">Successfully send SMS.</h3>');
                    } else {
                        $("#alertDiv").html('<p style="color:red;">' + resp + '</p>');
                    }
                });
            });





        });
    </script>


<?php else: ?>
    <h3 style="text-align: center;color: red;">There are no SMS credit. </h3>

<?php endif; ?>
