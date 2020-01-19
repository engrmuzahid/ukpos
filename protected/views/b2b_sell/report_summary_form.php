
<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/pager.css" />
<script type="text/javascript">
        var current_url;
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
        
        
        
        function load_data(url, data) {
            $("#reportContent").html('Loading...');
            $.post(url, data, function(resp){
                $("#reportContent").html(resp);
                //calculate_amount();
            });
        }
        
        $(document).ready(function(){
            $("#reportSearch").click(function(e){
                e.preventDefault();
                
                var url = $("#frmReportSearch").attr('action');
                current_url = url;
                var data = $("#frmReportSearch").serialize();
                load_data(url, data);
            });
            
            $(".first > a, .page > a, .last > a, .next > a, .previous > a").die('click').live('click', function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                current_url = url;
                var data = $("#frmReportSearch").serialize();
                load_data(current_url, data);
            });
            

            

        });
</script>

<style>
        #selected_calculation{
    position: relative;
    width: 780px;
    background: #E6E6E6;
    font-weight: bold;
    padding: 10px;
    font-size: 14px;
    text-align: center;
}

#selected_calculation ul{    
    list-style-type: none;
}
    </style>
 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">B2B Sell Report</td>
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
			   <?php echo CHtml::beginForm(Yii::app()->request->baseUrl.'/b2b_sell/summaryListing', 'post', array('id'=>'frmReportSearch')); ?>		
               <?php
					$models3 = Users::model()->findAll(array('order' => 'full_name'));			 
					$list3   = CHtml::listData($models3, 'username', 'full_name');
                                        
                                        $customer_model = Customer::model()->findAll(array('order' => 'customer_name'));			 
                                        //$customer_list   = CHtml::listData($customer_model, 'id', 'customer_name');
			   ?>
                <!-- start id-form -->
                <table border="0" cellpadding="0" cellspacing="0" width="88%">
                <tr><td colspan="6">&nbsp;</td></tr>
                <tr>
                    <th width="20%" align="center" valign="top"><?php echo CHtml::label('From Date', 'start_date')?>&nbsp;&nbsp;</th>
                    <td width="20%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:180px;height:25px;border:1px solid #CCC;'))?></td>
                    <td width="5%">&nbsp;</td>
                    <th width="20%" align="center" valign="top"><?php echo CHtml::label('To Date', 'end_date')?>&nbsp;&nbsp;</th>
                    <td width="20%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:180px;height:25px;border:1px solid #CCC;'))?></td>
                    <td width="15%">&nbsp;</td>
                </tr>
                <tr><td colspan="6">&nbsp;</td></tr>
                <tr>
                    <th width="20%" align="center" valign="top"><?php echo CHtml::label('Invoice No', 'invoice_no')?>&nbsp;&nbsp;</th>
                    <td width="20%" ><?php echo CHtml::textField('invoice_no', '', array('style' => 'width:180px;height:25px;border:1px solid #CCC;'))?></td>
                    <td width="5%">&nbsp;</td>
                    <th width="20%" align="center" valign="top"><?php echo CHtml::label('Sell By', 'user_id')?>&nbsp;&nbsp;</th>
                    <td width="20%">
					<?php echo CHtml::dropDownList('user_id','user_id', $list3, array('empty' => '', 'style' => 'width:180px;height:25px;border:1px solid #CCC;')); ?>
					</td>                    
                </tr>
                <tr><td colspan="6">&nbsp;</td></tr>
                <tr>
                    <th width="20%" align="center" valign="top"><?php echo "Customer "; ?>&nbsp;&nbsp;</th>
                    <td width="20%">
                        <select name="customer_id" style="width:150px;height:26px;border:1px solid #CCC;">
                            <option value="">Select</option>
                            <?php foreach($customer_model as $cust) : ?>
                            
                                <option value="<?php echo $cust->id ?>"><?php echo $cust->customer_name ?>-<?php echo $cust->id ?></option>

                            <?php endforeach; ?>
                        </select>
                        <?php //echo CHtml::dropDownList('customer_id','customer_id', $customer_list, array('empty' => '', 'style' => 'width:150px;height:26px;border:1px solid #CCC;')); ?>
                    </td>
                    <td width="5%" colspan="2">&nbsp;</td>
                    <td width="55%"><?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue', 'id'=>'reportSearch')); ?></td>
                </tr>
            </table>
          <?php echo CHtml::endForm()?>
                <br/>
                <div id="selected_calculation">
                    No order selected.
                </div>
                
                <div id="reportContent"></div>
                
		</td>
                
	</tr>
        
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
