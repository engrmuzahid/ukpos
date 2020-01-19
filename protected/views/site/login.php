<?php $form=$this->beginWidget('CActiveForm', array('id'=>'login-form',	'enableClientValidation'=>true,	'clientOptions'=>array( 'validateOnSubmit'=>true,),)); ?>
    <table id="login_form">	
		<tbody>
        <tr id="form_field_username">	
			<td class="form_field_label"><?php echo $form->labelEx($model,'username'); ?> </td>
			<td class="form_field">
			<?php echo $form->textField($model,'username',array('size' => '20')); ?>
            <div class="markcolor"><?php echo $form->error($model,'username'); ?></div>
            </td>
		</tr>
	
		<tr id="form_field_password">	
			<td class="form_field_label"><?php echo $form->labelEx($model,'password'); ?> </td>
			<td class="form_field">
            <?php echo $form->passwordField($model,'password',array('size' => '20')); ?>
            <div class="markcolor"><?php echo $form->error($model,'password'); ?></div>
			</td>
		</tr>
		
		<tr id="form_field_submit">	
			<td id="submit_button" colspan="2">
            <?php echo CHtml::submitButton('Login',array('name' => 'login_button')); ?>
			</td>
		</tr>
	</tbody>
    </table>
   <?php $this->endWidget(); ?>
