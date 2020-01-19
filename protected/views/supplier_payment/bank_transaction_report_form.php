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

	function getAccountNo()
	{
	    var d_bank_id = document.getElementById("d_bank_id").value;
	        document.getElementById("account_name").innerHTML='<img  alt="loading ..." src ="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/images/progress.gif" border="0" />';
		url="<?php  echo Yii::app()->request->baseUrl.'/'; ?>public/get_jquery_bank.php?d_bank_id="+ d_bank_id;
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
	
</script>
             <?php
				$list3   = array(
				           'debit'  => 'Received',
						   'credit' => 'Paid',
						   );				
              ?>
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'paid_report', 'activeTab' => 'bank_report')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Bank Paid Report</h1></div>
     <?php 
	         echo CHtml::beginForm();
			 $models_bank      = Bank_Info::model()->findAll(array('order' => 'bank_name'));			 
			 $bank_list        = CHtml::listData($models_bank, 'id', 'bank_name');
			 $common_list = array('' => '',);
	 ?>		
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="6">&nbsp;</td></tr>
        <tr>
			<th width="20%" valign="top"><?php echo CHtml::label('Bank Name', 'd_bank_id')?>&nbsp;&nbsp;</th>
			<td width="20%"><?php echo CHtml::dropDownList('d_bank_id','d_bank_id', $bank_list, array('empty' => '----- Select Bank -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;', 'onchange' => 'getAccountNo()')); ?></td>
			<td width="4%">&nbsp;</td>
			<th width="20%" valign="top"><?php echo CHtml::label('Account No', 'd_account_no')?>&nbsp;&nbsp;</th>
			<td width="20%"><div id="account_name" style="width:200px;"><?php echo CHtml::dropDownList('d_account_no','d_account_no', $common_list, array('empty' => '----- Select Account No -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
			<td width="16%">&nbsp;</td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr>
			<th width="20%" valign="top"><?php echo CHtml::label('Start Date', 'start_date')?>&nbsp;&nbsp;</th>
			<td width="20%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:200px;height:22px;border:1px solid #CCC;'))?></td>
			<td width="4%">&nbsp;</td>
			<th width="20%" valign="top"><?php echo CHtml::label('End Date', 'end_date')?>&nbsp;&nbsp;</th>
			<td width="20%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:200px;height:22px;border:1px solid #CCC;'))?></td>
			<td width="16%">&nbsp;<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
		</tr>
        <tr><td colspan="6">&nbsp;</td></tr>
	</table>
  <?php echo CHtml::endForm()?>
       </div>
<!--  END #PORTLETS -->  
   </div>
 