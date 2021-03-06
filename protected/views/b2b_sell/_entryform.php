<script language="javascript">
    
window.onload = function(){
        document.getElementById("product_code").focus();
    };

    function getQtyTotal()
    {
    
        var mutli_education = document.frm_soft.elements["quantity[]"];
        var newTotal=0;
        var qtyTotal=0;
        var vatTotal=0;
        var bpTotal = 0;
        mLength = mutli_education.length;
	 
        if(!mLength){ mLength = 1; } else{ mLength = mLength; }
	 
        var total_discount = 0; 
        for(var i=1; i<=mLength; i++)
        {
		
            var pprice    = document.getElementById("pprice"+i).value;
            var qty       =  document.getElementById("qty"+i).value;
            var dis       =  document.getElementById("dis"+i).value;
            var vatt      =  document.getElementById("vat"+i).value;
            var buy_price = $("#buy_price"+i).val();
		
            var st = pprice * qty;
            var discount = (st * dis) / 100;
            st_round = st - discount;
            var newnumber = new Number(st_round+'').toFixed(parseInt(2));
            st2 = parseFloat(newnumber);
	
            vat2 = (st2 * vatt) / 100;
	   
            subTT_round = st2 * 1 + vat2 * 1;
            var subTT2 = new Number(subTT_round+'').toFixed(parseInt(2));
            subTT2 = parseFloat(subTT2);
            document.getElementById("subTotal"+i).innerHTML = "&pound; "+subTT2;
		
            newTotal+=new Number(st2);
            qtyTotal+=new Number(qty);
            vatTotal+=new Number(vat2);
            total_discount += discount;
            bpTotal += buy_price*qty;
        }
        var newTotal2 = new Number(newTotal+'').toFixed(parseInt(2));
        nTotal2       = parseFloat(newTotal2);
        var vatTotal2 = new Number(vatTotal+'').toFixed(parseInt(2));
        vTotal2       = parseFloat(vatTotal2);
		
        var tTotal   = newTotal + vatTotal;		
        var trTotal2 = new Number(tTotal+'').toFixed(parseInt(2));
        tTotal2      = parseFloat(trTotal2);
        
        if($("#discount_ratio").val() > 0) {
            var discount_ratio = tTotal2*(parseFloat($("#discount_ratio").val())/100);
            total_discount += discount_ratio;
            tTotal2 = (tTotal2 - discount_ratio).toFixed(2);
        }
            
        
        $("#discountTotal").html('&pound; '+total_discount.toFixed(2));
        $("#totalDiscount").val(total_discount.toFixed(2));
        
        $("#total_bp").html(bpTotal.toFixed(2));

		
        document.getElementById("qtyTotal").innerHTML       = qtyTotal;
        document.getElementById("price_grand_total").value  = nTotal2;
        document.getElementById("vat_total").value = vTotal2;
        document.getElementById("vatTTotal").innerHTML   = "&pound; "+vTotal2;
        document.getElementById("amountSubTotal").innerHTML = "&pound; "+nTotal2;
        document.getElementById("price_grand_ttotal").value = tTotal2;
        document.getElementById("amountTTotal").innerHTML   = "&pound; "+tTotal2;
        document.getElementById("dueTotal").innerHTML       = "&pound; "+tTotal2;
        document.getElementById("amount_payable").value     = tTotal2;
    }
	
    function getDue()
    {        
        price_grand_ttotal  = document.getElementById('price_grand_ttotal').value;
        cash_payment        = document.getElementById('cash_payment').value;
        cheque_payment      = document.getElementById('cheque_payment').value;
        credit_card_payment = document.getElementById('credit_card_payment').value;
        old_payment = $("#old_payment").val();
        tPayment            = cash_payment*1 + cheque_payment*1 + credit_card_payment*1 + old_payment*1;        
        dPayment            = price_grand_ttotal - tPayment;
        var newnumber = new Number(dPayment+'').toFixed(parseInt(2));
        ds2 = parseFloat(newnumber);
        document.getElementById("dueTotal").innerHTML = "&pound; "+ds2;
    }
    
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
        $("#customer_name").autocomplete('<?php echo Yii::app()->request->baseUrl . '/public/customer_list.php'; ?>', {
            width: 198,
            multiple: false,
            matchContains: true,
            scroll: true,
            scrollHeight: 120
        });
        
        <?php if(isset($old_order->invoice_no)) : ?>
            getDue();
        <?php endif; ?>    
    });
    
