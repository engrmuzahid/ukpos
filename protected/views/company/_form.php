<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>

<table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
    <tr height="10"><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'company_name') ?><span class="markcolor">*</span>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'company_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'company_name'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'address') ?><span class="markcolor">*</span>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextArea($model, 'address', array('style' => 'width:200px;height:100px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'address'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'contact_no') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'contact_no', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'contact_no'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'email_address') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'email_address', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'email_address'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'website') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'website', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'website'); ?></div>
        </td>
    </tr>
     <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'passcode') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activePasswordField($model, 'passcode', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'passcode'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'company_logo') ?>&nbsp;&nbsp;</th>
        <td>
            <?php if ($model->company_logo) : ?>
                <img src="<?php echo Yii::app()->baseUrl . '/public/photos/company/' . $model->company_logo ?>" /> <br/>
            <?php endif; ?>
            <?php echo CHtml::activeFileField($model, 'company_logo'); ?>
        </td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'company_logo'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    
    <tr>
        <th>&nbsp;</th>
        <td valign="top">
            <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen')); ?>
        </td>
        <td></td>
    </tr>
</table>
<?php echo CHtml::endForm() ?>