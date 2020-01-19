<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/cart.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "return_date",
            dateFormat: "%Y-%m-%d"
        });
    };

    function getTotal()
    {
        p_price = document.getElementById('p_price').value;
        qty = document.getElementById('qty').value;
        amount_total2 = p_price * qty;
        var newnumber = new Number(amount_total2 + '').toFixed(parseInt(2));
        amount_total = parseFloat(newnumber);
        document.getElementById("amount_total").value = amount_total;
    }

</script>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Purchase Return → Entry Information</td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody>
        <tr>
            <td id="commands">
                <?php $this->renderPartial('_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td  style="font-family:Verdana; font-size:11px;">
                <?php if (Yii::app()->user->hasFlash('saveMessage')): ?>
                    <div class="message">
                        <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                    </div>
                <?php endif; ?>   
                <?php $this->renderPartial('_purchasereturnentryform', array('model' => $model)) ?>
            </td>
        </tr>
    </tbody>
</table>
<div id="feedback_bar"></div>
