   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'expense_info', 'activeTab' => 'office_expense')); ?>

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
			target:"expense_date",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"cheque_date",
			dateFormat:"%Y-%m-%d"
		});
	};
	
	
	function getExpenseName()
	{
        document.getElementById("expense_name").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/loader_light_blue.gif" border="0" />';
		expense_type_id = document.getElementById('expense_type_id').value;
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_bank.php?expense_type_id="+ expense_type_id;
		
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
		document.getElementById("expense_name").innerHTML=msg;				
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
		var account_no = document.getElementById("account_no").value;
	        document.getElementById("cheque_name").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/progress.gif" border="0" />';
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_bank.php?account_no="+ account_no;
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
	   
		var mySplitResult = msg.split("-");
		document.getElementById("cheque_name").innerHTML=mySplitResult[0];	
	}
   
    function check_value()
    {
        document.getElementById('cash_total').style.display='block';
        var myvar = document.getElementById('BankInfo').style.display='none';
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_bank.php?cashval=as";
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
	   
		var mySplitResult = msg.split("-");
		document.getElementById("cash_total").innerHTML=mySplitResult[0];	
    }
</script>

        <div style="margin-left:5px;"><h1><?php echo CHtml::link('Office Expense', array('index'))?> → Entry Information</h1></div>
	 <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('saveMessage'); ?>
		</div>
        <p>&nbsp;</p>
   <?php endif; ?>  
    
   <?php $this->renderPartial('_form', array('model' => $model))?>

   </div>
