<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/bootstrap.min.css" rel="stylesheet" media="print" type="text/css"/>
        <style type="text/css">
            .border-all{
                border: 1px solid #000;
            }
            .border-left{
                border-left:  1px solid #000;
            }
            .border-right{
                border-right: 1px solid #000;
            }
            .border-top{
                border-top: 1px solid #000;
            }
            .border-bottom{
                border-bottom: 1px solid #000;
            }
            p{
                margin: 0px;
                padding: 10px 0;
            }
        </style>
    </head>
    <body>
        <div class="container" style="margin-top:5px;">
            <?php
            $criteria = new CDbCriteria();
            $criteria->order = 'id DESC';
            $criteria->limit = 1;
            $companys = Company::model()->findAll($criteria);
            ?>
            <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:13px;margin-bottom:10px;border-bottom: 1px solid;">
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
            <h2 style="text-align: center;margin: 20px 0;">   MEMBERSHIP APPLICATION </h2>
            <table style="width: 100%;height: 700px">
                <tbody> 
                    <tr>
                        <td colspan="12" style="background-color: #ededed;text-align: center;color:#000;font-size:23px;border: 1px solid #000;">
                            BUSINESS INFORMATION
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Member ID : <?php echo $model->id; ?>
                        </td>
                        <td colspan="6" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Joining Date : <?php echo date("d M, Y", strtotime($model->joining_date)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Business Name : <?php echo $model->business_name; ?>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="8" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Company Reg No. : <?php echo "N/A"; ?>
                        </td>
                        <td colspan="4" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Business Tel : <?php echo $model->contact_no2; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Business Address : <?php echo $model->business_street1; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: left;color:#000;font-size:17px;border: 1px solid #000;padding: 5px 10px;">
                            City : <?php echo $model->business_city; ?>
                        </td>
                        <td colspan="3" style="text-align: left;color:#000;font-size:17px;border: 1px solid #000;padding: 5px 10px;">
                            County : <?php echo $model->business_state; ?>
                        </td>
                        <td colspan="5" style="text-align: left;color:#000;font-size:17px;border: 1px solid #000;padding: 5px 10px;">
                            Post Code : <?php echo $model->business_post_code; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" style="background-color: #ededed;text-align: center;color:#000;font-size:23px;border: 1px solid #000;">
                            OWNER INFORMATION
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Owner Name : <?php echo $model->customer_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Owner Address : <?php echo $model->home_street1; ?>  <?php echo $model->home_city ? ", " . $model->home_city : ""; ?> <?php echo $model->home_state ? ", " . $model->home_state : ""; ?>  <?php echo $model->home_post_code ? ", " . $model->home_post_code : ""; ?>
                        </td>
                    </tr>

                    <tr> <td colspan="4" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Email: <?php echo $model->email_address; ?>
                        </td>
                        <td colspan="4" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Home Phone : N/A
                        </td>
                        <td colspan="4" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Mobile : <?php echo $model->contact_no2; ?>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="12" style="background-color: #ededed;text-align: center;color:#000;font-size:23px;border: 1px solid #000;">
                            EMERGENCY CONTACT
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Name of a relative not residing with you: 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Address :  
                        </td>
                        <td colspan="4" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Phone :  
                        </td>
                    </tr>
<!--                    <tr>
                        <td colspan="4" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            City : 
                        </td>
                        <td colspan="4" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            State :  
                        </td>
                        <td colspan="4" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Post Code :  
                        </td>
                    </tr>-->
                    <tr>

                        <td colspan="7" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Mobile :  
                        </td>
                        <td colspan="5" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Position:  
                        </td>
                    </tr>
<!--                    <tr>
                        <td colspan="12" style="background-color: #ededed;text-align: center;color:#000;font-size:23px;border: 1px solid #000;">
                            LOGIN INFORMATION
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            User ID:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Comments:
                        </td>
                    </tr>-->
                    <tr>
                        <td colspan="12" style="background-color: #ededed;text-align: center;color:#000;font-size:23px;border: 1px solid #000;">
                            SIGNATURE
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: left;color:#000;font-size:13px;border: 1px solid #000;padding: 5px 10px;">
                            I certify that all information given in this application is correct to the best of my knowledge.By signing this form I/We accept and agree to be bound by the Terms and Conditions of Lynnwood Wholesale Ltd T/A Sylhet Cash and Curry.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Signature of Applicant :
                        </td>
                        <td colspan="4" style="text-align: left;color:#000;font-size:20px;border: 1px solid #000;padding: 5px 10px;">
                            Date : 
                        </td>
                    </tr>
                </tbody>
            </table> 
            <br/>
            <br/>
            <br/>
            <br/> 

            <div class="row">
                  <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="font-family:Verdana; font-size:13px;">
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
                   
                        <?php
                    endforeach;
                endif;
                ?>
            </table>
                <div class="col-md-12">
                  
                    <h5 style="text-align: center;text-transform: uppercase;text-decoration: underline;"> GUARANTEE FOR SUPPLY OF GOODS </h5>                   
                    <div style="text-align: justify;font-size: 13.5px;">
                        <p>In consideration of your having agreed to supply <span style="text-transform: uppercase;text-decoration: underline;"><?php echo $model->business_name; ?> (<?php echo $model->customer_name; ?>)</span>.(‘the Company’) with goods for use in the Company’s trading activities, I HEREBY AGREE WITH YOU AS FOLLOWS:</p>
                   1.	I will Guarantee and be answerable and responsible to you for any due payment by the Company for all Goods that you may from time to time at the Company’s request supply and deliver to the Company not withstanding that I may not have notice of any neglect or omission on the part of the Company to pay for any Goods supplied by you in accordance with the terms agreed between you and the Company.<br/>
                        <p>2.	This Agreement is to be a continuing Guarantee to you for the whole debt that is contracted with you by the Company in respect of the Goods to be supplied and delivered to it, and for the avoidance of doubt, is to be treated as security for the whole debt.</p>
                        <p>3.	All dividends compositions and payments received by you form the Company are to be taken and applied by you are payment without you making any deduction in respect of any clime arising under this Guarantee, and my right to be subrogated to you in respect of such dividends or payments shall not arise until you have received the full amount of all your claims against the Company.</p>
                        <p>4.	You may at any time, at your absolute discretion, and without giving any notice to me, refuse further credit or supplies to the Company and grant to the Company, or to any drawers, acceptors or endorsers of the bills or exchange, promissory notes to other securities received by you from the Company may be liable to you, any time or other indulgence and compound with the Company of them respectively without discharging or impairing my liability under this Guarantee.</p>
                        <p>5.	This Guarantee may be enforced against me notwithstanding that any negotiable or other securities referred to in this  document, or to which this Guarantee extends or is applicable, are at the time of proceedings, being taken against me on this Guarantee outstanding or in circulation.</p>
                        <p>6.	 In order to give effect to this Guarantee I declare that you shall be at liberty to act as though i were a principal debtor and i now waive all and any of  my rights as a Guarantor that may at any time be inconsistent with any of the above provisions. In particular, and without prejudice to the generally of the foregoing, no variation of your contract or contracts with the Company failing within clause 1 above, or of the mode of performance thereof, shall discharge me from liability under this Guarantee even though I may not have consented to such variation.</p>
                        <p>7.	 This Guarantee shall be recoverable at any time as to future transactions by 3 months’ notice in writing given to you or duly authorized agent by me or, in case of my death, by my personal representatives, but shall not affect my liability (or my estate's liability) for transactions entered into before a revocation was received.</p>

                    </div>
                </div>
            </div>
            <div class="row" style="">
 
                <div style="width: 50%;float: left;">
                    <p style="text-align: center;">_______________________________________<br/>   ( Signature of Guarantor )</p>

                </div>
                <div style="width: 50%;float: right;">     <p style="text-align: center;">_______________________________________<br/>  (  Print Name )</p>
                </div>
                <div class="col-md-12">
                    <p style="text-align: left;">_____________________________________________________________________________________________________________________<br/>   ( Guarantor Address )</p>
                </div> 
                <div class="col-md-12">
                    <p style="text-align: left;">Dated _______________________________________ </p>
                </div> 
            </div>
        </div>
    </body> 
</html>