<?php

include 'db.php';

$q = strtolower($_POST["product"]);
if (!$q)
    return;

$customer_id = @$_GET['customer_id'];
$product_codes = array();
if ($customer_id) {
    $sql = "SELECT sop.product_code, sop.amount, product.product_name, product.image FROM (
                    SELECT a.* FROM sell_order_product a, sell_order b WHERE a.invoice_no = b.invoice_no AND b.customer_id={$customer_id} ORDER BY a.id DESC) AS sop
                    INNER JOIN product ON product.product_code = sop.product_code
                    WHERE product.product_name LIKE '%$q%'
                    GROUP BY sop.product_code ORDER BY product.product_name LIMIT 5";


    $result = mysql_query($sql);
    $base_url = "";
    while ($row_sc = mysql_fetch_array($result)) {
        $product_name = $row_sc['product_name'];
        $product_code = $row_sc['product_code'];
        $sell_price = $row_sc['amount'];
        $product_codes[] = "'" . $product_code . "'";
        if (strpos(strtolower($product_name), $q) !== false) {
            echo   '<div class="product_item product_list_view"  data-customer="'.$customer_id.'"   data-name="'.$product_name.'" data-price="'.$row_sc['amount'].'" data-id="'.$product_code.'" id="tooltiptext_'.$product_code. '"><span style="float:left;width:85%">'.$product_name.'</span><span style="text-align:right;">&pound;'.number_format($sell_price,2).'</span></div>';
        }
    }
}
?>
