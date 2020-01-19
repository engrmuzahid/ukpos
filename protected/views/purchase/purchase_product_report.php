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
		<td id="title">Receive Product Report</td>
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
			<div id="table_holder">
           <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
			<table class="tablesorter" id="sortable_table" style="width:95%; margin-left:10px;">
                <?php  if(count($model)): 
					 
				?>
				<tr>
                    <th width="15%">Code</th>
                    <th width="30%">Name</th>
                    <th width="15%">Date</th>
                    <th width="10%">Qty</th>
                    <th width="15%">Price</th>
                    <th width="15%">Total</th>
				</tr>
                <?php $i=1; $total = 0; foreach($model as $model): 
				      
					  $product_code    = $model->product_code;
					  $q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 
					  $Products       = Product::model()->findAll( $q1 );
					  $product_name = "";  
					  if(count($Products)): foreach($Products as $Products): $product_name = $Products->product_name; endforeach; endif;
				 ?>
				<tr  style="font-family:Verdana; font-size:11px;">
                	<td><?php echo $product_code; ?></td>
					<td><?php echo $product_name; ?></td>
                    <td><?php echo date('M d, Y', strtotime($model->purchase_date)); ?></td>
                    <td><?php echo $model->quantity; ?></td>
					<td><?php echo "&pound; ".number_format($model->product_price, 2); ?></td>
                    <td><?php $sub_total = $model->product_price * $model->quantity; 
					      echo "&pound; ".number_format($sub_total, 2); ?></td>
				</tr>
                <?php $i = $i + 1; $total = $total + $sub_total; endforeach; ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td colspan="5" align="right"><strong>Grand Total :</strong>&nbsp;&nbsp;</td>
                    <td><?php echo "&pound; ".number_format($total, 2); ?></td>
				</tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="6" class="red-left">No Product Received Available.</td></div></tr>
                <?php endif; ?>
				</table> 
          </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
