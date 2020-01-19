<?php

include 'db.php';

$product_category_id = $_GET['product_category_id'];

if (!empty($product_category_id)) {
    // $cat_details = mysql_query("select * from product_category WHERE id = '$product_category_id'");
    $ad_sc = mysql_query("select * from product_category WHERE parent_id = '$product_category_id' ORDER BY category_name ASC");
    $data = '<option value="">----- Select Subcategory-----</option>';
//    $parent_id = 0;
//    while ($row_cat = @mysql_fetch_array($cat_details)) {
//        $parent_id = $row_cat['parent_id'];
//    }
    while ($row_sc = @mysql_fetch_array($ad_sc)) {
        $id = $row_sc['id'];
        $type_name = $row_sc['category_name'];
        $data = $data . '<option value="' . $id . '">' . $type_name . '</option>';
    }
    // if ($parent_id > 0) {
    if (mysql_num_rows($ad_sc) > 0) {
        echo '<br/><select  class="product_category"  style="border:1px solid #CCC; width:200px; height:25px;">
		  ' . $data . '
		</select><br/> ';
    } else {
        echo 'Selected';
    }
    //  }
} else {
    echo '<p style="color:RED;">Please Select a category</p>';
}
?>