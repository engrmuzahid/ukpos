  <script type="text/javascript">
	
	function getProductType()
	{
        document.getElementById("pro_type").innerHTML='<img  alt="loading ..." src ="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
		product_category_id = document.getElementById('product_category_id').value;
		url="<?php echo Yii::app()->request->baseUrl; ?>/public/get_jquery_stock.php?product_category_id="+ product_category_id;
		
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
	    var product_type_id = document.getElementById("product_type").value;
	        document.getElementById("pro_name").innerHTML='<img  alt="loading ..." src ="<?php echo Yii::app()->request->baseUrl; ?>/public/images/progress.gif" border="0" />';
		url="<?php echo Yii::app()->request->baseUrl; ?>/public/get_jquery_stock.php?product_type_id="+ product_type_id;
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
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'received_delivery', 'activeTab' => 'product_report')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Received Delivery Product Report</h1></div>
     <?php echo CHtml::beginForm()?>		
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<?php 
			// retrieve the models from db
			$models_cat     = Product_Category::model()->findAll(array('order' => 'category_name'));			 
			$category_list  = CHtml::listData($models_cat, 'id', 'category_name');
		?>
        <tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'product_category')?>&nbsp;&nbsp;</th>
            <td><div id="pro_category" style="width:150px;">
			 <?php echo CHtml::dropDownList('product_category_id','product_category_id', $category_list, array('empty' => '----- Select Category -----', 'style' => 'width:150px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductType()')); ?>
             </div> 
             <div class="markcolor"><?php //echo CHtml::error('product_category_id'); ?></div>
            </td>
			<td>&nbsp;</td>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'product_type')?>&nbsp;&nbsp;</th>
            <td>
            <div id="pro_type" style="width:150px;">
			 <?php echo CHtml::dropDownList('product_type_id', 'product_type_id', $default_com, array('style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?>
             </div>
             <div class="markcolor"><?php //echo CHtml::error('product_type_id'); ?></div>
            </td>
			<td>&nbsp;</td>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'product_name')?>&nbsp;&nbsp;</th>
            <td>
            <div id="pro_name" style="width:150px;">
			 <?php echo CHtml::dropDownList('product_id', 'product_id', $default_com, array('style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?>
            </div>
             <div class="markcolor"><?php //echo CHtml::error($model,'product_id'); ?></div>
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
 