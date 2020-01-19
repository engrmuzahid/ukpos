<style>
    .producthistorydetails{
        font-size: 15px;
        text-align: center;
        padding-left: 10px;
        list-style: none;
        line-height: 20px;
        color: #FFF;
    }
</style> 
<div style="width:160px;height: 120px;position: fixed;display: block;background: #000;padding: 20px;margin-top: -20px;">
    <ul>
        <?php foreach ($last_history as $history) : ?>
            <li class="producthistorydetails"><?php echo date("d/m/Y", strtotime($history['order_date'])); ?> | <?php echo '&pound;' . number_format($history['sell_price'], 2); ?> </li>
            <?php endforeach; ?>
    </ul>
</div>

