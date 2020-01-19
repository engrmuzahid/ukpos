<style>
    .buttonBlue{
        padding: 0 25px;
    }    
</style>
    <table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">
                
                <?php echo '<a href="' . Yii::app()->request->baseUrl . '/product/screenProduct/'.$product['screen_id'].'">Screens</a>'; ?> → Edit screen item</td>
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

                <?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')) ?>
                <?php //print_r($product); exit(); ?>
                <table style="margin-left:10px;" border="0" cellpadding="0" cellspacing="0">
                    <input type="hidden" name="Product[id]" value="<?php echo $product['id']; ?>" />
                   <tr><td colspan="3">&nbsp;</td></tr>
                   <tr>
                        <th valign="top">Screen name </th>
                        <td>
                            <div>
                                <select name="Product[screen_id]" style="width:200px;height:25px;border:1px solid #CCC;">
                                    <option value="0">None</option>
                                    <?php foreach ($screens as $screen): ?>
                                    <option <?php echo $screen['id']== $product['screen_id']?"selected":""; ?> value="<?php echo $screen['id']; ?>"><?php echo $screen['name']; ?></option>                   
                                    <?php endforeach; ?>
                                </select>  
                            </div>
                        </td>
                    </tr>
                    
                    
        <tr><td colspan="3">&nbsp;</td></tr>
        
         <tr>
        <th valign="top">Colour  </th>
        <td>
            <div>
                <select name="Product[color]" id="color_change" style="width:200px;height:25px;border:1px solid #CCC;">
                    <option <?php echo $product['color'] =="#337ab7"?"selected":""; ?>  value="#337ab7">Primary</option>                   
                     <option <?php echo $product['color'] =="#449d44"?"selected":""; ?>   value="#449d44">Success</option>                   
                     <option <?php echo $product['color'] =="#31b0d5"?"selected":""; ?>   value="#31b0d5">Info</option>                   
                     <option <?php echo $product['color'] =="#ec971f"?"selected":""; ?>   value="#ec971f">Warning</option>                   
                     <option <?php echo $product['color'] =="#c9302c"?"selected":""; ?>   value="#c9302c">Danger</option>                   
                     <option <?php echo $product['color'] =="#EDEDED"?"selected":""; ?>   value="#EDEDED">Gray</option>                                    

                </select>  
            </div>
        </td>
        <td>
           <div style="width:100px;min-height: 100px;background:<?php echo $product['color']; ?>;margin: -50px 0 -50px 100px;" id="color_code">&nbsp;</div>
        </td>
    </tr>

    <tr><td colspan="3">&nbsp;</td></tr>
      <tr>
        <th valign="top">Sort order  </th>
        <td>
            <div>
                <input type="text" name="Product[sort_order]"  value="<?php echo $product['sort_order']; ?>" style="width:190px;height:25px;border:1px solid #CCC;padding-left: 10px;"/>
                   
            </div>
        </td>
        <td>
           &nbsp;
        </td>
    </tr>

                    <tr><td colspan="3">&nbsp;</td></tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td valign="top">
                            <?php echo CHtml::submitButton('Save', array('class' => 'buttonBlue')); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr><td colspan="3">&nbsp;</td></tr>
                </table>
                <?php echo CHtml::endForm() ?>




            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>


<script type="text/javascript">

    $(document).ready(function ()
    {
   
    $("#color_change").live("change",function(e){
        e.preventDefault();
        $("#color_code").css("background",$(this).val());
    });
   
    });

   



</script>