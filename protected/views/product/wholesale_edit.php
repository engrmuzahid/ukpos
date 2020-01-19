<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title"><?php echo CHtml::link('Item', array('index')) ?> → Edit Offer Item</td>
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
                <?php if (Yii::app()->user->hasFlash('saveMessage')): ?>
                    <div class="message">
                        <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                    </div>
                <?php endif; ?>   
                <?php $this->renderPartial('_formedit_wholesale', array('model' => $model)); ?>
            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>
</div>
</div>