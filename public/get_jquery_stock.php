<?php

include 'db.php';

$product_category = $_GET['product_category_id'];
//$product_type = @$_GET['product_type_id'];
//$product_brand = @$_GET['product_brand_id'];
//$product_brand2 = @$_GET['product_brand_id2'];
//
//$stockin_product_category = $_GET['stockin_product_category'];
//$stockin_product_type = $_GET['stockin_product_type'];
//$stock_product_category = $_GET['stock_product_category'];
//$stock_product_type = $_GET['stock_product_type'];
//$stockout_product_category = $_GET['stockout_product_category'];
//$stockout_product_type = $_GET['stockout_product_type'];
//
//$stockparty_product_category = $_GET['stockparty_product_category'];
//$stockparty_product_type = $_GET['stockparty_product_type'];

if (!empty($product_category)) {
    $ad_sc = mysql_query("select * from product WHERE product_category_id = '$product_category' ORDER BY product_name ASC");
    $data = '<option value="">-- Select --</option>';
    while ($row_sc = mysql_fetch_array($ad_sc)) {
        $product_id = $row_sc['id'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_id . '">' . $product_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="product_id" id="product_id" style="border:1px solid #CCC; width:120px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="product_id" id="product_id" style="border:1px solid #CCC; width:120px; height:25px;">
		  <option value="">-- No Product Found --</option>
		</select>';
    endif;
}

elseif (!empty($product_type) && !empty($product_brand)) {
    $ad_sc = mysql_query("select * from product WHERE product_brand_id = '$product_brand' && product_type_id = '$product_type' ORDER BY product_name ASC");
    $data = '<option value="">-- Select --</option>';
    while ($row_sc = mysql_fetch_array($ad_sc)) {
        $product_code = $row_sc['product_code'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_code . '">' . $product_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="product_code" id="product_code" style="border:1px solid #CCC; width:120px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="product_code" id="product_code" style="border:1px solid #CCC; width:120px; height:25px;">
		  <option value="">-- No Product Found --</option>
		</select>';
    endif;
}
elseif (!empty($product_brand2)) {
    $ad_sc = mysql_query("select * from product WHERE product_brand_id = '$product_brand2' ORDER BY product_name ASC");
    $data = '<option value="">-- Select --</option>';
    while ($row_sc = mysql_fetch_array($ad_sc)) {
        $product_id = $row_sc['id'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_id . '">' . $product_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="product_id" id="product_id" style="border:1px solid #CCC; width:120px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="product_id" id="product_id" style="border:1px solid #CCC; width:120px; height:25px;">
		  <option value="">-- No Product Found --</option>
		</select>';
    endif;
}

elseif (!empty($stockin_product_category)) {
    $ad_sc = mysql_query("select * from product_type WHERE product_category_id = '$stockin_product_category' ORDER BY type_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = @mysql_fetch_array($ad_sc)) {
        $id = $row_sc['id'];
        $type_name = $row_sc['type_name'];
        $data = $data . '<option value="' . $id . '">' . $type_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="Stock_In[product_type]" id="Stock_In_product_type" onchange="getProductName()" style="border:1px solid #CCC; width:150px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="Stock_In[product_type]" id="Stock_In_product_type" style="border:1px solid #CCC; width:150px; height:25px;">
		  <option value="">--- No Subcategory Found ---</option>
		</select>';
    endif;
}


elseif (!empty($stockin_product_type)) {
    $ad_sc = mysql_query("select * from product WHERE product_type_id = '$stockin_product_type' ORDER BY product_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = mysql_fetch_array($ad_sc)) {
        $product_id = $row_sc['product_id'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_id . '">' . $product_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="Stock_In[product_id]" id="Stock_In_product_id" style="border:1px solid #CCC; width:150px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="Stock_In[product_id]" id="Stock_In_product_id" style="border:1px solid #CCC; width:150px; height:25px;">
		  <option value="">----- No Product Found -----</option>
		</select>';
    endif;
}

elseif (!empty($stock_product_category)) {
    $ad_sc = mysql_query("select * from product_type WHERE product_category_id = '$stock_product_category' ORDER BY type_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = @mysql_fetch_array($ad_sc)) {
        $id = $row_sc['id'];
        $type_name = $row_sc['type_name'];
        $data = $data . '<option value="' . $id . '">' . $type_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="Stock[product_type]" id="Stock_product_type" onchange="getProductName()" style="border:1px solid #CCC; width:150px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="Stock[product_type]" id="Stock_product_type" style="border:1px solid #CCC; width:150px; height:25px;">
		  <option value="">--- No Subcategory Found ---</option>
		</select>';
    endif;
}


elseif (!empty($stock_product_type)) {
    $ad_sc = mysql_query("select * from product WHERE product_type_id = '$stock_product_type' ORDER BY product_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = mysql_fetch_array($ad_sc)) {
        $product_id = $row_sc['product_id'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_id . '">' . $product_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="Stock[product_id]" id="Stock_product_id" style="border:1px solid #CCC; width:150px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="Stock[product_id]" id="Stock_product_id" style="border:1px solid #CCC; width:150px; height:25px;">
		  <option value="">----- No Product Found -----</option>
		</select>';
    endif;
}

elseif (!empty($stockout_product_category)) {
    $ad_sc = mysql_query("select * from product_type WHERE product_category_id = '$stockout_product_category' ORDER BY type_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = @mysql_fetch_array($ad_sc)) {
        $id = $row_sc['id'];
        $type_name = $row_sc['type_name'];
        $data = $data . '<option value="' . $id . '">' . $type_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="Stock_Out[product_type]" id="Stock_Out_product_type" onchange="getProductName()" style="border:1px solid #CCC; width:150px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="Stock_Out[product_type]" id="Stock_Out_product_type" style="border:1px solid #CCC; width:150px; height:25px;">
		  <option value="">--- No Subcategory Found ---</option>
		</select>';
    endif;
}


elseif (!empty($stockout_product_type)) {
    $ad_sc = mysql_query("select * from product WHERE product_type_id = '$stockout_product_type' ORDER BY product_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = mysql_fetch_array($ad_sc)) {
        $product_id = $row_sc['product_id'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_id . '">' . $product_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="Stock_Out[product_id]" id="Stock_Out_product_id" style="border:1px solid #CCC; width:150px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="Stock_Out[product_id]" id="Stock_Out_product_id" style="border:1px solid #CCC; width:150px; height:25px;">
		  <option value="">----- No Product Found -----</option>
		</select>';
    endif;
}

elseif (!empty($stockparty_product_category)) {
    $ad_sc = mysql_query("select * from product_type WHERE product_category_id = '$stockparty_product_category' ORDER BY type_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = @mysql_fetch_array($ad_sc)) {
        $id = $row_sc['id'];
        $type_name = $row_sc['type_name'];
        $data = $data . '<option value="' . $id . '">' . $type_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="Party_Stock[product_type]" id="Party_Stock_product_type" onchange="getProductName()" style="border:1px solid #CCC; width:110px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="Party_Stock[product_type]" id="Party_Stock_product_type" style="border:1px solid #CCC; width:110px; height:25px;">
		  <option value="">--- No Subcategory Found ---</option>
		</select>';
    endif;
}


elseif (!empty($stockparty_product_type)) {
    $ad_sc = mysql_query("select * from product WHERE product_type_id = '$stockparty_product_type' ORDER BY product_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = mysql_fetch_array($ad_sc)) {
        $product_id = $row_sc['product_id'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_id . '">' . $product_name . '</option>';
    }
    if (mysql_num_rows($ad_sc) > 0):
        echo '
		<select name="Party_Stock[product_id]" id="Party_Stock_product_id" style="border:1px solid #CCC; width:110px; height:25px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="Party_Stock[product_id]" id="Party_Stock_product_id" style="border:1px solid #CCC; width:110px; height:25px;">
		  <option value="">----- No Product Found -----</option>
		</select>';
    endif;
}

else {
    echo "";
}
?>