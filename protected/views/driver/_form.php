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
        <th valign="top"><?php echo CHtml::activeLabel($model, 'address') ?> &nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextArea($model, 'address', array('style' => 'width:200px;height:100px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'address'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'phone') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'phone', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'phone'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'licence_no') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'licence_no', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'licence_no'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
      
    <tr>
        <th>&nbsp;</th>
        <td valign="top">
              <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue', "style"=> "width:120px")); ?> 
            <a href="<?php echo Yii::app()->request->baseUrl . '/driver'; ?>" class="buttonGreen" style="width:120px;padding: 5px 30px;">Cancel</a>
         </td>
        <td></td>
    </tr>
</table>
<br/><br/><br/><br/>
<?php
echo CHtml::endForm()?>