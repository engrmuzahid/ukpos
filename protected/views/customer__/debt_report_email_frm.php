<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.jqprint.0.3.js"></script><div style="width:700px;margin: 0 auto;background: #FFF;padding: 15px;min-height: 400px;border:10px solid #ccc;" class="popup-basic admin-form mfp-with-anim mfp-hide" id="customer_popup_frm">
  <form method="post" id="emailfrm" action="#">
      
      
      <div style="width: 50%;height: 50px;padding-top: 15px;float: left;">
          EMAIL TO :  <input type="text" value="<?php echo $customer['email_address']; ?>" class="search_customer"   name="email" style="height: 30px; width: 200px;margin-left: 0px;padding-left: 10px;font-size: 14px;" > 
          </div>
       <div style="width: 50%;height: 50px;padding-top: 15px;float: left;">
         SUBJECT :   <input type="text" value="ACCOUNT STATEMENT" class="search_customer"   name="subject" style="height: 30px; width: 205px;margin-left: 10px;padding-left: 10px;font-size: 14px;" > 
          </div>
      <input type="hidden" value="<?php echo $customer['id']; ?>"   name="customer_id"  > 
      <input type="hidden" value="Send Email"   name="note_type"  > 
       
      <div>
          <textarea name="emailText" id="emailText" rows="22" style="width: 90%;padding: 15px;font-family: verdana;font-size: 12px;">
TO,
<?php echo $customer['business_name']; ?>

<?php echo $customer['business_street1']; ?>  <?php echo $customer['business_street2']; ?> 
<?php echo $customer['business_city']; ?> <?php echo $customer['business_post_code']; ?>

Date : <?php echo date("d-m-Y",  strtotime("NOW")); ?>


Dear Sirs,
Outstanding Account Value: <?php echo '&pound;' . number_format(($customer['grand_total'] - $customer['amount']), 2) ?>

The above sum was due for payment on <?php echo $last_receive_date; ?> but as at today's date no payment has been received.

Should your company have any legitimate reason for non-payment, please contact us within the next seven days.
 
Should no query exist please be aware our payment terms are strictly 07 days and we make no provision for extended credit terms in our pricing structure.

Kind Regards
Credit Control Team
SYLHET CASH AND CURRY 
Lynnwood Terrace, 
Newcastle upon Tyne NE4 6UL, 
United Kingdom.

Phone number: +44 191 273 6664 
Email: info@sylhetshop.co.uk

          </textarea>
          
      </div>
      
      <div style="display: none;border: 0px;" id="printEmail" >
        
<br/><br/>
<br/><br/>
<br/><br/>
<br/><br/>  <h3>      TO,<br>
<?php echo $customer['business_name']; ?><br>

<?php echo $customer['business_street1']; ?>  <?php echo $customer['business_street2']; ?> <br>
<?php echo $customer['business_city']; ?> <?php echo $customer['business_post_code']; ?><br>
</h3>
          <h4>Date : <?php echo date("d-m-Y",  strtotime("NOW")); ?></h4>


          <b>Dear Sirs,</b><br/>
<b>Outstanding Account Value: <?php echo '&pound;' . number_format(($customer['grand_total'] - $customer['amount']), 2) ?>
</b>
<p>The above sum was due for payment on <?php echo $last_receive_date; ?> but as at today's date no payment has been received.
</p>
<p>Should your company have any legitimate reason for non-payment, please contact us within the next seven days.
 </p>
<p>Should no query exist please be aware our payment terms are strictly 07 days and we make no provision for extended credit terms in our pricing structure.
</p>
<br/><br/>
<h4>
Kind Regards<br/>
Credit Control Team<br/>
SYLHET CASH AND CURRY <br/>
Lynnwood Terrace, <br/>
Newcastle upon Tyne NE4 6UL, <br/>
United Kingdom.<br/><br/>

Phone number: +44 191 273 6664 <br/>
Email: info@sylhetshop.co.uk</h4>
      </div>
      
      <br/>
       <input type="button" value="SEND EMAIL" style="width:140px;margin-top: 20px;cursor: pointer;" class="buttonGreen" id="sendEmailBtn"/>
     <input type="button" value="PRINT" style="width:140px;margin-top: 20px;float: right;cursor: pointer;" class="buttonBlue" id="printEmailBtn"/>
    </form>  
     <div id="alertDiv"></div>
    
    
</div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#sendEmailBtn").die("click").live("click", function (e) {
            e.preventDefault();
            var data = $("#emailfrm").serialize(); 
            $.post('http://sylhetshop.co.uk/site/send_email_by_url', data, function (resp) {
               if(resp == "DONE"){
                   $("#emailfrm").hide();
                   $.post('<?php echo Yii::app()->request->baseUrl; ?>/customer/adddebtreort', data, function (resp) {
                        $("#alertDiv").html('<h3 style="color:green;padding:50px;">Successfully send email.</h3>');
                   });
               }else{
                     $("#alertDiv").html('<p style="color:red;">Error Occured.Please try again after sometime.</p>');
           
               }    
            });

        });
        
  $("#printEmailBtn").die("click").live("click", function (e) {
            e.preventDefault();
            
              $("#printEmail").show();
              $("#printEmail").jqprint();
              
              $("#printEmail").hide();
        });

    });

</script>