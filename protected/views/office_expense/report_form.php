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
        
</script>

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'expense_info', 'activeTab' => 'expense_report')); ?>
  <?php
			 $models_extype_list = Expense_Type::model()->findAll(array('order' => 'expense_type_name'));			 
			 $extype_list        = CHtml::listData($models_extype_list, 'id', 'expense_type_name');
			 $common_list = array('' => '',);
  ?>
<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Office Expense Report</h1></div>
     <?php echo CHtml::beginForm()?>		
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
			<th width="10%" valign="top"><?php echo CHtml::label('Type', 'expense_type_id')?>&nbsp;&nbsp;</th>
			<td width="10%"><?php echo CHtml::dropDownList('expense_type_id','expense_type_id', $extype_list, array('empty' => '----- Select Type -----', 'style' => 'width:140px;height:25px;border:1px solid #CCC;', 'onchange' => 'getExpenseName()')); ?></td>
			<td width="2%">&nbsp;</td>
			<th width="10%" valign="top"><?php echo CHtml::label('Name', 'expense_name_id')?>&nbsp;&nbsp;</th>
			<td width="23%"><div id="expense_name" style="width:200px;"><?php echo CHtml::dropDownList('expense_name_id','expense_name_id', $common_list, array('empty' => '----- Select Name -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
			<td width="2%">&nbsp;</td>
			<th width="12%" valign="top"><?php echo CHtml::label('Start Date', 'start_date')?>&nbsp;&nbsp;</th>
			<td width="8%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:80px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="2%">&nbsp;</td>
			<th width="12%" valign="top"><?php echo CHtml::label('End Date', 'end_date')?>&nbsp;&nbsp;</th>
			<td width="8%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:80px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="2%">&nbsp;</td>
            <td valign="top" width="11%">
			<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?>
            </td>
		</tr>
	</table>
  <?php echo CHtml::endForm()?>
       </div>
<!--  END #PORTLETS -->  
   </div>
 