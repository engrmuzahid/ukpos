<script type="text/javascript">
$(document).ready(function()
{
    init_table_sorting();
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
});
</script>
 
 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">Customer Last Invoice</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell'; ?>" class="none new">Home</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/profit_loss_report'; ?>" class="none new">Profit / Loss Report</a>    
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell/report'; ?>" class="none new">Sell Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/daily_sell_report'; ?>" class="none new">Daily Sell Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_in/min_stockout_report'; ?>" class="none new">Min Stock Out Report</a> 
				<a href="<?php echo Yii::app()->request->baseUrl.'/sell/sell_return'; ?>" class="none new">Sell Return</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/sell/sell_return_report'; ?>" class="none new">Sell Return Report</a>    
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td>
         <?php echo CHtml::beginForm('/pos_uk/customer_invoice','post',array( 'enctype'=>'multipart/form-data')); ?>
         <table align="center" width="60%" style=" margin-left:5px;margin-bottom:10px;">
        <tr><td colspan="3">&nbsp;</td></tr>
                <tr>
                    <th align="left" width="40%"><?php echo "Customer Name"; ?><span class="markcolor">*</span></th>            
                    <td  align="left" width="20%">
							 <?php
                                $models3 = Customer::model()->findAll(array('order' => 'customer_name'));			 
                                $list3   = CHtml::listData($models3, 'id', 'customer_name');
                                echo CHtml::dropDownList('customer_id',$customer_id, $list3, array('empty' => '', 'style' => 'width:180px;height:26px;border:1px solid #CCC;'));
                             ?>
                    </td>
                    <td  align="left" width="40%">&nbsp;&nbsp;<?php echo CHtml::submitButton('Search' ,array('class' => 'buttonBlue')); ?></td>
                </tr>
           <tr><td colspan="3">&nbsp;</td></tr>
          </table>
         <?php echo CHtml::endForm(); ?>
       
        <?php echo CHtml::beginForm(Yii::app()->request->baseUrl.'/customer_invoice/add','post',array( 'enctype'=>'multipart/form-data')); ?>
                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>" />
       <table  width="90%"  cellpadding="0" cellspacing="0"  style="margin-bottom:10px; margin-left:5px;">  
        <tr><td colspan="7">&nbsp;</td></tr>
                <?php if(count($model)): 
					 
				?>
				<tr>
                    <th width="5%" scope="col">&nbsp;</th>
                    <th width="60%" scope="col">Product Name</th>
                    <th width="20%" scope="col">Price + Vat</th>
                    <th width="15%" scope="col">&nbsp;</th>
				</tr>
                <tr><td colspan="4">&nbsp;</td></tr>
                <tr><td colspan="4"><hr size="1" /></td></tr>
                <?php				      
				      foreach($model as $data): 
					  $product_code    = $data->product_code;
					  $product_name    = "";
					  
					  $q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 
					  $ProVals       = Product::model()->findAll( $q1 );
					  if(count($ProVals)): foreach($ProVals as $ProVal):  $product_name =  $ProVal->product_name;  $product_id =  $ProVal->id; endforeach; endif;
					  
					 $criteria2 = new CDbCriteria();
					 $criteria2->condition = "product_code = '$product_code'";
					 $criteria2->order = 'id DESC';
					 $criteria2->limit = 1;
					 $ProductVals = Sell_Product::model()->findAll($criteria2);					 
					  
				 ?>
				<tr style="font-size:12px;">
                    <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_'.$product_id; ?>" id="<?php echo 'checkbox_'.$product_id; ?>" value="<?php echo $product_id; ?>"  /></td>
                    <td align="center"><?php echo $product_name; ?></td>
                    <td align="center"><?php
					 if(count($ProductVals)): foreach($ProductVals as $ProductVal): 
					   $s_price  = $ProductVal->amount;
					   $vat      = ($s_price * $ProductVal->vat)/100;
                       $sell_price = $s_price + $vat;
					   echo '&pound; '.number_format($sell_price, 2);
					   endforeach; endif;
					  ?></td>
                    <td align="center">&nbsp;</td>
				</tr>
                <?php 
				 
				 endforeach; endif; ?>
                <tr><td colspan="4"><hr size="1" /></td></tr>
             <tr><td colspan="4">&nbsp;</td></tr>
            <tr>
            <td colspan="1">&nbsp;</td>
                <td valign="top">
                <?php echo CHtml::submitButton('Add to Sell' ,array('class' => 'buttonBlue')); ?>
                </td>
                <td colspan="4">&nbsp;</td>
            </tr>
                <tr><td colspan="5">&nbsp;</td></tr>
        </table>
   <?php echo CHtml::endForm()?>    

		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
