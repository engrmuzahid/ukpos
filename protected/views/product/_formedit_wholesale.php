<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')) ?>

<table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
     
   <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'offer_quantity') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'offer_quantity', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'offer_quantity'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'offerPrice') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'offerPrice', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'offerPrice'); ?></div>
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
    <tr><td colspan="3">&nbsp;</td></tr>
</table>
<?php
echo CHtml::endForm()?>