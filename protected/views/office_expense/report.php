    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'expense_info', 'activeTab' => 'expense_report')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
        <div id="ptable3">
        <div style="margin-left:5px;"><h1>Office Expense Report</h1></div>

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($model)): 
					 
				?>
				<tr>
                    <th width="15%" scope="col">Type</th>
                    <th width="15%" scope="col">Name</th>
                    <th width="15%" scope="col">Date</th>
                    <th width="15%" scope="col">Voucher No</th>
                    <th width="10%" scope="col">Mode</th>
                    <th width="20%" scope="col">Expense By</th>
                    <th width="10%" scope="col">Amount</th>
				</tr>
                <?php $i=1; $total_amount = 0; foreach($model as $model): 
				      $expense_type_id   = $model->expense_type_id;
				      $expense_name_id   = $model->expense_name_id;
				      $expense_by   = $model->expense_by;
					  
					  $cond1 = new CDbCriteria( array( 'condition' => "id = '$expense_type_id'",) ); 					 
					  $cond2 = new CDbCriteria( array( 'condition' => "id = '$expense_name_id'",) ); 					 
					  $cond3 = new CDbCriteria( array( 'condition' => "username = '$expense_by'",) ); 	
                     
					  $eTypes = Expense_Type::model()->findAll( $cond1 );
                      $eNames = Expense_Name::model()->findAll( $cond2 );
                      $eBys   = Users::model()->findAll( $cond3 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
                    <td><?php if(count($eTypes)): foreach($eTypes as $eType): echo $eType->expense_type_name; endforeach; endif; ?></td>
                    <td><?php if(count($eNames)): foreach($eNames as $eName): echo $eName->expense_name; endforeach; endif; ?></td>
					<td><?php echo date('M d, Y', strtotime($model->expense_date)); ?></td>
                    <td><?php echo $model->voucher_no; ?></td>
                    <td><?php echo $model->payment_mode; ?></td>
                    <td><?php if(count($eBys)): foreach($eBys as $eBy): echo $eBy->full_name; endforeach; endif; ?></td>
                    <td><?php echo "TK. ".$model->amount; ?></td>
				</tr>
                <?php $i = $i + 1; $total_amount =  $total_amount + $model->amount; endforeach; ?>
				<tr><td colspan="5">&nbsp;</td><td  align="right">Total Expense:&nbsp;</td><td><?php echo "TK. ".$total_amount; ?></td></tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="7" class="red-left">No Delivery Information Available.</td></div></tr>
                <?php endif; ?>
				</table> 
                </div>
<!--  END #PORTLETS -->  
   </div>
