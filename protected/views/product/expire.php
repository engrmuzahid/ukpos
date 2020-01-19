<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
    $(function(){
        $("#print_button2").click( function() {
            $("#ptable3").jqprint();
        });
    });
    
    $(document).ready(function()
    {
        init_table_sorting();
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
    });

    function init_table_sorting()
    {
        //Only init if there is more than one row
        if($('.tablesorter tbody tr').length >1)
        {
            $("#sortable_table").tablesorter(
            {
                sortList: [[1,0]],
                headers:
                    {
                    0: { sorter: false},
                    3: { sorter: false}
                }
            });
        }
    }

    function MyBulk()
    {
        var agree=confirm("Are you sure to delete this record?");
        if (agree){
            var oForm = document.frm_soft;
            oForm.action="<?php echo Yii::app()->request->baseUrl . '/product/index'; ?>";
            oForm.post="post";
            oForm.submit();
        }	
        else
        {
            return false;
        } 
    }

    function MyBulkBarcode()
    {
        var oForm = document.frm_soft;
        oForm.action="<?php echo Yii::app()->request->baseUrl . '/product/bulkbarcode'; ?>";
        oForm.post="post";
        oForm.submit();
    }
</script>
<script language="javascript">
    $().ready(function() {
	 
        $("#product_name").autocomplete('<?php echo Yii::app()->request->baseUrl . '/public/product_list.php'; ?>', {  //we have set data with source here
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
                $("#product_code").val('0');
            } else { // Set the value for the product id
                var info = formatted.split(":");
                $("#product_code").val(info[0]);                        
            }
        });
    });
</script>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title"><?php echo CHtml::link('Item', array('add')) ?></td>

        </tr>
    </tbody>
</table>
<?php echo CHtml::beginForm('', 'post', array('name' => 'frm_soft', 'enctype' => 'multipart/form-data')); ?>
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

                <div id="table_holder">

                    <table class="tablesorter" id="sortable_table"  style="width: 385px; float:left">
                        <?php if (count($product_expired)): ?>
                            <thead>
                                <tr>
                                    <th colspan="4">Items Already Expired</th>
                                </tr>
                                <tr>
                                    <!-- <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>                                    -->
                                    <th class="leftmost">Item Code</th>
                                    <th>Item Name</th>
                                    <th>Sell Price</th>
                                    <th class="rightmost header">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($product_expired as $model):
                                    $sell_p = $model->sell_price;
                                    $vat_pp = $model->vat;
                                    $vat = ($sell_p * $vat_pp) / 100;
                                    $sell_price = $sell_p + $vat;
                                    ?>
                                    <tr  style="font:Verdana; font-size:11px">
                                        <!-- <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_' . $model->id; ?>" id="<?php echo 'checkbox_' . $model->id; ?>" value="<?php echo $model->id; ?>"  /></td> -->
                                        
                                        
                                        <td width="20%"><?php echo $model->product_code; ?></td>
                                        <td width="55%"><?php echo CHtml::link(CHtml::encode($model->product_name), array('edit', 'id' => $model->id)); ?></td>
                                        <td width="15%"><?php echo '&pound; ' . number_format($sell_price, 2); ?></td>
                                        <td width="10%" >
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/edit/' . $model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a>
                                            <!-- <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/delete/' . $model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a>
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/bcode/' . $model->id; ?>" title="Barcode"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/barcode.png'; ?>" alt="Barcode" width="16" title="Barcode" border="0" /></a> -->
                                        </td>
                                    </tr>
    <?php endforeach;
endif; ?>
                        </tbody>
                    </table>
                    
                    <table class="tablesorter" id="sortable_table"  style="width: 385px; float:right">
                        <?php if (count($product_expiring)): ?>
                            <thead> 
                                <tr>
                                    <th colspan="4">Items Expiring within Next Month</th>
                                </tr>
                                <tr>
                                    <!-- <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>                                    -->
                                    <th class="leftmost">Item Code</th>
                                    <th>Item Name</th>
                                    <th>Sell Price</th>
                                    <th class="rightmost header">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($product_expiring as $model):
                                    $sell_p = $model->sell_price;
                                    $vat_pp = $model->vat;
                                    $vat = ($sell_p * $vat_pp) / 100;
                                    $sell_price = $sell_p + $vat;
                                    ?>
                                    <tr  style="font:Verdana; font-size:11px">
                                        <!-- <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_' . $model->id; ?>" id="<?php echo 'checkbox_' . $model->id; ?>" value="<?php echo $model->id; ?>"  /></td> -->
                                        
                                        
                                        <td width="20%"><?php echo $model->product_code; ?></td>
                                        <td width="55%"><?php echo CHtml::link(CHtml::encode($model->product_name), array('edit', 'id' => $model->id)); ?></td>
                                        <td width="15%"><?php echo '&pound; ' . number_format($sell_price, 2); ?></td>
                                        <td width="10%" >
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/edit/' . $model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a>
                                            <!-- <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/delete/' . $model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a>
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/bcode/' . $model->id; ?>" title="Barcode"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/barcode.png'; ?>" alt="Barcode" width="16" title="Barcode" border="0" /></a> -->
                                        </td>
                                    </tr>
    <?php endforeach;
endif; ?>
                        </tbody>
                    </table>
                    
                    <div style="clear:both"></div>
                </div>
                <div style="clear:both"></div>
                <div id="pagination"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></div>
            </td>
        </tr>
    </tbody></table>
<?php echo CHtml::endForm() ?>

<div id="feedback_bar"></div>
</div>
</div>
<script language="javascript">
    function confirmSubmit() {
        var agree=confirm("Are you sure to delete this record?");
        if (agree)
            return true;
        else
            return false;
    }
</script>
