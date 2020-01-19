
<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"report_date",
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
		<td id="title">Daily Sell Report</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<?php $this->renderPartial('_menu') ?>
		</td>
		<td style="width: 10px;"></td>        
		<td style="background-color:#E9E9E9">
			   <?php echo CHtml::beginForm()?>	
               <?php
					$models3 = Users::model()->findAll(array('order' => 'full_name'));			 
					$list3   = CHtml::listData($models3, 'username', 'full_name');
			   ?>
                <!-- start id-form -->
                <table border="0" cellpadding="0" cellspacing="0"   style="margin-left:10px;" width="80%">
                <tr><td colspan="7">&nbsp;</td></tr>
                <tr>
                    <td align="center" valign="top"><strong><?php echo CHtml::label('Sell By', 'user_id')?>&nbsp;&nbsp;</strong></td>
                    <td>
					<?php echo CHtml::dropDownList('user_id','user_id', $list3, array('empty' => '', 'style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?>
					</td>
                    <td>&nbsp;</td>          
                    <td align="center"><strong><?php echo CHtml::label('Report Date', 'report_date')?>&nbsp;&nbsp;</strong></td>
                    <td><?php echo CHtml::textField('report_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>  
                    <td>&nbsp;</td>          
                    <td><?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
                </tr>
            </table>
          <?php echo CHtml::endForm()?>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
