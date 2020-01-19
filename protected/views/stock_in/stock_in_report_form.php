<link rel="stylesheet" type="text/css" media="all" href="<?php  echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php  echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
  <script type="text/javascript">	
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"start_date",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"end_date",
			dateFormat:"%Y-%m-%d"
		});
	};
	
	function getProductType()
	{
        document.getElementById("pro_type").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/loader_light_blue.gif" border="0" />';
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
		document.getElementById("pro_type").innerHTML=msg;				
	}

	function getProductName()
	{
	    var product_type_id = document.getElementById("product_type").value;
	    var product_brand_id = document.getElementById("product_brand").value;
	        document.getElementById("pro_name").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/progress.gif" border="0" />';
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_stock.php?product_brand_id="+ product_brand_id + '&product_type_id='+ product_type_id;
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

 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">Stock In Report</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/stock_in/report'; ?>" class="none new">Stock Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_out'; ?>" class="none new">Stock Out</a>    
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_out/report'; ?>" class="none new">Stock Out Report</a>                  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td style="background-color:#E9E9E9">
     <?php echo CHtml::beginForm()?>		
        <table style="margin-left:10px;" width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="13">&nbsp;</td></tr>
		<?php 
			// retrieve the models from db
			$models_cat     = Product_Category::model()->findAll(array('order' => 'category_name'));			 
			$category_list  = CHtml::listData($models_cat, 'id', 'category_name');
			$models_brand    = Product_Brand::model()->findAll(array('order' => 'brand_name'));			 
			$brand_list      = CHtml::listData($models_brand, 'id', 'brand_name');
         ?>
        <tr>
            <th valign="top"><?php echo CHtml::activeLabel($model, 'category')?>&nbsp;&nbsp;</th>
            <td><div id="pro_category" style="width:120px;">
			 <?php echo CHtml::dropDownList('product_category','product_category', $category_list, array('empty' => 'Select Category', 'style' => 'width:120px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductType()')); ?>
             </div> 
             <div class="markcolor"><?php echo CHtml::error($model,'product_category'); ?></div>
            </td>
			<td>&nbsp;</td>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'type')?>&nbsp;&nbsp;</th>
            <td>
            <div id="pro_type" style="width:120px;">
			 <?php echo CHtml::dropDownList('product_type','product_type', $default_com, array('style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?>
             </div>
             <div class="markcolor"><?php echo CHtml::error($model,'product_type'); ?></div>
            </td>
            <td>&nbsp;</td>
           </tr>
           <tr><td colspan="6">&nbsp;</td></tr>
           <tr> 
            <th valign="top"><?php echo CHtml::label('Brand', 'product_brand')?>&nbsp;&nbsp;</th>
            <td>
            <div id="pro_brand" style="width:120px;">
             <?php echo CHtml::dropDownList('product_brand','product_brand', $brand_list, array('empty' => '-- Select Brand --', 'style' => 'width:120px;height:25px;border:1px solid #CCC;', 'onchange' => 'getProductName()')); ?>
            </div>        

             </td>
			 <td>&nbsp;</td>
				<th valign="top"><?php echo CHtml::label('Start Date', 'start_date')?>&nbsp;&nbsp;</th>
				<td>                        
				 <?php echo CHtml::TextField('start_date', '', array('style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?>                        
				</td>
				<td>&nbsp;</td>
             </tr>             
            <tr><td colspan="6">&nbsp;</td></tr>
            <tr>
            <th valign="top"><?php echo CHtml::label('End Date', 'end_date')?>&nbsp;&nbsp;</th>
            <td>
             <?php echo CHtml::TextField('end_date', '', array('style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?>                        
             </td>
            <td>&nbsp;</td>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'name')?>&nbsp;&nbsp;</th>
            <td>
            <div id="pro_name" style="width:120px;">
			 <?php echo CHtml::dropDownList('product_id','product_id', $default_com, array('style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?>
            </div>
             <div class="markcolor"><?php echo CHtml::error($model,'product_id'); ?></div>
            </td>
            <td valign="top">
			<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?>
            </td>
           </tr>
	</table>
  <?php echo CHtml::endForm()?>

		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>