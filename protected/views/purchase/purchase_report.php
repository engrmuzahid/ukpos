    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>
 
 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">Receiving Report</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/purchase'; ?>" class="none new">Home</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/purchase/add'; ?>" class="none new">Receive Product</a>  
				<a href="<?php echo Yii::app()->request->baseUrl.'/purchase/report'; ?>" class="none new">Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/purchase/product_report'; ?>" class="none new">Receiving Product Report</a>                  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td id="item_table">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
            <div id="table_holder">            
			<table class="tablesorter" id="sortable_table" style="width:100%">
                <?php  if(count($model)): 
					 
				?>
				<tr>
                    <th width="12%">Shipment Id</th>
                    <th width="15%">Receive Date</th>
                    <th width="18%">Supplier Name</th>
                    <th width="15%">Total</th>
                    <th width="15%">Paid</th>
                    <th width="15%">Due</th>
                    <th width="10%">&nbsp;</th>
				</tr>
                <?php $i=1; 
				        $grand_total = 0;  $paid_total = 0;  $due_total = 0; 
				       foreach($model as $model): 
				      $supplier_id   = $model->supplier_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$supplier_id'",) ); 					 
                      $Suppliers = Supplier::model()->findAll( $q1 );
					  $due_amount = $model->price_grand_total - $model->paid_amount;
				 ?>
				<tr style="font-family:Verdana; font-size:11px;">
                    <td><?php echo $model->chalan_id; ?></td>
					<td><?php echo date('M d, Y', strtotime($model->purchase_date)); ?></td>
                    <td><?php if(count($Suppliers)): foreach($Suppliers as $Suppliers): echo $Suppliers->name; endforeach; endif; ?></td>
                    <td><?php echo "&pound; ".number_format($model->price_grand_total, 2); ?></td>
                    <td><?php echo "&pound; ".number_format($model->paid_amount, 2); ?></td>
                    <td><?php echo "&pound; ".number_format($due_amount); ?></td>
                    <td  style="margin-left:5px;">
					<a href="<?php echo Yii::app()->request->baseUrl.'/purchase/view/'.$model->id; ?>" title="Show">Show</a>
                    </td>
				</tr>
                <?php $i = $i + 1;
					$grand_total = $grand_total + $model->price_grand_total;
					$paid_total = $paid_total + $model->paid_amount;
					$due_total = $due_total + $due_amount;
				 endforeach; ?>
				<tr>
					<td colspan="3" align="right"><strong>Total (&pound;) :&nbsp;&nbsp;</strong></td>
                    <td align="left"><strong><?php echo number_format($grand_total, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($paid_total, 2); ?></strong></td>
                    <td align="left"><strong><?php echo number_format($due_total, 2); ?></strong></td>
					<td>&nbsp;</td>
        		</tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="7" class="red-left">No Receive Information Available.</td></div></tr>
                <?php endif; ?>
				</table> 
          </div>
         </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
