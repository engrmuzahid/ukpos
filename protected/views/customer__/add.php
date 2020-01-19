<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "Customer_birthday",
            dateFormat: "%Y-%m-%d"
        });
        new JsDatePick({
            useMode: 2,
            target: "Customer_joining_date",
            dateFormat: "%Y-%m-%d"
        });
           
    };

</script>
<style>
    .customer_style,.retail_style {
        color:#333;
        font-size: 17px;
        cursor:pointer;
    }
    .retail_customer{
        color:#009;
        font-size: 17px;
        cursor:pointer;
        background-color: #E9E9E9;
        padding: 8px 10px;
        overflow: hidden;
    }
    .retail_info{
        color:#009;
        font-size: 17px;
        cursor:pointer;
        background-color: #E9E9E9;
        padding: 8px 10px;
        overflow: hidden;
    }

    .retail_margin{
        margin-top: 15px;
    }
    .retail_left{
        margin-left: 45px;
    }
</style>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title"><?php echo CHtml::link('Customer', array('index')) ?> → <span id="text_cus" style="font-size: 20px;">Add Customer</span> 
                <span id="retail_text" style="display:none; font-size: 20px;">Add Retail Customer</span> 
                <span style="margin-left: 300px; "></span> 
                <span class="retail" ><span class="retail_style" style="">Retail Customer</span></span>
                <span class="wholesale" ><span class="customer_style  retail_customer" style="float:right; ">Customer</span></span></td>

        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('/b2b_sell/_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td style="background-color:#E9E9E9">
                <?php if (Yii::app()->user->hasFlash('saveMessage')): ?>
                    <div class="message">
                        <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                    </div>
                <?php endif; ?> 

                <div id="retail" style="display:none;" >
                    <?php $this->renderPartial('_formretail', array('model' => $model)) ?>
                </div> 

                <div id="wholesale" >
                    <?php $this->renderPartial('_form', array('model' => $model)) ?>
                </div>

            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div> 

<script>
    function show_content(target) {
        //$(".common-content").hide();
        $("#" + target).show();
        window.scrollTo(0, 0);
    }
    function hide_content(target) {
        $("#" + target).hide();
        window.scrollTo(0, 0);
    }
    $(document).ready(function () {
        $(".retail").live('click', function (e) {
            show_content("retail");
            show_content("retail_text");
            hide_content("wholesale");
            hide_content("text_cus");
            $(".retail_style").addClass("retail_info");
            $(".customer_style").addClass("retail_margin");
            $(".customer_style").removeClass("retail_info");
            $(".customer_style").removeClass("retail_customer");
            $(".retail_style").removeClass("retail_left");

        });

        $(".wholesale").live('click', function (e) {
            show_content("wholesale");
            hide_content("retail");
            show_content("text_cus");
            hide_content("retail_text");
            $(".customer_style").addClass("retail_info");
            $(".retail_style").addClass("retail_left");
            $(".retail_style").removeClass("retail_info");
            $(".customer_style").removeClass("retail_customer");
            $(".customer_style").removeClass("retail_margin");
        });
    });
</script>