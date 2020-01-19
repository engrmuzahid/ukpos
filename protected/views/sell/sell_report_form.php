
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
        
        function calculate_amount() {
            var selected_amount = 0.00;

            $(".invoice_ids").each(function(){
                if($(this).attr('checked') == 'checked' || $(this).attr('checked') == true) {
                    selected_amount = parseFloat(selected_amount) + parseFloat($(this).attr('data-amount'));
                }
            });


            var total_amount = parseFloat($("#total_amount").val());
            var paid_amount = parseFloat($("#paid_amount").val());
            var due_amount = parseFloat($("#due_amount").val());
            var after_delete_amount = total_amount - selected_amount;
            var content = '<ul><li style="float:right">Paid Amount : &pound;'+paid_amount.toFixed(2)+'</li><li style="float:left">Due Amount : &pound;'+due_amount.toFixed(2)+'</li>';
            content += '<li>Total Selected Amount: &pound;'+selected_amount.toFixed(2)+'</li>';
            content += '<li style="color:red; clear:both" align="center">Total Balance : &pound;'+after_delete_amount.toFixed(2)+'</li></ul>';

            $("#selected_calculation").html(content);
        }
        
        function load_data(url, data) {
            $("#reportContent").html('Loading...');
            $.post(url, data, function(resp){
                $("#reportContent").html(resp);
                calculate_amount();
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
            
            $(".invoice_ids").die('click').live('click', function(e){
                calculate_amount();
            });
            
            $(window).scroll(function(e){
             $es = $('#selected_calculation');
              if ($(this).scrollTop() > 180 && $es.css('position') != 'fixed'){
                $('#selected_calculation').css({'position': 'fixed', 'top': '0px'});
              }
              else{
                      if($(this).scrollTop() <= 180){
                          $('#selected_calculation').css({'position': 'relative','top': ''});
                      }
                  }
            });
        });
</script>

<script language="javascript">
    function confirmSubmit() {
    var agree=confirm("Are you sure to delete this record?");
    if (agree)
         return true;
    else
         return false;
    }
    
    $(document).ready(function(){
            $("#select_all").die('click').live('click', function(e) {
                if($(this).attr('checked') == true || $(this).attr('checked') == 'checked') {
                    $(".invoice_ids").attr('checked', 'checked');
                } else {
                    $(".invoice_ids").removeAttr('checked');
                }
            });
            
            $("#delete_all_invoice").die('click').live('click', function(e) {
                if(confirm('Are you sure to delete the selected records?')){
                    $("#msg_delete").html('Processing Request...');
                    var url = '<?php echo Yii::app()->request->baseUrl.'/index.php/sell/deleteAll/'; ?>';
                    var data = $("#frmReport").serialize();
                    $.post(url, data, function(resp){
                        $("#msg_delete").html(resp);
//                        $(".invoice_ids").each(function(){
//                            if($(this).attr('checked') == true || $(this).attr('checked') == 'checked') {
//                                $("#row_"+$(this).val()).remove();
//                            }                            
//                        });                          
                          data = $("#frmReportSearch").serialize();
                          load_data(current_url, data);
                    });
                }
                
            });
            
            $(".delete").die('click').live('click', function(e) {
                e.preventDefault();
                if(confirm('Are you sure to delete the  record?')){
                    $("#msg_delete").html('Processing Request...');
                    var id = $(this).attr('data-id');
                    var url = $(this).attr('href');                    
                    $.post(url, {}, function(resp){
                        $("#msg_delete").html(resp);
                        //$("#row_"+id).remove();                         
                         var data = $("#frmReportSearch").serialize();
                         load_data(current_url, data);
                    });
                }
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
		<td id="title">Point of Sell Report</td>
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
			   <?php echo CHtml::beginForm(Yii::app()->request->baseUrl.'/sell/reportListing', 'post', array('id'=>'frmReportSearch'))?>		
               <?php
					$models3 = Users::model()->findAll(array('order' => 'full_name'));			 
					$list3   = CHtml::listData($models3, 'username', 'full_name');
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
                    <td width="20%"><?php echo CHtml::dropDownList('user_id','user_id', $list3, array('empty' => '', 'style' => 'width:180px;height:25px;border:1px solid #CCC;')); ?>
			</td>
                           </tr>
                   <tr><td colspan="6">&nbsp;</td></tr>
                    <tr>
                        
                        <td width="25%"><b style="padding-left:20px;"> Pay. method </b></td>
                        <td width="35%">
                             <select name="payment_type" style="width:180px;height:26px;border:1px solid #CCC;">
                                <option value="">Select</option>
                                <option value="cash">CASH</option>
                                <option value="card">CARD</option>
                               <option value="cheque"> CHEQUE </option>
                            </select>
                        </td>
                        
                         <td width="45%" align="center" colspan="4"><?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue', 'id'=>'reportSearch')); ?></td>
        
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
