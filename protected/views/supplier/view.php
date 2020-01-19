
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'customer', 'activeTab' => 'customer')); ?>
   <?php if(count($models)): foreach($models as $model):
   
		  $customer_type_id = $model->customer_type;
		  $q = new CDbCriteria( array( 'condition' => "id = '$customer_type_id'",) ); 
		  $Type_names = Customer_Type::model()->findAll( $q );
		  
    endforeach; endif; ?>
<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Customer Details</h1></div>
		<table border="0"  width="90%" style="margin:0px 30px 0px 30px;" cellpadding="0" cellspacing="0">
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td rowspan="4" > <?php if(!empty($model->customer_photo)):?> <img src="<?php echo Yii::app()->request->baseUrl.'/public/photos/customer/'.$model->customer_photo; ?>" style="padding:5px; border:1px solid #ccc;" width="150" /> <?php endif; ?>
            </td>
			
		</tr>
		<tr>
			<td valign="top"><strong><?php echo "Customer Name"; ?></strong></td>
			<td valign="top"> <?php echo $model->customer_name; ?></td>
			<td>&nbsp; </td>
			<td valign="top"><strong><?php echo "Customer Type"; ?></strong></td>
			<td valign="top"> <?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><strong><?php echo "Email Address"; ?></strong></td>
			<td valign="top"> <?php echo $model->email_address; ?></td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo "Birth Day"; ?></strong></td>
			<td valign="top"> <?php echo date("d M, Y", strtotime($model->birthday)); ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><strong><?php echo "Primary Phone No"; ?></strong></td>
			<td valign="top"> <?php echo $model->contact_no1; ?></td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo "Alternative Phone No"; ?></strong></td>
			<td valign="top"> <?php echo $model->contact_no2; ?></td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6" bgcolor="#999999"><strong>&nbsp;&nbsp;Billing Address</strong></td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo "Street Address1"; ?></strong></td>
			<td> <?php echo $model->billing_street1; ?></td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo "Street Address2"; ?><span class="markcolor"></span></strong></td>
			<td> <?php echo $model->billing_street2; ?></td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo "City"; ?></strong></td>
			<td> <?php echo $model->billing_city; ?></td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo "State"; ?></strong></td>
			<td> <?php echo $model->billing_state; ?></td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo "Zip Code"; ?></strong></td>
			<td> <?php echo $model->billing_zip_code; ?></td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo "Country"; ?></strong></td>
			<td> <?php echo $model->billing_country; ?></td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6" bgcolor="#999999"><strong>&nbsp;&nbsp;Home Address</strong></td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo "Street Address1"; ?></strong></td>
			<td> <?php echo $model->shipping_street1; ?></td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo "Street Address2"; ?><span class="markcolor"></span></strong></td>
			<td> <?php echo $model->shipping_street2; ?></td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo "City"; ?></strong></td>
			<td> <?php echo $model->shipping_city; ?></td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo "State"; ?></strong></td>
			<td> <?php echo $model->shipping_state; ?></td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo "Zip Code"; ?></strong></td>
			<td> <?php echo $model->shipping_zip_code; ?></td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo "Country"; ?></strong></td>
			<td> <?php echo $model->shipping_country; ?></td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
	</table>
<!--  END #PORTLETS -->  
   </div>
