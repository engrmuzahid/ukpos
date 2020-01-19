<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/product/screens/'; ?>"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon"> Screens</a>
            </td>

            <td id="title_search">

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
                        <?php if (count($models)): ?>
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Name</th> 
                                    <th>Sell Price</th>
                                    <th>Sort Order </th>
                                    <th>Colour </th>
                                    <th class="rightmost header">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($models as $model):

                                    $sell_p = $model->sell_price;
                                    $vat_pp = $model->vat;
                                    $sell_price = $model->sell_price - $model->vat_on_purchase - $model->vat_on_profit;
                                    $screen = Yii::app()->db->createCommand()
                                                    ->select('*')
                                                    ->where("product_id = '$model->id'")
                                                    ->from('screen_products')->queryRow();
                                    ?>
                                    <tr  style="font:Verdana; font-size:11px">
                                 <td width="10%"><?php echo $model->product_code; ?></td>
                                        <td width="25%"><?php echo CHtml::link(CHtml::encode($model->product_name), array('edit', 'id' => $model->id)); ?></td>
                                        <td width="15%"><?php echo '&pound; ' . number_format($sell_price, 2); ?></td>
                                        <td width="15%"><?php echo $screen['sort_order'] ?></td>
                                        <td width="15%"><div style="width:100%;height: 30px;background: <?php echo $screen['color'] ?>">&nbsp;</div></td>
                                        <td width="17%" style="margin-left:5px;">
                                            <a href="<?php echo Yii::app()->request->baseUrl . '/product/editScreenProduct/' . $screen['id']; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a>

                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>

            </td>
        </tr>
    </tbody></table>


<div id="feedback_bar"></div>