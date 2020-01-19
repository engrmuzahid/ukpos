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
			 $models_supplier_list    = Supplier::model()->findAll(array('order' => 'name'));			 
			 $supplier_list           = CHtml::listData($models_supplier_list, 'id', 'name');
         ?>
 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">Receiving Report</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/purchase'; ?>" class="none new">Home</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/purchase/add'; ?>" class="none new">Receive Product</a>  
				<a href="<?php echo Yii::app()->request->baseUrl.'/purchase/report'; ?>" class="none new">Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/purchase/product_report'; ?>" class="none new">Receiving Product Report</a>                  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td style="background-color:#E9E9E9">
			 <?php echo CHtml::beginForm()?>		
                <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
                <tr height="10"><td colspan="3">&nbsp;</td></tr>
                <tr>
                    <th width="15%" valign="top"><?php echo CHtml::label('Supplier Name', 'supplier_id')?>&nbsp;&nbsp;</th>
                    <td width="12%"><?php echo CHtml::dropDownList('supplier_id', '', $supplier_list, array('empty' => '----- Select Supplier -----', 'style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?></td>
                    <td width="2%">&nbsp;</td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>    
                    <th width="15%" valign="top"><?php echo CHtml::label('Start Date', 'start_date')?>&nbsp;&nbsp;</th>
                    <td width="12%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
                    <td width="2%">&nbsp;</td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>    
                    <th width="15%" valign="top"><?php echo CHtml::label('End Date', 'end_date')?>&nbsp;&nbsp;</th>
                    <td width="12%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
                    <td width="2%">&nbsp;</td>
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                    <td>&nbsp;</td>    
                    <td valign="top" width="14%">
                    <?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?>
                    </td>
                    <td>&nbsp;</td>    
                </tr>
                <tr><td colspan="3">&nbsp;</td></tr>
            </table>
          <?php echo CHtml::endForm()?>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
