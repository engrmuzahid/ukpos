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

   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'received_delivery', 'activeTab' => 'report')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1>Received Delivery Report</h1></div>
     <?php echo CHtml::beginForm()?>
        <?php
			 $models_party_list       = Storage_Party::model()->findAll(array('order' => 'party_name'));			 
			 $party_list              = CHtml::listData($models_party_list, 'id', 'party_name');
		?>
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
        <tr>
			<th width="15%" valign="top"><?php echo CHtml::label('Party Name', 'storage_party_id')?>&nbsp;&nbsp;</th>
			<td width="12%"><?php echo CHtml::dropDownList('storage_party_id', '', $party_list, array('empty' => '----- Select Party -----', 'style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?></td>
			<td width="2%">&nbsp;</td>
			<th width="15%" valign="top"><?php echo CHtml::label('Start Date', 'start_date')?>&nbsp;&nbsp;</th>
			<td width="12%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:130px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="2%">&nbsp;</td>
			<th width="15%" valign="top"><?php echo CHtml::label('End Date', 'end_date')?>&nbsp;&nbsp;</th>
			<td width="12%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:130px;height:25px;border:1px solid #CCC;'))?></td>
			<td width="2%">&nbsp;</td>
            <td valign="top" width="15%">
			<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?>
            </td>
		</tr>
	</table>
  <?php echo CHtml::endForm()?>
       </div>
<!--  END #PORTLETS -->  
   </div>
 