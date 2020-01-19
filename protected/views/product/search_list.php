<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/'; ?>public/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
    $(function () {
        $("#print_button2").click(function () {
            $("#ptable3").jqprint();
        });
    });

    function MyBulk()
    {
        var agree = confirm("Are you sure to delete this record?");
        if (agree) {
            var oForm = document.frm_soft;
            oForm.action = "<?php echo Yii::app()->request->baseUrl . '/product/index'; ?>";
            oForm.post = "post";
            oForm.submit();
        } else
        {
            return false;
        }
    }

    function MyBulkBarcode()
    {
        var oForm = document.frm_soft;
        oForm.action = "<?php echo Yii::app()->request->baseUrl . '/product/bulkbarcode'; ?>";
        oForm.post = "post";
        oForm.submit();
    }
</script>
<script language="javascript">
    $().ready(function () {
        init_table_sorting();
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();


        $("#product_name").autocomplete('<?php echo Yii::app()->request->baseUrl . '/public/product_list.php'; ?>', {//we have set data with source here
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

    function init_table_sorting()
    {
        //Only init if there is more than one row
//        if ($('.tablesorter tbody tr').length > 1)
//        {
//            $("#sortable_table").tablesorter(
//                    {
//                        sortList: [[1, 0]],
//                        headers:
//                                {
//                                    0: {sorter: false},
//                                    3: {sorter: false}
//                                }
//                    });
//        }
    }
</script>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title"><?php echo CHtml::link('Item', array('add')) ?></td>
            <td>
                <a href="#" onclick="return MyBulk()"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/bulk_delete.png" alt="Bulk Delete" title="Bulk Delete" align="absmiddle"></a>
                <a href="#" onclick="return MyBulkBarcode()"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/bulk_barcode.png" height="56" alt="Bulk Barcode" title="Bulk Barcode" align="absmiddle"></a>
            </td>
            <td id="title_search"> 
                   <?php echo CHtml::beginForm(Yii::app()->request->baseUrl . '/product/search', 'post') ?>	
                <?php echo CHtml::textField('product_name', '', array('style' => 'width:200px; height:15px;border:1px solid #CCC;')) ?>
                <?php echo CHtml::endForm() ?>
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
                <div id="table_holder">
                    <?php echo CHtml::beginForm('', 'post', array('name' => 'frm_soft', 'enctype' => 'multipart/form-data')); ?>
                    <table class="tablesorter" id="sortable_table" style="width:100%">
                        <?php if (count($models)): ?>
                            <thead>
                                <tr>
                                    <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                                    <th>Item Code</th>
                                    <th>Item Name</th> 
                                    <th>Sell Price</th>
                                    <th>Offer </th>
                                    <th class="rightmost header">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($models as $model):
                                    $product_type_id = $model->product_type_id;
                                    $unit_type_id = $model->unit_type_id;
                                    $product_brand_id = $model->product_brand_id;
                                    $q2 = new CDbCriteria(array('condition' => "id = '$product_type_id'",));
                                    $q3 = new CDbCriteria(array('condition' => "id = '$unit_type_id'",));
                                    $q4 = new CDbCriteria(array('condition' => "id = '$product_brand_id'",));

                                    $Type_names = Product_Type::model()->findAll($q2);
                                    $Unit_names = Unit::model()->findAll($q3);
                                    $Brand_names = Product_Brand::model()->findAll($q4);
                                    $purchase = Yii::app()->db->createCommand()->select('purchase_date')
                                                    ->from('purchase_product pp')
                                                    ->where("product_code='{$model->product_code}'")
                                                    ->limit(1)->order("purchase_date DESC")->queryRow();

                                    $sell_p = $model->sell_price;

                                    $sell_price = $model->sell_price - $model->vat_on_purchase - $model->vat_on_profit;
                                    ?>
                                    <tr style="font:Verdana; font-size:11px">
                                        <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_' . $model->id; ?>" id="<?php echo 'checkbox_' . $model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                                  
                                        <td width="10%"><?php echo $model->product_code; ?></td>
                                        <td width="25%"><?php echo CHtml::link(CHtml::encode($model->product_name), array('edit', 'id' => $model->id)); ?></td>
                                        <td width="15%"><?php echo '&pound; ' . number_format($sell_price, 2); ?></td>
                                        <td width="15%"><?php echo $model->offerPrice > 0 ? '&pound; ' . number_format($model->offerPrice, 2) . ' / ' . $model->offer_quantity : "N/A"; ?></td>
                                        <td width="17%" style="margin-left:5px;">
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/wholesaleedit/' . $model->id; ?>" title="Wholesale"><img style="width: 16px;height: 16px;" src="<?php echo Yii::app()->request->baseUrl . '/public/images/sales.png'; ?>" alt="Edit" title="Wholesale" border="0" /></a> | 
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/edit/' . $model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a> | 
                                            <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/delete/' . $model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> |
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/bcode/' . $model->id; ?>" title="Barcode"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/barcode.png'; ?>" alt="Barcode" width="16" title="Barcode" border="0" /></a>
                                        </td>
                                    </tr>
                        <?php endforeach;
                    endif;
                    ?>
                        </tbody>
                    </table>
<?php echo CHtml::endForm() ?>
                </div>
            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
<script language="javascript">
    function confirmSubmit() {
        var agree = confirm("Are you sure to delete this record?");
        if (agree)
            return true;
        else
            return false;
    }
</script>
