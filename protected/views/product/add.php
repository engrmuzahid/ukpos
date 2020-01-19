<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">

    function calculate_sell_price() {
        var profit = parseFloat($("#Product_other_cost").val());
        var b_price = parseFloat($("#Product_purchase_cost").val());
        var profit_amt = parseFloat((profit / 100) * b_price);
        var sell_price = parseFloat(b_price + profit_amt);
        var vat = parseFloat($("#Product_vat").val());
        vat = vat ? vat : 0;

        var vat_on_bp = parseFloat((vat / 100) * b_price).toFixed(2);
        var vat_on_profit = parseFloat(profit_amt - (profit_amt/ (1+ (vat / 100)))).toFixed(2); 



        sell_price = parseFloat(sell_price + parseFloat(vat_on_profit) + parseFloat(vat_on_bp));

        $("#Product_vat_on_purchase").val(vat_on_bp);
        $("#Product_vat_on_profit").val(vat_on_profit);
        $("#Product_sell_price").val(sell_price.toFixed(2));

    }
    $(document).ready(function () {
        new JsDatePick({
            useMode: 2,
            target: "Product_expire_date",
            dateFormat: "%Y-%m-%d"
        });

        $("#Product_other_cost").blur(function (e) {
            calculate_sell_price();
        });

        $("#Product_vat").blur(function (e) {
            calculate_sell_price();
        });

        $("#Product_sell_price").blur(function (e) {
            var sell_price = parseFloat($(this).val());

            var vat = parseFloat($("#Product_vat").val());
            //var x = (sell_price*100)/(100+vat);
            var b_price = parseFloat($("#Product_purchase_cost").val());
            //var profit = (((x-b_price)*100)/b_price).toFixed(2);

            var profit_amt = ((100 * sell_price) / (100 + vat)) - b_price;

            var profit = (profit_amt / b_price) * 100;

            $("#Product_other_cost").val(profit.toFixed(2));

            var vat_on_profit = parseFloat((vat / 100) * profit_amt).toFixed(2);
            $("#Product_vat_on_profit").val(vat_on_profit);
        });
        $('.product_category').live("change", function () {
            // document.getElementById("product_sub_category").innerHTML = '<img  alt="loading ..." src ="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
            product_category_id = $(this).val();
            parent_id = $(this).find(':selected').attr('data-value');
            url = "<?php echo Yii::app()->request->baseUrl; ?>/public/get_jquery_price.php?product_category_id=" + product_category_id;
            $("#product_category_id").val(product_category_id);
            try
            {// Firefox, Opera 8.0+, Safari, IE7
                xm = new XMLHttpRequest();
            } catch (e)
            {// Old IE
                try
                {
                    xm = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e)
                {
                    alert("Your browser does not support XMLHTTP!");
                    return;
                }
            }
            xm.open("GET", url, false);
            xm.send(null);
            msg = xm.responseText;
            if (parent_id == 0) {
                $("#product_sub_category").html(msg);
            } else {
                $(this).attr("disabled", "true");
                if (msg == "Selected") {
                    $("#product_category_id").val(product_category_id);
                    $("#product_sub_category").append('<p style="color:green;"><br>' + msg + '<p>');
                } else {
                    $("#product_sub_category").append(msg);
                }
            }
        });


    });

//    function getProductType()
//    {
//        document.getElementById("product_sub_category").innerHTML = '<img  alt="loading ..." src ="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
//        product_category_id = $('.product_category').val();
////		parent_category_id = $('.product_category').attr('data-value'); 
////                alert(parent_category_id);
//        url = "<?php echo Yii::app()->request->baseUrl; ?>/public/get_jquery_price.php?product_category_id=" + product_category_id;
//
//        try
//        {// Firefox, Opera 8.0+, Safari, IE7
//            xm = new XMLHttpRequest();
//        } catch (e)
//        {// Old IE
//            try
//            {
//                xm = new ActiveXObject("Microsoft.XMLHTTP");
//            } catch (e)
//            {
//                alert("Your browser does not support XMLHTTP!");
//                return;
//            }
//        }
//        xm.open("GET", url, false);
//        xm.send(null);
//        msg = xm.responseText;
//        $("#product_sub_category").html(msg);
//        //document.getElementById("product_sub_category").innerHTML = msg;				
//    }

</script>
<?php //print_r($boucher); ?>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title"><?php echo CHtml::link('Item', array('index')) ?> → Add Item</td>
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
                <?php if (Yii::app()->user->hasFlash('saveMessage')): ?>
                    <div class="message">
                        <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                    </div>
                <?php endif; ?>   
                <?php $this->renderPartial('_form', array('model' => $model)) ?>
            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
