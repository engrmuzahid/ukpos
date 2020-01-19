<?php echo CHtml::beginForm()?>
		<?php 
			// retrieve the models from db
			$models_expense = Expense_Type::model()->findAll(array('order' => 'expense_type_name'));			 
			$expense_list   = CHtml::listData($models_expense, 'id', 'expense_type_name');
		?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'expense_type')?>&nbsp;&nbsp;</th>
            <td><?php echo CHtml::activedropDownList($model,'expense_type_id', $expense_list, array('empty' => '----- Select Expense Type -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'expense_type_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'expense_name')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'expense_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'expense_name'); ?></div>
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