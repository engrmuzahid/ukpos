<script language="javascript">

    function getTotal()
    {
        p_price = document.getElementById('Product_purchase_cost').value;
        other_cost = document.getElementById('Product_other_cost').value;
        amount_total = p_price * 1 + other_cost * 1;
        document.getElementById("Product_sell_price").value = amount_total;
    }
</script>

<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')) ?>
<?php //print_r($model); exit();?>
<table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
    <tr height="10"><td colspan="3">&nbsp;</td></tr>
    <?php
    // retrieve the models from db
    $models_cat = Product_Category::model()->findAll(array('order' => 'category_name'));

    $models_type = Product_Type::model()->findAll(array('order' => 'type_name'));
    $type_list = CHtml::listData($models_type, 'id', 'type_name');
    $models_brand = Product_Brand::model()->findAll(array('order' => 'brand_name'));
    $brand_list = CHtml::listData($models_brand, 'id', 'brand_name');
    $models_unit = Unit::model()->findAll(array('order' => 'unit_type'));
    $unit_list = CHtml::listData($models_unit, 'id', 'unit_type');

    $catval = new CDbCriteria(array('condition' => "id = '$model->product_type_id'",));
    $CatIds = Product_Type::model()->findAll($catval);

    $online_categories = Online_category::model()->findAll(array('order' => 'category_name'));
    $product_category_id = "";
    if (count($CatIds)):
        foreach ($CatIds as $CatId):
            $product_category_id = $CatId->product_category_id;
        endforeach;
    endif;
    ?>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'item_category') ?>&nbsp;&nbsp;</th>
        <td> <?php echo $fullCategoryName; ?>

        <td>
            <div class="markcolor"><?php //echo CHtml::error($model,'product_category_id');         ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>  
    <tr>
        <th valign="top">&nbsp;&nbsp;</th>
        <td>
            <select  class="product_category"  style="border:1px solid #CCC; width:200px; height:25px;" >
                <option value="0">Change Category</option>    
                <?php foreach ($models_cat as $category_list): ?>
                    <?php if ($category_list['parent_id'] == 0): ?>
                        <option value="<?php echo $category_list['id']; ?>" data-value="<?php echo $category_list['parent_id']; ?>"> <?php echo $category_list['category_name']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        <td>
            <div class="markcolor"></div>
        </td>
    </tr>

    <tr>
        <th valign="top">&nbsp;</th>
        <td><div id ="product_sub_category">

            </div></td>
        <td>
            &nbsp;
        </td>
    </tr> 
    <tr><td colspan="3">&nbsp;</td></tr>  
    <input type="hidden"  id="product_category_id" name="product_category_id" value="<?php echo $model['product_category_id']; ?>">
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'item_type') ?>&nbsp;&nbsp;</th>
        <td><div id = "product_type"><?php echo CHtml::activedropDownList($model, 'product_type_id', $type_list, array('empty' => '----- Select Type -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'product_type_id'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'brand_name') ?>&nbsp;&nbsp;</th>
        <td><div id = "product_brand"><?php echo CHtml::activedropDownList($model, 'product_brand_id', $brand_list, array('empty' => '----- Select Brand -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></div></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'product_brand_id'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>

    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'online_category_id') ?>&nbsp;&nbsp;</th>
        <td>
            <div>
                <select name="Product[online_category_id]" style="width:200px;height:25px;border:1px solid #CCC;">
                    <?php foreach ($online_categories as $online_category): ?>
                        <option value="<?php echo $online_category['id']; ?>" <?php echo $model['online_category_id'] == $online_category['id'] ? "selected" : ""; ?>><?php echo $online_category['category_name']; ?></option>
                    <?php endforeach; ?>
                </select>  
            </div>
        </td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'online_category_id'); ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'item_code') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'product_code', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'product_code'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'item_name') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'product_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'product_name'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'unit_type') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activedropDownList($model, 'unit_type_id', $unit_list, array('empty' => '----- Select Unit -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'unit_type_id'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'description') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextArea($model, 'description', array('style' => 'width:200px;height:100px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'description'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'location') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'location', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'location'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'purchase_cost') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'purchase_cost', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'purchase_cost'); ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'vat') ?>&nbsp;&nbsp;(%)</th>
        <td><?php echo CHtml::activeTextField($model, 'vat', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'vat'); ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top">Vat on Purchase</th>
        <td><?php echo CHtml::activeTextField($model, 'vat_on_purchase', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'vat_on_purchase'); ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'other_cost') ?>&nbsp;&nbsp;(%)</th>
        <td><?php echo CHtml::activeTextField($model, 'other_cost', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'other_cost'); ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top">Vat on Profit</th>
        <td><?php echo CHtml::activeTextField($model, 'vat_on_profit', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'vat_on_profit'); ?></div>
        </td>
    </tr> 

    <tr><td colspan="3">&nbsp;</td></tr>

    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'sell_price') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'sell_price', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'sell_price'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'wholesale_price') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'wholesale_price', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'wholesale_price'); ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'offer_price') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'offer_price', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'purchase_cost'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'expire_date') ?>&nbsp;&nbsp;</th>
        <td>
            <?php echo CHtml::activeTextField($model, 'expire_date', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?>
                <!-- <input type="text" id="Product_expire_date" name="Product[expire_date]" value="<?php echo $model->expire_date != '0000-00-00' ? $model->expire_date : '' ?>" style="width:200px;height:25px;border:1px solid #CCC;" /> -->
        </td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'expire_date'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'min_stock_quantity') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'min_stock', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'min_stock'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'image') ?>&nbsp;&nbsp;</th>
        <td>
            <img src="<?php echo Yii::app()->baseUrl . '/images/products/' . $model->image ?>" /> <br/>
            <?php echo CHtml::activeFileField($model, 'image'); ?>
        </td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'image'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>

    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'photo_caption') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'photo_caption', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'photo_caption'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top">Is Boucher  </th>
        <td>
            <div>
                <select name="Product[is_boucher]" id="is_boucher" style="width:200px;height:25px;border:1px solid #CCC;">
                    <option <?php echo $model->is_boucher == '1' ? "selected" : ""; ?> value="1">Yes</option>                   
                    <option <?php echo $model->is_boucher == '0' ? "selected" : ""; ?>  value="0">No</option>                   

                </select>  
            </div>
        </td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'online_category_id'); ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <div  id="boucher_div" style="display: none;">
        
        <tr>
            <th valign="top">Boucher  </th>
            <td>
                <div>
                    <select name="screen_id" style="width:200px;height:25px;border:1px solid #CCC;">
                        <?php foreach ($screens as $screen): ?>
                            <option value="<?php echo $screen['id']; ?>" <?php echo $screen['id'] == $screen_id ? "selected" : ""; ?> ><?php echo $screen['name']; ?></option>
                        <?php endforeach; ?>
                    </select>  
                </div>
            </td>
            <td>
                <div class="markcolor"><?php echo CHtml::error($model, 'online_category_id'); ?></div>
            </td>
        </tr>


        <tr><td colspan="3">&nbsp;</td></tr>
        
         <tr>
        <th valign="top">Color  </th>
        <td>
            <div>
                <select name="color" id="is_boucher" style="width:200px;height:25px;border:1px solid #CCC;">
                    <option value="#337ab7">Primary</option>                   
                     <option value="#449d44">Success</option>                   
                     <option value="#31b0d5">Info</option>                   
                     <option value="#ec971f">Warning</option>                   
                     <option value="#c9302c">Danger</option>                   
                     <option value="#EDEDED">Gray</option>                                    

                </select>  
            </div>
        </td>
        <td>
           &nbsp;
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
      <tr>
        <th valign="top">Sort order  </th>
        <td>
            <div>
                <input type="text" name="sort_order" id="is_boucher" value="0" style="width:200px;height:25px;border:1px solid #CCC;"/>
                   
            </div>
        </td>
        <td>
           &nbsp;
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    </div>
    <tr>
        <th>&nbsp;</th>
        <td valign="top">
            <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen')); ?>
        </td>
        <td></td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
</table>
<?php
echo CHtml::endForm()?>