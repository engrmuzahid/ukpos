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
		<td id="title">B2B Item List</td>
	</tr>
  </tbody>
</table>
<table id="contents">
	<tbody><tr>
		<td  colspan="3">

        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3" align="center">
               <p align="right" style="margin-right:100px;"><?php if(!empty($invoices)): echo "Total Invoices: ".$invoices; endif; ?></p>
		      <?php echo CHtml::beginForm('/pos_uk/customer/generate_b2b_list','post',array('name'=>'frm_soft', 'enctype'=>'multipart/form-data')); ?>
			  <input type="hidden"  name="invoices" id="invoices" value="<?php echo $invoices; ?>" />
			  <table  border="1" style="width:80%; border-collapse:collapse;">
				<?php if(count($model)):	?>
				<tr>
                    <th width="60%" scope="col">Product Name</th>
                    <th width="15%" scope="col">Quantity</th>
                    <th width="25%" scope="col">Comment</th>
				</tr>
                <?php
				  $q_total = 0;
				  foreach($model as $modValue):
                  $product_code  = $modValue->product_code;				  
                  $quantity      = $modValue->quantity;
                  $amount        = $modValue->amount; 
				
				  $q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) );                    
				  $ProVals       = Product::model()->findAll( $q1 );
                  
                 ?>
				<tr>
                    <td align="justify">&nbsp;<?php $product_name = ""; if(count($ProVals)): foreach($ProVals as $ProVal): echo $product_name = $ProVal->product_name; endforeach; endif; ?>
                    <input type="hidden" name="product_name[]" id="product_name" value="<?php echo $product_name; ?>" />
					</td>
                    <td align="center">
					 <?php echo $quantity;  ?>
                     <input type="hidden"  name="quantity[]" id="quantity" value="<?php echo $quantity; ?>" />
					</td>
					<td align="center"> <?php echo CHtml::textField('comment[]', '', array('style' => 'width:150px;height:20px;border:1px solid #000;'))?></td>
				</tr>
             <?php
			   $q_total = $q_total + $quantity;
			 
			 endforeach; ?>
             	<tr>
                    <td align="right"><strong>Total Quantity:</strong>&nbsp;</td>
                    <td align="center"><?php echo $q_total;  ?> 
					<input type="hidden"  name="q_total" id="q_total" value="<?php echo $q_total; ?>" />
					</td>
					<td align="center">&nbsp;</td>
				</tr>
            <?php endif; ?>
            </table>
			<p>&nbsp;</p>
			<p style="margin-left:300px;"><?php echo CHtml::submitButton('Generate Report' ,array('id' => 'generate', 'name' => 'generate', 'class' => 'buttonGreen')); ?></p>
             <?php echo CHtml::endForm(); ?>
               </div>     
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
