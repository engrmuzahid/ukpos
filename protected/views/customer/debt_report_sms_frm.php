<div style="width:700px;margin: 0 auto;background: #FFF;padding: 15px;min-height: 400px;border:10px solid #ccc;" class="popup-basic admin-form mfp-with-anim mfp-hide" id="customer_popup_frm">
    <?php
    $balance = $sms_balance['credit'] - $sms_balance['debit'];

    if ($balance > 0):
        ?>

        <h3 style="text-align: center;">Available SMS Credit: <?php echo $balance; ?></h3>
        <form method="post" id="smsfrm" action="#">
            <div style="width: 50%;height: 50px;padding-top: 15px;float: left;">
                SMS TO :   <input type="text" value="<?php echo $customer['contact_no1']; ?>" id="customer_number" class="search_customer"   name="number" style="height: 30px; width: 205px;margin-left: 10px;padding-left: 10px;font-size: 14px;" > 
            </div>
            <div style="width: 50%;height: 50px;padding-top: 15px;float: left;">

                SENDER NAME :  <input type="text" value="SYLHETSHOP" class="search_customer"   name="sender" style="height: 30px; width: 200px;margin-left: 0px;padding-left: 10px;font-size: 14px;" > 
            </div>
            <input type="hidden" value="<?php echo $customer['id']; ?>"   name="customer_id"  > 
            <div>
                <textarea name="smsText" id="smstext" rows="13" style="width: 90%;padding: 15px;font-family: verdana;font-size: 12px;">
We have not received your payment as agreed. The total outstanding balance is £<?php echo number_format($amount, 2); ?>. To make a payment please call us on 01912736664 
                </textarea>
            </div>
            <br/>
            <input type="button" value="SEND SMS" style="width:140px;margin-top: 20px;" class="buttonGreen" id="sendSmsBtn"/>
            <div style="float: right;">
                <span id="msgalert" style="color: black;" data-msgcnt="0">1 message</span>
                <span id="msglen" style="color: black;" >0 Character</span> 
            </div>
            <input type="hidden" name="sms_count" id="sms_count" value="1"/>
            <input type="hidden" name="balance_id" value="<?php echo $sms_balance['id']; ?>"/>
            <input type="hidden" name="balance" value="<?php echo $sms_balance['debit']; ?>"/>
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


            $("#sendSmsBtn").die("click").live("click", function (e) {
                e.preventDefault();
                var customer_number = $("#customer_number").val();
                if (customer_number.length == 11 &&  customer_number.substr(0, 2).toString() == "07") {
                    var data = $("#smsfrm").serialize();
                    $.post('<?php echo Yii::app()->request->baseUrl . "/customer/sendSmsToCustomer"; ?>', data, function (resp) {
                        if (resp == "DONE") {
                            $("#smsfrm").hide();
                            $("#alertDiv").html('<h3 style="color:green;padding:50px;">Successfully send SMS.</h3>');
                        } else {
                            $("#alertDiv").html('<p style="color:red;">' + resp + '</p>');
                        }
                    });
                } else {
                    alert("Incorrect Phone Number ! Please Enter correct Number.\n\n\t\t\t\tEg. 07xxxxxxxxx");

                }

            });


        });
    </script>


<?php else: ?>
    <h3 style="text-align: center;color: red;">There are no SMS credit. </h3>

<?php endif; ?>
