

<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
		<td colspan="3">
				<?php 
				$amount_sub_total = 0;
	            $username   = Yii::app()->user->name;
				  $main_id = $model->id;
				  $cond  = new CDbCriteria( array( 'condition' => "delivery_id = '$main_id'",) ); 					 
				  $cart = Receive_Delivery_Product::model()->findAll( $cond );
				
				 if(count($cart)): ?>
                <div id="cart2">
                <table>
                <caption>Product List</caption>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach ($cart as $item):
					$product_type     = $item->product_type;
					$product_category = $item->product_category;
					$product_id       = $item->product_id;
					
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$product_category'",) ); 
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$product_type'",) ); 
					  $q3 = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 
					 
                      $Category_names = Product_Category::model()->findAll( $q1 );
                      $Type_names     = Product_Type::model()->findAll( $q2 );
                      $Products       = Product::model()->findAll( $q3 );
				 ?>
                    <tr><td colspan="7">&nbsp;</td></tr>
                    <tr>
                        <td align="center"><?php if(count($Category_names)): foreach($Category_names as $Category_names): echo $Category_names->category_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Products)): foreach($Products as $Products): echo $Products->product_name; endforeach; endif; ?></td>
                        <td align="center"><?php echo CHtml::textField('price[]', $item->product_price, array('style' => 'width:80px;height:23px;border:1px solid #CCC;')); ?></td>
                        <td align="center"><?php echo CHtml::textField('quantity[]', $item->quantity, array('style' => 'width:80px;height:23px;border:1px solid #CCC;'))?></td>
                        <td  class="remove">
                            <?php echo CHtml::hiddenField('product_category[]', $item->product_category).CHtml::hiddenField('product_type[]', $item->product_type).CHtml::hiddenField('product_id[]', $item->product_id); ?>
                        </td>
                    </tr>
                <?php 
				endforeach; ?>
                </table>		
            </div>
            <?php endif; ?>
		</td>
		</tr>
        <?php
			 $models_compartment_list = Compartment::model()->findAll(array('order' => 'warehouse_name'));			 
			 $compartment_list        = CHtml::listData($models_compartment_list, 'id', 'warehouse_name');
			 $models_party_list       = Storage_Party::model()->findAll(array('order' => 'party_name'));			 
			 $party_list              = CHtml::listData($models_party_list, 'id', 'party_name');
		?>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'received_from_date')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'received_from_date', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'received_from_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'received_to_date')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'received_to_date', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'received_to_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'expire_date')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'expire_date', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'expire_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'warehouse_name')?>&nbsp;&nbsp;</th>
            <td><?php echo CHtml::activeDropDownList($model, 'warehouse_id', $compartment_list, array('empty' => '----- Select Warehouse -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'warehouse_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'storage_party')?>&nbsp;&nbsp;</th>
            <td><?php echo CHtml::activeDropDownList($model, 'storage_party_id', $party_list, array('empty' => '----- Select Party -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'storage_party_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'total_charge')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'total_charge', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'total_charge'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'received_note')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextArea($model, 'note', array('style' => 'width:200px;height:100px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'note'); ?></div>
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