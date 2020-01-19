<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>
<?php echo CHtml::activeHiddenField($model, 'customer_type', array('value' => 'wholesale_customer')) ?>
<table border="0" style="margin-left:20px;" cellpadding="0" cellspacing="0">
    <tr height="10"><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'business_name') ?><span class="markcolor">*</span></td>
        <td><?php echo CHtml::activeTextField($model, 'business_name', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'business_name'); ?></div>
        </td>
        <td width="10%">&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'customer_name') ?><span class="markcolor">*</span></td>
        <td><?php echo CHtml::activeTextField($model, 'customer_name', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'customer_name'); ?></div>
        </td>
        <td width="10%">&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'email_address') ?></td>
        <td><?php echo CHtml::activeTextField($model, 'email_address', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'email_address'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'mobile_number') ?><span class="markcolor">*</span></td>
        <td><?php echo CHtml::activeTextField($model, 'contact_no1', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'contact_no1'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'business_tel') ?>&nbsp;</td>
        <td><?php echo CHtml::activeTextField($model, 'contact_no2', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'contact_no2'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'birth_day') ?></td>
        <td><?php echo CHtml::activeTextField($model, 'birthday', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'birthday'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'customer_photo') ?></td>
        <td><?php echo CHtml::activeFileField($model, 'customer_photo', array('style' => 'width:200px;height:25px;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'customer_photo'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'joining_date') ?></td>
        <td><?php echo CHtml::activeTextField($model, 'joining_date', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'joining_date'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'comment') ?></td>
        <td><?php echo CHtml::activeTextArea($model, 'comment', array('style' => 'width:200px;height:60px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'comment'); ?></div>
        </td>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr><td colspan="6" bgcolor="#999999">&nbsp;&nbsp;<strong>Order Day</strong></td></tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'order_day') ?></td>
        <td>
            <?php echo CHtml::activeDropDownList($model, 'order_day', array(
                'MON' => 'Monday', 'TUE' => 'Tuesday', 'WED' => 'Wednesday', 'THU' => 'Thursday',
                'FRI' => 'Friday', 'SAT' => 'Saturday', 'SUN' => 'Sunday'
            ))
            ?>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'is_alive') ?></td>
        <td>
            <?php
            echo CHtml::activeDropDownList($model, 'is_alive', array(
                '0' => 'No', '1' => 'Yes'   ))
            ?>
        </td>
    </tr>
    
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr><td colspan="6" bgcolor="#999999">&nbsp;&nbsp;<strong>Business Address</strong></td></tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'street_address1') ?><span class="markcolor">*</span></td>
        <td><?php echo CHtml::activeTextField($model, 'business_street1', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'business_street1'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'street_address2') ?><span class="markcolor"></span></td>
        <td><?php echo CHtml::activeTextField($model, 'business_street2', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'business_street2'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'city') ?><span class="markcolor">*</span></td>
        <td><?php echo CHtml::activeTextField($model, 'business_city', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'business_city'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'state') ?><span class="markcolor">*</span></td>
        <td><?php echo CHtml::activeTextField($model, 'business_state', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'business_state'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'post_code') ?><span class="markcolor">*</span></td>
        <td><?php echo CHtml::activeTextField($model, 'business_post_code', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'business_post_code'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'country') ?><span class="markcolor">*</span></td>
        <td><?php echo CHtml::activeTextField($model, 'business_country', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'business_country'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr><td colspan="6" bgcolor="#999999">&nbsp;&nbsp;<strong>Home Address</strong></td></tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'home_address1') ?></td>
        <td><?php echo CHtml::activeTextField($model, 'home_street1', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'home_street1'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'home_address2') ?></td>
        <td><?php echo CHtml::activeTextField($model, 'home_street2', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'home_street2'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'city') ?></td>
        <td><?php echo CHtml::activeTextField($model, 'home_city', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'home_city'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'state') ?></span></td>
        <td><?php echo CHtml::activeTextField($model, 'home_state', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'home_state'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'post_code') ?></td>
        <td><?php echo CHtml::activeTextField($model, 'home_post_code', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'home_post_code'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'country') ?></td>
        <td><?php echo CHtml::activeTextField($model, 'home_country', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'home_country'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr><td colspan="6" bgcolor="#999999">&nbsp;&nbsp;<strong>Other Information</strong></td></tr>
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'credit_limit') ?> </td>
        <td><?php echo CHtml::activeTextField($model, 'credit_limit', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'credit_limit'); ?></div>
        </td>
        <td>&nbsp;</td>
        <td valign="top"><?php echo CHtml::activeLabel($model, 'Limit_expires') ?><span class="markcolor"></span></td>
        <td><?php echo CHtml::activeTextField($model, 'pay_date', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <div class="markcolor"><?php echo CHtml::error($model, 'pay_date'); ?></div>
        </td>
        <td>&nbsp;</td>
    </tr> 

    <tr><td colspan="6">&nbsp;</td></tr>
    <tr>
        <th>&nbsp;</td>
        <td colspan="2" valign="top" align="left">
            <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue','style' => 'width:120px;margin-right:10px')); ?>
            <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen','style' => 'width:120px;margin-right:10px')); ?>
        </td>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
</table>
<?php
echo CHtml::endForm()?>