<?php
include 'db.php';

$product_code = $_REQUEST['product_code'];
$product_sl = $_REQUEST['product_sl'];

$results = mysql_query("select * FROM product_temp WHERE product_code = '$product_code'");
$result_product = mysql_query("select * FROM product WHERE product_code = '$product_code'");
if (mysql_num_rows($result_product) > 0) {
    die();
}
if (mysql_num_rows($results) > 0) {
        $product = mysql_fetch_assoc($results);
}

$result_category = mysql_query("SELECT id,category_name FROM product_category");
$result_brand = mysql_query("SELECT id,brand_name FROM product_brand");
$result_unit_type = mysql_query("SELECT id,unit_type FROM unit_type");
?>

<tr>
    <td>
        <select style="width:90%;height:25px;border:1px solid #CCC;" class="product_category" data-pcode="<?php echo $product_code ?>" name="Product[<?= $product_sl ?>][product_category_id]" >
            <option value="">-----</option>
            <?php while ($category = mysql_fetch_assoc($result_category)) : ?>
                <option value="<?= $category['id'] ?>" ><?= $category['category_name'] ?></option>
            <?php endwhile; ?>
        </select>
    </td>

    <td>
        <select style="width:90%;height:25px;border:1px solid #CCC;" id="product_subcategory_<?php echo $product_code ?>" name="Product[<?= $product_sl ?>][product_type_id]" >
            <option value="">-----</option>                    
        </select>
    </td>
    <td>
        <div id = "product_brand">
            <select style="width:90%;height:25px;border:1px solid #CCC;" name="Product[<?= $product_sl ?>][product_brand_id]" id="Product_product_brand_id">
                <option value="">-----</option>
                <?php while ($brand = mysql_fetch_assoc($result_brand)) : ?>
                    <option value="<?= $brand['id'] ?>" <?php echo isset($product) ? ($product['product_brand_id'] == $brand['id'] ? 'selected' : '') : '' ?>><?= $brand['brand_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
    </td>
    <td><input value="<?php echo $product_code ?>" readonly="readonly" style="width:90%;height:25px;border:1px solid #CCC;" name="Product[<?= $product_sl ?>][product_code]"  type="text" /></td>

    <td><input  style="width:90%;height:25px;border:1px solid #CCC;" name="Product[<?= $product_sl ?>][product_name]" value="<?php echo isset($product) ? $product['product_name'] : '' ?>" type="text" /></td>
    <td>
        <select style="width:90%;height:25px;border:1px solid #CCC;" name="Product[<?= $product_sl ?>][unit_type_id]" >
            <option value="">----- Select Unit -----</option>
            <?php while ($unit_type = mysql_fetch_assoc($result_unit_type)) : ?>
                <option value="<?= $unit_type['id'] ?>" <?php echo isset($product) ? ($product['unit_type_id'] == $unit_type['id'] ? 'selected' : '') : '' ?>><?= $unit_type['unit_type'] ?></option>
            <?php endwhile; ?>
        </select>
    </td>

    <td><input style="width:90%;height:25px;border:1px solid #CCC;" name="Product[<?= $product_sl ?>][purchase_cost]" value="<?php echo isset($product) ? $product['purchase_cost'] : '' ?>" type="text" /></td>


    <td><input style="width:90%;height:25px;border:1px solid #CCC;" name="Product[<?= $product_sl ?>][sell_price]" value="<?php echo isset($product) ? $product['sell_price'] : '' ?>" type="text" /></td>

    <td><input id="Product_expire_date_<?= $product_code ?>" style="width:90%;height:25px;border:1px solid #CCC;" name="Product[<?= $product_sl ?>][expire_date]" value="<?php echo isset($product) ? $product['expire_date'] : '' ?>" type="text" maxlength="255" /></td>
    
    <td><input style="width:90%;height:25px;border:1px solid #CCC;" name="Product[<?= $product_sl ?>][min_stock]" value="<?php echo isset($product) ? $product['min_stock'] : '' ?>" type="text" /></td>
</tr>