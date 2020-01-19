<?php if (!empty($org_customers)): ?>
    <table  id="item_table" style="width: 100%;">
        <tr>
            <th>Customer  details
        </tr>
        <?php
        foreach ($org_customers as $customer):
            $due_amount = 0;
            $customers_id = $customer['id'];
            $sell_order = Yii::app()->db->createCommand()
                            ->select('SUM(paid_amount) as amount,SUM(amount_grand_total) as grand_total')
                            ->where("customer_id = '$customers_id'")
                            ->from('sell_order')->queryRow();
            if ($sell_order){
                $due_amount = $sell_order['grand_total'] - $sell_order['amount'];
            }
            ?>
            <tr>
                <td style="line-height: 27px;cursor: pointer;" class="customer_radiobox" data-name="<?php echo "{$customer['customer_name']}, {$customer['business_name']}"; ?>"  data-value="<?php echo $customer['id']; ?>" >
                    <b><?php echo "{$customer['customer_name']}, {$customer['business_name']}"; ?></b><span style="float:right;color:red"> <?php echo $due_amount > 0 ? '-£' . number_format($due_amount,2) : ""; ?></span><br/>
                    <?php echo $customer['business_street1'] . ' ', $customer['business_city'] . ' ' . $customer['business_post_code'] ?> 
                    <span style="float:right;"><?php echo $customer['contact_no1'] . ' ' . $customer['contact_no2'] ?></span>

                </td> 
            </tr>
        <?php endforeach; ?>

    </table>  
<?php else: ?>
    <h2 style="color: RED"> SORRY ! NO CUSTOMER FOUND.</h2>
<?php endif; ?>
