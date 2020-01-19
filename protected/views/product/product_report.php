<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<style type="text/css">
    #reportDate{
        width: 150px;
        height: 30px;
        float: right;
        margin-right: 35px;
    }
    #search_btn{
        width: 32px;
        float: right;
    }
    .JsDatePickBox{
        top:40px !important;
    }
</style>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Product Based  Reports </td>

            <td id="title_search" style="width: 520px;">
                <form method="post" id="searchReport"> 
                    <input type="text" accept="" name="product_title" placeholder="Search item..." value="" style="width:150px;height:25px;border:1px solid #CCC;" />
                    <input type="text" id="product_start_date" placeholder="Start Date..." name="product_start_date" value="" style="width:120px;height:25px;border:1px solid #CCC;" />
                    <input type="text" id="product_end_date" placeholder="End Date..." name="product_end_date" value="" style="width:120px;height:25px;border:1px solid #CCC;" />
                    <button id="search_btn"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/img_search.png" style="height: 32px;float: left;" alt="title icon"></button>
               </form>
               <!-- 
               <select id="reportDate" >
                    <option selected value="<?php echo date("Y-m-d", strtotime("NOW")); ?>">Today</option>
                    <option  value="<?php echo date("Y-m-d", strtotime("-1 days")); ?>">Yesterday</option> 
                    <option value="<?php echo date("Y-m-d", strtotime("-2 days")); ?>">Day before yesterday</option>
                    <option value="<?php echo date("Y-m-d", strtotime("-3 days")); ?>">Last 3rd Day</option>
                    <option value="<?php echo date("Y-m-d", strtotime("-4 days")); ?>">Last 4th Day</option>
                    <option value="<?php echo date("Y-m-d", strtotime("-5 days")); ?>">Last 5th Day</option>
                    <option value="<?php echo date("Y-m-d", strtotime("-6 days")); ?>">Last 6th Day</option>
                    <option value="<?php echo date("Y-m-d", strtotime("-7 days")); ?>">Last 7th Days</option> 
                </select>
               -->
            </td>
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
            <td id="item_table">
                <?php if (Yii::app()->user->hasFlash('saveMessage')): ?>
                    <div class="message">
                        <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                    </div>
                <?php endif; ?> 
                <div id="higher_product">
                    <p style="text-align: center;padding: 140px 0px;"> Please select date and search...</p>
                </div>
            </td>
        </tr>
    </tbody>
</table> 

<script language="javascript">
    function loadProduct() {
        $('#higher_product').html('<p style="text-align: center;padding: 140px 0px;">Searching report.Please wait...<br/><br/><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loading.gif"/></p>');
        // alert($("#product_report_date").val());
        //  var url = "<?php //echo Yii::app()->request->baseUrl;   ?>/public/get_product_jquery.php?reportDate='" + $("#product_report_date").val() + "'";
        var url = "<?php echo Yii::app()->request->baseUrl; ?>/public/get_product_jquery.php";
        var data = $("#searchReport").serialize();
        $.post(url, data, function (resp) {
            $('#higher_product').html(resp);
        });
    }
    $(document).ready(function () {

        new JsDatePick({
            useMode: 2,
            target: "product_start_date",
            dateFormat: "%Y-%m-%d"
        });
        new JsDatePick({
            useMode: 2,
            target: "product_end_date",
            dateFormat: "%Y-%m-%d"
        });
 
        $("#search_btn").click(function (e) {
            e.preventDefault();
           if(!$("#product_start_date").val()) {
                alert("Please select start date.");
            } else if(!$("#product_end_date").val()) {
                alert("Please select end date.");
            } else {
                loadProduct();
            }
        });
    });

</script>
