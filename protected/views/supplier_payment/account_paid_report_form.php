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
</script>
             <?php
				$models3 = Supplier::model()->findAll(array('order' => 'name'));			 
				$list3   = CHtml::listData($models3, 'id', 'name');				
              ?>
 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">Account Paid Report</td>
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

     <?php echo CHtml::beginForm()?>		
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="10">&nbsp;</td></tr>
        <tr>
			<th width="12%" valign="top"><?php echo CHtml::label('Supplier Name', 'supplier_id')?>&nbsp;&nbsp;</th>
			<td width="15%"><?php echo CHtml::dropDownList('supplier_id','supplier_id', $list3, array('empty' => 'Select Supplier', 'style' => 'width:150px;height:25px;border:1px solid #CCC;'));?></td>
			<td width="2%">&nbsp;</td>
			<th width="12%" valign="top"><?php echo CHtml::label('Start Date', 'start_date')?>&nbsp;&nbsp;</th>
			<td width="15%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="2%">&nbsp;</td>
            </tr>
            <tr><td colspan="6">&nbsp;</td></tr>
            <tr>
			<th width="12%" valign="top"><?php echo CHtml::label('End Date', 'end_date')?>&nbsp;&nbsp;</th>
			<td width="15%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="2%">&nbsp;</td>
            <td valign="top" colspan="3">
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
