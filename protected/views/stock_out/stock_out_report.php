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
		<td id="title">Stock Out Report</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
				<a href="<?php echo Yii::app()->request->baseUrl.'/stock_in/report'; ?>" class="none new">Stock Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_out'; ?>" class="none new">Stock Out</a>    
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_out/report'; ?>" class="none new">Stock Out Report</a>                  
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
                    <th width="15%" scope="col">Date</th>
                    <th width="15%" scope="col">Item Code</th>
                    <th width="35%" scope="col">Item Name</th>
                    <th width="10%" scope="col">Qty</th>
                    <th width="15%" scope="col">Reason</th>
                    <th width="10%" scope="col">&nbsp;</th>
				</tr>
                <?php $i=1; foreach($model as $model): 
					  $product_code    = $model->product_code;
					  $q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 
					  $Products       = Product::model()->findAll( $q1 );
					  
					  $product_name = ""; $min_stock = 0; $sell_price = 0;  
					  if(count($Products)): foreach($Products as $product_names):
					   $product_name = $product_names->product_name;
					   endforeach; endif;
				 ?>
				<tr style="font-family:Verdana; font-size:11px;">
					<td><?php echo date('M d, Y', strtotime($model->stock_out_date)); ?></td>
                    <td><?php echo $product_code; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $model->quantity; ?></td>
                    <td><?php echo $model->reason; ?></td>
                    <td style="margin-left:10px;">
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/stock_out/delete/'.$model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="7" class="red-left">No Product Available.</td></div></tr>
                <?php endif; ?>
				</table> 
          </div>
          </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
