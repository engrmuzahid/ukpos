<script type="text/javascript">
    $(document).ready(function ()
    {
        
        enable_select_all();
        enable_checkboxes();
        enable_row_selection();
    });

</script>
<style type="text/css">
    #sortable_table td{
        line-height: 23px;
        font-size: 14px;
    }
</style>

<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">
                <?php echo CHtml::link('Customer', array('add')) ?> <span style="font-size: 16px; margin-left: 23px">Total <?php echo $total ?> Customer(s)</span>
                <div style="float: right">
                    <select name="suspend_date" style="height: 30px; min-width: 150px" id="filter_day">
                        <option value="">Order Day</option>
                        <option value="MON" <?php echo $filter_day == 'MON' ? 'selected' : '' ?>>Monday</option>
                        <option value="TUE" <?php echo $filter_day == 'TUE' ? 'selected' : '' ?>>Tuesday</option>
                        <option value="WED" <?php echo $filter_day == 'WED' ? 'selected' : '' ?>>Wednesday</option>
                        <option value="THU" <?php echo $filter_day == 'THU' ? 'selected' : '' ?>>Thursday</option>
                        <option value="FRI" <?php echo $filter_day == 'FRI' ? 'selected' : '' ?>>Friday</option>
                        <option value="SAT" <?php echo $filter_day == 'SAT' ? 'selected' : '' ?>>Saturday</option>
                        <option value="SUN" <?php echo $filter_day == 'SUN' ? 'selected' : '' ?>>Sunday</option>
                    </select>
                </div>
            </td>
            <td>
                <div style="margin-left: 15px;">
                    <select name="select_customer" style="height: 30px; min-width: 150px" id="select_customer"> 
                        <option value="">Select Customer Type</option>
                        <option value="customer" <?php echo $customer_type == 'customer' ? 'selected' : '' ?>>Customer</option>
                        <option value="retail_customer" <?php echo $customer_type == 'retail_customer' ? 'selected' : '' ?>>Retail Customer</option>
                    </select>
                </div>
            </td>
            <td id="title_search">                   
                <?php echo CHtml::beginForm(Yii::app()->request->baseUrl . '/customer/search', 'post') ?>		
                <?php echo CHtml::textField('customer_name', '', array('style' => 'width:150px;border:1px solid #CCC;')) ?>             
                <?php echo CHtml::endForm(); ?>             
            </td>
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
                <?php if (Yii::app()->user->hasFlash('saveMessage')): ?>
                    <div class="message">
                        <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                    </div>
                <?php endif; ?> 
                <div id="table_holder">
                    
                <form action="/newpos/customer/CustomerbulkSms" method="post" id="CustomerbulkSms">
                    <table class="tablesorter" id="sortable_table" style="width:100%">
                <?php if (count($models)): ?>
                    <thead>
                        <tr>
                            <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                            <th>Customer Name</th>
                            <?php if ($customer_type != 'retail_customer') : ?>
                                <th>Business Name</th>
                            <?php endif; ?>
                            <th>Contact No</th>
                            <?php if (@$filter_day != '') : ?>
                                <th>Checking</th>
                            <?php endif; ?>
                            <th>
                                <a style="color: #FFF;" href="javascript:void(0)" class="sendBulkSms">
                                    <?php $balance = $sms_balance['credit'] - $sms_balance['debit']; ?>
                                    <img style="height:30px;"   src="<?php echo Yii::app()->request->baseUrl . '/images/smsimg.png'; ?>" alt="SMS" title="SMS" /><span style="vertical-align: top;line-height: 30px;"><?php echo $balance; ?> </span>
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($models as $model): ?>
                            <tr style="font:Verdana; font-size:13px">
                                <td width="5%"><input type="checkbox" name="Phone[]" class="cusCheckbox" name="<?php echo 'checkbox_' . $model->id; ?>" id="<?php echo 'checkbox_' . $model->id; ?>"  data-no1="<?php echo $model->contact_no1; ?>" data-no2="<?php echo $model->contact_no2; ?>" value="<?php echo $model->id; ?>"  /></td>
                                <td width="25%"><?php echo CHtml::link(CHtml::encode($model->customer_name . "-" . $model->id), array('edit', 'id' => $model->id)); ?> <br/><?php echo $model->email_address; ?></td>
                                <?php if ($customer_type != 'retail_customer') : ?>
                                    <td width="25%"><?php echo $model->business_name; ?>z</td>
                                <?php endif; ?>
                                <td width="18%"><?php echo $model->contact_no1 . ' ' . $model->contact_no2; ?></td>

                                <?php if (@$filter_day != '') : ?>
                                    <td>
                                        <a href="javascript:void(0)" class="checkingDone" data-id="<?php echo $model->id ?>" style="text-decoration: underline"><?php echo $model->checkingDone == 1 ? 'CHECKED' : 'N-CHECKED' ?></a>
                                    </td>
                                <?php endif; ?>
                                <td width="20%" style="margin-left:10px;">
                                    <?php if ($customer_type == 'retail_customer') : ?>
                                        <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/customer/retailedit/' . $model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a> | 
                                    <?php else : ?>
                                        <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/customer/edit/' . $model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a> | 
                                    <?php endif; ?>
                                    <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl . '/index.php/customer/delete/' . $model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/delete.png'; ?>" width="16" alt="Delete" title="Delete" border="0" /></a> | 
                                    <?php if ($customer_type == 'retail_customer') : ?>
                                        <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/customer/retailview/' . $model->id; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a>
                                    <?php else : ?>
                                        <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/customer/view/' . $model->id; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>         
                </form> 
                </div>
                <div id="pagination"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></div>
            </td>
        </tr>
    </tbody>
