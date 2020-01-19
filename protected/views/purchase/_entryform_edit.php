<script>
        function getQtyTotal()
    {
     
        var mutli_education = document.frm_soft.elements["quantity[]"];
        mlt = mutli_education.length;
        if(!mlt){ mlt = 1; } else{ mlt = mlt; }
        var newTotal=0;
        var vatTotal = 0;
        for(var i=1; i<= mlt; i++)
        {
		 
            var pprice    = document.getElementById("price"+i).value;
            var qty =  document.getElementById("quantity"+i).value;
            var st2 = pprice * qty;
            var newnumber = new Number(st2+'').toFixed(parseInt(2));
            st = parseFloat(newnumber);

            document.getElementById("subTotal"+i).innerHTML = '<?php echo  Yii::app()->user->getState('currency-html'); ?>'+st;
            newTotal+=new Number(st);
            
            var pvat = parseFloat($("#productVat_"+i).val());
            vatTotal += (pvat/100)*st2;            
        }
        var newTotal2 = new Number(newTotal+'').toFixed(parseInt(2));
        nTotal2       = parseFloat(newTotal2);
        document.getElementById("price_grand_total").value = (nTotal2+vatTotal).toFixed(2);
        
        $("#amountTotal").html('<?php echo Yii::app()->user->getState('currency-html'); ?>'+(nTotal2).toFixed(2));
        $("#amountTotalVat").html('<?php echo Yii::app()->user->getState('currency-html'); ?>'+vatTotal.toFixed(2));
        document.getElementById("amountSubTotal").innerHTML = '<?php echo  Yii::app()->user->getState('currency-html'); ?>'+(nTotal2+vatTotal).toFixed(2);
    }

    function calculate_sell_price(row) {
        //var qty = parseFloat($("#quantity"+row).val());
        var profit = parseFloat($("#profitMargin_"+row).val());
        var b_price = parseFloat($("#price"+row).val());
        //var sell_price = b_price + (profit/100)*b_price;
        var sell_price = parseFloat($("#s_price"+row).val());
        var vat = parseFloat($("#productVat_"+row).val());
//        vat = vat ? vat : 0;
//        var sell_price = sell_price + (vat/100)*sell_price;
//        
        if(!sell_price) sell_price = 0;

        $("#s_price"+row).val(sell_price.toFixed(2));
    }


    
    $(document).ready(function(){
        //calculate_sell_price(); 
        $(".buyPrice").blur(function(e){
            calculate_sell_price($(this).attr('data-row'));
            getQtyTotal();
        });
        
        $(".sellPrice").blur(function(e){
            calculate_sell_price($(this).attr('data-row'));
            getQtyTotal();
        });
        
        $(".profitMargin").blur(function(e){
            calculate_sell_price($(this).attr('data-row'));
            getQtyTotal();
        });
        
        $(".productVat").blur(function(e){
            calculate_sell_price($(this).attr('data-row'));
            getQtyTotal();
        });
        
        $(".productQty").blur(function(e){
            getQtyTotal();
        })
        
        $(".sellPrice").blur(function(e){
            var row = $(this).attr('data-row');
//            var sell_price = parseFloat($(this).val());
            var sell_price = parseFloat($("#s_price"+row).val());  
            var vat = parseFloat($("#productVat_"+row).val());
            var x = (sell_price*100)/(100+vat);
            var b_price = parseFloat($("#price"+row).val());
            var profit = ((x-b_price)*100)/b_price;
            
            if(!profit || profit <= 0) profit = 0;
            
            $("#profitMargin_"+row).val(profit.toFixed(2));
            
        });
    });
</script>

