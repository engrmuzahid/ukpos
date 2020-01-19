<link rel="stylesheet" type="text/css" media="all" href="<?php  echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php  echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl.'/'; ?>public/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl.'/'; ?>public/js/jquery.autocomplete.js"></script>
  <script type="text/javascript">	
     $().ready(function() {	 
	$("#product_code").autocomplete('<?php echo Yii::app()->request->baseUrl . '/public/product_list.php'; ?>', {  //we have set data with source here
            formatItem: function(rowdata) { //This function is called right before the item is displayed on the dropdown, so we splitted and returned what we show in the selection box
                var info = rowdata[0].split(":");
                return info[1];
            },
            formatResult: function (rowdata) { // This function is called when any item selected, here also we returned that what we wanted to show our product_name field.
                var info = rowdata[0].split(":");
                return info[1];
            },
            width: 198,
            multiple: false,
            matchContains: true,
            scroll: true,
            scrollHeight: 120
        }).result(function(event, data, formatted){ //Here we do our most important task :)
            if(!data) { //If no data selected set the product_id field value as 0
                $("#product_id").val('0');
            } else { // Set the value for the product id
                var info = formatted.split(":");
                $("#product_id").val(info[0]);                        
            }
        });
});
</script>
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
		<td id="title">Stock Out Report</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/stock_in/report'; ?>" class="none new">Stock Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_out'; ?>" class="none new">Stock Out</a>    
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_out/report'; ?>" class="none new">Stock Out Report</a>                  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td style="background-color:#E9E9E9">
        <?php echo CHtml::beginForm()?>
                   <table align="center" width="85%" style="margin-bottom:10px;margin-left:10px;"> 
                      <tr><td colspan="4">&nbsp;</td></tr>
                      <tr style="font-weight:bold; margin-bottom:10px;">
                        <td align="center" width="35%" valign="top"><?php echo CHtml::label('Start Date', 'start_date')?>&nbsp;&nbsp;</td>
                        <td align="center" width="25%"><?php echo CHtml::TextField('start_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?></td>
                        <td align="center" width="20%" valign="top"><?php echo CHtml::label('End Date', 'end_date')?>&nbsp;&nbsp;</td>
                        <td align="center" width="20%"><?php echo CHtml::TextField('end_date', '', array('style' => 'width:120px;height:25px;border:1px solid #CCC;')); ?> </td>
                      </tr>
                      <tr><td colspan="4">&nbsp;</td></tr>
                      <tr style="font-weight:bold; margin-bottom:10px;">
                        <td align="center" width="35%" valign="top"><?php echo CHtml::label('Product Name / Code', 'product_code')?><span class="markcolor">*</span></td>
                        <td align="center" width="25%"><?php echo CHtml::textField('product_code', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;'))?></td>
                        <td  colspan="2" width="40%"><?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
                    </tr>
                      <tr><td colspan="4">&nbsp;</td></tr>
                   </table>
     <?php echo CHtml::endForm()?>

		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>