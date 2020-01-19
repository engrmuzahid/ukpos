
         <?php echo CHtml::beginForm('/pos_uk/account_received/add','post',array( 'enctype'=>'multipart/form-data')); ?>
         <table align="center" width="50%" style=" margin-left:5px;margin-bottom:10px;">
        <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                    <th align="left" width="20%"><?php echo "Invoice No"; ?><span class="markcolor">*</span></th>            
                    <td  align="left" width="20%"><?php echo CHtml::textField('invoice_no', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
                    <td  align="left" width="60%">&nbsp;&nbsp;<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
                </tr>
           <tr><td colspan="3">&nbsp;</td></tr>
          </table>
         <?php echo CHtml::endForm(); ?>
         
       <?php  if(count($model)): ?>
       <table border="0" width="90%"  cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-left:5px; background-color:#EEEEEE"> 
        <tr><td colspan="8">&nbsp;</td></tr>
		<?php   foreach($model as $model):
					  $delivery_id   = $model->id;
		              $customer_name = "";
					
					if(!empty($model->customer_id)):
				      $customer_id   = $model->customer_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 
                      $Customers = Customer::model()->findAll( $q1 );
                      if(count($Customers)): foreach($Customers as $Customers): $customer_name = $Customers->customer_name; endforeach; endif;
					else:
					 $customer_name = $model->customer_name;
					endif;
		  ?>
        <tr>
        <td width="20%">&nbsp;<strong><?php echo 'Invoice No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo $model->invoice_no; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Sale Date'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo date('M d, Y', strtotime($model->order_date)); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top">&nbsp;<strong><?php echo 'Customer Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo $customer_name; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Sub Total'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo "&pound; ".$model->amount_sub_total; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top">&nbsp;<strong><?php echo 'Discount'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo "&pound; ".$model->discount." (".$model->discount_ratio." % )"; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Grand Total'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo "&pound; ".$model->amount_grand_total; ?></td>
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
                <tr><td colspan="7"><hr size="1" /></td></tr>
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
                    <td align="center"><?php echo "&pound; ".$data->amount; ?></td>
                    <td align="center"><?php echo $data->quantity; ?></td>
                    <td align="center"><?php echo "&pound; ".$data->amount * $data->quantity; ?></td>
				</tr>
                <?php $i = $i + 1;
				 endforeach; endif; ?>
                <tr><td colspan="6"><hr size="1" /></td></tr>
                <tr>
                <td align="center" colspan="2">&nbsp;</td>
                <td align="center"><strong>Paid Amount: </strong></td><td align="center" ><?php echo "&pound; ".$model->paid_amount; ?></td>
                <td align="center"><strong>Due Amount: </strong></td><td align="center" ><?php $due_total = $model->amount_grand_total - $model->paid_amount; echo "&pound; ".$due_total; ?></td>
                </tr>
               <tr><td colspan="7">&nbsp;</td></tr>
        </table>
	   <?php echo CHtml::beginForm('/pos_uk/account_received/add','post',array('id' => 'frm_soft', 'name' => 'frm_soft', 'enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
        <?php
			 $models_bank      = Bank_Info::model()->findAll(array('order' => 'bank_name'));			 
			 $bank_list        = CHtml::listData($models_bank, 'id', 'bank_name');
             $cheque_type_list = array('cash' => 'Cash', 'account pay' => 'Account Pay',);
			 $common_list = array('' => '',);
		?>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Receive Date', 'receive_date')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::textField('receive_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="10%">
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Amount', 'amount')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::textField('amount', $due_total, array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Payment Mode', 'receive_mode')?>&nbsp;&nbsp;</strong></td>
			<td valign="top">
			<?php echo CHtml::radioButton('receive_mode', '', array( 'value'=>'bank', 'onclick' => "document.getElementById('c1').style.display='block'; document.getElementById('c2').style.display='block'; document.getElementById('cash_total').style.display='none';") )." Bank"; ?>
			<?php echo CHtml::radioButton('receive_mode', '', array( 'value'=>'cash', 'onclick' => "check_value()") )." Cash"; ?>
            <div id="cash_total"></div>
            </td>
			<td>
            <?php //echo CHtml::error($model,'stock_in_date'); ?>
           </td>
		</tr>
        </table>
        
    <fieldset id="c1" style="display:none; margin-left:20px; width:450px;">
    <legend align="left">Receive Cheque Detail</legend>
		<table style="margin-left:10px;"> 
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
        <td align="left" valign="top"><?php echo CHtml::label('Bank Name', 'r_bank_name')?>&nbsp;&nbsp;</td>
        <td><?php echo CHtml::textField('r_bank_name', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
        <td align="left" valign="top"><?php echo CHtml::label('Cheque No', 'r_cheque_no')?>&nbsp;&nbsp;</td>
        <td><?php echo CHtml::textField('r_cheque_no', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <td align="left" valign="top"><?php echo CHtml::label('Cheque Date', 'cheque_date')?>&nbsp;&nbsp;</td>
            <td><?php echo CHtml::textField('r_cheque_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
            <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		</table>
       </fieldset>
    <fieldset id="c2" style="display:none; margin-left:20px; width:450px;">
    <legend align="left">Deposit In Detail</legend>
		<table style="margin-left:10px;"> 
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
        <td align="left" valign="top"><?php echo CHtml::label('Bank Name', 'd_bank_id')?>&nbsp;&nbsp;</td>
        <td><?php echo CHtml::dropDownList('d_bank_id','d_bank_id', $bank_list, array('empty' => '----- Select Bank -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onchange' => 'getAccountNo()')); ?></td>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <td align="left" valign="top"><?php echo CHtml::label('Account No', 'd_account_no')?>&nbsp;&nbsp;</td>
            <td><div id="account_name" style="width:200px;"><?php echo CHtml::dropDownList('d_account_no','d_account_no', $common_list, array('empty' => '----- Select Account No -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
            <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
        <td align="left" valign="top">&nbsp;&nbsp;</td>
        <td colspan="2"><div id="account_total"></div></td>
        </tr>
		</table>
        </fieldset>

      <table style="margin-left:20px;"> 
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</th>
            <td valign="top">
            <input type="hidden"  name="customer_id"  id="customer_id" value="<?php echo $model->customer_id; ?>" />
            <input type="hidden"  name="invoice_no" id="invoice_no" value="<?php echo $model->invoice_no; ?>" />
            <input type="hidden"  name="amount_grand_total" id="amount_grand_total" value="<?php echo $model->amount_grand_total; ?>" />
            <input type="hidden"  name="paid_amount" id="paid_amount" value="<?php echo $model->paid_amount; ?>" />
			<?php echo CHtml::submitButton('Save' ,array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel' ,array('class' => 'buttonGreen')); ?>
            </td>
            <td></td>
        </tr>
	</table>
<?php echo CHtml::endForm()?>    
<?php endif; ?>
