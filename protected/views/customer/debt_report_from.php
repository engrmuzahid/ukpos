<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Debt Report </td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('/b2b_sell/_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td style="background-color:#E9E9E9">

                <?php echo CHtml::beginForm("debtreport") ?>		
                <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
                    <tr height="10"><td colspan="10">&nbsp;</td></tr>
                    <tr>
                        <th width="35%" valign="top"><?php echo CHtml::label('Customer ', 'customer_id') ?>&nbsp;&nbsp;</th>
                        <td width="35%">
                            <select name="customer_id" style="width:210px;height:26px;border:1px solid #CCC;">
                                <option value="">Select All</option>
                                <?php foreach ($customers as $cust) : ?>

                                    <option value="<?php echo $cust['id'] ?>"><?php echo $cust['customer_name'] ?>-<?php echo $cust['id'] ?></option>

                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td width="5%">&nbsp;</td><td width="2%">&nbsp;</td>
                        <td>
                            <?php echo CHtml::submitButton('Search', array('class' => 'buttonBlue','style'=>'width:150px;')); ?>
                        </td>
                    </tr>

                </table>
                <?php echo CHtml::endForm() ?>

            </td>
        </tr>
    </tbody>
</table>

