<style type="text/css">
    .pre_notes{
        padding: 15px;
    }
    .pre_notes:nth-child(odd){
        background: #ededed;
    }
</style>

    <?php foreach ($customer_notes as $customer_note): ?>
   <?php                        $customer_id = $customer_note['user_id'];
                                $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                                $customers = Users::model()->findAll($q1);

                                if (count($customers)):
                                    foreach ($customers as $customer):
                                        $customer_name = $customer->full_name;
                                    endforeach;
                                else:
                                    $customer_name = "";
                                endif;
                                ?>
        <div class="pre_notes">
            <h4 style="text-align: left;">
                <?php if($customer_note['note_type']=="payment"): ?>
                Payment Date  : <?php echo date("d/m/Y", strtotime($customer_note['payment_date'])); ?>
                <?php else: ?>
                <?php echo $customer_note['note_type'] ?>
                <?php endif; ?>
            </h4>
          
            <p style="text-align: justify;margin-top: 10px;"><?php echo $customer_note['notes'] ?></p>
            <p style="text-align: right;font-style: italic;"> <?php echo $customer_name.' | '.date("d/m/Y", strtotime($customer_note['note_date'])); ?> </p>
        </div>
    <?php endforeach; ?>