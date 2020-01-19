   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'received_delivery', 'activeTab' => 'add')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
<link rel="stylesheet" type="text/css" media="all" href="<?php  echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php  echo Yii::app()->request->baseUrl; ?>/public/css/cart.css" />
<script type="text/javascript" src="<?php  echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"Receive_Delivery_received_from_date",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"Receive_Delivery_received_to_date",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"Receive_Delivery_expire_date",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"cheque_date",
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
	        document.getElementById("pro_name").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/progress.gif" border="0" />';
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_stock.php?product_type_id="+ product_type_id;
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
        
	function getAccountNo()
	{
	    var bank_id2 = document.getElementById("bank_id").value;
	      document.getElementById("account_name").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/progress.gif" border="0" />';
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_bank.php?bank_id2="+ bank_id2;
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
		document.getElementById("account_name").innerHTML=msg;	
	}
	
	function getChequeNo()
	{
		var account_no2 = document.getElementById("account_no").value;
		
	        document.getElementById("cheque_name").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/progress.gif" border="0" />';
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_bank.php?account_no2="+ account_no2;
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
	    document.getElementById("cheque_name").innerHTML=msg;	
	}

	function getTotal()
	{
		p_price = document.getElementById('p_price').value;
		qty  = document.getElementById('qty').value;
		amount_total = p_price * qty;
		document.getElementById("amount_total").value = amount_total;				
	}

</script>

        <div style="margin-left:5px;"><h1><?php echo CHtml::link('Receiving Product', array('index'))?> → Entry Information</h1></div>
	 <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('saveMessage'); ?>
		</div>
        <p>&nbsp;</p>
   <?php endif; ?>  
    
   <?php $this->renderPartial('_entryform', array('model' => $model))?>

   </div>
