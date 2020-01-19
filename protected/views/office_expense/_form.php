<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
        <?php
			 $models_extype_list = Expense_Type::model()->findAll(array('order' => 'expense_type_name'));			 
			 $extype_list        = CHtml::listData($models_extype_list, 'id', 'expense_type_name');
			
			 $models_user_list = Users::model()->findAll(array('order' => 'full_name'));			 
			 $user_list        = CHtml::listData($models_user_list, 'username', 'full_name');
			 $models_bank      = Bank_Info::model()->findAll(array('order' => 'bank_name'));			 
			 $bank_list        = CHtml::listData($models_bank, 'id', 'bank_name');
             $cheque_type_list = array('cash' => 'Cash', 'account pay' => 'Account Pay',);
			 $common_list = array('' => '',);
		?>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Expense Type', 'expense_type_id')?>&nbsp;&nbsp;</strong></td>
            <td><?php echo CHtml::dropDownList('expense_type_id','expense_type_id', $extype_list, array('empty' => '----- Select Type -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onchange' => 'getExpenseName()')); ?></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
			<td valign="top"><strong><?php echo CHtml::label('Expense Name', 'expense_name_id')?>&nbsp;&nbsp;</strong></td>
            <td><div id="expense_name" style="width:200px;"><?php echo CHtml::dropDownList('expense_name_id','expense_name_id', $common_list, array('empty' => '----- Select Name -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Date', 'expense_date')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::textField('expense_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="10%">
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
			<td valign="top"><strong><?php echo CHtml::label('Voucher No', 'voucher_no')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::textField('voucher_no', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="10%">
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Expense By', 'expense_by')?>&nbsp;&nbsp;</strong></td>
            <td><?php echo CHtml::dropDownList('expense_by','expense_by', $user_list, array('empty' => '----- Select User -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
			<td valign="top"><strong><?php echo CHtml::label('Amount', 'amount')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::textField('amount', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onKeyUp' => 'getamount_value()' ))?>
                <div id="amount_error" class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
             </td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
			<td valign="top"><strong><?php echo CHtml::label('Description', 'expense_description')?>&nbsp;&nbsp;</strong></td>
			<td><?php echo CHtml::TextArea('expense_description', '', array('style' => 'width:200px;height:60px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'note'); ?></div>
           </td>
			<td valign="top"><strong><?php echo CHtml::label('Payment Mode', 'payment_mode')?>&nbsp;&nbsp;</strong></td>
			<td valign="top">
			<?php echo CHtml::radioButton('payment_mode', '', array( 'value'=>'bank', 'onclick' => "document.getElementById('BankInfo').style.display='block'; document.getElementById('cash_total').style.display='none';") )." Bank"; ?>
			<?php echo CHtml::radioButton('payment_mode', '', array( 'value'=>'cash', 'onclick' => "check_value();  document.getElementById('bank_id').value=''; document.getElementById('account_no').value='';   document.getElementById('cheque_no').value=''; document.getElementById('cheque_date').value=''; document.getElementById('cheque_type').value='';  document.getElementById('account_amount').innerHTML=''; ") )." Cash"; ?>
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
        <tr>
        <td align="left" valign="top"><?php echo CHtml::label('Cheque No', 'cheque_no')?>&nbsp;&nbsp;</td>
        <td><div id="cheque_name" style="width:200px;"><?php echo CHtml::dropDownList('cheque_no','cheque_no', $common_list, array('empty' => '----- Select Cheque No -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div>
             <div id ="account_amount">&nbsp;</div>
        </td>
        <td valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo CHtml::label('Cheque Date', 'cheque_date')?>&nbsp;&nbsp;</td>
        <td><?php echo CHtml::textField('cheque_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
        <td valign="top">&nbsp;</td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr>
        <td align="left" valign="top"><?php echo CHtml::label('Cheque Type', 'cheque_type')?>&nbsp;&nbsp;</td>
        <td><?php echo CHtml::dropDownList('cheque_type','cheque_type', $cheque_type_list, array('empty' => '----- Select Type -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td valign="top" colspan="4">&nbsp;</td>
        </tr>
		</table>
        </fieldset>
	  </td></tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</th>
            <td valign="top">
            <input type="hidden" id="t_balance"  name="t_balance" value="" />
			<?php echo CHtml::submitButton('Save' ,array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel' ,array('class' => 'buttonGreen')); ?>
            </td>
            <td></td>
        </tr>
	</table>
<?php echo CHtml::endForm()?>