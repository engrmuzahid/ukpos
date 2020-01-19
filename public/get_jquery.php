<?php

include 'db.php';

$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : 0;
$contact_no1 = isset($_GET['contact_no1']) ? $_GET['contact_no1'] : '';

$deptid = isset($_GET['deptid']) ? $_GET['deptid'] : '';
$pro_type = isset($_GET['pro_type']) ? $_GET['pro_type'] : '';
$uni_type = isset($_GET['uni_type']) ? $_GET['uni_type'] : '';
$currency_code = isset($_GET['currency_code']) ? $_GET['currency_code'] : '';
$total_amount = isset($_GET['total_amount']) ? $_GET['total_amount'] : '';
$pro_name = isset($_GET['pro_name']) ? $_GET['pro_name'] : '';

$p_type = isset($_GET['p_type']) ? $_GET['p_type'] : '';
$p_category = isset($_GET['p_category']) ? $_GET['p_category'] : '';
$product_cat_id = isset($_GET['product_cat_id']) ? $_GET['product_cat_id'] : '';
$product_type_id = isset($_GET['product_type_id']) ? $_GET['product_type_id'] : '';

if (!empty($deptid)) {
    $ad_sc = mysql_query("select * from employeeinfo WHERE dept = '$deptid'");
    $data = '';
    while ($row_sc = mysql_fetch_array($ad_sc)) {
        $id = $row_sc['id'];
        $name = $row_sc['name'];
        $data = $data . '<option value="' . $id . '">' . $name . '</option>';
    }
    if (!empty($data)):
        echo '
	<select name="emp_name" id="emp_name" style="border:1px solid #CCC; width:325px;">
	  ' . $data . '
	</select>';
    else:
        echo "No Employee";
    endif;
}

elseif (!empty($customer_id)) {
    $ad_sc = mysql_query("select * from customer WHERE 	id = '$customer_id' ");
    $row_sc = @mysql_fetch_array($ad_sc);
    $customer_name = $row_sc['customer_name'];
    $comment = $row_sc['comment'];
    $credit_limit = $row_sc['credit_limit'];
    $customer_id = $row_sc['id'];
    $cus_type = $row_sc['customer_type'];
    $ad_sc3 = mysql_query("select paid_amount, amount_grand_total from sell_order WHERE customer_id = '$customer_id'");

    $due_amount = 0;
    while ($row_sc3 = @mysql_fetch_array($ad_sc3)) {
        $paid_amount = $row_sc3['paid_amount'];
        $amount_grand_total = $row_sc3['amount_grand_total'];
        $due_sub = $amount_grand_total - $paid_amount;
        $due_amount = $due_amount + $due_sub;
    }
    echo '<font color="red">Due: ' . number_format($due_amount, 2) . '</font>' . '_@_' . $comment . '_@_' . $cus_type.'_@_' . number_format($due_amount, 2).'_@_'.$credit_limit.'_@_'.$customer_name;
} elseif (!empty($contact_no1)) {
    $ad_sc = mysql_query("select * from customer WHERE 	contact_no1 = '$contact_no1' ");
    $row_sc = @mysql_fetch_array($ad_sc);
    $customer_type = $row_sc['customer_type'];
    $customer_name = $row_sc['customer_name'];
    $customer_id = $row_sc['id'];

    $ad_sc2 = mysql_query("select * from customer_type WHERE id = '$customer_type'");
    $row_sc2 = @mysql_fetch_array($ad_sc2);
    $discount_ratio = $row_sc2['discount_ratio'];
    echo $discount_ratio . "-" . $customer_name . "-" . $customer_id;
} elseif (!empty($pro_type)) {
    $ad_sc = mysql_query("select * from product_type WHERE inventory_type = '$pro_type'");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = mysql_fetch_array($ad_sc)) {
        $product_type_id = $row_sc['product_type_id'];
        $type_name = $row_sc['type_name'];
        $data = $data . '<option value="' . $product_type_id . '">' . $type_name . '</option>';
    }
    if (!empty($data)):
        echo '
		<select name="p_type" id="p_type" style="border:1px solid #CCC; width:150px;" onchange="getProductName(this.value)">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="p_type" id="p_type" style="border:1px solid #CCC; width:150px;">
		  <option value="">----- Select -----</option>
		</select>';
    endif;
}

