<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo Yii::app()->baseUrl ?>';
    window.onload = function () {
        new JsDatePick({
            useMode: 2,
            target: "start_date",
            dateFormat: "%Y-%m-%d"
        });
        new JsDatePick({
            useMode: 2,
            target: "end_date",
            dateFormat: "%Y-%m-%d"
        });
    };
    $('body').on('change', '#supplier_id', function (e) {
        e.preventDefault();
        var supplier_id = $('#supplier_id').val();
        $.post(base_url + '/supplier/supplier_list', {'supplier_id': supplier_id}, function (resp) {
            $("#chalan_idTable").empty()
            $("#chalan_idTable").html(resp);
        });
    });

</script>
<?php
$models3 = Supplier::model()->findAll(array('order' => 'name'));
$list3 = CHtml::listData($models3, 'id', 'name');
$models4 = Purchase::model()->findAll(array('order' => 'chalan_id'));
$list4 = CHtml::listData($models4, 'chalan_id', 'chalan_id');
?>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Account Payable Report</td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td style="background-color:#E9E9E9">

                <?php echo CHtml::beginForm() ?>		
                <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
                    <tr height="10"><td colspan="10">&nbsp;</td></tr>
                    <tr>
                        <th width="12%" valign="top"><?php echo CHtml::label('Supplier Name', 'supplier_id') ?>&nbsp;&nbsp;</th>
                        <td width="15%"><?php echo CHtml::dropDownList('supplier_id', 'supplier_id', $list3, array('empty' => 'Select Supplier', 'style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?></td>
                        <td width="2%">&nbsp;</td>
                        <th width="12%" valign="top"><?php echo CHtml::label('Start Date', 'start_date') ?>&nbsp;&nbsp;</th>
                        <td width="15%"><?php echo CHtml::textField('start_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?></td>
                        <td width="2%">&nbsp;</td>
                    </tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr>
                        <th width="12%" valign="top"><?php echo CHtml::label('End Date', 'end_date') ?>&nbsp;&nbsp;</th>
                        <td width="15%"><?php echo CHtml::textField('end_date', '', array('style' => 'width:150px;height:25px;border:1px solid #CCC;')) ?></td>
                        <td width="2%">&nbsp;</td>
                        <th width="12%" valign="top"><?php echo CHtml::label('Supplier Invoice', 'chalan_id') ?>&nbsp;&nbsp;</th>
                        <td width="15%" id="chalan_idTable">
                            <?php echo CHtml::dropDownList('chalan_id', 'chalan_id', $list4, array('empty' => 'Select Supplier Invoice', 'style' => 'width:150px;height:25px;border:1px solid #CCC;')); ?>
                        </td>
                        <td valign="top" style="margin-right:40px;">
                            <?php echo CHtml::submitButton('Search', array('class' => 'buttonBlue')); ?>
                        </td>
                    </tr>
                </table>
                <?php echo CHtml::endForm() ?>

            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div> 
