<script type="text/javascript">
	
	function getProductType()
	{
	   
        document.getElementById("product_type").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
		product_category_id = document.getElementById('Item_Name_product_category_id').value;
		url="<?php  echo Yii::app()->request->baseUrl; ?>/public/get_jquery_price.php?product_category_id3="+ product_category_id;
		
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
		document.getElementById("product_type").innerHTML=msg;				
	}
	function getItemType()
	{
	   
        document.getElementById("item_type").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
		product_type_id = document.getElementById('Item_Name_product_type_id').value;
		url="<?php  echo Yii::app()->request->baseUrl; ?>/public/get_jquery_price.php?product_type_id3="+ product_type_id;
		
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
		document.getElementById("item_type").innerHTML=msg;				
	}
</script>
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'product', 'activeTab' => 'item_name')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1><?php echo CHtml::link('Product Item', array('index'))?> → Add Item Name</h1></div>
	 <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('saveMessage'); ?>
		</div>
   <?php endif; ?>   
   <?php $this->renderPartial('_form', array('model' => $model))?>

   </div>
