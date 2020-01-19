 
<table style="width: 300px;">
    <tbody>
        <?php foreach ($last_history as $history) : ?>
            <tr>
                <td><?php echo date("d/m/Y",strtotime($history['purchase_date'])); ?> | <?php echo '&pound;'.number_format($history['product_price'],2); ?> | <?php echo $history['name'] ?>
                </td>

            </tr>
        <?php endforeach; ?>


    </tbody>
</table>
