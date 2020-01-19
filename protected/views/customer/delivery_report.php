<?php if (count($reports)): ?>
    <?php //echo "<pre>";  print_r($reports); exit();              ?>
    <table border="0" width="98%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:11px;margin-bottom:10px; margin-left:10px;">
        <?php
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->limit = 1;
        $companys = Company::model()->findAll($criteria);
        ?> 

        <?php
        if (count($companys)):
            foreach ($companys as $company):
                ?>
                <tr>
                    <td width="10%" rowspan="2" valign="top"><img src="<?php echo Yii::app()->request->baseUrl . '/public/photos/company/' . $company->company_logo; ?>" height="70" alt=""  /></td>
                    <td width="55%">
                        <p style="margin-right:30px;"><font style="font-size:15px; font-weight:bold;"><?php echo ucwords($company->company_name); ?></font><br />
                            <?php echo $company->address . "<br/> " . $company->contact_no . ". <br/> " . $company->email_address . ".<br/> " . $company->website; ?></p>
                    </td>
                    <td width="35%" align="right">
                        <table  border="1" style="border-collapse:collapse;font-family:Verdana; font-size:14px;width: 100%">
                            <tr>
                                <td style="padding: 20px;">
                                    Driver : <?php echo $driver->name; ?><br/>
                                    Car Reg : <?php echo $car->reg_no; ?> <br/>
                                    Date : <?php echo date("d-M-Y H:i", strtotime("NOW")); ?><br/>
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
    <table border="1" style="width:100%;">
        <thead>
            <tr border="1" style="height: 35px;background: #CCCCCC;padding-top: 5px;">
                <th> NO </th>
                <th>SALE AMOUNT </th>
                <th>NAME </th>
                <th>PAID AMOUNT </th>
                <th>COMMENTS & RETURN </th>
                <th>CHECKED BY  </th>
                <th>SIGNATURE </th> 
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($reports as $report):
                $customer_id = $report['customer_id'];
                $customer_name = "";
                if (!empty($customer_id)):
                    $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                    $customers = Customer::model()->findAll($q1);
                    if (count($customers)):
                        foreach ($customers as $customer):
                            $customer_name = $customer->customer_name;
                        endforeach;
                    endif;
                endif;

                $customer_invoices = Yii::app()->db->createCommand("SELECT  invoice_no FROM sell_order WHERE customer_id = $customer_id AND invoice_no IN ($invoices)")
                        ->queryAll();
//                echo "<pre>";
//                print_r($customer_invoice);
//                exit();
                ?>
                <tr style ='height:60px;font-family:Verdana; font-size:12px;'>
                    <td style="text-align: center;"> <?php echo $i; ?></td>     
                    <td style="text-align: center;"><strong><?php echo '&pound;' . number_format($report['customer_amount'], 2); ?>
                          
                        
                        </strong>
                    
                            <span style="font-size: 10px;"> 
                            <?php  foreach ($customer_invoices as $customer_invoice): ?>
                                    <?php echo '<br>'.$customer_invoice['invoice_no']; ?>                
                              <?php endforeach; 
                              
                                     
                              ?>
                            </span></td>
                            <td style="padding-left: 10px;"><strong>    <?php echo ucwords($customer_name); ?></strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
        <?php $i++;
    endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
