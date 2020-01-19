<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')) ?>

<table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
    <tr height="10"><td colspan="3">&nbsp;</td></tr>

    <tr>
        <th valign="top"><br/> Parent Category: <?php echo CHtml::activeLabel($model, '') ?>&nbsp;&nbsp;</th>
        <td><br/>
            <select name="Product_Category[parent_id]"  id="product_cat" style="border: 1px solid #ccc;height: 25px;width: 200px;">
                <option value="0">Select Option </option>
                <?php foreach ($product_list as $value): ?>
                    <option <?php echo $model->parent_id == $value['id'] ? "selected" : "" ?> value="<?php echo $value['id']; ?>"><?php echo $value['category_name']; ?></option>
                <?php endforeach; ?>
            </select>  
        </td>
    </tr>
    <tr height="10"><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'category_name') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'category_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'category_name'); ?></div>
        </td>
    </tr>
    <tr height="10"><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'sort_order') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'sort_order', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'sort_order'); ?></div>
        </td>
    </tr>
    <tr>
        <th valign="top"><br/> Is Online: <?php echo CHtml::activeLabel($model, '') ?>&nbsp;&nbsp;</th>
        <td><br/>
            <select name="Product_Category[isOnline]"  id="isOnline" style="border: 1px solid #ccc;height: 25px;width: 200px;">
                <option value="">Select Option </option>
                <option value="1" <?php echo $model['isOnline'] == 1 ? 'selected' : ''; ?> >Yes</option>
                <option value="0" <?php echo $model['isOnline'] == 0 ? 'selected' : ''; ?> >No</option>
            </select>  
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'image') ?>&nbsp;&nbsp;</th>
        <td>
            <?php if ($model->image) : ?>
                <img src="<?php echo Yii::app()->baseUrl . '/images/categories/' . $model->image ?>" /> <br/>
            <?php endif; ?>
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
        <th valign="top"><label for="Product_Category_color_code">Colour Code</label>&nbsp;&nbsp;</th>
        <td><input style="width:200px;height:40px;border:1px solid #CCC;" name="Product_Category[color_code]" id="Product_Category_color_code" value="<?php echo $model['color_code']; ?>" type="color"></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'color_code'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th>&nbsp;</th>
        <td valign="top">
            <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen')); ?>
        </td>
        <td></td>
    </tr>
</table>
<?php echo CHtml::endForm() ?>

<!--<script>
     var url = '<?php // echo Yii::app()->request->baseUrl. '/index.php/product_category/edit';      ?>';
    $(document).ready(function(){
        $("#product_cat").change(function(){
            var sub_product = $("#product_cat").val();
             $.post(url, sub_product,function (resp) {});
            
//            $.post(base_url + 'Product_category/actionEdit', {}, function (resp) {
//            $("#popup-form").html(resp);
//            show_popup();
//        });
            alert(url);
        });
    });
    
</script>-->