<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
            <?php 
			// retrieve the models from db
			$models2 = Supplier_Type::model()->findAll(array('order' => 'type_name'));			 
			$list = CHtml::listData($models2, 'id', 'type_name');		   
		  ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'supplier_name')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'name'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'supplier_type')?>&nbsp;&nbsp;</th>
            <td>
			    <?php echo CHtml::activedropDownList($model,'supplier_type', $list, array('empty' => '----- Select Supplier Type -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?>
                
            </td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'supplier_type'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'phone')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'phone', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'phone'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'fax')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'fax', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'fax'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'mobile')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'mobile', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'mobile'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'email')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'email', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'email'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'address')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextArea($model, 'address', array('style' => 'width:200px;height:100px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'address'); ?></div>
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