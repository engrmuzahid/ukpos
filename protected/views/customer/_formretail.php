<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
<!--<input id="Customer_customer_type" type="hidden" value="retail_customer" name="Customer[customer_type]"/>-->
<?php echo CHtml::activeHiddenField($model, 'customer_type',array('value'=>'retail_customer')) ?>

    <table border="0" style="margin-left:20px;" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
		<tr>
                    <td valign="top"><?php echo CHtml::activeLabel($model, 'customer_name')?><span class="markcolor">*</span></td>
                    <td><?php echo CHtml::activeTextField($model, 'customer_name', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                    <div class="markcolor"><?php echo CHtml::error($model,'customer_name'); ?></div>
                    </td>
                    <td width="10%">&nbsp;</td>
                    <td valign="top"><?php echo CHtml::activeLabel($model, 'mobile_number')?><span class="markcolor">*</span></td>
                    <td><?php echo CHtml::activeTextField($model, 'contact_no1', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                    <div class="markcolor"><?php echo CHtml::error($model,'contact_no1'); ?></div>
                    </td>
                    <td width="10%">&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
                    <td valign="top"><?php echo CHtml::activeLabel($model, 'email_address')?></td>
                    <td><?php echo CHtml::activeTextField($model, 'email_address', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                    <div class="markcolor"><?php echo CHtml::error($model,'email_address'); ?></div>
                    </td>
                    <td>&nbsp;</td>
                    <td valign="top"><?php echo CHtml::activeLabel($model, 'Phone Number')?></td>
                    <td><?php echo CHtml::activeTextField($model, 'contact_no2', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                    <div class="markcolor"><?php echo CHtml::error($model,'contact_no2'); ?></div>
                    </td>
                    <td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><?php echo CHtml::activeLabel($model, 'street_address1')?><span class="markcolor">*</span></td>
			<td><?php echo CHtml::activeTextField($model, 'business_street1', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'business_street1'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><?php echo CHtml::activeLabel($model, 'city')?><span class="markcolor">*</span></td>
			<td><?php echo CHtml::activeTextField($model, 'business_city', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'business_city'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
                    <td valign="top"><?php echo CHtml::activeLabel($model, 'post_code')?><span class="markcolor">*</span></td>
                    <td><?php echo CHtml::activeTextField($model, 'business_post_code', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                    <div class="markcolor"><?php echo CHtml::error($model,'business_post_code'); ?></div>
                    </td>
                    <td>&nbsp;</td>
                    <td valign="top"><?php echo CHtml::activeLabel($model, 'comment')?></td>
                    <td><?php echo CHtml::activeTextArea($model, 'comment', array('style' => 'width:200px;height:60px;border:1px solid #CCC;'))?>
                        <div class="markcolor"><?php echo CHtml::error($model,'comment'); ?></div>
                    </td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>

        <tr>
            <th>&nbsp;</td>
            <td valign="top" align="left">
			  <?php echo CHtml::submitButton('Save' ,array('class' => 'buttonBlue')); ?>
              <?php echo CHtml::resetButton('Cancel' ,array('class' => 'buttonGreen')); ?>
            </td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
    </table>
<?php echo CHtml::endForm()?>