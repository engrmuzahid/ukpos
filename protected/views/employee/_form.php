<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>

<table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
    <tr height="10"><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'name') ?><span class="markcolor">*</span>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'name'); ?></div>
        </td>
    </tr>
    
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'contact_no ') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'contact_no1', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'contact_no1'); ?></div>
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
        <th valign="top"><?php echo CHtml::activeLabel($model, 'Street ') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'street1', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'street1'); ?></div>
        </td>
    </tr>
    
    <tr><td colspan="3">&nbsp;</td></tr>
     <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'city') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'city', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'city'); ?></div>
        </td>
    </tr>
    
    <tr><td colspan="3">&nbsp;</td></tr>
     <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'post_code') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'post_code', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'post_code'); ?></div>
        </td>
    </tr>
    
    <tr><td colspan="3">&nbsp;</td></tr>
     <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'country') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'country', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'country'); ?></div>
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
<?php
echo CHtml::endForm()?>