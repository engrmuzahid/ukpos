
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
		<td id="title">Profit / Loss Report</td>
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
                <!-- start id-form -->
                <table border="0" cellpadding="0" cellspacing="0"   style="margin-left:10px;" width="75%">
                <tr><td colspan="7">&nbsp;</td></tr>
                <tr>
                    <td width="20%" align="center" valign="top"><strong><?php echo CHtml::label('From Date', 'start_date')?>&nbsp;&nbsp;</strong></td>
                    <td width="20%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>  
                    <td width="3%">&nbsp;</td>          
                    <td width="20%" align="center"><strong><?php echo CHtml::label('To Date', 'end_date')?>&nbsp;&nbsp;</strong></td>
                    <td width="20%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>  
                    <td width="3%">&nbsp;</td>          
                    <td width="14%"><?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
                </tr>
            </table>
          <?php echo CHtml::endForm()?>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
