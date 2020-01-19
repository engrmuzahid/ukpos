<?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>		
<table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
    <tr height="10"><td colspan="3">&nbsp;</td></tr>
    <?php
    $models_station = Station::model()->findAll(array('order' => 'station_name'));
    $station_list = CHtml::listData($models_station, 'id', 'station_name');
    $yesNo = array(
        '1' => 'Yes',
        '0' => 'No'
    );
    $printtype = array(
        'A4' => 'A4 Size',
        'THARMAL' => 'Tharmal Print'
    );
    ?>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'station_name') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activedropDownList($model, 'station_id', $station_list, array('empty' => '----- Select Station -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'station_id'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'full_name') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'full_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'full_name'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'email_address') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'email', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'email'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'user_name') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'username', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'username'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'password') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activePasswordField($model, 'password', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'password'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'Online User') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeTextField($model, 'is_online', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'is_online'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'user_sign') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activeFileField($model, 'user_sign', array('style' => 'width:200px;height:25px;border:1px solid #CCC;')) ?></td>
        <td><div class="markcolor"><?php echo CHtml::error($model, 'user_sign'); ?></div></td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'user_privilege_option') ?>&nbsp;&nbsp;</th>
        <td><?php
            echo CHtml::activeCheckBox($model, 'customer_prev') . "&nbsp;&nbsp; Customer &nbsp;&nbsp;" . CHtml::activeCheckBox($model, 'item_prev') . "&nbsp;&nbsp; Item &nbsp;&nbsp;" . CHtml::activeCheckBox($model, 'stock_prev') . "&nbsp;&nbsp; Stock &nbsp;&nbsp;";
            echo CHtml::activeCheckBox($model, 'supplier_prev') . "&nbsp;&nbsp; Supplier &nbsp;&nbsp;" . CHtml::activeCheckBox($model, 'report_prev') . "  Reports &nbsp;&nbsp;" . CHtml::activeCheckBox($model, 'receiving_prev') . "&nbsp;&nbsp; Receivings &nbsp;&nbsp;" . CHtml::activeCheckBox($model, 'sale_prev') . "&nbsp;&nbsp; Sales &nbsp;&nbsp;&nbsp;";
            echo CHtml::activeCheckBox($model, 'employee_prev') . "&nbsp;&nbsp; Employee &nbsp;&nbsp;&nbsp;" . CHtml::activeCheckBox($model, 'store_config_prev') . "  Store Config &nbsp;&nbsp;" . CHtml::activeCheckBox($model, 'b2b_prev') . "  B2B &nbsp;&nbsp; &nbsp;&nbsp;" . CHtml::activeCheckBox($model, 'driver_prev') . "  Driver";
            ?></td>
        <td>
            <div class="markcolor"><?php //echo CHtml::error($model,'password');              ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'customer_mandatory') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activedropDownList($model, 'customer_mandatory', $yesNo, array('empty' => '----- Select -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'customer_mandatory'); ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'e_u') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activedropDownList($model, 'eu', $yesNo, array('empty' => '----- Select -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'eu'); ?></div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'bank_check') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activedropDownList($model, 'payment_check', $yesNo, array('empty' => '----- Select -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'payment_check'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    
    <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'suspend_status') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activedropDownList($model, 'is_suspend', $yesNo, array('empty' => '----- Select -----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'is_suspend'); ?></div>
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
     <tr>
        <th valign="top"><?php echo CHtml::activeLabel($model, 'printer_name') ?>&nbsp;&nbsp;</th>
        <td><?php echo CHtml::activedropDownList($model, 'printer_name', $printtype, array('empty' => '----- Select One-----', 'style' => 'width:200px;height:25px;border:1px solid #CCC;')); ?></td>
        <td>
            <div class="markcolor"><?php echo CHtml::error($model, 'printer_name'); ?></div>
        </td>
    </tr>
 
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <th>&nbsp;</th>
        <td valign="top">
            <?php echo CHtml::submitButton('Register', array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel', array('class' => 'buttonGreen')); ?>
        </td>
        <td></td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
</table>
<?php
echo CHtml::endForm()?>