elseif (!empty($p_type) && !empty($p_category)) {
    $ad_sc = mysql_query("select * from product WHERE product_type_id = '$p_type' && product_category_id = '$p_category' ORDER BY product_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = @mysql_fetch_array($ad_sc)) {
        $product_id = $row_sc['product_id'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_id . '">' . $product_name . '</option>';
    }
    if (!empty($data)):
        echo '
		<select name="p_name" id="p_name" style="border:1px solid #CCC; width:150px; height:26px; " onchange="getUnitType(this.value)">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="p_name" id="p_name" style="border:1px solid #CCC; width:150px;">
		  <option value="">----- Select -----</option>
		</select>';
    endif;
}

elseif (!empty($pro_name)) {
    $ad_sc = mysql_query("select * from product WHERE product_type_id = '$pro_name' ORDER BY product_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = @mysql_fetch_array($ad_sc)) {
        $product_id = $row_sc['product_id'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_id . '">' . $product_name . '</option>';
    }
    if (!empty($data)):
        echo '
		<select name="p_name" id="p_name" style="border:1px solid #CCC; width:150px; height:30px; ">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="p_name" id="p_name" style="border:1px solid #CCC; width:150px;">
		  <option value="">----- Select -----</option>
		</select>';
    endif;
}
elseif (!empty($product_cat_id) && !empty($product_type_id)) {
    $ad_sc = mysql_query("select * from product WHERE product_category_id = '$product_cat_id' && product_type_id = '$product_type_id' ORDER BY product_name ASC");
    $data = '<option value="">----- Select -----</option>';
    while ($row_sc = @mysql_fetch_array($ad_sc)) {
        $product_id = $row_sc['product_id'];
        $product_name = $row_sc['product_name'];
        $data = $data . '<option value="' . $product_id . '">' . $product_name . '</option>';
    }
    if (!empty($data)):
        echo '
		<select name="product_id" id="product_id" style="border:1px solid #CCC; width:200px; height:30px;">
		  ' . $data . '
		</select>';
    else:
        echo '
		<select name="product_id" id="product_id" style="border:1px solid #CCC; width:200px; height:30px;">
		  <option value="">----- Select -----</option>
		</select>';
    endif;
}
elseif (!empty($uni_type)) {
    $ad_sc = mysql_query("select * from product WHERE product_id = '$uni_type'");
    $row_sc = mysql_fetch_array($ad_sc);
    $unit_type_id = $row_sc['unit_type_id'];
    $ad_sc2 = mysql_query("select * from unit_type WHERE unit_type_id = '$unit_type_id'");
    $data = '';
    $row_sc2 = mysql_fetch_array($ad_sc2);
    $unit_type_id = $row_sc2['unit_type_id'];
    $unit_type = $row_sc2['unit_type'];

    if (!empty($unit_type)):
        echo '<input type="text" name="unit2_type" readonly="readonly" id="unit2_type" style="border:1px solid #CCC; color:green; width:144px; height:24px; " value = "' . ucwords($unit_type) . '" ><input type="hidden" name="u_type" id="u_type" value = "' . $unit_type_id . '" >';
    else:
        echo '';
    endif;
}
elseif (!empty($currency_code) && !empty($total_amount)) {
    $ad_sc = mysql_query("select * from currency WHERE currency_code = '$currency_code'");
    $row_sc = mysql_fetch_array($ad_sc);
    $currency_code = $row_sc['currency_code'];
    $currency_name = $row_sc['currency_name'];
    $rate_per_dolar = $row_sc['rate_per_dolar'];
    $payable_amount = $total_amount * $rate_per_dolar;
    echo round($payable_amount);
    //echo '&nbsp;&nbsp;&nbsp;&nbsp;<font color="#92B22C" size="6">'.round($payable_amount).'  '.ucwords($currency_name).'</font><input type= "hidden" name="payable_amount" value="'.round($payable_amount).'" /><input type= "hidden" name="payable_amount_with_currency" value="'.$payable_amount.'  '.ucwords($currency_name).'" />';
} else {
    echo "";
}
?>