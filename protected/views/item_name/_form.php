<?php echo CHtml::beginForm()?>
		
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<?php 
			// retrieve the models from db
			$models2 = Product_Category::model()->findAll(array('order' => 'category_name'));			 
			// format models as $key=>$value with listData
			$list = CHtml::listData($models2, 'id', 'category_name');
			$models_type    = Product_Type::model()->findAll(array('order' => 'type_name'));			 
			$type_list      = CHtml::listData($models_type, 'id', 'type_name');
			$models_item_type = Product_Item::model()->findAll(array('order' => 'item_type_name'));			 
			$item_type_list   = CHtml::listData($models_item_type, 'id', 'item_type_name');
		?>
        <tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'product_category')?>&nbsp;&nbsp;</th>
            <td><?php echo CHtml::activedropDownList($model,'product_category_id', $list, array('empty' => '----- Select Category -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductType()')); ?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'product_category_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'product_type')?>&nbsp;&nbsp;</th>
            <td><div id = "product_type"><?php echo CHtml::activedropDownList($model,'product_type_id', $type_list, array('empty' => '----- Select Subcategory -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'product_type_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'item_category_name')?>&nbsp;&nbsp;</th>
            <td><div id = "item_type"><?php echo CHtml::activedropDownList($model,'product_item_type_id', $type_list, array('empty' => '----- Select Item Type -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'product_item_type_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'brand_name')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'item_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'item_name'); ?></div>
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