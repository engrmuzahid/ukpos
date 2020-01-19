  <script type="text/javascript">
	
	function getProductType()
	{
        document.getElementById("pro_type").innerHTML='<img  alt="loading ..." src ="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
		product_category = document.getElementById('Party_Stock_product_category').value;
		url="<?php echo Yii::app()->request->baseUrl; ?>/public/get_jquery_stock.php?stockparty_product_category="+ product_category;
		
		try
		{// Firefox, Opera 8.0+, Safari, IE7
			xm=new XMLHttpRequest();
		}
		catch(e)
		{// Old IE
			try
			{
				xm=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e)
			{
				alert ("Your browser does not support XMLHTTP!");
				return;
			}
		}
		xm.open("GET",url,false);
		xm.send(null);
		msg=xm.responseText;		
		document.getElementById("pro_type").innerHTML=msg;				
	}

        
	function getProductName()
	{
	    var product_type = document.getElementById("Party_Stock_product_type").value;
	        document.getElementById("pro_name").innerHTML='<img  alt="loading ..." src ="<?php echo Yii::app()->request->baseUrl; ?>/public/images/progress.gif" border="0" />';
		url="<?php echo Yii::app()->request->baseUrl; ?>/public/get_jquery_stock.php?stockparty_product_type="+ product_type;
		try
		{// Firefox, Opera 8.0+, Safari, IE7
			xm=new XMLHttpRequest();
		}
		catch(e)
		{// Old IE
			try
			{
				xm=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e)
			{
				alert ("Your browser does not support XMLHTTP!");
				return;
			}
		}
		xm.open("GET",url,false);
		xm.send(null);
		msg=xm.responseText;		
		document.getElementById("pro_name").innerHTML=msg;				
	}

</script>
<?php
$default_com = array(
	''		=> 	'----- Select -----'
);
?>
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'received_delivery', 'activeTab' => 'party_stock')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Party Stock Report</h1></div>
     <?php echo CHtml::beginForm()?>		
        <table style="margin-left:10px;" width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<?php 
			// retrieve the models from db
			$models_cat     = Product_Category::model()->findAll(array('order' => 'category_name'));			 
			$category_list  = CHtml::listData($models_cat, 'id', 'category_name');
			 $models_compartment_list = Compartment::model()->findAll(array('order' => 'warehouse_name'));			 
			 $compartment_list        = CHtml::listData($models_compartment_list, 'id', 'warehouse_name');
			 $models_party_list       = Storage_Party::model()->findAll(array('order' => 'party_name'));			 
			 $party_list              = CHtml::listData($models_party_list, 'id', 'party_name');
		?>
        <tr>
			<th valign="top"><?php echo CHtml::label('Party', 'storage_party_id')?>&nbsp;&nbsp;</th>
            <td>
			  <?php echo CHtml::dropDownList('storage_party_id', '', $party_list, array('empty' => 'Select Party', 'style' => 'width:110px;height:25px;border:1px solid #CCC;')); ?>
            </td>
			<td>&nbsp;</td>
			<th valign="top"><?php echo CHtml::label('Warehouse', 'warehouse_name')?>&nbsp;&nbsp;</th>
            <td>
			  <?php echo CHtml::dropDownList('warehouse_id', '', $compartment_list, array('empty' => 'Select Warehouse', 'style' => 'width:110px;height:25px;border:1px solid #CCC;')); ?>
            </td>
			<td>&nbsp;</td>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'category')?>&nbsp;&nbsp;</th>
            <td><div id="pro_category" style="width:110px;">
			 <?php echo CHtml::activedropDownList($model,'product_category', $category_list, array('empty' => 'Select Category', 'style' => 'width:110px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductType()')); ?>
             </div> 
             <div class="markcolor"><?php echo CHtml::error($model,'product_category'); ?></div>
            </td>
			<td>&nbsp;</td>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'type')?>&nbsp;&nbsp;</th>
            <td>
            <div id="pro_type" style="width:110px;">
			 <?php echo CHtml::activedropDownList($model,'product_type', $default_com, array('style' => 'width:110px;height:25px;border:1px solid #CCC;')); ?>
             </div>
             <div class="markcolor"><?php echo CHtml::error($model,'product_type'); ?></div>
            </td>
			<td>&nbsp;</td>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'name')?>&nbsp;&nbsp;</th>
            <td>
            <div id="pro_name" style="width:110px;">
			 <?php echo CHtml::activedropDownList($model,'product_id', $default_com, array('style' => 'width:110px;height:25px;border:1px solid #CCC;')); ?>
            </div>
             <div class="markcolor"><?php echo CHtml::error($model,'product_id'); ?></div>
            </td>
			<td>&nbsp;</td>
            <td valign="top">
			<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?>
            </td>
		</tr>
	</table>
  <?php echo CHtml::endForm()?>
       </div>
<!--  END #PORTLETS -->  
   </div>
 