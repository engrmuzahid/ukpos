<script language="javascript">
 $(document).ready(function() {
	
        $("#product_code2").autocomplete('<?php echo Yii::app()->request->baseUrl.'/public/product_list.php'; ?>', {  //we have set data with source here
                formatItem: function(rowdata) { //This function is called right before the item is displayed on the dropdown, so we splitted and returned what we show in the selection box
                    var info = rowdata[0].split(":");
                    return info[1];
                },
                formatResult: function (rowdata) { // This function is called when any item selected, here also we returned that what we wanted to show our product_name field.
                    var info = rowdata[0].split(":");
                    return info[1];
                },
                width: 198,
		multiple: false,
		matchContains: true,
		scroll: true,
		scrollHeight: 120
            }).result(function(event, data, formatted){ //Here we do our most important task :)
                    if(!data) { //If no data selected set the product_id field value as 0
                        $("#product_id").val('0');
                    } else { // Set the value for the product id
                        var info = formatted.split(":");
                        $("#product_id").val(info[0]);                        
                    }
            }); 
        
        });
	
</script>          
         <?php echo CHtml::beginForm( Yii::app()->request->baseUrl.'/supplier/purchase_return','post',array( 'enctype'=>'multipart/form-data')); ?>
         <table align="center" width="50%" style=" margin-left:5px;margin-bottom:10px;">
          <tr><td colspan="4">&nbsp;</td></tr>
                <tr>
                    <td width="10%">&nbsp;</td>
                    <th width="30%" align="left"><?php echo "Supplier Invoice"; ?><span class="markcolor">*</span></th>            
                    <td width="15%" align="left"><?php echo CHtml::textField('chalan_id', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
                    <td width="45%" align="left">&nbsp;&nbsp;<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
                </tr>
          </table>
         <?php echo CHtml::endForm(); ?>
        <?php
			 $criteria2 = new CDbCriteria();
			 $criteria2->order = 'id DESC';
			 $criteria2->limit = 1;
			 $modelmain = Invoice_Track2::model()->findAll($criteria2);					 
            if(count($modelmain)): foreach($modelmain as $models): $chalan_id = $models->chalan_id; endforeach; endif;
			  $cond = new CDbCriteria( array( 'condition' => "chalan_id = '$chalan_id'",) ); 
			  $model = Purchase::model()->findAll( $cond );
			  $model2 = Purchase_Product::model()->findAll( $cond );
	     if(count($model)): ?>
       <table border="0" width="90%"  cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-left:5px; margin-right:10px;"> 
        <tr><td colspan="8">&nbsp;</td></tr>
		<?php   foreach($model as $model):
					  $purchase_id   = $model->id;
		              $supplier_name = "";
					if(!empty($model->chalan_id)):
				      $supplier_id = $model->supplier_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$supplier_id'",) ); 
                      $Suppliers = Supplier::model()->findAll( $q1 );
                      if(count($Suppliers)): foreach($Suppliers as $Suppliers): $supplier_name = $Suppliers->name; endforeach; endif;
				    endif;
  
		  ?>
        <tr>
        <td width="20%">&nbsp;<strong><?php echo 'Supplier Invoice'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo $model->chalan_id; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Purchase Date'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo date('M d, Y', strtotime($model->purchase_date)); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top">&nbsp;<strong><?php echo 'Supplier Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php echo $supplier_name; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
       <?php endforeach;  ?>
      </table>
	   <table border="1" width="90%"  cellpadding="0" cellspacing="0" style="margin-bottom:10px; margin-left:5px; margin-right:5px;">  
                <?php  if(count($model2)): 
					 
				?>
				<tr>
                    <th width="15%">Code</th>
                    <th width="35%">Product Name</th>
                    <th width="10%">Qty</th>
				    <th width="15%">Unit</th>
                    <th width="25%">Total</th>
				</tr>
                <tr><td colspan="6">&nbsp;</td></tr>
                <?php $i=1; $amount_sub_total = 0;
		foreach($model2 as $data): 
				   
                $product_code = $data->product_code;

                $q3 = new CDbCriteria(array('condition' => "product_code = '$product_code'",));
                $product_names = Product::model()->findAll($q3);
                $product_name = "";
                if (count($product_names)): foreach ($product_names as $product_names): $product_name = $product_names->product_name;
                    endforeach;
                endif;
                                  ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
					<td><?php echo $product_code; ?></td>
					<td><?php echo $product_name; ?></td>
                    <td align="center"><?php echo $data->quantity; ?></td>
                    <td align="center"><?php echo "&pound; ".number_format($data->product_price, 2); ?></td>
                    <td align="center"><?php echo "&pound; ".number_format($data->product_price * $data->quantity, 2); ?></td>
				</tr>
                <?php $i = $i + 1;
				 endforeach; endif; ?>
                <tr>  
                <td align="center"><strong>Grand Total: </strong><?php echo "&pound; ".number_format($model->price_grand_total, 2); ?></td>
                <td align="center"><strong>Paid Total: <?php echo "&pound; ".number_format($model->paid_amount, 2); ?></td>
                <td>&nbsp;</td>
			    <td align="center" colspan="2"><strong>Due Total: <?php $due_total = $model->price_grand_total - $model->paid_amount; echo "&pound; ".number_format($due_total, 2); ?></td>
		</tr>
        </table>
   <?php echo CHtml::beginForm(Yii::app()->request->baseUrl.'/supplier/purchaseentry','post',array('enctype'=>'multipart/form-data')); ?>

       <table align="center" width="95%" style="margin-bottom:10px; margin-left:10px;"> 
          <tr height="25" style="font-weight:bold; margin-bottom:10px;" bgcolor="#CCCCCC">
          <td align="center" width="25%" valign="top"><?php echo CHtml::activeLabel($model, 'code')?><span class="markcolor">*</span></td>
          <td align="center" width="25%" valign="top"><?php echo CHtml::activeLabel($model, 'quantity')?><span class="markcolor">*</span></td>
          <td width="50%">&nbsp;</td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
        <tr>
        <td align="center" width="25%"><?php echo CHtml::textField('product_code2', '', array('style' => 'width:120px;height:23px;border:1px solid #CCC;'))?></td>
        <td align="center" width="25%"><?php echo CHtml::textField('qty', '1', array('style' => 'width:120px;height:23px;border:1px solid #CCC;'))?></td>
        <td width="50%">
		   <input type="hidden" name="chalan_id2" value="<?php echo $model->chalan_id; ?>" />
		   <?php echo CHtml::submitButton('Add' ,array('class' => 'buttonGreen')); ?>
		 </td>
        </tr>
       </table>
<?php echo CHtml::endForm()?>    
<?php endif; ?>
<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
		<td colspan="3">
				<?php 
				$amount_sub_total = 0;
                                $username   = Yii::app()->user->name;
				$cond = new CDbCriteria( array( 'condition' => "user_id = '$username'", 'order' => 'id DESC',) );					 
				$cart = Purchase_Return_Tempory::model()->findAll( $cond );
				
				 if(count($cart)): ?>
                <div id="cart2">
                <table>
                <caption>Product List</caption>
                <thead>
                    <tr>
                        <th>Subcategory</th>
                        <th>Code</th>
                        <th>Product Name</th>
                        <th>Price + Vat</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach ($cart as $item):
					$product_code       = $item->product_code;
					  $q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 
					 $q2 = new CDbCriteria( array( 'condition' => "chalan_id = '$model->chalan_id' && product_code = '$product_code'",) ); 
					  $product_name = ""; $Type_names = ""; $sell_price = 0; 
                                          $Products       = Product::model()->findAll( $q1 );
					   $salProducts   = Purchase_Product::model()->findAll( $q2 );
					   if(count($salProducts)): foreach($salProducts as $salProduct):
					          $sell_p       = $salProduct->product_price; 
				            endforeach; endif;		  
						  
					   if(count($Products)): foreach($Products as $Products): 
			           $product_type_id = $Products->product_type_id;					   					   
					   $q2 = new CDbCriteria( array( 'condition' => "id = '$product_type_id'",) ); 
                                           $Type_names     = Product_Type::model()->findAll( $q2 );
					   $product_name   = $Products->product_name;						  
					  endforeach; endif;
				 ?>
                    <tr>
                        <td align="center"><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
                        <td align="center"><?php echo $product_code; ?></td>
                        <td align="center"><?php echo $product_name; ?></td>
                        <td align="center"><?php echo "&pound; ".number_format($sell_p, 2); ?></td>
                        <td align="center"><?php echo $item->quantity; ?></td>
                        <td align="center"><?php echo "&pound; ".number_format($sell_p * $item->quantity, 2); ?></td>
                        <td  class="remove">
                            <?php echo CHtml::link('X', array('/supplier/premove/'.$item->id)); ?>
                            <?php echo CHtml::hiddenField('product_code22[]', $product_code).CHtml::hiddenField('quantity[]', $item->quantity).CHtml::hiddenField('price[]', $sell_p); ?>
                        </td>
                    </tr>
                <?php 
			$pree_amount = $sell_p * $item->quantity;
			$amount_sub_total = $amount_sub_total + $pree_amount;
			
                    endforeach; ?>
                <tr><td colspan="5" align="right"><strong>Grand Total: </strong></td><td  align="center"><?php echo "&pound; ".number_format($amount_sub_total, 2); ?> <input type="hidden"  name="price_grand_total" value="<?php echo $amount_sub_total; ?>" /></td></tr>
                </table>		
            </div>
            <?php endif; ?>
		</td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::label('Return Date', 'return_date')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::textField('return_date', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::label('Reason', 'reason')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::textField('reason', '', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php //echo CHtml::error($model,'stock_in_date'); ?></div>
           </td>
	  </tr>
		
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</th>
            <td valign="top">	
                <input type="hidden" name="chalan_id3" value="<?php echo $model->chalan_id; ?>" />
		<?php echo CHtml::submitButton('Purchase Return' ,array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel' ,array('class' => 'buttonGreen')); ?>
            </td>
            <td></td>
        </tr>
	</table>
<?php echo CHtml::endForm()?>