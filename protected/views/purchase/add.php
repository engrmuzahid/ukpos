<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/cart.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "Purchase_purchase_date",
            dateFormat: "%Y-%m-%d"
        });
        document.getElementById("qty").focus();
    };

    $().ready(function () {

//	$("#product_code").autocomplete('<?php echo Yii::app()->request->baseUrl . '/public/product_list.php'; ?>', {
//		width: 198,
//		multiple: false,
//		matchContains: true,
//		scroll: true,
//		scrollHeight: 120
//	});
        $("#product_code").autocomplete('<?php echo Yii::app()->request->baseUrl . '/public/product_list.php'; ?>', {//we have set data with source here
            formatItem: function (rowdata) { //This function is called right before the item is displayed on the dropdown, so we splitted and returned what we show in the selection box
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
        }).result(function (event, data, formatted) { //Here we do our most important task :)
            if (!data) { //If no data selected set the product_id field value as 0
                $("#product_id").val('0');
            } else { // Set the value for the product id
                var info = formatted.split(":");
                $("#product_id").val(info[0]);
            }
        });
    });

    function getProductType()
    {
        document.getElementById("pro_type").innerHTML = '<img  alt="loading ..." src ="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/images/loader_light_blue.gif" border="0" />';
        product_category_id = document.getElementById('product_category').value;
        url = "<?php echo Yii::app()->request->baseUrl . '/'; ?>public/get_jquery_stock.php?product_category_id=" + product_category_id;

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
        document.getElementById("pro_type").innerHTML = msg;
    }

    function getProductBrand()
    {
        document.getElementById("pro_brand").innerHTML = '<img  alt="loading ..." src ="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loader_light_blue.gif" border="0" />';
        product_type_id = document.getElementById('product_type').value;
        url = "<?php echo Yii::app()->request->baseUrl; ?>/public/get_jquery_stock.php?product_type_id=" + product_type_id;

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
        document.getElementById("pro_brand").innerHTML = msg;
    }

    function getProductName()
    {
        var product_brand_id = document.getElementById("product_brand").value;
        document.getElementById("pro_name").innerHTML = '<img  alt="loading ..." src ="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/images/progress.gif" border="0" />';
        url = "<?php echo Yii::app()->request->baseUrl . '/'; ?>public/get_jquery_stock.php?product_brand_id=" + product_brand_id;
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
        document.getElementById("pro_name").innerHTML = msg;
    }

    function getTotal()
    {
        p_price = document.getElementById('p_price').value;
        qty = document.getElementById('qty').value;
        amount_total = p_price * qty;
        document.getElementById("amount_total").value = amount_total;
    }
    function MyCard()
    {
        var oForm = document.frm_soft;
        oForm.action = "<?php echo Yii::app()->request->baseUrl . '/purchase/entry'; ?>";
        oForm.post = "post";
        oForm.submit();
    }
    
    function MyCardBox()
    {
        var oForm = document.frm_soft;
        oForm.action = "<?php echo Yii::app()->request->baseUrl . '/purchase/entryBox'; ?>";
        oForm.post = "post";
        oForm.submit();
    }

</script>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title"><?php echo CHtml::link('Receivings', array('index')) ?> → Entry Information</td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <div id="new_button">
                    <a style="display: inline-block" href="<?php echo Yii::app()->request->baseUrl . '/purchase'; ?>" class="none new">Home</a>
                    <a style="display: inline-block" href="<?php echo Yii::app()->request->baseUrl . '/purchase/add'; ?>" class="none new">Receive Product</a>  
                    <a style="display: inline-block" href="<?php echo Yii::app()->request->baseUrl . '/purchase/report'; ?>" class="none new">Report</a>
                    <a style="display: inline-block" href="<?php echo Yii::app()->request->baseUrl . '/purchase/product_report'; ?>" class="none new">Receiving Product Report</a>                  
                </div>
            </td>
        </tr>
        <tr>

            <td style="background-color:#E9E9E9">
                <?php if (Yii::app()->user->hasFlash('saveMessage')): ?>
                    <div class="message">
                        <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                    </div>
                <?php endif; ?>   
                <?php $this->renderPartial('_entryform', array('model' => $model)) ?>
            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>