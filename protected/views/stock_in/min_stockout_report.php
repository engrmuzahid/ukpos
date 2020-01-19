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
		<td id="title">Minimum Stock Out Report</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell'; ?>" class="none new">Home</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/profit_loss_report'; ?>" class="none new">Profit / Loss Report</a>    
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell/report'; ?>" class="none new">Sell Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/daily_sell_report'; ?>" class="none new">Daily Sell Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_in/min_stockout_report'; ?>" class="none new">Min Stock Out Report</a> 
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell/sell_return'; ?>" class="none new">Sell Return</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/sell_return_report'; ?>" class="none new">Sell Return Report</a>                  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td id="item_table">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
			<div id="table_holder">
            
			<table class="tablesorter" id="sortable_table" style="width:100%">
                <?php  if(count($model)): ?>
				<tr>
                    <th width="16%" scope="col">Code</th>
                    <th width="38%" scope="col">Product Name</th>
                    <th width="12%" scope="col">Min Qty</th>
                    <th width="14%" scope="col">Stock Qty</th>
                    <th width="20%" scope="col">Sell Price</th>
				</tr>
                <?php $i=1; $min_stock = false; foreach($model as $model): 
				     
				      $product_code = $model->product_code;
					  $q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 

					  $product_names  = Product::model()->findAll( $q1 );
                      $product_name ="";
					  if(count($product_names)): foreach($product_names as $product_):
					   $product_name = $product_->product_name;
						   $sell_p       = $product_->sell_price; 
						   $vat_pp       = $product_->vat;
						   $vat = ($sell_p * $vat_pp) / 100;
						   $sell_price = $sell_p + $vat; 
					   $min_stock = $product_->min_stock;
					   endforeach; endif;					   
					   
				 ?>
                                <?php if($min_stock !== false) : ?>
                <?php if($model->product_balance <= $min_stock): $style = "style='font:Verdana; font-size:11px;background-color:#F47F7F'"; ?>
				<tr <?php echo $style; ?>>
					<td><?php echo $product_code; ?></td>
					<td><?php echo $product_name; ?></td>
                    <td><?php echo $min_stock; ?></td>
                    <td><?php echo $model->product_balance; ?></td>
                    <td><?php echo "&pound; ".number_format($sell_price, 2); ?></td>
				</tr>
                <?php endif; $min_stock = false; endif; $i = $i + 1; endforeach; ?>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="5" class="red-left">No Product Available.</td></div></tr>
                <?php endif; ?>
				</table> 
          </div>
          </div>
        <div id="pagination"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
