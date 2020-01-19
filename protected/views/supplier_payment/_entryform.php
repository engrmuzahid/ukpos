
         <?php echo CHtml::beginForm('/pos_uk/supplier_payment/add','post',array( 'enctype'=>'multipart/form-data')); ?>
         <table align="center" width="50%" style=" margin-left:5px;margin-bottom:10px;">
          <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                    <th  align="left" width="20%"><?php echo "Shipment Id"; ?><span class="markcolor">*</span></th>            
                    <td  align="left" width="20%"><?php echo CHtml::textField('chalan_id', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
                    <td   align="left" width="60%">&nbsp;&nbsp;<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
                </tr>
           <tr><td colspan="3">&nbsp;</td></tr>
          </table>
         <?php echo CHtml::endForm(); ?>
         
       <?php  if(count($model)): ?>
       <table border="0" width="90%"  cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-left:5px; background-color:#EEEEEE"> 
        <tr><td colspan="8">&nbsp;</td></tr>
		<?php   foreach($model as $model):
				      $supplier_id   = $model->supplier_id;
					  $delivery_id   = $model->id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$supplier_id'",) ); 
					  $q2 = new CDbCriteria( array( 'condition' => "delivery_id = '$delivery_id'",) ); 					 
                      $Suppliers = Supplier::model()->findAll( $q1 );
		  ?>
        <tr>
        <td width="20%">&nbsp;<strong><?php echo 'Shipment Id'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo $model->chalan_id; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Purchase Date'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo date('M d, Y', strtotime($model->purchase_date)); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top">&nbsp;<strong><?php echo 'Supplier Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php if(count($Suppliers)): foreach($Suppliers as $Suppliers): echo $Suppliers->name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Note'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo $model->note; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
       <?php endforeach;  ?>
      </table>
       <table border="1" width="90%"  cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-left:5px; background-color:#EEEEEE">  
        <tr><td colspan="7">&nbsp;</td></tr>
                <?php  if(count($model2)): 
					 
				?>
				<tr>
                    <th width="15%" scope="col">Category</th>
                    <th width="15%" scope="col">Subcategory</th>
                    <th width="20%" scope="col">Product Name</th>
                    <th width="20%" scope="col">Price</th>
                    <th width="10%" scope="col">Quantity</th>
                    <th width="20%" scope="col">Total</th>
				</tr>
                <tr><td colspan="6"><hr size="1" /></td></tr>
                <?php $i=1; $amount_sub_total = 0;
				      foreach($model2 as $data): 
				      $product_category = $data->product_category;
				      $product_type     = $data->product_type;
				      $product_id       = $data->product_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$product_category'",) ); 
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$product_type'",) ); 
					  $q3 = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 

					  $Category_names = Product_Category::model()->findAll( $q1 );
					  $Type_names     = Product_Type::model()->findAll( $q2 );
					  $product_names  = Product::model()->findAll( $q3 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
                	<td align="center"><?php if(count($Category_names)): foreach($Category_names as $Category_name): echo $Category_name->category_name; endforeach; endif; ?></td>
					<td align="center"><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
					<td align="center"><?php if(count($product_names)): foreach($product_names as $product_names): echo $product_names->product_name; endforeach; endif; ?></td>
                    <td align="center"><?php echo "&pound; ".$data->product_price; ?></td>
                    <td align="center"><?php echo $data->quantity; ?></td>
                    <td align="center"><?php echo "&pound; ".$data->product_price * $data->quantity; ?></td>
				</tr>
                <?php $i = $i + 1;
				       $pree_amount = $data->product_price * $data->quantity;
				       $amount_sub_total = $amount_sub_total + $pree_amount;
				 endforeach; endif; ?>
                <tr><td colspan="6"><hr size="1" /></td></tr>
                <tr>
                <td align="center"><strong>Grand Total: </strong></td><td align="center" ><?php echo "&pound; ".$model->price_grand_total; ?></td>
                <td align="center"><strong>Paid Amount: </strong></td><td align="center" ><?php echo "&pound; ".$model->paid_amount; ?></td>
                <td align="center"><strong>Due Amount: </strong></td><td align="center" ><?php $due_total = $model->price_grand_total - $model->paid_amount; echo "&pound; ".$due_total; ?></td>
                </tr>
               <tr><td colspan="6">&nbsp;</td></tr>
        </table>
	   <?php echo CHtml::beginForm('/pos_uk/supplier_payment/add','post',array('id' => 'frm_soft', 'name' => 'frm_soft', 'enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
        <?php
			 $models_bank      = Bank_Info::model()->findAll(array('order' => 'bank_name'));			 
			 $bank_list        = CHtml::listData($models_bank, 'id', 'bank_name');
             $cheque_type_list = array('cash' => 'Cash', 'account pay' => 'Account Pay',);
			 $common_list = array('' => '',);
		?>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Payment Date', 'payment_date')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::textField('payment_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="10%">
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Amount', 'amount')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::textField('amount', $due_total, array('style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onKeyUp' => 'getamount_value()'))?>
            <div id="amount_error" class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
            </td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Payment Mode', 'payment_mode')?>&nbsp;&nbsp;</strong></td>
			<td valign="top">
			<?php echo CHtml::radioButton('payment_mode', '', array( 'value'=>'bank', 'onclick' => "document.getElementById('BankInfo').style.display='block'; document.getElementById('cash_total').style.display='none';") )." Bank"; ?>
			<?php echo CHtml::radioButton('payment_mode', '', array( 'value'=>'cash', 'onclick' => "check_value();   document.getElementById('bank_id').value=''; document.getElementById('account_no').value='';   document.getElementById('cheque_no').value=''; document.getElementById('cheque_date').value=''; document.getElementById('cheque_type').value='';  document.getElementById('account_amount').innerHTML='';") )." Cash"; ?>
            <div id="cash_total"></div>
            </td>
			<td>
            <?php //echo CHtml::error($model,'stock_in_date'); ?>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>

		<tr><td colspan="3">
    <fieldset id="BankInfo" style="display:none; width:550px;">
    <legend align="left">Bank Info Detail</legend>
		<table style="margin-left:10px;"> 
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
        <td align="left" valign="top"><?php echo CHtml::label('Bank Name', 'bank_id')?>&nbsp;&nbsp;</td>
        <td><?php echo CHtml::dropDownList('bank_id','bank_id', $bank_list, array('empty' => '----- Select Bank -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onchange' => 'getAccountNo()')); ?></td>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <td align="left" valign="top"><?php echo CHtml::label('Account No', 'account_no')?>&nbsp;&nbsp;</td>
            <td><div id="account_name" style="width:200px;"><?php echo CHtml::dropDownList('account_no','account_no', $common_list, array('empty' => '----- Select Account No -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
            <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
        <td align="left" valign="top"><?php echo CHtml::label('Cheque No', 'cheque_no')?>&nbsp;&nbsp;</td>
        <td><div id="cheque_name" style="width:200px;"><?php echo CHtml::dropDownList('cheque_no','cheque_no', $common_list, array('empty' => '----- Select Cheque No -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div>
            <div id ="account_amount">&nbsp;</div>
        </td>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <td align="left" valign="top"><?php echo CHtml::label('Cheque Date', 'cheque_date')?>&nbsp;&nbsp;</td>
            <td><?php echo CHtml::textField('cheque_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
            <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
        <td align="left" valign="top"><?php echo CHtml::label('Cheque Type', 'cheque_type')?>&nbsp;&nbsp;</td>
        <td><?php echo CHtml::dropDownList('cheque_type','cheque_type', $cheque_type_list, array('empty' => '----- Select Type -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td valign="top">&nbsp;</td>
        </tr>
		</table>
        </fieldset>
	  </td></tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</th>
            <td valign="top">
            <input type="hidden" id="t_balance"  name="t_balance" value="" />
            <input type="hidden"  name="supplier_id" id="supplier_id" value="<?php echo $model->supplier_id; ?>" />
            <input type="hidden"  name="chalan_id" id="chalan_id" value="<?php echo $model->chalan_id; ?>" />
            <input type="hidden"  name="price_grand_total" id="price_grand_total" value="<?php echo $model->price_grand_total; ?>" />
            <input type="hidden"  name="paid_amount" id="paid_amount" value="<?php echo $model->paid_amount; ?>" />
			<?php echo CHtml::submitButton('Save' ,array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel' ,array('class' => 'buttonGreen')); ?>
            </td>
            <td></td>
        </tr>
	</table>
<?php echo CHtml::endForm()?>    
<?php endif; ?>
