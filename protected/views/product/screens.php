
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">  <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/addScreen/'; ?>">
                    SCREENS</a>
            </td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('_menu') ?>

            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">
                <?php if (Yii::app()->user->hasFlash('saveMessage')): ?>
                    <div class="message">
                        <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                    </div>
                <?php endif; ?> 

                <div id="table_holder">

                    <table class="tablesorter" id="sortable_table" style="width:100%">
                        <thead>
                            <tr>
                                <th class="leftmost">
                                    SL NO.</th>
                                <th>SCREEN NAME</th>
                                <th class="rightmost header">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $inc = 1;
                            foreach ($screens as $screen):
                                ?>
                                <tr  style="font:Verdana; font-size:11px">
                                    <td width="10%"><?php echo $inc++; ?></td>
                                    <td width="80%"><?php echo $screen->name; ?></td>
                                    <td width="10%" style="margin-left:5px;">
                                           <a href="<?php echo Yii::app()->request->baseUrl . '/product/screenProduct/'; ?><?php echo $screen->id; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/edit.png" height="24" alt="Screens" title="Screens" align="absmiddle"></a>
                                   <a href="<?php echo Yii::app()->request->baseUrl . '/product/showScreen/'; ?><?php echo $screen->id; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/displaysIcon.png" height="24" alt="Screens" title="Screens" align="absmiddle"></a>
                                           
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div></td>
        </tr>
    </tbody></table>


<div id="feedback_bar"></div>
