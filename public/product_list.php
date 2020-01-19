<?php
include 'db.php';

$q = strtolower($_GET["q"]);
if (!$q) return;

$customer_id = @$_GET['customer_id'];
$product_codes = array();
/*if($customer_id) {
    $sql = "SELECT sop.product_code, sop.amount, product.product_name FROM (
                    SELECT a.* FROM sell_order_product a, sell_order b WHERE a.invoice_no = b.invoice_no AND b.customer_id={$customer_id} ORDER BY a.id DESC) AS sop
                    JOIN product ON product.product_code = sop.product_code
                    WHERE product.product_name LIKE '%$q%'
                    GROUP BY sop.product_code ORDER BY product.product_name LIMIT 50";
                    

    $result = mysql_query($sql);

    while($row_sc = mysql_fetch_array($result)){
            $product_name = $row_sc['product_name'];
            $product_code = $row_sc['product_code'];
            $product_codes[] = "'".$product_code."'";
            if (strpos(strtolower($product_name), $q) !== false) {
                    echo "$product_code:<span class='customer-product'>$product_name</span>\n";
            }
    }

    
    
}*/
//$product_codes = !empty($product_codes) ? "AND product_code NOT IN (".implode(",", $product_codes).")" : "";
//echo "select product_code, product_name FROM product WHERE product_name LIKE '%$q%' $product_codes ORDER BY product_name";
$ad_sc = mysql_query("select product_code, product_name FROM product WHERE product_name LIKE '%$q%' ORDER BY product_name limit 5");
	
	while($row_sc = mysql_fetch_array($ad_sc)){
		$product_name = $row_sc['product_name'];
		$product_code = $row_sc['product_code'];
		if (strpos(strtolower($product_name), $q) !== false) {
                    echo "$product_code:$product_name\n";
		}
	}

?>
