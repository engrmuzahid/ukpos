<html>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    </head>
    <body>
        <?php $customer = Customer::model()->findAllByPk($customer_id); ?>
 

        <?php
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->limit = 1;
        $companys = Company::model()->findAll($criteria);
 
        ?>
         <h2 style="color:#000000;font-size:15px;text-align: left;">
            Dear Customer <br>
            Please find account statement below.

        </h2>
        <div style="width: 700px;text-align: center;"><br><br><hr/><br><br></div>
        <table border="0" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:11px;margin-bottom:10px; margin-left:10px;width:700px;">
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
        <div style="clear: both"></div>
       
        <table cellspacing="0" cellpadding="10" style="color:#666;font:13px Arial;line-height:1.4em;width:700px;" border="1">
            <tbody>
                <tr>
                    <th width="15%" scope="col">Invoice No</th>                                                
                    <th width="20%" scope="col">Date</th>
                    <th width="15%" scope="col">Total Amount</th>
                    <th width="20%" scope="col">Paid Amount</th>
                    <th width="10%" scope="col">Due</th> 
                </tr>
                <?php foreach ($sells as $posValue): ?>
                    <tr style="font:Verdana; font-size:11px">
                        <td><?php echo $posValue->invoice_no; ?> </td>                                            
                        <td><?php echo date('M d, Y', strtotime($posValue->order_date)); ?></td>
                        <td><?php echo '&pound; ' . number_format($posValue->amount_grand_total, 2); ?></td>
                        <td><?php echo '&pound; ' . number_format($posValue->paid_amount, 2); ?></td>
                        <td>
                            <?php
                            $due = $posValue->amount_grand_total - $posValue->paid_amount;
                            echo '&pound; ' . number_format($due, 2);
                            ?>
                        </td>

                    </tr>
                    <?php
                endforeach;
                ?>
                <tr style="font:Verdana; font-size:13px">
                    <td>&nbsp; </td>                                            
                    <td>Total </td>
                    <td><strong>    &pound;<?php echo number_format($accountSummary[$customer_id]['total'], 2) ?></strong> </td>
                    <td><strong> &pound;<?php echo number_format($accountSummary[$customer_id]['paid'], 2) ?></strong> </td>
                    <td>
                        <strong>&pound;<?php echo number_format($accountSummary[$customer_id]['total'] - $accountSummary[$customer_id]['paid'], 2) ?></strong> 
                    </td>

                </tr>

                
            </tbody>
        </table>
        <div style="width: 700px;text-align: left;"><br><br> Regards <br><?php echo Yii::app()->params['adminName']; ?> </div>
    </body>
</html>

