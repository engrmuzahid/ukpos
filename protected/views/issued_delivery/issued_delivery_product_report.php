    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'issued_delivery', 'activeTab' => 'product_report')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
        
        <div id="ptable3">
        <div style="margin-left:5px;"><h1>Issued Delivery Product Report</h1></div>

            	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($model)): 
					 
				?>
				<tr>
                    <th width="15%" scope="col">Warehouse</th>
                    <th width="15%" scope="col">Subcategory</th>
                    <th width="15%" scope="col">Product Name</th>
                    <th width="15%" scope="col">Date</th>
                    <th width="15%" scope="col">Price</th>
                    <th width="10%" scope="col">Quantity</th>
                    <th width="15%" scope="col">Total</th>
				</tr>
                <?php $i=1; foreach($model as $model): 
				      $warehouse_id     = $model->warehouse_id;
				      $product_category = $model->product_category;
				      $product_type     = $model->product_type;
				      $product_id       = $model->product_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$product_category'",) ); 
					  $q2 = new CDbCriteria( array( 'condition' => "id = '$product_type'",) ); 
					  $q3 = new CDbCriteria( array( 'condition' => "product_id = '$product_id'",) ); 
					  $q4 = new CDbCriteria( array( 'condition' => "id = '$warehouse_id'",) ); 					 

					  $Category_names = Product_Category::model()->findAll( $q1 );
					  $Type_names     = Product_Type::model()->findAll( $q2 );
					  $product_names  = Product::model()->findAll( $q3 );
                      $Compartments   = Compartment::model()->findAll( $q4 );
				 ?>
				<tr <?php if($i %2 == 0): ?> class="alternate-row" <?php endif;?>>
                    <td><?php if(count($Compartments)): foreach($Compartments as $Compartment): echo $Compartment->warehouse_name; endforeach; endif; ?></td>
					<td><?php if(count($Type_names)): foreach($Type_names as $Type_names): echo $Type_names->type_name; endforeach; endif; ?></td>
					<td><?php if(count($product_names)): foreach($product_names as $product_names): echo $product_names->product_name; endforeach; endif; ?></td>
                    <td><?php echo date('M d, Y', strtotime($model->created)); ?></td>
                    <td><?php echo "TK ".$model->product_price; ?></td>
                    <td><?php echo $model->quantity; ?></td>
                    <td><?php echo "TK ".$model->product_price * $model->quantity; ?></td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="7" class="red-left">No Product Available.</td></div></tr>
                <?php endif; ?>
				</table> 
            </div> 
<!--  END #PORTLETS -->  
   </div>
