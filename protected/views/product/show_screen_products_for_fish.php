<style type="text/css">    
    body{
        font-family: tahoma;
    }
    table tr td p{
        background: #ccc;
    }
    table tr td p:nth-child(odd){
        background: #ededed;
    }
    table thead tr{
        background: #000 !important;
        color: #fff;
    }

    table td{
        border: 0px solid #BBB;
        font-size: 2vw; 
        font-weight: normal; 
    } 
    table tr th{ 
        font-size: 1em; 
    }
    /*  18 */
</style>
<title> PRICE SCREEN </title>


<table class="tablesorter" id="sortable_table" style="width:50%;float: left;">
    <?php if (count($models)): ?>
        <thead>
            <tr>
                <th>
                    <span>   <a href="<?php echo Yii::app()->request->baseUrl . '/product/screens/'; ?>" style="float:left;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/displaysIcon.png" height="24" alt="Screens" title="Screens" align="absmiddle"></a>
                        <span>FISH </span> </span>   <span style="float:right;margin-right: 8%;"> Price </span>    
                </th>

            </tr>
        </thead>
        <tbody>
            <?php
            $inc = 1;
            foreach ($models as $model):
                $cond = new CDbCriteria(array('condition' => "product_id = '$model->id'",));
                $screen = Screen_products::model()->find($cond);
                $sell_price = $model->sell_price - $model->vat_on_purchase - $model->vat_on_profit;
                if ($inc < 10):
                    ?>
                    <tr>
                        <td>
                            <p style="line-height:65px;margin: 0;border-bottom: 1px dotted #000;background:<?php echo $screen->color; ?>;"> <span style="vertical-align:top;" > <?php echo $model->product_name; ?> </span><span style="float:right;padding-right: 3%;background: #FF0000;color:#FFF;text-align: right;font-weight: bold;width:120px;">&nbsp;  <?php echo '&pound;' . number_format($sell_price, 2); ?></span></p>

                        </td>
                    </tr>
                    <?php
                endif;
                $inc++;
            endforeach;
        endif;
        ?>
    </tbody>
</table> 

<table class="tablesorter" id="sortable_table" style="width:50%;float: left;">
<?php if (count($models)): ?>
        <thead>
            <tr>
                <th>
                    <span>   
                        <span>FISH</span> </span>    <a  style="float:right;text-align: right;" href="" onclick="window.location.reload();"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/reorder.jpg" height="24" alt="Screens" title="Screens" align="absmiddle"></a> <span style="float:right;margin-right: 8%;"> Price </span>    
                </th>

            </tr>
        </thead>
        <tbody>
            <?php
            $inc1 = 1;
            foreach ($models as $model):
                $cond = new CDbCriteria(array('condition' => "product_id = '$model->id'",));
                $screen = Screen_products::model()->find($cond);
               
                $sell_price = $model->sell_price - $model->vat_on_purchase - $model->vat_on_profit;
                if ($inc1 >= 10):
                    ?>
                    <tr>
                        <td>
                            <p style="line-height:65px;margin: 0;border-bottom: 1px dotted #000;background:<?php echo $screen->color; ?>;"> <span style="vertical-align:top;" > <?php echo $model->product_name; ?> </span><span style="float:right;padding-right: 3%;background: #FF0000;color:#FFF;text-align: right;font-weight: bold;width:120px;">&nbsp;  <?php echo '&pound;' . number_format($sell_price, 2); ?></span></p>

                        </td>
                    </tr>
                    <?php
                endif;
                $inc1++;
            endforeach;
        endif;
        ?>
    </tbody>
</table> 

<script src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery-1.8.1.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>

<script type="text/javascript">
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000 * 60 * 20);
</script>
