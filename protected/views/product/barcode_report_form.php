<script type="text/javascript">
	function getProductType()
	{
        document.getElementById("pro_name").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/loader_light_blue.gif" border="0" />';
		product_category_id = document.getElementById('product_category').value;
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_stock.php?product_category_id="+ product_category_id;
		
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
	
	function getProductBrand()
	{
        document.getElementById("pro_brand").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
		product_type_id = document.getElementById('product_type').value;
		url="<?php  echo Yii::app()->request->baseUrl; ?>/public/get_jquery_stock.php?product_type_id="+ product_type_id;
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
		document.getElementById("pro_brand").innerHTML=msg;				
	}

	function getProductName()
	{
	    var product_brand_id = document.getElementById("product_brand").value;
	    var product_type_id  = document.getElementById("product_type").value;
	        document.getElementById("pro_name").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/progress.gif" border="0" />';
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_stock.php?product_brand_id="+ product_brand_id + "&product_type_id="+ product_type_id;
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
			$models1 = Product_Category::model()->findAll(array('order' => 'category_name'));	
			$models2 = Product_Type::model()->findAll(array('order' => 'type_name'));			 
			$models3 = Product::model()->findAll(array('order' => 'product_name'));			 
			$list1   = CHtml::listData($models1, 'id', 'category_name');
			$list2   = CHtml::listData($models2, 'id', 'type_name');		   
			$list3   = CHtml::listData($models3, 'product_code', 'product_name');	
			$models_brand    = Product_Brand::model()->findAll(array('order' => 'brand_name'));			 
			$brand_list      = CHtml::listData($models_brand, 'id', 'brand_name');
	?>
<table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">Barcode Generator</td>
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
      
       <?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
		<!-- start id-form -->
		<table border="0" cellpadding="0" cellspacing="0"  width="98%" style="margin-left:10px;">
		<tr>
          <!--<td align="center" width="18%" valign="top"><strong><?php echo CHtml::label('Category', 'product_category')?></strong></td>-->
<!--          <td align="center" width="18%" valign="top"><strong><?php echo CHtml::label('Type', 'product_type')?></strong></td>
          <td align="center" width="18%" valign="top"><strong><?php echo CHtml::label('Brand', 'product_brand')?></strong></td>-->
          <td align="center" width="18%" valign="top"><strong><?php echo CHtml::label('Item Name', 'product_code')?></strong></td>
          <td align="left" width="30%" colspan="2" valign="top"><strong><?php echo CHtml::label('Barcode Number', 'barcode_no')?></strong></td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
		<tr>
        <!--<td align="center" width="18%"><div id="pro_category" style="width:120px;"> <?php echo CHtml::dropDownList('product_category','product_category', $list1, array('empty' => '-- Select Category --', 'style' => 'width:120px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductType()')); ?></div></td>-->
<!--        <td align="center" width="18%"><div id="pro_type" style="width:120px;"> <?php echo CHtml::dropDownList('product_type','product_type', $list2, array('empty' => '-- Select Type --', 'style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?></div></td>
        <td align="center" width="18%"><div id="pro_brand" style="width:120px;"> <?php echo CHtml::dropDownList('product_brand','product_brand', $brand_list, array('empty' => '-- Select Brand --', 'style' => 'width:120px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductName()')); ?></div></td>-->
        <td align="center" width="18%"><div id="pro_name" style="width:120px;"> <?php echo CHtml::dropDownList('product_code','product_code', $list3, array('empty' => '-- Select Name --', 'style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?></div></td>
        <td align="center" width="16%"><?php echo CHtml::textField('barcode_no', '', array('style' => 'width:80px;height:23px;border:1px solid #CCC;'))?></td>
        <td width="12%"><?php echo CHtml::submitButton('Generate' ,array('class' => 'buttonBlue')); ?></td>
		</tr>
	</table>
  <?php echo CHtml::endForm()?>

		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>