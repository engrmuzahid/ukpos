<link rel="stylesheet" type="text/css" media="all" href="<?php  echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php  echo Yii::app()->request->baseUrl; ?>/public/css/cart.css" />
<script type="text/javascript" src="<?php  echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"payment_date",
			dateFormat:"%Y-%m-%d"
		});
		new JsDatePick({
			useMode:2,
			target:"cheque_date",
			dateFormat:"%Y-%m-%d"
		});
	};
        
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
	   
	    var amount =  parseInt(document.getElementById("amount").value);
		var mySplitResult = msg.split("-");
		var amountval = parseInt(mySplitResult[2]);
		document.getElementById("cheque_name").innerHTML=mySplitResult[0];	
		document.getElementById("account_amount").innerHTML=mySplitResult[1];
		document.getElementById("t_balance").value = amountval;	

		if (amountval < amount)
		  {
		    document.getElementById('amount_error').innerHTML = "Your given amount is more from your balance !!!";
		  }
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
	   
	    var amount =  parseInt(document.getElementById("amount").value);
		var mySplitResult = msg.split("-");
		var amountval = parseInt(mySplitResult[1]);
		document.getElementById("cash_total").innerHTML=mySplitResult[0];	
		document.getElementById("t_balance").value = amountval;	
		if (amountval < amount)
		  {
		    document.getElementById('amount_error').innerHTML = "Your given amount is more from your balance !!!";
		  }
    }
   
   function getamount_value()
    {
        document.getElementById('amount_error').innerHTML ="";
	    var amount = parseInt(document.getElementById("amount").value);
		var amountval = parseInt(document.getElementById("t_balance").value);

		if (amountval != '' && amountval < amount)
		  {
		    document.getElementById('amount_error').innerHTML = "Your given amount is more from your balance !!!";
		  }
    }
</script>
 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title"><?php echo CHtml::link('Supplier Payment', array('index'))?> → Entry Information</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received'; ?>" class="none new">Receive</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/receiable_report'; ?>" class="none new">Receiable Report</a>
				<a href="<?php echo Yii::app()->request->baseUrl.'/account_received/received_report'; ?>" class="none new">Received Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment'; ?>" class="none new">Payment</a>  
				<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/payable_report'; ?>" class="none new">Payable Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/supplier_payment/paid_report'; ?>" class="none new">Paid Report</a>  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td style="background-color:#E9E9E9">
			  <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
                <div class="message">
                    <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                </div>
             <?php endif; ?>   
           <?php $this->renderPartial('_entryform', array('model' => $model, 'model2' => $model2))?>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
