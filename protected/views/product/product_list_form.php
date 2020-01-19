<script type="text/javascript">
	
	function getProductType()
	{
        document.getElementById("product_type").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
		product_category_id = document.getElementById('product_category_id').value;
		url="<?php  echo Yii::app()->request->baseUrl; ?>/public/get_jquery_price.php?product_category_id="+ product_category_id;
		
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
	function getProductBrand()
	{
        document.getElementById("product_brand").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
		product_type_id = document.getElementById('Product_product_type_id').value;
		url="<?php  echo Yii::app()->request->baseUrl; ?>/public/get_jquery_price.php?product_type_id="+ product_type_id;
		
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
		document.getElementById("product_brand").innerHTML=msg;				
	}
</script>
<table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">Item List</td>
	</tr>
  </tbody>
</table>
<table id="contents">
	<tbody><tr>
		<td id="commands">
                    <?php $this->renderPartial('_menu') ?>

		</td>
		<td style="width: 10px;"></td>        
		<td style="background-color:#E9E9E9">
      
			 <?php echo CHtml::beginForm()?>		
                <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
                <tr height="10"><td colspan="3">&nbsp;</td></tr>
                <?php 
                    // retrieve the models from db
                    $models_cat     = Product_Category::model()->findAll(array('order' => 'category_name'));			 
                    $category_list  = CHtml::listData($models_cat, 'id', 'category_name');
                    $models_type    = Product_Type::model()->findAll(array('order' => 'type_name'));			 
                    $type_list      = CHtml::listData($models_type, 'id', 'type_name');
					$models_brand    = Product_Brand::model()->findAll(array('order' => 'brand_name'));			 
					$brand_list      = CHtml::listData($models_brand, 'id', 'brand_name');
                ?>
                <tr>
                    <th valign="top"><?php echo CHtml::activeLabel($model, 'item_category')?>&nbsp;&nbsp;</th>
                    <td>
                     <?php echo CHtml::dropDownList('product_category_id','product_category_id', $category_list, array('empty' => '----- Select Category -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductType()')); ?>
                     <div class="markcolor"><?php //echo CHtml::error($model,'product_category_id'); ?></div>
                    </td>
                    <td>&nbsp;</td>
                   </tr>
                  <tr><td colspan="3">&nbsp;</td></tr>
                   <tr>
                    <th valign="top">Subcategory&nbsp;&nbsp;</th>
                    <td>
                     <div id = "product_type"><?php echo CHtml::activedropDownList($model,'product_type_id', $type_list, array('empty' => '----- Select Subcategory -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div>
                     <div class="markcolor"><?php echo CHtml::error($model,'product_type_id'); ?></div>
                    </td>
                    <td>&nbsp;</td>
                  </tr>
                 <tr><td colspan="3">&nbsp;</td></tr>
                  <tr>  
                    <th valign="top"><?php echo CHtml::activeLabel($model, 'brand_name')?>&nbsp;&nbsp;</th>
                    <td><div id = "product_brand"><?php echo CHtml::activedropDownList($model,'product_brand_id', $brand_list, array('empty' => '----- Select Brand -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
                    <td>&nbsp;</td>
                </tr>
                 <tr><td colspan="3">&nbsp;</td></tr>
                  <tr>  
                    <td>&nbsp;&nbsp;</th>
                    <td valign="top"><?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
                </tr>
            </table>
          <?php echo CHtml::endForm()?>

		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>