   <?php $this->renderPartial('/layouts/site_top_menu', array('mainTab' => 'supplier', 'activeTab' => 'supplier')); ?>

<!-- CONTENT START -->
    <div class="grid_16" id="content">

    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div style="margin-left:5px;"><h1><?php echo CHtml::link('Supplier', array('index'))?> → Add Supplier</h1></div>
	 <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('saveMessage'); ?>
		</div>
   <?php endif; ?>   
   <?php $this->renderPartial('_form', array('model' => $model))?>

   </div>
