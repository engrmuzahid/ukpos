<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl.'/'; ?>public/css/jsDatePick_ltr.min.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl.'/'; ?>public/css/cart.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl.'/'; ?>public/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl.'/'; ?>public/js/jquery.autocomplete.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl.'/'; ?>public/js/jsDatePick.min.1.3.js"></script>

<script type="text/javascript">
	
	function getCustomer()
	{
        document.getElementById("customer").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/loader_light_blue.gif" border="0" />';
		customer_id = document.getElementById('customer_id').value;
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery.php?customer_id="+ customer_id;
		
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
		document.getElementById("customer").innerHTML=msg;				
	}
	
	function getDiscountAmount()
	{
		amount_sub_total     = document.getElementById('amount_sub_total').value;
		discount_ratio       = document.getElementById('discount_ratio').value;
		discount_sub = amount_sub_total * discount_ratio;
		discount_value2 =  discount_sub / 100;
		discount_value = Math.ceil(discount_value2 * 100) / 100; 
		document.getElementById('discount_value').innerHTML = "&pound; "+ discount_value +"(" + discount_ratio + "%)";
		document.getElementById('discount').value = discount_value;
		
		amount_grand_total_sub   = amount_sub_total;
        amount_grand_total_value2 = amount_grand_total_sub * 1 - discount_value * 1; 
		var newnumber            = new Number(amount_grand_total_value2+'').toFixed(parseInt(2));
		amount_grand_total_value = parseFloat(newnumber);

		document.getElementById('amount_grand_total_value').innerHTML = "&pound; "+ amount_grand_total_value;
		document.getElementById('amount_grand_total').value = amount_grand_total_value;
	}

	function getTotal()
	{
		p_price = document.getElementById('p_price').value;
		qty  = document.getElementById('qty').value;
		amount_total2 = p_price * qty;
		var newnumber = new Number(amount_total2+'').toFixed(parseInt(2));
		amount_total  = parseFloat(newnumber);
		document.getElementById("amount_total").value = amount_total;				
	}

	function getDiscountValue()
	{
		customer_id = document.getElementById('customer_id').value;
		url="<?php echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery.php?customer_id="+ customer_id;
		
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
		
		amount_sub_total     = document.getElementById('amount_sub_total').value;
		discount_ratio       = msg;
		discount_sub = amount_sub_total * discount_ratio;
		discount_value2 =  discount_sub / 100;
		var newnumber2   = new Number(discount_value2+'').toFixed(parseInt(2));
		discount_value   = parseFloat(newnumber2);

		document.getElementById('discount_value').innerHTML = "&pound; "+ discount_value +"(" + discount_ratio + "%)";
		document.getElementById('discount').value = discount_value;
		document.getElementById('discount_ratio2').value = discount_ratio;

		amount_grand_total_sub   = amount_sub_total;
        amount_grand_total_value2 = amount_grand_total_sub * 1 - discount_value * 1; 
		var newnumber            = new Number(amount_grand_total_value2+'').toFixed(parseInt(2));
		amount_grand_total_value = parseFloat(newnumber);

		document.getElementById('amount_grand_total_value').innerHTML = "&pound; "+ amount_grand_total_value;
		document.getElementById('amount_grand_total').value = amount_grand_total_value;
	}

	function getDiscountValue2()
	{
		contact_no1 = document.getElementById('contact_no1').value;
		url="<?php echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery.php?contact_no1="+ contact_no1;
		
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
        
		amount_sub_total     = document.getElementById('amount_sub_total').value;
		discount_ratio       = mySplitResult[0];
		discount_sub = amount_sub_total * discount_ratio;
		discount_value2 =  discount_sub / 100;
		
		var newnumber2   = new Number(discount_value2+'').toFixed(parseInt(2));
		discount_value   = parseFloat(newnumber2);

		document.getElementById('discount_value').innerHTML = "&pound; "+ discount_value +"(" + discount_ratio + "%)";
		document.getElementById('discount').value = discount_value;
		document.getElementById('discount_ratio2').value = discount_ratio;

		amount_grand_total_sub   = amount_sub_total;
        amount_grand_total_value2 = amount_grand_total_sub * 1 - discount_value * 1; 
		
		var newnumber            = new Number(amount_grand_total_value2+'').toFixed(parseInt(2));
		amount_grand_total_value = parseFloat(newnumber);

		document.getElementById('amount_grand_total_value').innerHTML = "&pound; "+ amount_grand_total_value;
		document.getElementById('amount_grand_total').value = amount_grand_total_value;
		document.getElementById('payment_amount').value = amount_grand_total_value;

		if (discount_ratio==null || discount_ratio=="")
		  {
		    document.getElementById('cusName').innerHTML = "Invalid Contact Number or Customer Not Registered !!!";
		  }
		else{  
		document.getElementById('cusName').innerHTML = "Customer Name : "+ mySplitResult[1];
		document.getElementById('customer_id').value = mySplitResult[2];
		}
	}
		function MyCart()
		{
			var oForm = document.frm_soft;
			oForm.action="<?php echo Yii::app()->request->baseUrl.'/sell/add'; ?>";
			oForm.post="post";
			oForm.submit();
		}
	
		function MySuspend()
		{
			var oForm = document.frm_soft;
			oForm.action="<?php echo Yii::app()->request->baseUrl.'/sell/suspend'; ?>";
			oForm.post="post";
			oForm.submit();
		}
		
		function MySellCancel()
		{
			var oForm = document.frm_soft;
			oForm.action="<?php echo Yii::app()->request->baseUrl.'/sell/sell_cancel'; ?>";
			oForm.post="post";
			oForm.submit();
		}
	function getBalance()
	{
		price_grand_ttotal = document.getElementById('price_grand_ttotal').value;
		amount_payable     = document.getElementById('amount_payable').value;
		amount_balance2    = price_grand_ttotal - amount_payable;
		var newnumber      = new Number(amount_balance2+'').toFixed(parseInt(2));
		amount_balance     = parseFloat(newnumber);
		document.getElementById("cash_balance").value = amount_balance;	
					
	}

</script>
 
            <?php $this->renderPartial('_entryform', array('model' => $model))?>

 <div id="feedback_bar"></div>
</div>
</div>