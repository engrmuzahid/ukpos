
   <?php echo CHtml::beginForm('/pos_uk/index.php/stock_in/entry','post',array('enctype'=>'multipart/form-data')); ?>

       <table align="center" width="95%" style="margin-bottom:10px;margin-left:10px;"> 
          <tr><td colspan="3">&nbsp;</td></tr>
		  <tr height="25" style="font-weight:bold; margin-bottom:10px;">
		  <td width="8%">&nbsp;</td>
          <td align="center" width="15%" valign="top"><?php echo CHtml::label('Product Code', 'product_code')?><span class="markcolor">*</span></td>
			<td align="center" width="15%"><?php echo CHtml::textField('product_code', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="25%"><?php echo CHtml::submitButton('Add' ,array('class' => 'buttonGreen')); ?></td>
        </tr>
          <tr><td colspan="3">&nbsp;</td></tr>
       </table>
  <?php echo CHtml::endForm()?>

<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
		<td colspan="3">
				<?php 
				 $cart = Stock_Tempory::model()->findAll();
				 if(count($cart)): 
				 ?>
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
					$product_type     = $item->product_type;
					$product_category = $item->product_category;
					$product_brand    = $item->product_brand;
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
                        <td align="center"><?php echo CHtml::textField('quantity[]', '1', array('style' => 'width:50px;height:25px;border:1px solid #CCC;'))?></td>
                        <td  class="remove">
                            <?php echo CHtml::link('X', array('/stock_in/remove/'.$item->id)); ?>
                            <?php echo CHtml::hiddenField('product_category[]', $item->product_category).CHtml::hiddenField('product_type[]', $item->product_type).CHtml::hiddenField('product_brand[]', $item->product_brand).CHtml::hiddenField('product_id[]', $item->product_id); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </table>		
            </div>
            <?php endif; ?>
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