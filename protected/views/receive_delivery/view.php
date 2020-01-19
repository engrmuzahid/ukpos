    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'received_delivery', 'activeTab' => 'home')); ?>
<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
        <div style="margin-left:15px;"><h1>Received Delivery Details</h1></div>
		
		<?php   if(count($models)): foreach($models as $model):
					  $delivery_id   = $model->id;
				      $storage_party_id   = $model->storage_party_id;
				      $warehouse_id       = $model->warehouse_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$storage_party_id'",) ); 	
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$warehouse_id'",) ); 					 
					  $q3 = new CDbCriteria( array( 'condition' => "delivery_id = '$delivery_id'",) ); 					  					 
                      $Sparties = Storage_Party::model()->findAll( $q1 );
                      $Compartments = Compartment::model()->findAll( $q2 );
                      $Dproducts = Receive_Delivery_Product::model()->findAll( $q3 );

		  ?>
       <table border="0" width="90%"  cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:15px;">  
        <tr>
        <td width="20%"><strong><?php echo 'Storage Period'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo date('M d, Y', strtotime($model->received_from_date)).' To '.date('M d, Y', strtotime($model->received_to_date)); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Warehouse Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php if(count($Compartments)): foreach($Compartments as $Compartment): echo $Compartment->warehouse_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Party Name'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php if(count($Sparties)): foreach($Sparties as $Sparty): echo $Sparty->party_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%"><strong><?php echo 'Note'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" colspan="6" align="left"><?php echo $model->note; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        </table>
       <?php endforeach; endif; ?>

				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($Dproducts)): 
					 
				?>
				<tr>
                    <th width="20%" scope="col">Category</th>
                    <th width="20%" scope="col">Subcategory</th>
                    <th width="20%" scope="col">Product Name</th>
                    <th width="15%" scope="col">Price</th>
                    <th width="10%" scope="col">Quantity</th>
                    <th width="15%" scope="col">Total</th>
				</tr>
                <?php $i=1; $amount_sub_total = 0;
				      foreach($Dproducts as $data): 
				      $product_category = $data->product_category;
				      $product_type     = $data->product_type;
				      $product_id       = $data->product_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$product_category'",) ); 
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$product_type'",) ); 
					  $q3 = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 
					 
					  $Category_names = Product_Category::model()->findAll( $q1 );
					  $Type_names     = Product_Type::model()->findAll( $q2 );
					  $product_names  = Product::model()->findAll( $q3 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
                	<td><?php if(count($Category_names)): foreach($Category_names as $Category_name): echo $Category_name->category_name; endforeach; endif; ?></td>
					<td><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
					<td><?php if(count($product_names)): foreach($product_names as $product_names): echo $product_names->product_name; endforeach; endif; ?></td>
                    <td><?php echo "TK. ".$data->product_price; ?></td>
                    <td><?php echo $data->quantity; ?></td>
                    <td><?php echo "TK. ".$data->product_price * $data->quantity; ?></td>
				</tr>
                <?php $i = $i + 1;
				       $pree_amount = $data->product_price * $data->quantity;
				       $amount_sub_total = $amount_sub_total + $pree_amount;
				 endforeach; ?>
                <tr><td colspan="5" align="right"><strong>Grand Total: </strong></td><td ><?php echo "TK. ".$amount_sub_total; ?></td></tr>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="6" class="red-left">No Product Available.</td></div></tr>
                <?php endif; ?>
				</table> 
           </div>     
<!--  END #PORTLETS -->  
   </div>
