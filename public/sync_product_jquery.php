<?php

include 'db.php';

$results = mysql_query("select * FROM product limit 2000");
$url = 'http://sylhetshop.co.uk/api/sync_product';
$data = array();


if (mysql_num_rows($results) > 0):
    while ($row_sc = mysql_fetch_array($results)):
        $insert_data = array(
            "product_code" => $row_sc['product_code'],
            "product_name" => $row_sc['product_name'],
            "description" => $row_sc['description'],
            "vat" => $row_sc['vat'],
            "sell_price" => $row_sc['sell_price'],
            "offer_price" => $row_sc['offer_price'],
            "vat_on_purchase" => $row_sc['vat_on_purchase'],
            "vat_on_profit" => $row_sc['vat_on_profit'],
            "offerPrice" => $row_sc['offerPrice']
        );
        $data[$row_sc['id']] = $insert_data;
    endwhile;
endif;

$ch = curl_init($url);
$data_string = urlencode(json_encode($data));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, array("product" => $data_string));
$result = curl_exec($ch);
curl_close($ch);
//$_result = json_decode($result);
//echo $_result['updated']." Products updated.";
//print_r($result);
?>  