</script>
<?php echo CHtml::beginForm(Yii::app()->request->baseUrl . '/b2b_sell/add', 'post', array('name' => 'frm_soft', 'enctype' => 'multipart/form-data', 'id' => 'frm_b2b_sell')); ?>
<input type="hidden" name="total_discount" id="totalDiscount" value="0" />
<input type="hidden" name="remove_item" id="remove_item" />
<?php //if(isset($old_order->invoice_no)) :  ?>
    <input type="hidden" name="existing_invoice_no" value="<?php echo $old_order->invoice_no ?>" />
<?php //endif; ?>
<table>
    <tbody>
        <tr>
            <td id="register_items_container">
                <table id="title_section">
                    <tbody><tr>
                            <td id="title_icon">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
                            </td>
                            <td id="title">Sales Register</td>
                            <td id="register_wrapper">
                            </td>
                            <td id="show_suspended_sales_button"><a href="<?php echo Yii::app()->request->baseUrl . '/b2b_sell/suspended/'; ?>" title="Suspended Sales"><div class="small_button">Suspended Sales</div></a></td>
                        </tr>
                    </tbody></table>


                <div id="reg_item_search">
                    <?php echo CHtml::textField('product_code', '', array('style' => 'width:508px;height:26px;border:1px solid #CCC;')) ?>
                    <input type="hidden" id="product_id" name="product_id" />
                    <div id="new_item_button_register">
                        <a target="_blank" href="<?php echo Yii::app()->request->baseUrl . '/product/add/'; ?>" title="New Item"><div class="small_button"><span>New Item</span></div></a>
                    </div>					
                </div>
                <div id="register_holder">
                    <table id="register" style="width:100%">

                        <thead>
                            <tr>
                                <th  style="width: 68px;"></th>
                                <th style="width: 283px;">Item Name</th>
                                <th id="reg_item_stock" style="width: 58px;">Stock</th>
                                <th id="reg_item_price" style="width: 55px;">Euro</th>
                                <th id="reg_item_price" style="width: 60px;">Price</th>
                                <th id="reg_item_qty" style="width: 50px;">Qty.</th>
                                <th id="reg_item_discount" style="width: 55px;">Disc %</th>
                                <th id="reg_item_total" style="width: 100px;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="cart_contents">
                            <tr>
                                <td colspan="8">
                                    <table>							
                                        <tbody>
                                            <?php
                                            $amount_sub_total = 0;
                                            $total_bp = 0;
                                            $total_discount = 0;
                                            $qty_total = 0;
                                            $user_id = Yii::app()->user->id;
                                            $cond = new CDbCriteria(array('condition' => "user_id = '$user_id'", 'order' => 'id DESC',));
                                            $cart = Sell_Tempory::model()->findAll($cond);

                                            if (count($cart)):
                                                $i = 1;

                                                foreach ($cart as $item):
                                                    $q1 = new CDbCriteria(array('condition' => "product_code = '$item->product_code'",));
                                                    $Product = Product::model()->find($q1);
                                                    $product_name = $item->product_name;
                                                    $buy_price = $Product->purchase_cost;

                                                    $Stocks = Stock::model()->findAll($q1);
                                                    $stock_qty = "";
                                                    if (empty($product_name)):
                                                        $product_name = $Product->product_name;
                                                        
                                                    endif;
                                                    if (count($Stocks)): foreach ($Stocks as $Stocks): $stock_qty = $Stocks->product_balance;
                                                        endforeach;
                                                    endif;
                                                    if ($i == 1): $style = "style='width:270px;height:22px;border:1px solid #CCC;font-size:14px;font-weight:bold;'";
                                                    else: $style = "style='width:270px;height:22px;border:1px solid #CCC;'";
                                                    endif;
                                                    ?>
                                                    <tr id="reg_item_top">
                                                        <td style="width: 68px;" class="item_delete">
                                                            <a href="javascript:void(0)" onclick="$('#remove_item').val('<?php echo $item->id ?>'); $('#frm_b2b_sell').submit();">Delete</a>                                                                                                                    
                                                        </td>
                                                        <td style="width: 283px;"><input type="text" id="<?php echo 'product_name' . $i; ?>" name="product_name[]" value="<?php echo $product_name; ?>" <?php echo $style; ?>></td>
                                                        <td style="width: 58px;" id="reg_item_stock"><?php echo $stock_qty; ?></td>
                                                        <td style="width: 55px;color: #BBB" id="reg_item_stock">
                                                            <input id="<?php echo 'buy_price' . $i; ?>" type="hidden" value="<?php echo $buy_price ?>" />
                                                            <?php echo $buy_price; ?>
                                                        </td>
                                                        <td style="width: 60px;" id="reg_item_price"><input id="<?php echo 'pprice' . $i; ?>" name="price[]" value="<?php echo $item->p_price; ?>" size="4"  type="text" onKeyUp="javascript:getQtyTotal()"></td>
                                                        <td style="width: 50px;" id="reg_item_qty"><input id="<?php echo 'qty' . $i; ?>" name="quantity[]" value="<?php echo $item->quantity; ?>" type="text" onkeyup="javascript:getQtyTotal()"></td>
                                                        <td style="width: 55px;" id="reg_item_discount">
                                                            <?php
                                                            $price_sub = $item->p_price * $item->quantity;                                                            
                                                            if($item->discount > 0) {
                                                                $discount_amount = number_format(($item->discount/100)*$price_sub, 2, '.', '');
                                                                $price_sub = number_format($price_sub - ($item->discount/100)*$price_sub, 2, '.', '');
                                                            }
                                                            ?>
                                                            <input name="discount[]" value="<?php echo $item->discount ?>" size="3" id="<?php echo 'dis' . $i; ?>" type="text"  onkeyup="javascript:getQtyTotal()">
                                                        </td>
                                                        <td style="width: 100px;" id="reg_item_total">
                                                            <div id = "<?php echo 'subTotal' . $i; ?>">
                                                            <?php                                                            
                                                            $vat_s_total = ($price_sub * $item->vat) / 100;
                                                            $p_sub_vat = $price_sub + $vat_s_total;
                                                            echo '&pound; ' . $p_sub_vat;
                                                            ?>
                                                            </div>
                                                            <input name="vat[]" size="20" id="vat<?php echo $i; ?>" type="hidden" value="<?php echo $item->vat; ?>">
                                                    <?php echo CHtml::hiddenField('product_code22[]', $item->product_code); ?>
                                                        </td>
                                                    </tr>						
        <?php        
        $amount_sub_total = $amount_sub_total + $price_sub;
        $total_discount += $discount_amount;
        $total_bp += $buy_price*$item->quantity;
        $i = $i + 1;
        $qty_total = $qty_total + $item->quantity;
    endforeach;
