
<?php
if (count($models)): foreach ($models as $model):


    endforeach;
endif;
?>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Customer Details</td>
        </tr>
    </tbody>
</table>
<table id="contents">
    <tbody><tr>
            <td colspan="3">
                <table border="0"  width="90%" style="margin:0px 30px 0px 30px;" cellpadding="0" cellspacing="0">
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr>
                        <td rowspan="6" > <?php if (!empty($model->customer_photo)): ?> <img src="<?php echo Yii::app()->request->baseUrl . '/public/photos/customer/' . $model->customer_photo; ?>" style="padding:5px; border:1px solid #ccc;" width="150" /> <?php endif; ?>
                        </td>

                    </tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Customer Name"; ?></strong></td>
                        <td valign="top"> <?php echo $model->customer_name; ?></td>
                        <td>&nbsp; </td>
                        <td valign="top"><strong><?php echo "Mobile Number"; ?></strong></td>
                        <td valign="top"> <?php echo $model->contact_no1; ?></td>
                        <td>&nbsp; </td>
                    </tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Email Address"; ?></strong></td>
                        <td valign="top"> <?php echo $model->email_address; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "Phone Number"; ?></strong></td>
                        <td valign="top"> <?php echo $model->contact_no2; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Address"; ?></strong></td>
                        <td> <?php echo $model->business_street1; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "City"; ?></strong></td>
                        <td> <?php echo $model->business_city; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Post Code"; ?></strong></td>
                        <td> <?php echo $model->business_post_code; ?></td>
                        <td>&nbsp;</td>

                    </tr>

                </table>
            </td>
        </tr>
    </tbody></table>
<div id="feedback_bar"></div>
</div>
