<?php
$base_url = "";
foreach ($result as $row_sc) {
    $product_name = $row_sc['product_name'];
    $product_code = $row_sc['product_code'];
    $sell_price = $row_sc['amount']; 
         ?>
        <div class="product_item product_list_view "  data-customer="<?php echo $customer_id ?>"   data-name="<?php echo $product_name ?>" data-price="<?php echo $row_sc['amount'] ?>" data-id="<?php echo $product_code ?>" id="tooltiptext_<?php echo $product_code ?>">
            <span style="float:left;" class="___producthistorydiv"><?php echo $product_name; ?> 
                <span class="producthistorylistdiv" id="product_tooltiptext_<?php echo $product_code; ?>"></span>
            </span>

            <span  style="text-align:right;float:right;padding-right: 35px;"><?php echo  '&pound;'.number_format($sell_price, 2); ?></span>
        </div>

        <?php 
}
?>