   <?php $this->renderPartial('/layouts/site_top_main_menu', array('mainTab' => 'contact_us')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1><?php echo $this->pageTitle=Yii::app()->name . ' - Contact Us'; ?></h1></div>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>
<?php $form=$this->beginWidget('CActiveForm', array( 'id'=>'contact-form', 'enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true,),)); ?>
    <p style="margin-left:10px;">If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.</p>
	
        <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
        <tr height="10"><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo $form->labelEx($model,'name'); ?><span class="markcolor"></span>&nbsp;&nbsp;</th>
			<td><?php echo $form->textField($model,'name'); ?></td>
			<td>
            <div class="markcolor"><?php echo $form->error($model,'name'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo $form->labelEx($model,'email'); ?><span class="markcolor"></span>&nbsp;&nbsp;</th>
			<td><?php echo $form->textField($model,'email'); ?></td>
			<td>
            <div class="markcolor"><?php echo $form->error($model,'email'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo $form->labelEx($model,'subject'); ?><span class="markcolor"></span>&nbsp;&nbsp;</th>
			<td><?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?></td>
			<td>
            <div class="markcolor"><?php echo $form->error($model,'subject'); ?></div>
           </td>
		</tr>
        <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top"><?php echo $form->labelEx($model,'body'); ?><span class="markcolor"></span>&nbsp;&nbsp;</th>
			<td><?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?></td>
			<td>
            <div class="markcolor"><?php echo $form->error($model,'body'); ?></div>
           </td>
		</tr>
        <?php if(CCaptcha::checkRequirements()): ?>
	    <tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<th valign="top" colspan="2">
			<?php $this->widget('CCaptcha'); ?>
		    &nbsp;&nbsp;<?php echo $form->textField($model,'verifyCode'); ?></td>
			<td>
            <div class="markcolor"><?php echo $form->error($model,'verifyCode'); ?></div>
           </td>
		</tr>
	  <?php endif; ?>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr>
            <th>&nbsp;</th>
            <td valign="top"><?php echo CHtml::submitButton('Submit',array('class' => 'buttonBlue')); ?>
            </td>
            <td></td>
        </tr>
	</table>
<?php $this->endWidget(); ?>

<?php endif; ?>
</div>