endif;
?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>			
                <div id="reg_item_base"></div>
            </td>
            <td style="width: 8px;"></td>
            <td id="over_all_sale_container">
                Customer Comment: <span style="color: #E6E6E6" id="total_bp"><?php echo $total_bp; ?></span>
                <input name="comment"  id="comment" type="text" value="" style="width:210px;height:22px;border:1px solid #CCC;">
                <div id="overall_sale">				
                    <div id="suspend_cancel">
                        <div id="suspend" style="visibility: visible;">
                            <?php echo CHtml::button('Suspend Sale', array('id' => 'suspend_sale_button', 'name' => 'pay_now2', 'style' => 'width:105px; height:26px;', 'onClick' => 'MySuspend2()')); ?>			
                        </div>
                        <div id="cancel" style="visibility: visible;">	
                            <?php echo CHtml::button('Cancel Sale', array('id' => 'cancel_sale_button', 'name' => 'pay_now', 'style' => 'width:90px; height:26px;', 'onClick' => 'MySellCancel2()')); ?>											
                        </div>
                    </div>
                    <div id="customer_info_shell">
                        <div id="customer_info_empty">
                            <label id="customer_label" for="customer_name">Select Customer</label>
<?php
if (!empty($customer_id2)): $customer_id2 = $customer_id2;
else: $customer_id2 = "";
endif;
$models3 = Customer::model()->findAll(array('order' => 'customer_name'));
$list3 = CHtml::listData($models3, 'id', 'customer_name');
echo CHtml::dropDownList('customer_id', $customer_id2, $list3, array('required' => 'required', 'empty' => '', 'style' => 'width:180px;height:22px;border:1px solid #CCC;', 'onchange' => 'getCustomer()'));
?>
                            <div id="add_customer_info">

                                <div id="common_or">OR</div>
                                <a target="_blank" href="<?php echo Yii::app()->request->baseUrl . '/customer/add/'; ?>" title="New Customer"><div class="small_button" style="margin: 0pt auto;"> <span>New Customer</span> </div></a>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                        </div>
                    </div>
                    <div id="customer" style="color:#FF0000"> &nbsp;</div>
                    <div>
                        <p align="center" style="margin-bottom:3px;"><a class = "buttonGreen"onClick = "CustomerInvoice()" href="#" title="Customer Invoice"> <span>Customer Invoice</span></a></p>
                    </div>
                    <div id="sale_details">
                        <table id="sales_items" style="width:100%; font-size:14px;">
                            <tbody>
                                <tr>
                                    <td class="left">Items In Cart:</td>
                                    <td class="right"><div id="qtyTotal"><?php echo $qty_total; ?></div></td>
                                </tr>
                                <tr>
                                    <td class="left">Sub Total:</td>
                                    <td class="right">
                                        <div id = "amountSubTotal"><?php echo "&pound; " . number_format($amount_sub_total, 2); ?></div> 
                                    </td>
                                </tr>
                                <?php
                                $user_id = Yii::app()->user->name;
                                $cond = new CDbCriteria(array('condition' => "user_id = '$user_id'", 'order' => 'id DESC',));
                                $cart2 = Sell_Tempory::model()->findAll($cond);

                                if (count($cart2)):
                                    $i = 1;
                                    $vat_total = 0;
                                    foreach ($cart2 as $item2):
                                        $vat = $item2->vat;
                                        if ($vat > 0):
                                            $sum = $item2->p_price * $item2->quantity;
                                            $vat_sub_total = ($sum * $vat) / 100;
                                            ?>
            <?php
            $vat_total = $vat_total + $vat_sub_total;
        else:
            ?>
        <?php
        endif;
        $i = $i + 1;
    endforeach;
    $amount_ttotal = $amount_sub_total + $vat_total;
