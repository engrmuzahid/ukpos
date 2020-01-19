<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
		<table border="0" style="margin-left:20px;"  cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'customer_name')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'customer_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'customer_name'); ?></div>
            </td>
			<td width="10%">&nbsp;</td>
            <?php 
			// retrieve the models from db
			$models2 = Customer_Type::model()->findAll(array('order' => 'type_name'));			 
			$list = CHtml::listData($models2, 'id', 'type_name');		   
		  ?>

			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'member_type')?><span class="markcolor"></span></strong></td>
            <td>
			    <?php echo CHtml::activedropDownList($model,'customer_type', $list, array('empty' => '----- Select Member Type -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?>
                <div class="markcolor"><?php echo CHtml::error($model,'customer_type'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'email_address')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'email_address', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'email_address'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'customer_photo')?></strong></td>
			<td><?php echo CHtml::activeFileField($model, 'customer_photo', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'customer_photo'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'primary_phone_no')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'contact_no1', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'contact_no1'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'alternative_phone_no')?>&nbsp;</strong></td>
			<td><?php echo CHtml::activeTextField($model, 'contact_no2', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'contact_no2'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'birth_day')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'birthday', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'birthday'); ?></div>
            </td>
			<td colspan="4">&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6" bgcolor="#999999"><strong>&nbsp;&nbsp;Billing Address</strong></td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'street_address1')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'billing_street1', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'billing_street1'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'street_address2')?><span class="markcolor"></span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'billing_street2', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'billing_street2'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'city')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'billing_city', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'billing_city'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'state')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'billing_state', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'billing_state'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'zip_code')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'billing_zip_code', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'billing_zip_code'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'country')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'billing_country', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'billing_country'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6" bgcolor="#999999"><strong>&nbsp;&nbsp;Shipping Address</strong></td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'street_address1')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'shipping_street1', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'shipping_street1'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'street_address2')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'shipping_street2', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'shipping_street2'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'city')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'shipping_city', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'shipping_city'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'state')?></span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'shipping_state', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'shipping_state'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'zip_code')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'shipping_zip_code', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'shipping_zip_code'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'country')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'shipping_country', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'shipping_country'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</strong></td>
            <td valign="top" align="left">
			  <?php echo CHtml::submitButton('Save' ,array('class' => 'buttonBlue')); ?>
              <?php echo CHtml::resetButton('Cancel' ,array('class' => 'buttonGreen')); ?>
            </td>
            <td colspan="4">&nbsp;</td>
        </tr>
	</table>
<?php echo CHtml::endForm()?>