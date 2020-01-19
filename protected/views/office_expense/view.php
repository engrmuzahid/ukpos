    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'expense_info', 'activeTab' => 'office_expense')); ?>
<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
        <div style="margin-left:15px;"><h1>Office Expense Details</h1></div>
		
		<?php   if(count($models)): foreach($models as $model):
				      $expense_type_id   = $model->expense_type_id;
				      $expense_name_id   = $model->expense_name_id;
				      $expense_by        = $model->expense_by;
				      $bank_id           = $model->bank_id;
				      $account_no        = $model->account_no;

					  $cond1 = new CDbCriteria( array( 'condition' => "id = '$expense_type_id'",) ); 
					  $cond2 = new CDbCriteria( array( 'condition' => "id = '$expense_name_id'",) ); 
					  $cond3 = new CDbCriteria( array( 'condition' => "username = '$expense_by'",) ); 
					  $cond4 = new CDbCriteria( array( 'condition' => "id = '$bank_id'",) ); 
					  $cond5 = new CDbCriteria( array( 'condition' => "id = '$account_no'",) ); 					 
                      $expenseTypes = Expense_Type::model()->findAll( $cond1 );
                      $expenseNames = Expense_Name::model()->findAll( $cond2 );
                      $userNames = Users::model()->findAll( $cond3 );
                      $bankNames = Bank_Info::model()->findAll( $cond4 );
                      $accountNames = Bank_Account::model()->findAll( $cond5 );
		  ?>
       <table border="0" width="90%"  cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:15px;">  
        <tr>
        <td width="20%"><strong><?php echo 'Expense Type'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php if(count($expenseTypes)): foreach($expenseTypes as $expenseTypes): echo $expenseTypes->expense_type_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Expense Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php if(count($expenseNames)): foreach($expenseNames as $expenseNames): echo $expenseNames->expense_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Expense Date'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo date('M d, Y', strtotime($model->expense_date)); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Voucher No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo $model->voucher_no; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Description'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo $model->expense_description; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Expense By'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php if(count($userNames)): foreach($userNames as $userNames): echo $userNames->full_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Payment Mode'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo $model->payment_mode; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Amount'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo $model->amount; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>   
       <?php if($model->payment_mode =='bank'): ?>
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Bank Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php if(count($bankNames)): foreach($bankNames as $bankNames): echo $bankNames->bank_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Account No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php if(count($accountNames)): foreach($accountNames as $accountNames): echo $accountNames->account_no; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Cheque Type'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo $model->cheque_type; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Cheque No'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo $model->cheque_no; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr> 
        <?php endif; ?>       
        </table>
       <?php endforeach; endif; ?>
           </div>     
<!--  END #PORTLETS -->  
   </div>
