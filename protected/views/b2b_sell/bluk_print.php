<style>
    body {
        font-family: Tahoma, serif;
        background: none;
        color: black;
/*        width: 595px;*/
        margin:0 auto;
        padding-top: 10px;
    }
    #page {
        width: 100%;
        margin: 0; padding: 0;
        background: none;
    } 
    .entry a:after {
        content: " [" attr(href) "] ";
    }
    *{
        margin: 0px;
        padding: 0px;
    }    
</style>
<div id="printReport">
    
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
  
    
  <?php echo '<h3>TO<span style="float:right;font-size: 13px;font-weight: bold;">Date : '.date("d-m-Y",strtotime("NOW")).'</span><h3>';
                    echo '<h3>' . $Customers->business_name . '<span style="float:right;font-size: 17px;font-weight: bold;"> ACCOUNT BALANCE STATEMENT</span></h3>';
                    echo '<p>' . $Customers->business_street1 . ' ' . $Customers->business_street2 . ' <br>' . $Customers->business_city . '<br>' . strtoupper($Customers->business_post_code) . '<br>';
                    echo 'Phone: ' . $Customers->contact_no2 . '</p><br><br>';
                    ?>
                    <table width="100%" cellpadding="2" cellspacing="3" border="1" style="border-collapse:collapse;font-family:Verdana; font-size:13px;" >
                        <tr>
                            <td width="20%"  align="left">&nbsp;<strong>INVOICE</strong></td>
                            <td width="20%" align="left">&nbsp;<strong>DATE</strong></td>
                            <td width="20%" align="left">&nbsp;<strong>TOTAL </strong></td>
                            <td width="20%" align="left">&nbsp;<strong>PAID</strong></td>
                            <td width="20%" align="left">&nbsp;<strong>DUE</strong></td>
                        </tr>
                    <?php
                    }
                endforeach;
            endif;
        endif;
        ?>
        <tr>
            <td style="padding: 5px;"><?php echo $invoice['invoice_no']; ?></td>

            <td style="padding: 5px;"><?php echo date('M d, Y', strtotime($invoice['order_date'])); ?></td>
            <td style="padding: 5px;text-align: right;"><?php echo '&pound;' . number_format($invoice['amount_grand_total'], 2); ?></td>
            <td style="padding: 5px;text-align: right;"><?php echo '&pound;' . number_format($invoice['paid_amount'], 2); ?></td>
            <td style="padding: 5px;text-align: right;"><?php echo '&pound;' . number_format(($invoice['amount_grand_total'] - $invoice['paid_amount']), 2); ?></td>


        </tr>

    <?php
    $amount +=  $invoice['amount_grand_total'];
    $total_paid += $invoice['paid_amount'];
    
    $inc++;
endforeach; ?>
           <tr> 
               <td colspan="4" align="right" style="font-weight:bold;text-align: right;font-size: 15px;"> TOTAL </td>
             <td style="padding: 5px;text-align: right;font-weight: bold;font-size: 15px;"><?php echo '&pound;' . number_format(($amount - $total_paid), 2); ?></td>


        </tr>
</table> 

</div>
    
