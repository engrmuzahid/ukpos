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
   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'paid_report', 'activeTab' => 'cash_report')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Cash Paid Report</h1></div>
     <?php echo CHtml::beginForm()?>		
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="10">&nbsp;</td></tr>
        <tr>
			<th width="12%" valign="top"><?php echo CHtml::label('Start Date', 'start_date')?>&nbsp;&nbsp;</th>
			<td width="15%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="2%">&nbsp;</td>
			<th width="12%" valign="top"><?php echo CHtml::label('End Date', 'end_date')?>&nbsp;&nbsp;</th>
			<td width="15%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="2%">&nbsp;</td>
            <td valign="top" width="42%">
			<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?>
            </td>
		</tr>
	</table>
  <?php echo CHtml::endForm()?>
       </div>
<!--  END #PORTLETS -->  
   </div>
 