</table>
<div id="feedback_bar"></div>
<div id="customer_popup"></div>
<script language="javascript">
    function confirmSubmit() {
        var agree = confirm("Are you sure to delete this record?");
        if (agree)
            return true;
        else
            return false;
    }

            var mobileNumbers = [];
            
    $(document).ready(function () {
        $("#select_customer").change(function (e) {
            if ($(this).val() != "")
                location = '<?php echo Yii::app()->baseUrl ?>/customer/index/?customer_type=' + $(this).val();
            else
                location = '<?php echo Yii::app()->baseUrl ?>/customer/index/';
        });

        $("#filter_day").change(function (e) {
            if ($(this).val() != "")
                location = '<?php echo Yii::app()->baseUrl ?>/customer/index/?filter_day=' + $(this).val();
            else
                location = '<?php echo Yii::app()->baseUrl ?>/customer/index/';
        });


        $(".checkingDone").click(function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var url = '<?php echo Yii::app()->baseUrl ?>/customer/doneChecking/?customer_id=' + id;
            var btn = $(this);
            $.post(url, {}, function (resp) {
                if (resp == 'CHECKED')
                    btn.parent().parent().css('background-color', '#e5e5e5');
                else
                    btn.parent().parent().css('background-color', '');
                btn.html(resp);
                btn.parent().parent().click();
            });
        });

        $(".checkingClear").click(function () {
            var url = '<?php echo Yii::app()->baseUrl ?>/customer/clearChecking';
            $.post(url, {}, function (resp) {
                if($("#filter_day").val() != "")
                {
                    location = '<?php echo Yii::app()->baseUrl ?>/customer/index/?filter_day=' + $("#filter_day").val();
                }
                else
                {
                    location = '<?php echo Yii::app()->baseUrl ?>/customer/index/';
                }
            });
        });
//        
//

        $(".sendBulkSms").live("click", function (e) {
            e.preventDefault();

            var data =  $("#CustomerbulkSms").serialize();
            $.post('<?php echo Yii::app()->request->baseUrl . "/customer/customerbulkSms"; ?>', data, function (resp) {
                $("#customer_popup").html(resp);
                $.magnificPopup.open({
                    type: 'inline',
                    items: {
                        src: "#customer_popup_frm"
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
    });
</script>