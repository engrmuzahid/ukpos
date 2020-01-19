<style type="text/css">
    table.hovertable {
        font-family: verdana,arial,sans-serif;
        font-size:11px;
        color:#333333;
        border-width: 1px;
        border-color: #999999;
        border-collapse: collapse;
        width: 100%
    }
    table.hovertable thead tr th {
        border-width: 1px;
        font-size:13px !important;
        padding: 8px;
        border-style: solid;
        border-color: #a9c6c9;
    }
    table.hovertable tbody tr {
        background-color:#d4e3e5;
    }
    table.hovertable tbody tr:nth-of-type(odd) {
        background-color:#ededed;
    }
    table.hovertable td {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #a9c6c9;
    }

    table.hovertable tbody tr:hover ,table.hovertable tbody td:hover {
        background-color:#ffff66;
    }


</style> 
<?php if (!$orders): ?>
    <h2 style="text-align: center;padding: 40px 0px;"> There are no record. </h2>
<?php else: ?>

    <table class="hovertable">
        <thead>
            <tr>
                <th> Invoice </th>
                <th> Customer  </th>
                <th> Pay Mode </th>
                <th> Amount   </th>
                <th> Paid </th>
                <th> Due  </th>
                <th> &nbsp; </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <?php $customer = Customer::model()->findAllByPk($order['customer_id']); ?>
                <tr>
                    <td style="<?php echo $order['print_status'] > 0 ? 'color:#5f84f2;' : ''; ?>"> <?php echo $order['invoice_no']; ?> </td>
                    <td style="<?php echo $order['print_status'] > 0 ? 'color:#5f84f2;' : ''; ?>">  <?php echo $customer[0]['customer_name']; ?>   </td>
                    <td style="<?php echo $order['print_status'] > 0 ? 'color:#5f84f2;' : ''; ?>"> <?php echo $order['cash_sell'] == 0 ? "Account" : "Cash"; ?>  </td>
                    <td style="<?php echo $order['print_status'] > 0 ? 'color:#5f84f2;' : ''; ?>"> &pound;<?php echo number_format($order['amount_grand_total'], 2); ?>    </td>
                    <td style="<?php echo $order['print_status'] > 0 ? 'color:#5f84f2;' : ''; ?>"> &pound;<?php echo number_format($order['paid_amount'], 2); ?>    </td>
                    <td style="<?php echo $order['print_status'] > 0 ? 'color:#5f84f2;' : ''; ?>"> &pound;<?php echo number_format($order['amount_grand_total'] - $order['paid_amount'], 2); ?>    </td>
                    <td style="text-align: center;background: #FFF;width: 200px;cursor: default;">
                        <a href="<?php echo Yii::app()->request->baseUrl . '/b2b_sell/view/' . $order['invoice_no']; ?>" target="_blank"  title="Show"><img  style="height: 32px;" src="<?php echo Yii::app()->request->baseUrl . '/public/images/view_1.png'; ?>" alt="Show" title="Show" border="0" /></a>
                        <?php if ($order['online_order_status'] == "pending"): ?>
                            <a href="<?php echo Yii::app()->request->baseUrl . '/b2b_sell/reorder/' . $order['invoice_no']; ?>" title="Show" style="float:right;"><img style="height: 32px;" src="<?php echo Yii::app()->request->baseUrl . '/public/images/accept.png'; ?>" alt="Show" title="Show" border="0" /></a>
                            <?php endif; ?>
                    </td>
                </tr> 
            <?php endforeach; ?>

        </tbody>

    </table>


<?php endif; ?>