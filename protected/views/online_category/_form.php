<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')) ?>
		
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'category_name')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'category_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'category_name'); ?></div>
           </td>
		</tr>
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'category_description')?>&nbsp;&nbsp;</th>
                        <td><?php echo CHtml::activeTextArea($model, 'category_description', array('style' => 'width:200px;height:125px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'sort_order'); ?></div>
           </td>
		</tr>                
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'sort_order')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'sort_order', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'sort_order'); ?></div>
           </td>
		</tr>                
        <tr><td colspan="3">&nbsp;</td></tr>
       
        <tr>
            <th>&nbsp;</th>
            <td valign="top">
			<?php echo CHtml::submitButton('Save' ,array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel' ,array('class' => 'buttonGreen')); ?>
            </td>
            <td></td>
        </tr>
	</table>
<?php echo CHtml::endForm()?>