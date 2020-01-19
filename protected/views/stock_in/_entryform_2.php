
   <?php echo CHtml::beginForm('/pos_uk/index.php/stock_in/entry','post',array('enctype'=>'multipart/form-data')); ?>
   <?php 
			$models1 = Product_Category::model()->findAll(array('order' => 'category_name'));	
			$models2 = Product_Type::model()->findAll(array('order' => 'type_name'));			 
			$models3 = Product::model()->findAll(array('order' => 'product_name'));			 
			$list1   = CHtml::listData($models1, 'id', 'category_name');
			$list2   = CHtml::listData($models2, 'id', 'type_name');		   
			$list3   = CHtml::listData($models3, 'product_id', 'product_name');	
			$models_brand    = Product_Brand::model()->findAll(array('order' => 'brand_name'));			 
			$brand_list      = CHtml::listData($models_brand, 'id', 'brand_name');
	?>

       <table align="center" width="95%" style="margin-bottom:10px;margin-left:10px;"> 
          <tr height="25" style="font-weight:bold; margin-bottom:10px;" bgcolor="#CCCCCC">
          <td align="center" width="15%" valign="top"><?php echo CHtml::activeLabel($model, 'category')?><span class="markcolor">*</span></td>
          <td align="center" width="15%" valign="top"><?php echo CHtml::activeLabel($model, 'product_type')?><span class="markcolor">*</span></td>
          <td align="center" width="15%" valign="top"><strong><?php echo CHtml::label('Brand', 'product_brand')?></strong></td>
          <td align="center" width="15%" valign="top"><?php echo CHtml::activeLabel($model, 'product_name')?><span class="markcolor">*</span></td>
          <td align="center" width="15%" valign="top"><?php echo CHtml::activeLabel($model, 'quantity')?><span class="markcolor">*</span></td>
          <td width="25%">&nbsp;</td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr>
        <td align="center" width="15%"><div id="pro_category" style="width:120px;"> <?php echo CHtml::dropDownList('product_category','product_category', $list1, array('empty' => '----- Select Category -----', 'style' => 'width:120px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductType()')); ?></div></td>
        <td align="center" width="15%"><div id="pro_type" style="width:120px;"> <?php echo CHtml::dropDownList('product_type','product_type', $list2, array('empty' => '----- Select Type -----', 'style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?></div></td>
        <td align="center" width="15%"><div id="pro_brand" style="width:120px;"> <?php echo CHtml::dropDownList('product_brand','product_brand', $brand_list, array('empty' => '-- Select Brand --', 'style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?></div></td>
        <td align="center" width="15%"><div id="pro_name" style="width:120px;"> <?php echo CHtml::dropDownList('product_id','product_id', $list3, array('empty' => '----- Select Name -----', 'style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?></div></td>
        <td align="center" width="15%"><?php echo CHtml::textField('qty', '', array('style' => 'width:100px;height:23px;border:1px solid #CCC;'))?></td>
        <td width="25%"><?php echo CHtml::submitButton('Add' ,array('class' => 'buttonGreen')); ?></td>
        </tr>
       </table>
  <?php echo CHtml::endForm()?>

<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
		<td colspan="3">
				<?php $cart = Yii::app()->shoppingCart; if(count($cart)): ?>
                <div id="cart2">
                <table>
                <caption>Product List</caption>
                <thead>
                    <tr>
                        <th>Subcategory</th>
                        <th>Category</th>
                        <th>Brand Name</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach ($cart as $item):
					$product_type     = $item->product_type_id;
					$product_category = $item->product_category_id;
					$product_brand    = $item->product_brand_id;
					$product_id       = $item->product_id;

					  $q1 = new CDbCriteria( array( 'condition' => "id = '$product_category'",) ); 
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$product_type'",) ); 
					  $q3 = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 
					  $q4 = new CDbCriteria( array( 'condition' => "id = '$product_brand'",) ); 

                      $Category_names = Product_Category::model()->findAll( $q1 );
                      $Type_names     = Product_Type::model()->findAll( $q2 );
                      $Products       = Product::model()->findAll( $q3 );
                      $Brand_names    = Product_Brand::model()->findAll( $q4 );
				 ?>
                    <tr>
                        <td align="center"><?php if(count($Category_names)): foreach($Category_names as $Category_names): echo $Category_names->category_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Brand_names)): foreach($Brand_names as $Brand_names): echo $Brand_names->brand_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Products)): foreach($Products as $Products): echo $Products->product_name; endforeach; endif; ?></td>
                        <td align="center"><?php echo $item->quantity; ?></td>
                        <td  class="remove">
                            <?php echo CHtml::link('X', array('/stock_in/remove/'.$item->id)); ?>
                            <?php echo CHtml::hiddenField('product_category[]', $item->product_category_id).CHtml::hiddenField('product_type[]', $item->product_type_id).CHtml::hiddenField('product_brand[]', $item->product_brand_id).CHtml::hiddenField('product_id[]', $item->product_id).CHtml::hiddenField('quantity[]', $item->quantity); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </table>		
            </div>
            <?php endif; ?>
		</td>
		</tr>
        <?php
			 $models_shop_list = Warehouse::model()->findAll(array('order' => 'shop_name'));			 
			 $shop_list        = CHtml::listData($models_shop_list, 'id', 'shop_name');
		?>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::label('Shop Name', 'shop_name')?>&nbsp;&nbsp;</th>
            <td><?php echo CHtml::dropDownList('shop_id', '', $shop_list, array('empty' => '----- Select Shop -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'warehouse_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::label('Stock In Date', 'stock_in_date')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::textField('stock_in_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
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
        <tr><td colspan="3">&nbsp;</td></tr>
	</table>
<?php echo CHtml::endForm()?>