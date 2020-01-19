<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
		<table border="0" style="margin-left:20px;" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'business_name')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'business_name', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'business_name'); ?></div>
            </td>
			<td width="10%">&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'customer_name')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'customer_name', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'customer_name'); ?></div>
            </td>
			<td width="10%">&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'email_address')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'email_address', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'email_address'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'mobile_number')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'contact_no1', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'contact_no1'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'business_tel')?>&nbsp;</strong></td>
			<td><?php echo CHtml::activeTextField($model, 'contact_no2', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'contact_no2'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'birth_day')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'birthday', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'birthday'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'joining_date')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'joining_date', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'joining_date'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'comment')?></strong></td>
			<td><?php echo CHtml::activeTextArea($model, 'comment', array('style' => 'width:150px;height:80px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'comment'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6" bgcolor="#999999"><strong>&nbsp;&nbsp;Login Info</strong></td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'username')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'username', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'username'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'password')?><span class="markcolor"></span></strong></td>
			<td><?php echo CHtml::activePasswordField($model, 'password', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'password'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6" bgcolor="#999999"><strong>&nbsp;&nbsp;Business Address</strong></td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'street_address1')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'business_street1', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'business_street1'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'street_address2')?><span class="markcolor"></span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'business_street2', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'business_street2'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'city')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'business_city', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'business_city'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'state')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'business_state', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'business_state'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'post_code')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'business_post_code', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'business_post_code'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'country')?><span class="markcolor">*</span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'business_country', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'business_country'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr><td colspan="6" bgcolor="#999999"><strong>&nbsp;&nbsp;Home Address</strong></td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'home_address1')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'home_street1', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'home_street1'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'home_address2')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'home_street2', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'home_street2'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'city')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'home_city', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'home_city'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'state')?></span></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'home_state', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'home_state'); ?></div>
            </td>
			<td>&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'post_code')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'home_post_code', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'home_post_code'); ?></div>
            </td>
			<td>&nbsp;</td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'country')?></strong></td>
			<td><?php echo CHtml::activeTextField($model, 'home_country', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?>
                <div class="markcolor"><?php echo CHtml::error($model,'home_country'); ?></div>
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