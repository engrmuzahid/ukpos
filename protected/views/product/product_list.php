<script>
    $(function () {
        $("#print_button2").click(function () {
            $("#ptable3").jqprint();
        });
    });

    $(document).ready(function ()
    {
        init_table_sorting();
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
    });

    function init_table_sorting()
    {
        //Only init if there is more than one row
        if ($('.tablesorter tbody tr').length > 1)
        {
            $("#sortable_table").tablesorter(
                    {
                        sortList: [[1, 0]],
                        headers:
                                {
                                    0: {sorter: false},
                                    3: {sorter: false}
                                }
                    });
        }
    }

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

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('_menu') ?>

            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">
                <div id="table_holder">
                    <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
                    <p>
                        <a href="#" onclick="return MyBulk()"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/bulk_delete.png" alt="Bulk Delete" title="Bulk Delete" align="absmiddle"></a>
                        <a href="#" onclick="return MyBulkBarcode()"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/bulk_barcode.png" height="56" alt="Bulk Barcode" title="Bulk Barcode" align="absmiddle"></a>
                    </p>
                    <div id="ptable3">
                        <?php echo CHtml::beginForm('', 'post', array('name' => 'frm_soft', 'enctype' => 'multipart/form-data')); ?>
                        <table class="tablesorter" id="sortable_table" style="width:100%">
                            <?php if (count($model)): ?>
                                <thead>
                                    <tr>
                                        <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>

                                        <th width="30%">Item Code</th>
                                        <th width="23%">Item Name</th>
                                        <th width="15%">Sell Price</th>
                                        <th width="15%">Sell Price + Vat</th>
                                        <th>Offer</th>
                                        <th class="rightmost header">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($model as $model):
                                        $product_type_id = $model->product_type_id;
                                        $unit_type_id = $model->unit_type_id;
                                        $product_brand_id = $model->product_brand_id;

                                        $q2 = new CDbCriteria(array('condition' => "id = '$product_type_id'",));
                                        $q3 = new CDbCriteria(array('condition' => "id = '$unit_type_id'",));
                                        $q4 = new CDbCriteria(array('condition' => "id = '$product_brand_id'",));
                                        
                                        $Type_names = Product_Type::model()->findAll($q2);
                                        $Unit_names = Unit::model()->findAll($q3);
                                        $Brand_names = Product_Brand::model()->findAll($q4);
                                        $sell_p = $model->sell_price;
                                        $vat_pp = $model->vat;

                                        $sell_price = $model->sell_price - $model->vat_on_purchase - $model->vat_on_profit;
                                        ?>
                                        <tr style="font:Verdana; font-size:11px">
                                            <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_' . $model->id; ?>" id="<?php echo 'checkbox_' . $model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                                            <td><?php echo $model->product_code; ?></td>
                                            <td><?php echo $model->product_name; ?></td>

                                            <td><?php echo '&pound; ' . number_format($sell_p, 2); ?></td>
                                            <td width="15%"><?php echo '&pound; ' . number_format($sell_price, 2); ?></td>
                                            <td width="15%"><?php echo $model->offerPrice > 0 ? '&pound; ' . number_format($model->offerPrice, 2) / $model->offer_quantity : "N/A"; ?></td>
                                            <td width="12%" style="margin-left:5px;">
                                                <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/wholesaleedit/' . $model->id; ?>" title="Wholesale"><img style="width: 32px;height: 32px;" src="<?php echo Yii::app()->request->baseUrl . '/public/images/sales.png'; ?>" alt="Edit" title="Wholesale" border="0" /></a> | 
                                                <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/edit/' . $model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a> | 
                                                <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/delete/' . $model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> |
                                                <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/bcode/' . $model->id; ?>" title="Barcode"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/barcode.png'; ?>" alt="Barcode" width="16" title="Barcode" border="0" /></a>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
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
