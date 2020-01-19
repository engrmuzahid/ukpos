<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Product Sync To Server </td>

            <td id="title_search">

            </td>
        </tr>
    </tbody>
</table> 
<table id="contents">
    <tbody><tr>
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


                <div id="higher_product" style="text-align: center;">
                    <button class="buttonBlue" id="productSync" style="width: 150px;padding: 10px;height: 40px;margin: 30px auto;"> SYNC </button>
                    Click here to sync product to server
                </div>


            </td>
        </tr>
    </tbody>
</table> 

<script language="javascript">
    function loadProduct() {
        $('#higher_product').html('<p style=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loader.gif" alt="" style="height:120px;margin-bottom: -52px;"/> Updating now! Please wait ...</p>');
        var url = "<?php echo Yii::app()->request->baseUrl; ?>/public/sync_product_jquery.php";
        $.post(url, {}, function (resp) {
            $('#higher_product').html(resp);
        });
    }
    $(document).ready(function () {

        $("#productSync").click(function (e) {
            loadProduct();
        });

    });

</script>
