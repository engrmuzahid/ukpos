<?php echo CHtml::beginForm()?>
		
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo CHtml::activeLabel($model, 'station_name')?>&nbsp;&nbsp;</th>
			<td><?php echo CHtml::activeTextField($model, 'station_name', array('style' => 'width:200px;height:25px;border:1px solid #CCC;'))?></td>
			<td>
            <div class="markcolor"><?php echo CHtml::error($model,'station_name'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</th>
            <td valign="top">
			<?php echo CHtml::submitButton('Save' ,array('class' => 'buttonBlue')); ?>
            <?php echo CHtml::resetButton('Cancel' ,array('class' => 'buttonGreen')); ?>
            </td>
            <td></td>
        </tr>
	</table>
<?php echo CHtml::endForm()?>