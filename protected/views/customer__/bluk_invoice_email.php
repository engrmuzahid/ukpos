<!DOCTYPE html>
<html>
    <head>
        <title>Sylhet cush & curry</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <style type="text/css">
            /* CLIENT-SPECIFIC STYLES */
            body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
            table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} /* Remove spacing between tables in Outlook 2007 and up */
            img{-ms-interpolation-mode: bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

            /* RESET STYLES */
            img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}
            table{border-collapse: collapse !important;}
            body{height: 100% !important; margin: 0 auto !important; padding: 0 !important; width: 500px !important;}

            /* iOS BLUE LINKS */
            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }

            /* MOBILE STYLES */
            @media screen and (max-width: 525px) {

                /* ALLOWS FOR FLUID TABLES */
                .wrapper {
                    width: 100% !important;
                    max-width: 100% !important;
                }

                /* ADJUSTS LAYOUT OF LOGO IMAGE */
                .logo img {
                    margin: 0 auto !important;
                }

                /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
                .mobile-hide {
                    display: none !important;
                }

                .img-max {
                    max-width: 100% !important;
                    width: 100% !important;
                    height: auto !important;
                }

                /* FULL-WIDTH TABLES */
                .responsive-table {
                    width: 100% !important;
                }

                /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
                .padding {
                    padding: 10px 5% 15px 5% !important;
                }

                .padding-meta {
                    padding: 30px 5% 0px 5% !important;
                    text-align: center;
                }

                .padding-copy {
                    padding: 10px 5% 10px 5% !important;
                    text-align: center;
                }

                .no-padding {
                    padding: 0 !important;
                }

                .section-padding {
                    padding: 50px 15px 50px 15px !important;
                }

                /* ADJUST BUTTONS ON MOBILE */
                .mobile-button-container {
                    margin: 0 auto;
                    width: 100% !important;
                }

                .mobile-button {
                    padding: 15px !important;
                    border: 0 !important;
                    font-size: 16px !important;
                    display: block !important;
                }

            }

            /* ANDROID CENTER FIX */
            div[style*="margin: 16px 0;"] { margin: 0 !important; }
        </style>
    </head>
    <body style="margin: 0 auto !important; padding: 0 !important;">
        <div style="height:130px;width: 500px;background: #cccccc;">
        <div style="width:120px;float:left"> <a href="http://sylhetshop.co.uk" target="_blank">
                <img alt="Logo" src="http://sylhetshop.co.uk/theme/webmarket_theme/images/logo.png" style="display: block;width: 100px;font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
            </a> 
        </div>
        <div style="float:left;text-align: right;width: 340px;"> 
            <h1> ACCOUNT STATEMENT</h1>
        </div>    
        </div>
        <div style="clear:both"></div>
   <div style="width: 500px;padding: 5px;">
        <?php
        $inc = 0;
        $amount = $total_paid = 0;
        foreach ($model as $invoice):

            $customer_name = "";
            if (!empty($invoice['customer_id'])):
                $customer_id = $invoice['customer_id'];
                $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                $Customers = Customer::model()->findAll($q1);
                if (count($Customers)):
                    foreach ($Customers as $Customers):
                        if ($inc < 1) {
                            ?>
                            <div style="width:50%;float:left;text-align: left;margin-top:-100px;">
                                <p><?php echo $Customers->business_name; ?>,<br>
                    <?php echo $Customers->business_street1 . ' ' . $Customers->business_street2 . ' <br>' . $Customers->business_city . ',' . strtoupper($Customers->business_post_code); ?>
                                    <br><?php echo 'Phone: ' . $Customers->contact_no2; ?>
                                </p>
                            </div> 

       <table cellpadding="0" cellspacing="0" border="0" width="480" style="margin-top:-100px;">
                                <tr style="background: #EDEDED">
                                    <td align="left" style="background: #EDEDED;width: 30%;font-family: Arial, sans-serif; color: #333333; font-size: 16px;padding: 5px;">INVOICE NO </td>
                                    <td align="right" style="background: #EDEDED;width: 30%;font-family: Arial, sans-serif; color: #333333; font-size: 16px;padding: 5px;">TOTAL</td>
                                    <td align="right" style="background: #EDEDED;width: 20%;font-family: Arial, sans-serif; color: #333333; font-size: 16px;padding: 5px;">PAID</td>
                                    <td align="right" style="background: #EDEDED;width: 20%;font-family: Arial, sans-serif; color: #333333; font-size: 16px;padding: 5px;">DUE</td>
                                </tr>  
                                <?php
                            }
                        endforeach;
                    endif;
                endif;
                ?> <tr>
                    <td align="left" style="width:30px;font-family: Arial, sans-serif; color: #333333; font-size: 16px;padding: 5px;"><?php echo $invoice['invoice_no']; ?></td>

                    <td  style="width: 30%;font-family: Arial, sans-serif; color: #333333; font-size: 16px;text-align: right;padding: 5px;"><?php echo '&pound;' . number_format($invoice['amount_grand_total'], 2); ?></td>
                    <td  style="width: 20%;font-family: Arial, sans-serif; color: #333333; font-size: 16px;text-align: right;padding: 5px;"><?php echo '&pound;' . number_format($invoice['paid_amount'], 2); ?></td>
                    <td  style="width: 20%;font-family: Arial, sans-serif; color: #333333; font-size: 16px;text-align: right;padding: 5px;"><?php echo '&pound;' . number_format(($invoice['amount_grand_total'] - $invoice['paid_amount']), 2); ?></td>
                </tr>
                <?php
                $amount += $invoice['amount_grand_total'];
                $total_paid += $invoice['paid_amount'];

                $inc++;
            endforeach;
            ?>
            <tr>   
                <td align="right" colspan="3" style="color:red;font-weight: bold;width: 80%;font-family: Arial, sans-serif; font-size: 18px;padding: 5px;">Total</td>
                <td align="right" style="color:red;font-weight: bold;width: 20%;font-family: Arial, sans-serif;font-size: 18px;padding: 5px;"><?php echo '&pound;' . number_format(($amount - $total_paid), 2); ?></td>
            </tr>
        </table>

    </div>
    
    
        <div style="clear:both"></div>
   <div style="width: 500px;text-align: center;">
        <a href="tel:+441912736664"  style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none;background: #00CC00; color: #ffffff; text-decoration: none; border-radius: 3px; padding: 15px 25px; border: 1px solid #256F9C; display: inline-block;" class="mobile-button">CALL  US </a>
   </div>
        
        <div style="clear:both"></div>
  <div style="width: 500px;"> 
        <table width="480" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 500px;" class="responsive-table">
            <tr>
                <td align="center" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                    Lynnwood Terrace, 
                    Newcastle upon Tyne NE4 6UL, 
                    United Kingdom
                    <br>
                    <a href="tel:+441912736664" target="_blank" style="color: #666666; text-decoration: none;"> +44 191 273 6664 </a>
                    <span style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                    <a href="http://sylhetshop.co.uk/" target="_blank" style="color: #666666; text-decoration: none;"> SYLHET CASH AND CURRY </a>
                </td>
            </tr>
        </table>
  </div>
</body>
</html>