<?php echo CHtml::beginForm(Yii::app()->request->baseUrl . '/purchase/add', 'post', array('name' => 'frm_soft', 'enctype' => 'multipart/form-data')); ?>
<table align="center" width="95%" style="margin-bottom:10px;margin-left:10px;"> 
    <tr><td colspan="6">&nbsp;</td></tr>
    <tr height="25" style="font-weight:bold; margin-bottom:10px;">
        <td align="center" width="8%" valign="top"><?php echo CHtml::label('Qty', 'qty') ?><span class="markcolor">*</span></td>
        <td align="center" width="12%"><?php echo CHtml::textField('qty', '', array('style' => 'width:50px;height:25px;border:1px solid #CCC;')) ?></td>
        <td align="center" width="20%" valign="top">
            <?php echo CHtml::label('Product Code', 'product_code') ?><span class="markcolor">*</span>            
        </td>
        <td align="center" width="20%">
            <?php echo CHtml::textField('product_code', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?>
            <input type="hidden" id="product_id" name="product_id" />
        </td>
        <td width="15%"><?php echo "&nbsp;" . CHtml::submitButton('Add', array('class' => 'buttonGreen', 'onClick' => 'MyCard()')); ?></td>
        <td width="25%"  align="center"><a href="<?php echo Yii::app()->request->baseUrl; ?>/product/add" target="_blank"> Add New Item</a></td>
    </tr>
    <tr><td colspan="6">&nbsp;</td></tr>
</table>

<table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
    <tr height="10"><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td colspan="3">
            <?php
            $amount_sub_total = 0;
            $total_vat = 0;
            $user_id = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "user_id = '$user_id'", 'order' => 'id DESC',));
            $cart = Purchase_Tempory::model()->findAll($cond);

            if (count($cart)):
                ?>
                <div id="cart2">
                    <table style="width: 935px">
                        <caption>Product List</caption>
                        <thead>
                            <tr>                                
                                <th>Productkkk</th>
                                <th>Buy</th>
                                <th>Profit%</th>
                                <th>Vat%</th>
                                <th>Sell</th>
                                <th>Qty</th>
                                <th>Note</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php
                        $i = 1;
                        foreach ($cart as $item):
                            $product_code = $item->product_code;

                            $q1 = new CDbCriteria(array('condition' => "product_code = '$product_code'",));
                            $Products = Product::model()->findAll($q1);
                            $sell_price = $item->sell_price;                            
                            $Type_names = "";                            

                            if (count($Products)): foreach ($Products as $Product):
                                    $product_note = $Product->description;
                                    //$sell_price = $Product->sell_price;
                                    

                                endforeach;
                            endif;
                            ?>
                            <tr style="font-size:12px;">                                
                                <td align="center"><?php echo $Product->product_name; ?></td>
                                <td align="center"><?php echo  Yii::app()->user->getState('currency-html');
                            echo CHtml::textField('price[]', $item->p_price, array('id' => 'price' . $i, 'class'=>'buyPrice', 'style' => 'width:40px;height:25px;border:1px solid #CCC;', 'data-row'=>$i)); ?></td>
                                <td><input type="text" class="profitMargin" value="<?php echo $item->profit ?>" style="width:40px;height:25px;border:1px solid #CCC;" data-row="<?php echo $i; ?>" name="profit[]" id="profitMargin_<?php echo $i?>" /></td>
                                <td><input type="text" class="productVat" value="<?php echo $item->vat ?>" style="width:40px;height:25px;border:1px solid #CCC;" data-row="<?php echo $i ?>" name="vat[]" id="productVat_<?php echo $i?>" /></td>
                                <td align="center"><?php echo  Yii::app()->user->getState('currency-html');
                            echo CHtml::textField('s_price[]', $sell_price, array('id' => 's_price' . $i, 'class'=>'sellPrice', 'data-row'=>$i, 'style' => 'width:40px;height:25px;border:1px solid #CCC;')); ?></td>
                                <td align="center"><?php echo CHtml::textField('quantity[]',  $item->quantity, array('id' => 'quantity' . $i, 'class'=>'productQty', 'data-row'=>$i, 'style' => 'width:40px;height:25px;border:1px solid #CCC;')) ?></td>
                                <td align="center"><?php echo CHtml::textField('description[]', $product_note, array('id' => 'description' . $i, 'style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?></td>
                                <td align="center"><div id = "<?php echo 'subTotal' . $i; ?>"><?php echo  Yii::app()->user->getState('currency-html') . number_format($item->p_price * $item->quantity, 2); ?></div></td>
                                <td  class="remove">
        <?php echo CHtml::hiddenField('product_code22[]', $product_code); ?>
        <?php echo CHtml::link('X', array('/purchase/remove/' . $item->id)); ?>

                                </td>
                            </tr>
            <?php
            $pree_amount = $item->p_price * $item->quantity;  //$sell_price
            $amount_sub_total = $amount_sub_total + $pree_amount;
            $total_vat += ($item->vat/100)*$pree_amount;
            $i = $i + 1;
        endforeach;
        ?>
                        <tr><td colspan="5" align="right">
                                <strong>Sub Total: </strong></td><td  align="center"><div id = "amountTotal"><?php echo  Yii::app()->user->getState('currency-html') . number_format($amount_sub_total,2); ?></div>
                                
                        </td></tr>
                        <tr><td colspan="5" align="right">
                            <strong>Vat Total: </strong></td><td  align="center"><div id = "amountTotalVat"><?php echo  Yii::app()->user->getState('currency-html') . number_format($total_vat,2); ?></div> </td>
                        <tr><td colspan="5" align="right">
                            <strong>Grand Total: </strong></td><td  align="center"><div id = "amountSubTotal"><?php echo  Yii::app()->user->getState('currency-html') . number_format($amount_sub_total+$total_vat,2); ?></div> 
                                <input type="hidden"  name="price_grand_total" id="price_grand_total" value="<?php echo $amount_sub_total+$total_vat; ?>" />
                            </td>
                        </tr>
                    </table>		
                </div>
    <?php endif; ?>
        </td>
    </tr>
    <?php
    $models_supplier_list = Supplier::model()->findAll(array('order' => 'name'));
    $supplier_list = CHtml::listData($models_supplier_list, 'id', 'name');


    $criteria = new CDbCriteria();
    $criteria->order = 'id DESC';
    $criteria->limit = 1;
    $purchases = Purchase::model()->findAll($criteria);

    if (count($purchases)): foreach ($purchases as $lastValues):
            $p_sl = $lastValues->id + 1;
            $cl_id = date('y') . date('m') . date('d') . $p_sl;
            if (!empty($cl_id)): $cl_id = $cl_id;
            else: $cl_id = date('y') . date('m') . date('d') . '1';
            endif;
        endforeach;
    else:
        $cl_id = date('y') . date('m') . date('d') . '1';
    endif;
    ?>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'shipment_id') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'chalan_id', array('value' => $cl_id, 'readonly' => 'readonly', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'chalan_id'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'receive_date') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'purchase_date', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'purchase_date'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'supplier_name') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeDropDownList($model, 'supplier_id', $supplier_list, array('empty' => '----- Select Supplier -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'supplier_id'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'receive_note') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextArea($model, 'note', array('style' => 'width:200px;height:100px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'note'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th>&nbsp;</th>
        <td valign="top">
<?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue')); ?>
<!-- <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen')); ?> -->
        </td>
        <td></td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
</table>
<?php
echo CHtml::endForm()?>