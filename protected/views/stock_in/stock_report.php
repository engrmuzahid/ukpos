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
		<td id="title">Stock Report</td>
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
            
			<table class="tablesorter" id="sortable_table"  style="width:100%">
                <?php  if(count($model)): ?>
				<tr>
                    <th width="20%" scope="col">Product Code</th>
                    <th width="40%" scope="col">Product Name</th>
                    <th width="20%" scope="col">Stock Quantity</th>
                    <th width="20%" scope="col">Sell Price</th>
				</tr>
                <?php $i=1; foreach($model as $model): 
				     
					  $product_code    = $model->product_code;
					  $q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 
					  $Products       = Product::model()->findAll( $q1 );
					  
					  $product_name = ""; $min_stock = 0; $sell_price = 0;  
					  if(count($Products)): foreach($Products as $product_names):
					   $product_name = $product_names->product_name;
					   $sell_p       = $product_names->sell_price; 
					   $vat_pp       = $product_names->vat;
					   $vat = ($sell_p * $vat_pp) / 100;
					   $sell_price = $sell_p + $vat; 					   
					   $min_stock = $product_names->min_stock;
					   endforeach; endif;
					   
					   if($model->product_balance <= $min_stock): $style = "style='font:Verdana; font-size:11px;background-color:#FF0000;'"; else: $style = "style='font:Verdana; font-size:11px;background-color:#E9E9E9'"; endif;
				 ?>
                
				<tr <?php echo $style; ?>>
					<td><?php echo $product_code; ?></td>
					<td><?php echo $product_name;  ?></td>
                    <td><?php echo $model->product_balance; ?></td>
                    <td><?php echo "&pound; ".number_format($sell_price, 2); ?></td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="4" class="red-left">No Product Available.</td></div></tr>
                <?php endif; ?>
				</table> 
          </div>
          </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