endif;
?>
                                <tr>
                                    <td class="left">Vat Total:</td>
                                    <td class="right"><div id = "vatTTotal"><?php echo "&pound; " . number_format($vat_total, 2); ?></div></td>
                                </tr>
                                <tr>
                                        <td class="left">Discount:</td>
                                        <td class="right"><div id = "discountTotal">&pound; <?php echo number_format($total_discount, 2) ?></div></td>
                                </tr>
                            </tbody></table>
                        <table id="sales_items_total" style="width:100%">
                            <tbody><tr>
                                    <td class="left">Total:</td>
                                    <td class="right">
                                        <div id = "amountTTotal"><?php echo "&pound; " . number_format($amount_ttotal, 2); ?></div> 
                                        <input type="hidden"  name="price_grand_total" id="price_grand_total" value="<?php echo $amount_sub_total; ?>" />
                                        <input type="hidden"  name="vat_total" id="vat_total" value="<?php echo $vat_total; ?>" />
                                        <input type="hidden"  name="price_grand_ttotal" id="price_grand_ttotal" value="<?php echo $amount_ttotal; ?>" />
                                        <input type="hidden" id="old_payment" value="<?php echo isset($old_order->paid_amount) ? $old_order->paid_amount : '0' ?>" />
                                    </td>
                                </tr>
                                <?php if(isset($old_order->invoice_no)) : ?>
                                <tr>
                                    <td class="left">Paid:</td>
                                    <td class="right">
                                        <?php echo "&pound; " . number_format($old_order->paid_amount, 2); ?> 
                                        
                                    </td>
                                </tr>
                                <?php endif; ?>
                                
                                <tr>
                                    <td class="left">Discount</td>
                                    <td class="right"><input style="margin-bottom:3px;" name="discount_ratio" value="" id="discount_ratio" size="10"  type="text" onkeyup = "javascript:getQtyTotal();">%</td>
                                </tr>
                                
                            </tbody></table>
                    </div>


                    <div id="Payment_Types">					
                        <table id="amount_due">
                            <tbody>
                                <tr class="">
                                    <td><div class="float_left" style="font-size: 0.8em;">Amount Due:</div></td>
                                    <td style="text-align: right;"><div class="float_left" style="text-align: right; font-weight: bold;">
                                            <div id = "dueTotal" style="color:#FF0000">
                                                    <?php echo "&pound; " . number_format($amount_ttotal, 2); ?>
                                            </div>
                                        </div></td>
                                </tr>
                            </tbody>
                        </table>

                        <div id="make_payment">
                            <table>
                                <tbody>
                                    <tr><td align="center" style="margin-bottom:3px;"><strong>Payment By</strong></td></tr>                                    
                                    <tr>
                                        <td>&nbsp;&nbsp;Cash</td>
                                        <td><input style="margin-bottom:3px;" name="cash_payment" value="" id="cash_payment" size="10"  type="text" onkeyup = "javascript:getDue()"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Cheque</td>
                                        <td><input style="margin-bottom:3px;" name="cheque_payment" value="" id="cheque_payment" size="10"  type="text" onkeyup = "javascript:getDue()"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Card</td>
                                        <td><input style="margin-bottom:3px;" name="credit_card_payment" value="" id="credit_card_payment" size="10"  type="text" onkeyup = "javascript:getDue()"></td>
                                    </tr>
                                </tbody></table>
                            <div style="margin-left:50px;"><?php echo CHtml::submitButton('Pay Now', array('id' => 'pay_now', 'name' => 'pay_now', 'class' => 'buttonGreen')); ?></div>
                            <p>&nbsp;</p>
                        </div>
                    </div>

                </div><!-- END OVERALL-->	
            </td>
        </tr>
    </tbody></table>
<?php echo CHtml::endForm(); ?>