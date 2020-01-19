 

<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            
             <td id="title">
                     <a href="<?php echo Yii::app()->request->baseUrl . '/bank/addtansection/'.$bank_id; ?>">Bank transaction info</a> 
                </td>
            
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">
                <div id="table_holder">

                    <table class="tablesorter" id="sortable_table" style="width:100%">
                        <?php if (count($models)): ?>
                            <thead>
                                <tr>
                                    <th width="5%" scope="col">SL</th>
                                    <th width="15%" scope="col">Date</th>
                                    
                                    <th width="40%" scope="col">Purpose</th>
                                    <th width="40%" scope="col"> Debits/Credits </th>
                                    <th width="20%" scope="col">User</th>
                                    <th width="20%" scope="col">Amount</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $amount = 0;
                                foreach ($models as $model):
                                    ?>
                                    <tr <?php if ($i % 2 == 0): ?> class="alternate-row" <?php endif; ?>>
                                        <td><?= $i; ?></td>
                                        <td><?php echo date("d-m-Y",strtotime($model['date'])); ?></td>
                                        <td><?php echo $model['purpose_description']; ?></td>
                                                <td><?php echo $model['is_saving']?"Credits":"Debits"; ?></td>
                                                <td><?php echo $model['user_name']; ?></td>
                                                <td><span style="float:right;"><?php echo $model['is_saving']?"":"-"; ?><?php echo "£".number_format($model['amount'],2); ?></span></td>

                                    </tr>
                                    <?php
                                    $model['is_saving']?$amount +=$model['amount']:$amount -=$model['amount'];
                                    $i = $i + 1;
                                endforeach;  ?>
                                    
                                    <tr> 
                                        <td colspan="4">Total Amount</td>
                                        <td colspan="2"><b style="float:right;"> <?php echo "£".number_format($amount,2); ?></b></td>
                                </tr>
                            <?php else: ?>
                                    <tr> 
                                        <td colspan="6">There are no transection of this bank.</td>
                                     </tr>
                             <?php   endif;  ?>
                                    
                        </tbody>
                    </table>
                </div> 
            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
<script language="javascript">
    function confirmSubmit() {
        var agree = confirm("Are you sure to delete this record?");
        if (agree)
            return true;
        else
            return false;
    }
</script>