 <table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title"><?php echo CHtml::link('Shop', array('index'))?> → Add Shop</td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/user'; ?>" class="none new">Employees</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/user/register'; ?>" class="none new">Registration</a>  
				<a href="<?php echo Yii::app()->request->baseUrl.'/station'; ?>" class="none new">Station</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/company'; ?>" class="none new">Company</a>  
    			<a href="<?php echo Yii::app()->request->baseUrl.'/warehouse'; ?>" class="none new">Shop</a>                  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td style="background-color:#E9E9E9">
			  <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
                <div class="message">
                    <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                </div>
             <?php endif; ?>   
            <?php $this->renderPartial('_form', array('model' => $model))?>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>