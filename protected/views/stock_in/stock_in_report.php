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
		<td id="title">Stock In Report</td>
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
            <?php  if(count($model)): ?>
            <thead>
            <tr>
                <th width="5%" class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                <th width="15%" >Date</th>
                <th width="20%" >Product Code</th>
                <th width="35%" >Product Name</th>
                <th width="15%" >Quantity</th>
                <th width="10%">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($model as $model): 
				      $product_id       = $model->product_id;

					  $q3 = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 
                      $Products       = Product::model()->findAll( $q3 );
                      $product_name = ""; $product_code = "";
					  if(count($Products)): foreach($Products as $Products): $product_name = $Products->product_name; $product_code = $Products->product_code; endforeach; endif;
				 ?>
				<tr style="font:Verdana; font-size:11px;">
                    <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
					<td width="15%"><?php echo date('M d, Y', strtotime($model->stock_in_date)); ?></td>
                    <td><?php echo $product_code; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $model->quantity; ?></td>
                    <td style="margin-left:10px;">
					<!--<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/stock_in/edit/'.$model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a> | -->
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/stock_in/delete/'.$model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach;  ?>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="6" class="red-left">No Product Available.</td></div></tr>
                <?php endif; ?>
				</table> 
          </div>
          </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
