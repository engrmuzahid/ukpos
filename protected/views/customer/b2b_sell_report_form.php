
<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
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
 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">B2B Delivery Note</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<?php $this->renderPartial('/b2b_sell/_menu') ?>
		</td>
		<td style="width: 10px;"></td>        
		<td style="background-color:#E9E9E9">
			   <?php echo CHtml::beginForm()?>	
				 <?php
                    $models3 = Customer::model()->findAll(array('order' => 'customer_name'));			 
                    $list3   = CHtml::listData($models3, 'id', 'customer_name');
                 ?>
                <!-- start id-form -->
                <table border="0" cellpadding="0" cellspacing="0" width="88%">
                <tr><td colspan="6">&nbsp;</td></tr>
                <tr>
                    <th width="20%" align="center" valign="top"><?php echo CHtml::label('From Date', 'start_date')?>&nbsp;&nbsp;</th>
                    <td width="20%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
                    <td width="5%">&nbsp;</td>
                    <th width="20%" align="center" valign="top"><?php echo CHtml::label('To Date', 'end_date')?>&nbsp;&nbsp;</th>
                    <td width="20%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
                    <td width="15%">&nbsp;&nbsp;</td>
                </tr>
                <tr><td colspan="6">&nbsp;</td></tr>
                <tr>
                    <th width="20%" align="center" valign="top"><?php echo "Customer Name"; ?>&nbsp;&nbsp;</th>
                    <td width="20%">
                        <select name="customer_id" style="width:150px;height:26px;border:1px solid #CCC;">
                                <option value="">Select</option>
                                <?php foreach($models3 as $cust) : ?>

                                    <option value="<?php echo $cust->id ?>"><?php echo $cust->customer_name ?>-<?php echo $cust->id ?></option>

                                <?php endforeach; ?>
                            </select>
                        <?php //echo CHtml::dropDownList('customer_id','customer_id', $list3, array('empty' => '', 'style' => 'width:150px;height:26px;border:1px solid #CCC;')); ?>
                    </td>
                    <td width="5%">&nbsp;</td>
                    <td width="55%" colspan="3">&nbsp;&nbsp;<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
                </tr>
                <tr><td colspan="6">&nbsp;</td></tr>
            </table>
          <?php echo CHtml::endForm()?>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
