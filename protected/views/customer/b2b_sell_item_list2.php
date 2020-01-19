    <script>
        $(function(){
            $("#print_button2").click( function() {
                $("#contentTable").jqprint();
            });
        });
    
    </script>
<table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">B2B Item List</td>
	</tr>
  </tbody>
</table>
<table id="contents">
	<tbody><tr>
		<td  colspan="3">

        <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl.'/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>

        <div id="contentTable">
            <div id="ptable3" align="center">
               <p align="right" style="margin-right:100px;"><?php if(!empty($invoices)): echo "Total Invoices: ".$invoices; endif; ?></p>
			  <table  border="1" style="width:80%; border-collapse:collapse;">
				<tr>
                    <th width="60%" scope="col">Product Name</th>
                    <th width="15%" scope="col">Quantity</th>
                    <th width="25%" scope="col">Comment</th>
				</tr>
                <?php
				  for($i = 0; $i< sizeof($product_name); $i++):
                  $product_name2  = $product_name[$i];				  
                  $quantity2      = $quantity[$i];
                  $comment2       = $comment[$i];

                  $quantity2 = is_numeric($quantity2) && strpos($quantity2, ".") !== false ? number_format($quantity2, 2) : $quantity2;
                  
                 ?>
				<tr>
                    <td align="justify">&nbsp;<?php echo $product_name2; ?>
					</td>
                    <td align="center">
					 <?php echo $quantity2;  ?>
					</td>
					<td align="center"> <?php echo $comment2; ?></td>
				</tr>
             <?php  endfor; ?>
             	<tr>
                    <td align="right"><strong>Total Quantity:</strong>&nbsp;</td>
                    <td align="center"><?php echo $q_total;  ?> 
					</td>
					<td align="center">&nbsp;</td>
				</tr>
            </table>
               </div>

            <div style="clear: both; page-break-after:always;"><br/><br/></div>
            <!-- h3 style="text-align: center">B2B item list per customer</h3>
            <br/><br/>


            <?php /*
            $q_total = 0;
            foreach($orders as $orders_) : ?>

                <?php if($q_total > 0) : ?>
                    <div style="clear: both; page-break-after:always;"><br/><br/></div>
                <?php endif; ?>

                <div id="ptable3" align="center">
                    <table  border="1" style="width:80%; border-collapse:collapse;">

                        <?php
                        $cnt = 0;
                        foreach ($orders_ as $order) :
                            $product_code  = $order['product_code'];
                            $quantity      = $order['quantity'];
                            $amount        = $order['amount'];
                            $product_name  = $order['product_name'];

                            //$q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) );
                            //$ProVals       = Product::model()->findAll( $q1 );
                            $cnt++;

                            $quantity = is_numeric($quantity) && strpos($quantity, ".") !== false ? number_format($quantity, 2) : $quantity;


                            $sql = "SELECT p.*, u.unit_type FROM product p JOIN unit_type u ON u.id = p.unit_type_id where p.product_code = '$product_code'";
                            $products = Yii::app()->db->createCommand($sql)->queryAll();

                            $quantity_desc = "";

                            if(count($products)) {
                                $product = $products[0];

                                $product_name = $product_name == "" ? $product['product_name'] : $product_name;
                                $unit_type = $product['unit_type'];
                                if($product["is_boucher"]) {
                                    $quantity = 1;
                                    $quantity_desc = " (". (is_numeric($order['quantity']) && strpos($order['quantity'], ".") !== false  ? number_format($order['quantity'], 2) : $order['quantity']) ." $unit_type)";
                                } else {
                                    $quantity_desc = "";
                                }
                            }

                            $q_total = $q_total + $quantity;

                            ?>

                            <?php if($cnt == 1) : ?>
                            <tr>
                                <th colspan="2" style="padding: 20px;">
                                    <?=$order['business_name']?>
                                    <p style="font-weight: normal">Invoice No: <?=$order['invoice_no']?></p>
                                    <p style="font-weight: normal"><?=$order['business_street1']?> <?=$order['business_street2']?>, <?=$order['business_city']?>, <?=$order['business_state']?>, <?=$order['business_post_code']?></p>
                                </th>
                            </tr>

                            <tr>
                                <th width="80%" scope="col">Product Name</th>
                                <th width="20%" scope="col">Quantity</th>
                            </tr>
                        <?php endif; ?>

                            <tr>
                                <td align="justify">
                                    <?php echo $product_name . $quantity_desc ?>
                                </td>
                                <td align="center">
                                    <?php echo $quantity;  ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </table>
                </div>

            <?php endforeach; */ ?> -->

        </div>

        </td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
