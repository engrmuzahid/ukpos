      <script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.jqprint.0.3.js"></script>     
    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable").jqprint();
            });
        });
    
    </script>
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'point_of_sell', 'activeTab' => 'point_of_sell')); ?>
<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
		<div class="flash-success"> <?php echo Yii::app()->user->getFlash('saveMessage'); ?></div>

       <div id="ptable">
        <div style="margin-left:15px;"><h1>Client Invoice Report</h1></div>
       <?php 
		 $criteria = new CDbCriteria(); $criteria->order = 'id DESC'; $criteria->limit = 1; $companys = Company::model()->findAll($criteria);	   
	   ?>
        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:10px;">
        <?php if(count($companys)): foreach($companys as $company):?>
        <tr>
         <td width="45%"><img src="<?php echo Yii::app()->request->baseUrl.'/public/photos/company/'.$company->company_logo; ?>" height="100" alt=""  /></td>
         <td width="55%"><h1>Invoice Report</h1></td>
        </tr>
        <?php endforeach; endif; ?>
        </table>
        <table border="0" width="90%" cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:10px;">
        <tr>
        <td>
			<?php
            if(count($models)): foreach($models as $posValue): $contentId =$posValue->invoice_no; endforeach; endif;
			$customer_type = $posValue->customer_type;
			$station_id    = $posValue->station_id;
			  $user_id = $posValue->user_id;
			  $cond2 = new CDbCriteria( array( 'condition' => "username = '$user_id'",) ); 					 
			  $users = Users::model()->findAll( $cond2 );

			  $cond2     = new CDbCriteria( array( 'condition' => "id = '$station_id'",) ); 					 
			  $stations = Station::model()->findAll( $cond2 );

			if($customer_type == "regular"):
				$customer_name = $posValue->customer_name;
			else:
			$customer_id = $posValue->customer_id;
			  $q1 = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 					 
			  $customers = Customer::model()->findAll( $q1 );
			  if(count($customers)): foreach($customers as $customer): $customer_name = $customer->customer_name; endforeach; else:  $customer_name = ""; endif;
			endif;
            ?>
        </td>
        <td>
       <table>           
        <tr>
        <td align="left" valign="top"><strong><?php echo 'Invoice No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td><?php echo $posValue->invoice_no; ?></td>
        </tr>        
        <tr><td colspan="3"></td></tr>
        <tr>
        <td align="left" valign="top"><strong><?php echo 'Station Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td><?php if(count($stations)): foreach($stations as $stations ): echo ucwords($stations->station_name); endforeach; endif; ?></td>
        </tr>    
        <tr><td colspan="3"></td></tr>
        <tr>
        <td align="left" valign="top"><strong><?php echo 'Invoice Date'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td><?php echo date('M d, Y', strtotime($posValue->order_date)); ?></td>
        </tr>        
        <tr><td colspan="3"></td></tr>
        </table>
        </td>
        <td>
        <table>
        <tr>
        <td align="left" valign="top"><strong><?php echo 'Customer Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td><?php echo $customer_name; ?></td>
        </tr>        
        <tr><td colspan="3"></td></tr>
        <tr>
        <td align="left" valign="top"><strong><?php echo 'Payment By'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td><?php echo $posValue->payment_mode; ?></td>
        </tr>        
        <tr><td colspan="3"></td></tr>
        </table>
        </td>
        </tr>
        </table>
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" >
                <?php if(count($model_products)): ?>
				<tr>
                    <th width="10%" scope="col">SL No</th>
                    <th width="25%" scope="col">Product Code</th>
                    <th width="30%" scope="col">Product Name</th>
                    <th width="10%" scope="col">Price Rate</th>
                    <th width="10%" scope="col">Quantity</th>
                    <th width="15%" scope="col">Total Price(TK)</th>
				</tr>
                <?php   
				       $i = 1;
					   foreach($model_products as $posProductValue):
						  $product_id = $posProductValue->product_id;
						  $prod1      = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 					 
						  $pValues = Product::model()->findAll( $prod1 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td align="center"><?php echo $i; ?></td>
					<td><?php if(count($pValues)): foreach($pValues as $pValue ): echo ucwords($pValue->product_code); endforeach; endif; ?></td>
					<td><?php if(count($pValues)): foreach($pValues as $pValue ): echo ucwords($pValue->product_name); endforeach; endif; ?></td>
					<td align="center"><?php echo 'TK '.$posProductValue->amount; ?></td>
                    <td align="center"><?php echo $posProductValue->quantity; ?></td>
					<td align="center"><?php echo 'TK '.$posProductValue->amount_total; ?></td>
                </tr>
                <?php $i = $i + 1; endforeach; endif; ?>
				<tr>
					<td colspan="5" align="right">Amount Sub Total &nbsp;&nbsp;: </td>
					<td align="center"><?php echo 'TK '.$posValue->amount_sub_total; ?>&nbsp;</td>
                </tr>
				<tr>
					<td colspan="5" align="right">Discount &nbsp;&nbsp;:</td>
					<td align="center"><?php echo 'TK '.$posValue->discount; ?>&nbsp;</td>
                </tr>
				<tr>
					<td colspan="5" align="right">Grand Total &nbsp;&nbsp;:</td>
					<td align="center"><?php echo 'TK '.$posValue->amount_grand_total; ?>&nbsp;</td>
                </tr>
     		</table> 
            
            <table border="0" width="100%" cellpadding="0" cellspacing="0"  style="margin-bottom:10px;">
            <tr><td colspan="2"><strong><p align="right" style="margin-right:50px;">
            <?php if(count($users)): foreach($users as $user): $full_name = $user->full_name; $user_sign = $user->user_sign; if(!empty($user_sign)): ?>
            <img src="<?php echo Yii::app()->request->baseUrl.'/public/photos/user/'.$user_sign; ?>" height="40" alt=""  /> <?php else: echo $full_name; endif; endforeach; endif; ?></strong></p></td></tr>
            <tr><td colspan="2"><strong><p align="right" style="margin-right:7px;">Signature of User </p></strong></td></tr>
            <tr><td colspan="2"><hr size="1" width="100%" /></td></tr>
            <?php if(count($companys)): foreach($companys as $company):?>
            <tr>
             <td colspan="2"><p style="margin-left:30px; margin-right:30px;"><?php echo "Address: ".$company->address.". Contact No: ".$company->contact_no.". E-mail: ".$company->email_address.". Web: ".$company->website; ?></p></td>
            </tr>
            <?php endforeach; endif; ?>
            </table>
     </div>  
 <!--  END #PORTLETS -->  
   </div>
