
<script type="text/javascript">


    $(document).ready(function () {

        $(".change_payment").die('click').live('click', function () {
            var data_id = $(this).attr("data-id");
            
        $.post('<?php echo Yii::app()->request->baseUrl; ?>/customer/editchaque',{"id":data_id},function(resp){
            $("#changeFrm").html(resp);
            $("#changeFrm").append($("#post_date").html());
        })
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: "#change_popup"
                },
                callbacks: {
                    beforeOpen: function (e) {
                        this.st.mainClass = "mfp-rotateLeft";
                    }
                },
                midClick: true
            });
        });
        });
        

</script>


<div id="post_date">
    
 <input type="hidden" name="start_date" value="<?php echo isset($start_date)?$start_date:""; ?>">
 <input type="hidden" name="end_date" value="<?php echo isset($end_date)?$end_date:""; ?>">
</div>

<div id="change_popup" style="width: 600px;margin: 0 auto;background: #FFF;padding: 15px;min-height: 600px;" class="popup-basic admin-form mfp-with-anim mfp-hide" >
    <form id="changeFrm" method="post" action="<?php echo Yii::app()->request->baseUrl; ?>/customer/inteditchaque">
     </form>
  
</div>

<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title"> Chaque Report</td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('/b2b_sell/_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">
                <p align="right" style="margin-right:80px;"><input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print report" title="Print Report"  /></p>
                <div id="ptable3">
                    <div id="table_holder" style="width:100%">
                       <table class="tablesorter" id="sortable_table" style="width:100%">
                            <?php if (count($model)): ?>
                                <thead>
                                    <tr>
                                       <th width="15%" >Receive Date</th>
                                         <th width="35%" >Customer Name</th>
                                        <th width="10%" > Amount</th>
                                        <th width="20%" >Banking Date</th>
                                        <th width="20%" >Note</th>
                                        <th width="15%" >&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $grand_total = 0;
                                    foreach ($model as $posValue):
                                        $customer_id = $posValue['customer_id'];
                                        $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                                        $customers = Customer::model()->findAll($q1);
                                        if (count($customers)): foreach ($customers as $customer): $customer_name = $customer->customer_name;
                                            endforeach;
                                        else: $customer_name = "";
                                        endif;
                                         
                                        ?>
                                        <tr style="font:Verdana; font-size:11px">
                                             <td><?php echo date('M d, Y', strtotime($posValue['receive_date'])); ?></td>
                                           <td><?php echo $customer_name; ?></td>
                                            <td><?php echo '&pound; ' . number_format($posValue['amount'], 2); ?></td>
                                            <td><?php  echo date('M d, Y', strtotime($posValue['confirm_date'])); ?></td>
                                            <td><?php  echo $posValue['notes']; ?></td>
                                            <td class="change_payment" data-id="<?php  echo $posValue['id']; ?>" style="background: #1c94c4;color: #FFFFFF;cursor: pointer;"> Change </td>
                                        </tr>
                                        <?php
                                        $i = $i + 1;
                                        $grand_total = $grand_total + $posValue['amount'];
                                    endforeach;
                                    ?>
                                    <tr>
                                         <td colspan="2"><strong><?php echo "Total"; ?></strong></td>
                                        <td><strong><?php echo "&pound; " . number_format($grand_total, 2); ?></strong></td>
                                  
                                        </tr>
<?php else: ?>
                                    <tr><div id="message-red"><td colspan="5" class="red-left">No Received Amount Available Yet .. <a href="<?php echo Yii::app()->request->baseUrl . '/customer/received_report/'; ?>">Search Again..</a></td></div></tr>
<?php endif; ?>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>
</div>
