    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#ptable3").jqprint();
            });
        });
    
    </script>

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'requisition', 'activeTab' => 'home')); ?>
<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
       <div id="ptable3">
        <div style="margin-left:15px;"><h1>Requisition Details</h1></div>
		
		<?php   if(count($models)): foreach($models as $model):
					  $requisition_id   = $model->id;
					  $q2 = new CDbCriteria( array( 'condition' => "requisition_id = '$requisition_id'",) ); 					 
                      $Rproducts = Requisition_Product::model()->findAll( $q2 );
				      $username   = $model->requisition_submitted_by;
					  $q1 = new CDbCriteria( array( 'condition' => "username = '$username'",) ); 					 
                      $users = Users::model()->findAll( $q1 );
		  ?>
       <table border="0" width="90%"  cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:15px;">  
        <tr>
        <td width="20%"><strong><?php echo 'Requisition Date'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%" align="left"><?php echo date('M d, Y', strtotime($model->requisition_date)); ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        <td width="20%" align="left" valign="top"><strong><?php echo 'Requisition Submit By'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="20%"><?php if(count($users)): foreach($users as $users): echo $users->full_name; endforeach; endif; ?></td>
        <td width="5%" align="center" valign="top">&nbsp;</td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        <tr>
        <td width="20%"><strong><?php echo 'Note'; ?></strong><span class="markcolor"></span></td>
        <td width="5%" align="center" valign="top">:</td>
        <td width="75%" colspan="6" align="left"><?php echo $model->note; ?></td>
        </tr>        
        <tr><td colspan="8">&nbsp;</td></tr>
        </table>
       <?php endforeach; endif; ?>

				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
                <?php  if(count($Rproducts)): 
					 
				?>
				<tr>
                    <th width="25%" scope="col">Category</th>
                    <th width="25%" scope="col">Subcategory</th>
                    <th width="25%" scope="col">Product Name</th>
                    <th width="25%" scope="col">Quantity</th>
				</tr>
                <?php $i=1; foreach($Rproducts as $data): 
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
                    <td><?php echo $data->quantity; ?></td>
				</tr>
                <?php $i = $i + 1; endforeach; ?>
                <?php else: ?>
				<tr><div id="message-red"><td colspan="4" class="red-left">No Product Available.</td></div></tr>
                <?php endif; ?>
				</table> 
           </div>     
<!--  END #PORTLETS -->  
   </div>
