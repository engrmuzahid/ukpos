
   <?php echo CHtml::beginForm('/pos_uk/receive_delivery/entry','post',array('enctype'=>'multipart/form-data')); ?>
   <?php 
			$models1 = Product_Category::model()->findAll(array('order' => 'category_name'));	
			$models2 = Product_Type::model()->findAll(array('order' => 'type_name'));			 
			$models3 = Product::model()->findAll(array('order' => 'product_name'));			 
			$list1   = CHtml::listData($models1, 'id', 'category_name');
			$list2   = CHtml::listData($models2, 'id', 'type_name');		   
			$list3   = CHtml::listData($models3, 'product_id', 'product_name');		   
	?>

       <table align="center" width="95%" style="margin-bottom:10px; margin-left:10px;"> 
          <tr height="25" style="font-weight:bold; margin-bottom:10px;" bgcolor="#CCCCCC">
          <td align="center" width="20%" valign="top"><?php echo CHtml::activeLabel($model, 'category')?><span class="markcolor">*</span></td>
          <td align="center" width="20%" valign="top"><?php echo CHtml::activeLabel($model, 'product_type')?><span class="markcolor">*</span></td>
          <td align="center" width="20%" valign="top"><?php echo CHtml::activeLabel($model, 'product_name')?><span class="markcolor">*</span></td>
          <td align="center" width="10%" valign="top"><?php echo CHtml::activeLabel($model, 'price')?><span class="markcolor">*</span></td>
          <td align="center" width="10%" valign="top"><?php echo CHtml::activeLabel($model, 'quantity')?><span class="markcolor">*</span></td>
          <td align="center" width="10%" valign="top"><?php echo CHtml::activeLabel($model, 'total')?><span class="markcolor">*</span></td>
          <td width="10%">&nbsp;</td>
        </tr>
        <tr><td colspan="7">&nbsp;</td></tr>
        <tr>
        <td align="center" width="20%"><div id="pro_category" style="width:150px;"> <?php echo CHtml::dropDownList('product_category','product_category', $list1, array('empty' => '----- Select Category -----', 'style' => 'width:150px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductType()')); ?></div></td>
        <td align="center" width="20%"><div id="pro_type" style="width:150px;"> <?php echo CHtml::dropDownList('product_type','product_type', $list2, array('empty' => '----- Select Type -----', 'style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?></div></td>
        <td align="center" width="20%"><div id="pro_name" style="width:150px;"> <?php echo CHtml::dropDownList('product_id','product_id', $list3, array('empty' => '----- Select Name -----', 'style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?></div></td>
        <td align="center" width="10%"><?php echo CHtml::textField('p_price', '', array('style' => 'width:80px;height:23px;border:1px solid #CCC;', 'onKeyUp'=> 'javascript:getTotal()'))?></td>
        <td align="center" width="10%"><?php echo CHtml::textField('qty', '1', array('style' => 'width:80px;height:23px;border:1px solid #CCC;', 'onblur' => 'javascript:getTotal()'))?></td>
        <td align="center" width="10%"><?php echo CHtml::textField('amount_total', '', array('style' => 'width:80px;height:23px;border:1px solid #CCC;', 'readonly' => 'readonly'))?></td>
        <td width="10%"><?php echo CHtml::submitButton('Add' ,array('class' => 'buttonGreen')); ?></td>
        </tr>
       </table>
  <?php echo CHtml::endForm()?>

<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
        <tr>
		<td colspan="6">
				<?php 
				$amount_sub_total = 0;
	            $username   = Yii::app()->user->name;
				$cond = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
				$cart = Received_Delivery_Tempory::model()->findAll( $cond );
				
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
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach ($cart as $item):
					$product_type     = $item->product_type_id;
					$product_category = $item->product_category_id;
					$product_id       = $item->product_id;
					
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$product_category'",) ); 
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$product_type'",) ); 
					  $q3 = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 
					 
                      $Category_names = Product_Category::model()->findAll( $q1 );
                      $Type_names     = Product_Type::model()->findAll( $q2 );
                      $Products       = Product::model()->findAll( $q3 );
				 ?>
                    <tr>
                        <td align="center"><?php if(count($Category_names)): foreach($Category_names as $Category_names): echo $Category_names->category_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
                        <td align="center"><?php if(count($Products)): foreach($Products as $Products): echo $Products->product_name; endforeach; endif; ?></td>
                        <td align="center"><?php echo "TK. ".$item->p_price; ?></td>
                        <td align="center"><?php echo $item->quantity; ?></td>
                        <td align="center"><?php echo "TK. ".$item->p_price * $item->quantity; ?></td>
                        <td  class="remove">
                            <?php echo CHtml::link('X', array('/receive_delivery/remove/'.$item->id)); ?>
                            <?php echo CHtml::hiddenField('product_category[]', $item->product_category_id).CHtml::hiddenField('product_type[]', $item->product_type_id).CHtml::hiddenField('product_id[]', $item->product_id).CHtml::hiddenField('quantity[]', $item->quantity).CHtml::hiddenField('price[]', $item->p_price); ?>
                        </td>
                    </tr>
                <?php 
				       $pree_amount = $item->p_price * $item->quantity;
				      $amount_sub_total = $amount_sub_total + $pree_amount;
				endforeach; ?>
                <tr><td colspan="5" align="right"><strong>Grand Total: </strong></td><td  align="center"><?php echo "TK. ".$amount_sub_total; ?> <input type="hidden"  name="price_grand_total" value="<?php echo $amount_sub_total; ?>" /></td></tr>
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
			 $models_bank      = Bank_Info::model()->findAll(array('order' => 'bank_name'));			 
			 $bank_list        = CHtml::listData($models_bank, 'id', 'bank_name');
             $cheque_type_list = array('cash' => 'Cash', 'account pay' => 'Account Pay',);
			 $common_list = array('' => '',);
		?>
       
	    <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'received_from_date')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::activeTextField($model, 'received_from_date', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="10%">
            <div class="markcolor"><?php echo CHtml::error($model,'received_from_date'); ?></div>
           </td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'received_to_date')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::activeTextField($model, 'received_to_date', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="10%">
            <div class="markcolor"><?php echo CHtml::error($model,'received_to_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'expire_date')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::activeTextField($model, 'expire_date', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="10%">
            <div class="markcolor"><?php echo CHtml::error($model,'expire_date'); ?></div>
           </td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'storage_party')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::activeDropDownList($model, 'storage_party_id', $party_list, array('empty' => '----- Select Party -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td width="10%">
            <div class="markcolor"><?php echo CHtml::error($model,'storage_party_id'); ?></div>
           </td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'warehouse_name')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::activeDropDownList($model, 'warehouse_id', $compartment_list, array('empty' => '----- Select Warehouse -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td width="10%">
            <div class="markcolor"><?php echo CHtml::error($model,'warehouse_id'); ?></div>
           </td>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'total_charge')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::activeTextField($model, 'total_charge', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="10%">
            <div class="markcolor"><?php echo CHtml::error($model,'total_charge'); ?></div>
           </td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::activeLabel($model, 'received_note')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::activeTextArea($model, 'note', array('style' => 'width:200px;height:100px;border:1px solid #CCC;'))?></td>
			<td width="10%">
            <div class="markcolor"><?php echo CHtml::error($model,'note'); ?></div>
           </td>
			<td valign="top"><strong><strong><?php echo CHtml::label('Received Mode', 'payment_mode')?>&nbsp;&nbsp;</strong></td>
			<td valign="top">
			<?php echo CHtml::radioButton('payment_mode', '', array( 'value'=>'bank', 'onclick' => "document.getElementById('BankInfo').style.display='block'; document.getElementById('cash_total').style.display='none';") )." Bank"; ?>
			<?php echo CHtml::radioButton('payment_mode', '', array( 'value'=>'cash', 'onclick' => "document.getElementById('bank_id').value=''; document.getElementById('account_no').value='';   document.getElementById('cheque_no').value=''; document.getElementById('cheque_date').value=''; document.getElementById('cheque_type').value=''; ") )." Cash"; ?>
            <div id="cash_total"></div>
            </td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr><td colspan="6">
    <fieldset id="BankInfo" style="display:none">
    <legend align="left">Bank Info Detail</legend>
		<table style="margin-left:10px;"> 
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr>
        <td align="left" valign="top"><?php echo CHtml::label('Bank Name', 'bank_id')?>&nbsp;&nbsp;</td>
        <td><?php echo CHtml::dropDownList('bank_id','bank_id', $bank_list, array('empty' => '----- Select Bank -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onchange' => 'getAccountNo()')); ?></td>
        <td valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo CHtml::label('Account No', 'account_no')?>&nbsp;&nbsp;</td>
        <td>
        <div id="account_name" style="width:200px;"><?php echo CHtml::dropDownList('account_no','account_no', $common_list, array('empty' => '----- Select Account No -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div>
        
        </td>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		</table>
        </fieldset>
	  </td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>
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