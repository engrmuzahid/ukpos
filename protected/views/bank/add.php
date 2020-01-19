<link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        new JsDatePick({
            useMode: 2,
            target: "bank_date",
            dateFormat: "%Y-%m-%d"
        });
    });
</script>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Add Bank Transaction </td>
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
                <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
                    <div class="message">
                        <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                    </div>
                <?php endif; ?> 

                <?php echo CHtml::beginForm() ?>
                <input type="hidden" name="Bank[bank_id]" value="<?php echo $bank_id; ?>"/>
                <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <th valign="top">Purpose</th>
                        <td>
                            <select name="Bank[purpose_id]">
                                <?php foreach ($transaction_purpose as $purpose): ?>
                                    <option value="<?php echo $purpose['id']; ?>"><?php echo $purpose['purpose_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr><td colspan="3">&nbsp;</td></tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td valign="top">
                            <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue')); ?>
                            <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen')); ?>
                        </td>
                        <td></td>
                    </tr>
                </table>
                <?php echo CHtml::endForm() ?>
            </td>
        </tr>
    </tbody></table>
