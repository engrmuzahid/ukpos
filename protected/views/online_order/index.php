<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "start_date",
            dateFormat: "%Y-%m-%d"
        });
        new JsDatePick({
            useMode: 2,
            target: "end_date",
            dateFormat: "%Y-%m-%d"
        });
    };
</script>
<style type="text/css">
    .icon_title{
        width: 250px;
        float: left;
        padding-left: 10px;
    }
    .icon_title span{
        font-size: 24px;
        position: absolute;
        padding:12px 0 0 5px;
    }
    .search_title{
        width: 680px;
        float: right;
    }
    .sameDiv{
        width: 175px;
        float: left
    }
    input[type='text']{
        padding-left: 10px;
    }
    input[type='text']
    {
        height: 30px;
        border: 1px solid #ccc;

    }
    select {
        height: 32px;
        border: 1px solid #ccc;
        width: 200px;
        padding: 5px;
    }
</style>
<div style="width: 100%;padding: 10px 0px;background: #ededed;height: 55px;border-radius: 15px;border: 1px solid #ccc;margin-bottom: 10px;">
    <div class="icon_title" style="width: 200px;">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/online_order.png" alt="title icon"> <span>  Online Order </span>
    </div>
    <div class="search_title" style="float: left;width: 750px;">
        <form method="post" action="#" id="onlineOrderFrm">
            <div style="width: 150px;float: left">
                Order Type   
                <br/>   
                <select name="Search[online_order_status]" style="width: 140px;">
                    <option value="pending">Pending</option>
                    <option value="accept">Accepted</option>

                </select>
            </div>
            <div class="sameDiv">
                Form Date 
                <br/>
                <input type="text" name="Search[start_date]" id="start_date" style="width: 160px;"/>
            </div>
            <div class="sameDiv">
                To  Date 
                <br/>
                <input type="text" name="Search[end_date]" id="end_date" style="width: 160px;"/>
            </div>
            <div style="width: 150px;float: left">
                Customer   
                <br/>   
                <select name="Search[customer_id]" style="width: 140px;">
                    <option value="">Select</option>
                    <?php foreach ($customers as $customer) : ?>

                        <option value="<?php echo $customer->id ?>"><?php echo $customer->customer_name ?>-<?php echo $customer->id ?></option>

                    <?php endforeach; ?>
                </select>
            </div>
            <div style="width: 80px;float: left;padding-top: 15px; ">
                <button class="buttonBlue" id="onlineOrderBtn"> Search </button>
            </div>
        </form>
    </div>
</div>   


<table id="contents">
    <tbody>
        <tr>       
            <td id="item_table">
                <div class="message" style="display: none;">     </div> 
                <div id="orderList">

                </div>


        </tr>
    </tbody>
</table> 
<script language="javascript">
    function load_order_list() {
        $("#orderList").html('<p style="text-align: center;padding: 140px 0px;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loading.gif"/></p>');
        var data = $("#onlineOrderFrm").serialize();
        var url = '<?php echo Yii::app()->baseUrl ?>/online_order/orderlist';
        $.post(url, data, function (resp) {
            $("#orderList").html(resp);

        });

    }


    $(document).ready(function () {
        load_order_list();

        setInterval(function () {
            $("#orderList").html('<p style="text-align: center;padding: 140px 0px;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/loading.gif"/></p>');
            var data = $("#onlineOrderFrm").serialize();
            var url = '<?php echo Yii::app()->baseUrl ?>/online_order/pendinglist';
            $.post(url, data, function (resp) {
                $("#orderList").html(resp);

            });
        }, 60000 * 10);
        $("#filter_day").change(function (e) {
            if ($(this).val() != "")
                location = '<?php echo Yii::app()->baseUrl ?>/customer/index/?filter_day=' + $(this).val();
            else
                location = '<?php echo Yii::app()->baseUrl ?>/customer/index/';
        });

        $("#onlineOrderBtn").click(function (e) {
            e.preventDefault();
            load_order_list();

        });

//        $(".hovertable").on("click",".deleteBtn",function (e) {
        $(".deleteBtn").click(function (e) {
            e.preventDefault();
            if (onfirm("Are you sure to delete this record?"))
            {
                var data_id = $(this).attr("data-id");
                var url = '<?php echo Yii::app()->request->baseUrl . '/order_online/delete/'; ?>' + data_id;
                $.post(url, {}, function (resp) {
                    $(".message").show().html("Successfully deleted record..");
                    load_order_list();
                });
            } else
                return false;



        });


    });
</script>