<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
		<td colspan="3">
				<?php 
				$amount_sub_total = 0;
	            $username   = Yii::app()->user->name;
				  $main_id = $model->id;
				  $cond  = new CDbCriteria( array( 'condition' => "purchase_id = '$main_id'",) ); 					 
				  $cart = Purchase_Product::model()->findAll( $cond );
				
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
					$product_brand    = $item->product_brand;

					  $q1 = new CDbCriteria( array( 'condition' => "id = '$product_category'",) ); 
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$product_type'",) ); 
					  $q3 = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 
					  $q4 = new CDbCriteria( array( 'condition' => "id = '$product_brand'",) ); 

                      $Category_names = Product_Category::model()->findAll( $q1 );
                      $Type_names     = Product_Type::model()->findAll( $q2 );
                      $Products       = Product::model()->findAll( $q3 );
                      $Brand_names    = Product_Brand::model()->findAll( $q4 );
				 ?>
                    <tr><td colspan="8">&nbsp;</td></tr>
                    <tr>
                        <td align="center"><?php if(count($Category_names)): foreach($Category_names as $Category_names): echo $Category_names->category_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Brand_names)): foreach($Brand_names as $Brand_names): echo $Brand_names->brand_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Products)): foreach($Products as $Products): echo $Products->product_name; endforeach; endif; ?></td>
                        <td align="center"><?php echo CHtml::textField('price[]', $item->product_price, array('style' => 'width:80px;height:23px;border:1px solid #CCC;')); ?></td>
                        <td align="center"><?php echo CHtml::textField('quantity[]', $item->quantity, array('style' => 'width:80px;height:23px;border:1px solid #CCC;'))?></td>
                        <td  class="remove">
                            <?php echo CHtml::hiddenField('product_category[]', $item->product_category).CHtml::hiddenField('product_type[]', $item->product_type).CHtml::hiddenField('product_brand[]', $item->product_brand).CHtml::hiddenField('product_id[]', $item->product_id); ?>
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
			 $models_supplier_list = Supplier::model()->findAll(array('order' => 'name'));			 
			 $supplier_list        = CHtml::listData($models_supplier_list, 'id', 'name');
		?>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'shipment_id')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'chalan_id', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'chalan_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'receive_date')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'purchase_date', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'purchase_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'supplier_name')?>&nbsp;&nbsp;</th>
            <td><?php echo CHtml::activeDropDownList($model, 'supplier_id', $supplier_list, array('empty' => '----- Select Supplier -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'supplier_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'receive_note')?>&nbsp;&nbsp;</th>
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