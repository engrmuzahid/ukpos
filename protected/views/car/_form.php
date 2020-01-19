<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>

<table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
    <tr height="10"><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'title') ?><span class="markcolor">*</span>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'title', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'title'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'reg_no') ?><span class="markcolor">*</span>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextArea($model, 'reg_no', array('style' => 'width:200px;height:100px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'reg_no'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'model') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'model', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'model'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'details') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'details', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'details'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
      
    <tr>
        <th>&nbsp;</th>
        <td valign="top">
            <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue',"style"=>"width:140px;")); ?> 
        </td>
        <td></td>
    </tr>
</table>
<?php
echo CHtml::endForm()?>