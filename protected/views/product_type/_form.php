<?php echo CHtml::beginForm()?>
		
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<?php 
			// retrieve the models from db
			$models2 = Product_Category::model()->findAll(array('order' => 'category_name'));			 
			// format models as $key=>$value with listData
			$list = CHtml::listData($models2, 'id', 'category_name');
		   
		?>
        <tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'item_category')?>&nbsp;&nbsp;</th>
            <td><?php echo CHtml::activedropDownList($model,'product_category_id', $list, array('empty' => '----- Select Category -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'product_category_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
			<th valign="top">Subcategory&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'type_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'type_name'); ?></div>
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