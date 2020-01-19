<div align="center" style="margin: 20px;">
    <h3>
        Daily Sell Report <?php echo  isset($_POST['start_date']) ? 'For Date ' . date('d/m/Y', strtotime($_POST['start_date'])) : '' ?><?php echo  $_POST['end_date'] ? ' to ' . date('d/m/Y', strtotime($_POST['end_date'])) : '' ?>
        <a id="printDailyReport" class="__gcp_button_cls" href="javascript:void(0)" style="float:right">Print</a>
    </h3>
    <br/>
    <div id="tblOrderReport">
    <table cellspacing="0" style="font-size: 12px; font-family: Verdana">
        <tr>
            
            <th>Report Summary</th>            
        </tr>
        <?php $total_cash = $total_cheque = $total_card = $total_vat = 0; ?>
        <?php $cnt=0; $total=0;  foreach($orders as $date=>$order )  : $total+=$order['total_amount'];  ?>
            <?php $change_amt = $order['total_paid_amount'] > $order['total_amount'] ? $order['total_paid_amount'] - $order['total_amount'] : 0 ?>

            <tr>
                <td style="width: 100%; height: 5px; border-top: 1px dashed">&nbsp;</td>
            </tr>
            <tr>
                             
                <td>
                    <?php echo  date("d/m/y", strtotime($date)) ?>,
                
                    CASH:&pound;<?php echo number_format($order['cash_amount']-$change_amt,2) ?>&nbsp;&nbsp;
                    CHEQ:&pound;<?php echo number_format($order['cheque_amount'],2) ?>&nbsp;&nbsp;
                    CARD:&pound;<?php echo number_format($order['card_amount'],2) ?>&nbsp;&nbsp;
                    VAT:&pound;<?php echo number_format($order['total_vat'],2) ?>&nbsp;&nbsp;
                    
                    <?php $total_cash += $order['cash_amount']-$change_amt; ?>
                    <?php $total_card += $order['card_amount']; ?>
                    <?php $total_cheque += $order['cheque_amount']; ?>
                    <?php $total_vat += $order['total_vat']; ?>
                    
                    <span style="float:right; font-weight: bold">TOTAL:&pound;<?php echo  number_format($order['total_amount'],2) ?> </span>
                </td>
            </tr>

        <?php endforeach; ?>
            <tr>
                <td ><hr/></td>
            </tr>
            <tr>                
                <td align="right">
                    
                    <b>Total Cash : &pound;<?php echo number_format($total_cash,2); ?></b> <br/>
                    <b>Total Card : &pound;<?php echo number_format($total_card,2); ?></b> <br/>
                    <b>Total Cheque : &pound;<?php echo number_format($total_cheque,2); ?></b> <br/>
                    <hr style="width: 100%" />
                    <b>Total VAT : &pound;<?php echo number_format($total_vat,2); ?></b> <br/>
                    <hr style="width: 100%" />
                    <b>Total Amount : &pound;<?php echo number_format($total,2); ?></b> 
                    
                </td>
            </tr>


    </table>
    </div>
</div>

<div id="printReportContent" style="display: none">
    <div align="center" style="margin-bottom:10px;">        
        <?php $criteria = new CDbCriteria(); $criteria->order = 'id DESC'; $criteria->limit = 1; $company = Company::model()->find($criteria); ?>
        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:11px;margin-bottom:10px; margin-left:10px;">
        
            <tr>
                <td width="10%" rowspan="2" valign="top"><img src="<?php echo Yii::app()->request->baseUrl.'/public/photos/company/'.$company->company_logo; ?>" height="70" alt=""  /></td>
                <td width="55%">
                    <p style="margin-right:30px;"><font style="font-size:15px; font-weight:bold;"><?php echo ucwords($company->company_name); ?></font><br />
                        <?php echo $company->address."<br/> ".$company->contact_no.". <br/> ".$company->email_address.".<br/> ".$company->website; ?></p>
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
        
        <tr>
            <td colspan="3">
                <h3>Daily Sell Report <?php echo  isset($_POST['start_date']) ? 'For Date ' . date('d/m/Y', strtotime($_POST['start_date'])) : '' ?><?php echo  $_POST['end_date'] ? ' to ' . date('d/m/Y', strtotime($_POST['end_date'])) : '' ?></h3>
            </td>
        </tr>
        
    </table>
        
    </div>
</div>

<script type="text/javascript">
    function printDiv(content) {
        var mywindow = window.open('', 'Daily Report', 'height=400,width=300,allowscrollbar=yes');
        mywindow.document.write('<html><head><title>Daily Order Report</title>');        
        mywindow.document.write(content);        
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

    $(document).ready(function(){        
        $("#printDailyReport").click(function(e){            
            
            $("#printReportContent").append($("#tblOrderReport").html());
            printDiv($("#printReportContent").html());

        });
    });
</script>
