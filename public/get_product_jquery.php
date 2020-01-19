<?php
include 'db.php';
$date = date("Y-m-d", strtotime($_REQUEST['product_start_date']));
$edate = date("Y-m-d", strtotime($_REQUEST['product_end_date']));
$product_title = $_REQUEST['product_title']; //date("Y-m-d",strtotime($_REQUEST['reportDate']));
//print_r($_REQUEST);
// exit();
$sql = "select sum(sell_order_product.quantity) as countProduct,product.product_name,sell_order_product.product_code FROM sell_order_product
left join sell_order ON sell_order_product.invoice_no = sell_order.invoice_no
left join product ON product.product_code = sell_order_product.product_code
where sell_order.order_date >='$date' AND  sell_order.order_date <='$edate'
group by sell_order_product.product_code 
order by countProduct desc";
if ($product_title != null || $product_title != "") {
    $sql = "select sum(sell_order_product.quantity) as countProduct,product.product_name,sell_order_product.product_code FROM sell_order_product
left join sell_order ON sell_order_product.invoice_no = sell_order.invoice_no
left join product ON product.product_code = sell_order_product.product_code
where sell_order.order_date >='$date' AND  sell_order.order_date <='$edate'
 AND (sell_order_product.product_code like '%$product_title%' OR  product.product_name like '%$product_title%')
group by sell_order_product.product_code 
order by countProduct desc";
}

//echo $sql;
//exit();

$results = mysql_query($sql);
if (mysql_num_rows($results) > 0) {
    ?>
    <table style="width: 100%;float: left;">
        <thead>
        <caption>Top items sold  </caption>
        <tr>

            <th width="35%"> Code</th>
            <th width="50%"> Name</th>
            <th width="15%">Quantity</th> 

        </tr>
    </thead>
    <tbody>





        <?php while ($row_sc = mysql_fetch_array($results)) { ?>
            <tr>
                <td width="35%"> <?php echo $row_sc['product_code']; ?></td>
                <td width="50%"> <?php echo $row_sc['product_name']; ?></td>
                <td width="15%"><?php echo number_format($row_sc['countProduct'], 2); ?></td> 
            </tr>
            <?php
        }
    } else {
        ?><p style="text-align: center;padding: 140px 0px;color: red;">Result Not found !</p><?php
    }
    ?>
</tbody>
</table>
<?php /*
  $_results = mysql_query("select count(sell_order_product.id) as countProduct,product.product_name,sell_order_product.product_code FROM sell_order_product
  left join sell_order ON sell_order_product.invoice_no = sell_order.invoice_no
  left join product ON product.product_code = sell_order_product.product_code
  where sell_order.order_date >= $date
  group by sell_order_product.product_code
  order by countProduct asc limit 0,50");

  if (mysql_num_rows($_results) > 0) {
  ?>
  <table style="width: 45%;float: left;margin-left: 50px">
  <thead>
  <caption>Bottom 50 items sold   </caption>
  <tr>

  <th width="35%"> Code</th>
  <th width="50%"> Name</th>
  <th width="15%">Total sell</th>

  </tr>
  </thead>
  <tbody>





  <?php while ($_row_sc = mysql_fetch_array($_results)) { ?>
  <tr>
  <td width="35%"> <?php echo $_row_sc['product_code']; ?></td>
  <td width="50%"> <?php echo $_row_sc['product_name']; ?></td>
  <td width="15%"><?php echo $_row_sc['countProduct']; ?></td>
  </tr>
  <?php
  }
  }
  ?>
  </tbody>
  </table>
 * /*
 */ ?>
