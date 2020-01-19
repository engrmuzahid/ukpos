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
			target:"confirm_date",
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
		{  
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
    
    $(document).ready(function(){
        $("#discount").keyup(function(e){
            
            if($(this).val() > 0) {
                var amount = parseFloat($("#original_amount").val()) - parseFloat($(this).val());
                $("#amount").val(amount.toFixed(2));
            } else {
                $("#amount").val($("#original_amount").val());
            }
            
        });
        
          $(".payment_mode").live("change",function(e){
            e.preventDefault();
            var payment_mode = $(this).val();
            if(payment_mode == 1){
                $("#check_payment_date").show();
                
            }else{
                  $("#check_payment_date").hide();
            }
            
            
        });
        
        
    });
</script>
 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
                <td id="title"><?php echo CHtml::link('Supplier', array('index'))?> → Entry Information</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		  <td id="commands">
                <?php $this->renderPartial('_menu') ?>
            </td>
		<td style="width: 10px;"></td>        
		<td>
			  <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
                <div class="message">
                    <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                </div>
             <?php else: ?>   
           <?php $this->renderPartial('_entryform22', array('model' => $model, 'model2' => $model2))?>
	<?php endif; ?>   
          	</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
