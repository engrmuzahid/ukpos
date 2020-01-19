
   <?php echo CHtml::beginForm('/pos_uk/purchase/entry','post',array('enctype'=>'multipart/form-data')); ?>
       <table align="center" width="95%" style="margin-bottom:10px;margin-left:10px;"> 
          <tr><td colspan="3">&nbsp;</td></tr>
		  <tr height="25" style="font-weight:bold; margin-bottom:10px;">
		    <td width="8%">&nbsp;</td>
            <td align="center" width="15%" valign="top"><?php echo CHtml::label('Product Code', 'product_code')?><span class="markcolor">*</span></td>
			<td align="center" width="15%"><?php echo CHtml::textField('product_code', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="25%"><?php echo CHtml::submitButton('Add' ,array('class' => 'buttonGreen')); ?></td>
			<td width="20%"  align="center"><a href="<?php echo Yii::app()->request->baseUrl; ?>/product/add" target="_blank"> Add New Item</a></td>
        </tr>
          <tr><td colspan="5">&nbsp;</td></tr>
       </table>
  <?php echo CHtml::endForm()?>
<script>
	function getQtyTotal()
	{
     
	var mutli_education = document.purchase.elements["quantity[]"];
     mlt = mutli_education.length;
	 if(!mlt){ mlt = 1; } else{ mlt = mlt; }
	 var newTotal=0;
	 for(var i=1; i<= mlt; i++)
		{
		 
		var pprice    = document.getElementById("price"+i).value;
		var qty =  document.getElementById("quantity"+i).value;
		var st=pprice * qty;
		document.getElementById("subTotal"+i).innerHTML = "&pound; "+st;
		newTotal+=new Number(st);
		}
		document.getElementById("price_grand_total").value = newTotal;
		document.getElementById("amountSubTotal").innerHTML = "&pound; "+newTotal;
	}
</script>
<?php echo CHtml::beginForm('','post',array('name' => 'purchase', 'enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
		<td colspan="3">
				<?php 
				$amount_sub_total = 0;
	            $username   = Yii::app()->user->name;
				$cond = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
				$cart = Purchase_Tempory::model()->findAll( $cond );
				
				 if(count($cart)): ?>
                <div id="cart2">
                <table>
                <caption>Product List</caption>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Brand Name</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <?php $i = 1; foreach ($cart as $item):
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
                      $Brand_names    = Product_Brand::model()->findAll( $q4 );
                      $Products       = Product::model()->findAll( $q3 );
				 ?>
                    <tr>
                        <td align="center"><?php if(count($Category_names)): foreach($Category_names as $Category_names): echo $Category_names->category_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Brand_names)): foreach($Brand_names as $Brand_names): echo $Brand_names->brand_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Products)): foreach($Products as $Products): echo $Products->product_name; endforeach; endif; ?></td>
                        <td align="center"><?php echo "&pound; "; echo CHtml::textField('price[]', $item->p_price, array('id'=>'price'.$i, 'style' => 'width:50px;height:25px;border:1px solid #CCC;', 'onKeyUp' => 'javascript:getQtyTotal()'));?></td>
                        <td align="center"><?php echo CHtml::textField('quantity[]', '1', array('id' => 'quantity'.$i, 'style' => 'width:50px;height:25px;border:1px solid #CCC;', 'onKeyUp' => 'javascript:getQtyTotal()'))?></td>
                        <td align="center"><div id = "<?php echo 'subTotal'.$i; ?>"><?php echo "&pound; ".$item->p_price * 1; ?></div></td>
                        <td  class="remove">
                            <?php echo CHtml::link('X', array('/purchase/remove/'.$item->id)); ?>
                            <?php echo CHtml::hiddenField('product_category[]', $item->product_category_id).CHtml::hiddenField('product_type[]', $item->product_type_id).CHtml::hiddenField('product_brand[]', $item->product_brand_id).CHtml::hiddenField('product_id[]', $item->product_id); ?>
                        </td>
                    </tr>
                <?php 
				       $pree_amount = $item->p_price * 1;
				      $amount_sub_total = $amount_sub_total + $pree_amount;
					  $i = $i + 1;
				endforeach; ?>
                <tr><td colspan="6" align="right"><strong>Grand Total: </strong></td><td  align="center"><div id = "amountSubTotal"><?php echo "&pound; ".$amount_sub_total; ?></div> <input type="hidden"  name="price_grand_total" id="price_grand_total" value="<?php echo $amount_sub_total; ?>" /></td></tr>
                </table>		
            </div>
            <?php endif; ?>
		</td>
		</tr>
        <?php
			 $models_supplier_list    = Supplier::model()->findAll(array('order' => 'name'));			 
			 $supplier_list           = CHtml::listData($models_supplier_list, 'id', 'name');
			
			 $models_shop_list = Warehouse::model()->findAll(array('order' => 'shop_name'));			 
			 $shop_list        = CHtml::listData($models_shop_list, 'id', 'shop_name');

			 $criteria = new CDbCriteria();
			 $criteria->order = 'id DESC';
			 $criteria->limit = 1;
			 $purchases = Purchase::model()->findAll($criteria);
			 
			 if(count($purchases)): foreach($purchases as $lastValues): 
			  $p_sl  = $lastValues->id + 1; 
              $cl_id = date('y').date('m').date('d').$p_sl; 
			 if(!empty($cl_id)): $cl_id = $cl_id; else: $cl_id = date('y').date('m').date('d').'1'; endif;
		     endforeach;
			 else:
			  $cl_id = date('y').date('m').date('d').'1';
			 endif;

		?>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'shipment_id')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'chalan_id', array('value' => $cl_id, 'readonly' => 'readonly', 'style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
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
			<th valign="top"><?php echo CHtml::label('Shop', 'shop_name')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::dropDownList('shop_id', '', $shop_list, array('empty' => 'Select Shop', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
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