
<?php if (count($models)): foreach ($models as $model):


    endforeach;
endif;
?>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">Customer Details <span id="printCustomer" data-id="<?php echo $model->id; ?>" style="float: right;cursor: pointer;"> <img  src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print Customer" title="Print Customer"  /></span></td>
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
                        <td valign="top"><strong><?php echo "Business Name"; ?></strong></td>
                        <td valign="top"> <?php echo $model->business_name; ?></td>
                        <td>&nbsp; </td>
                        <td valign="top"><strong><?php echo "Customer Name"; ?></strong></td>
                        <td valign="top"> <?php echo $model->customer_name; ?></td>
                        <td>&nbsp; </td>
                    </tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Email Address"; ?></strong></td>
                        <td valign="top"> <?php echo $model->email_address; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "Mobile Number"; ?></strong></td>
                        <td valign="top"> <?php echo $model->contact_no1; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Business Tel"; ?></strong></td>
                        <td valign="top"> <?php echo $model->contact_no2; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "Birth Day"; ?></strong></td>
                        <td valign="top"> <?php echo date("d M, Y", strtotime($model->birthday)); ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Comment"; ?></strong></td>
                        <td valign="top" colspan="5"> <?php echo $model->comment; ?></td>
                    </tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Joining Date"; ?></strong></td>
                        <td valign="top"> <?php echo date("d M, Y", strtotime($model->joining_date)); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "Username"; ?></strong></td>
                        <td valign="top"> <?php echo $model->username; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr><td width="97%" colspan="6" bgcolor="#999999"><strong>&nbsp;&nbsp;Business Address</strong></td></tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Street Address1"; ?></strong></td>
                        <td> <?php echo $model->business_street1; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "Street Address2"; ?><span class="markcolor"></span></strong></td>
                        <td> <?php echo $model->business_street2; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr>
                        <td valign="top"><strong><?php echo "City"; ?></strong></td>
                        <td> <?php echo $model->business_city; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "State"; ?></strong></td>
                        <td> <?php echo $model->business_state; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Post Code"; ?></strong></td>
                        <td> <?php echo $model->business_post_code; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "Country"; ?></strong></td>
                        <td> <?php echo $model->business_country; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr><td colspan="6" bgcolor="#999999"><strong>&nbsp;&nbsp;Home Address</strong></td></tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Street Address1"; ?></strong></td>
                        <td> <?php echo $model->home_street1; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "Street Address2"; ?><span class="markcolor"></span></strong></td>
                        <td> <?php echo $model->home_street2; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr>
                        <td valign="top"><strong><?php echo "City"; ?></strong></td>
                        <td> <?php echo $model->home_city; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "County"; ?></strong></td>
                        <td> <?php echo $model->home_state; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                    <tr>
                        <td valign="top"><strong><?php echo "Post Code"; ?></strong></td>
                        <td> <?php echo $model->home_post_code; ?></td>
                        <td>&nbsp;</td>
                        <td valign="top"><strong><?php echo "Country"; ?></strong></td>
                        <td> <?php echo $model->home_country; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr><td colspan="6">&nbsp;</td></tr>
                </table>
            </td>
        </tr>
    </tbody></table>
<div id="printCustomerDiv"></div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/jquery.jqprint.0.3.js"></script>
<script>

    $(document).ready(function () {
        $("#printCustomer").die('click').live('click', function (e) {
            var CusId = $(this).attr("data-id");
            $.post('<?php echo Yii::app()->request->baseUrl . "/customer/printCustomer" ?>', {'cusID': CusId}, function (resp) {
                $('#printCustomerDiv').html(resp);
                $("#printCustomerDiv").jqprint();
                $("#printCustomerDiv").empty();

            });

        });

    });
</script>
