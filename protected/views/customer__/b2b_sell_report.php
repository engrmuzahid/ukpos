<script type="text/javascript">
    $(function () {
        $("#print_button2").click(function () {
            $("#ptable3").jqprint();
        });
    });

function checkAll()
{
	//Keep track of enable_select_all has been called
	if(!enable_select_all.enabled)
		enable_select_all.enabled=true;

	$('#select_all').click(function()
	{
		if($(this).attr('checked'))
		{	
			$("#sortable_table tbody :checkbox").each(function()
			{
				$(this).attr('checked',true);
				$(this).parent().parent().find("td").addClass('selected').css("backgroundColor","");

			});
		}
		else
		{
			$("#sortable_table tbody :checkbox").each(function()
			{
				$(this).attr('checked',false);
				$(this).parent().parent().find("td").removeClass('selected');				
			});    	
		}
	 });	
}
//    $(document).ready(function ()
//    {
//        init_table_sorting();
//        enable_select_all();
//        enable_checkboxes();
//        enable_row_selection();
//    });

    function init_table_sorting()
    {
        //Only init if there is more than one row
        if ($('.tablesorter tbody tr').length > 1)
        {
            $("#sortable_table").tablesorter(
                    {
                        sortList: [[1, 0]],
                        headers:
                                {
                                    0: {sorter: false},
                                    3: {sorter: false}
                                }
                    });
        }
    }

    function MyReport()
    {
        var oForm = document.frm_soft;
        oForm.action = "<?php echo Yii::app()->request->baseUrl . '/customer/b2b_list'; ?>";
        oForm.post = "post";
        oForm.submit();
    }

    function printIframe(data, copies)
    {
        if ($('iframe#printf').size() != 0) {
            $('iframe#printf').remove();
        }

        var iframe = document.createElement('iframe');
        iframe.id = 'printf';
        var html = '<html><head><title></title><style>@page {margin: 0} </style><style type="text/css" media="print"> @page { size: landscape; }</style>'  // Your styles here, I needed the margins set up like this
                + '</head><body><div>'
                + data
                + '</div></body></html>';
        document.body.appendChild(iframe);
        iframe.contentWindow.document.open();
        iframe.contentWindow.document.write(html);
        iframe.contentWindow.document.close();


        for (var i = 0; i < parseInt(copies); i++) {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        }

        return true;
    }

    function driverReport()
    {
        var oForm = document.frm_soft;
        oForm.action = "<?php echo Yii::app()->request->baseUrl . '/customer/delivery_report'; ?>";
        oForm.post = "post";
        oForm.submit();

    }

    $("#printReport").live('click', function (e) {
        e.preventDefault();

        var data = $("#reportfrm").serialize();
        var url = '<?php echo Yii::app()->request->baseUrl . '/customer/delivery_report'; ?>';
        $.post(url, data, function (resp) {
            printIframe(resp,1); 
        });

    });


</script>

<style type="text/css">
    .select_field{
        width: 160px;
        height: 35px;
        font-size: 17px;
        line-height: 25px;
        border: 1px solid #ededed;
        margin-top: 10px;
        margin-bottom: 10px;

    }
</style>
<table id="title_bar">
    <tbody>
        <tr>
            <td id="title_icon">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
            </td>
            <td id="title">B2B Delivery Note</td>
            <td></td>
        </tr>
    </tbody>
</table>

<table id="contents">
    <tbody><tr>
            <td id="commands">
                <?php $this->renderPartial('/b2b_sell/_menu') ?>
            </td>
            <td style="width: 10px;"></td>        
            <td id="item_table">

                <p align="right" style="margin-right:40px;margin-bottom: -40px;">
                    <input type="image" id="print_button2" src="<?php echo Yii::app()->request->baseUrl . '/public/images/print.png'; ?>" alt="print report" title="Print Report"  />
               </p>
                <p>
                    <a href="#" onclick="return MyReport()"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/reports.png" alt="Generate Report" title="Generate Report" align="absmiddle"></a>
                       </p>
                <?php echo CHtml::beginForm('', 'post', array('name' => 'frm_soft', 'id' => 'reportfrm', 'enctype' => 'multipart/form-data')); ?>

                <div style="height: 60px; background: #777;margin-bottom: 20px;width: 100%">
                    Driver :
                    <select class="select_field" name="driver_id" id="driver_name">
                        <?php foreach ($drivers as $driver): ?>
                            <option value="<?php echo $driver->id; ?>"><?php echo $driver->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    Car Model:
                    <select class="select_field"  name="car_id" id="car_id">
                        <?php foreach ($cars as $car): ?>
                            <option value="<?php echo $car->id; ?>"><?php echo $car->reg_no; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a class="select_field buttonBlue" style="padding: 8px;cursor: pointer;" id="printReport"> Driver Sheet </a>
                    
                    &nbsp;&nbsp;&nbsp;<a style="background: #0066cc;color: #FFF;padding: 5px 8px;" href="<?php echo Yii::app()->request->baseUrl . '/driver/add'; ?>"><img height="12" src="<?php echo Yii::app()->request->baseUrl . '/public/images/icon_add.png'; ?>" alt="add" title="add " border="0" />  Driver</a>
            
                    &nbsp;&nbsp;&nbsp;<a style="background: #579ED2;color: #FFF;margin-left: -14px;padding: 6px 8px;" href="<?php echo Yii::app()->request->baseUrl . '/car/add'; ?>"><img height="12" src="<?php echo Yii::app()->request->baseUrl . '/public/images/icon_add.png'; ?>" alt="add" title="add " border="0" />  Van</a>
            

                </div>
                <div id="ptable3">
                    <div id="table_holder">
                        <!--  start product-table ..................................................................................... -->
                        <?php echo CHtml::beginForm('', 'post', array('name' => 'frm_soft', 'enctype' => 'multipart/form-data')); ?>
                        <table class="tablesorter" id="sortable_table" style="width:100%">
                            <?php if (count($model)): ?>
                                <tr>
                                    <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                                    <th>Date</th>
                                    <th>Invoice No</th>
                                    <th>Customer Name</th>
                                    <th>Amount(&pound;)</th>
                                    <th>Discount(&pound;)</th>
                                    <th>Vat(&pound;)</th>
                                    <th>Amount Total(&pound;)</th>
                                    <th>&nbsp;</th>
                                </tr>
                                <?php
                                $i = 1;
                                $grand_total = 0;
                                $amount_sub = 0;
                                $discount_sub = 0;
                                $vat_sub = 0;
                                foreach ($model as $posValue):
                                    $customer_id = $posValue->customer_id;
                                    $customer_name = "";
                                    if (!empty($customer_id)):
                                        $q1 = new CDbCriteria(array('condition' => "id = '$customer_id'",));
                                        $customers = Customer::model()->findAll($q1);
                                        if (count($customers)): foreach ($customers as $customer): $customer_name = $customer->customer_name;
                                            endforeach;
                                        endif;
                                    endif;
                                    $print_status = $posValue->print_status;
                                    if ($print_status != 1): $style = "style = 'font-family:Verdana; font-size:11px;'";
                                    else: $style = "style = 'font-family:Verdana; font-size:11px; background-color:#F47F7F;'";
                                    endif;
                                    ?>
                                    <tr <?php echo $style; ?>>
                                        <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_' . $posValue->invoice_no; ?>" id="<?php echo 'checkbox_' . $posValue->invoice_no; ?>" value="<?php echo $posValue->invoice_no; ?>"  /></td>
                                        <td><?php echo date('d M, Y', strtotime($posValue->order_date)); ?></td>
                                        <td><?php echo $posValue->invoice_no; ?></td>
                                        <td><strong><?php echo ucwords($customer_name); ?></strong></td>
                                        <td><strong><?php echo number_format($posValue->amount_sub_total, 2); ?></strong></td>
                                        <td><strong><?php
                                                $discount = ($posValue->amount_sub_total * $posValue->discount_ratio) / 100;
                                                echo number_format($discount, 2);
                                                ?></strong></td>
                                        <td><strong><?php echo number_format($posValue->vat_total, 2); ?></strong></td>
                                        <td><strong><?php echo number_format($posValue->amount_grand_total, 2); ?></strong></td>
                                        <td width="10%" style="margin-left:10px;">
                                            <a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl . '/index.php/sell/delete/' . $posValue->invoice_no; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a> | 
                                            <a target="_blank" href="<?php echo Yii::app()->request->baseUrl . '/index.php/sell/view/' . $posValue->invoice_no; ?>" title="Show"><img src="<?php echo Yii::app()->request->baseUrl . '/public/images/view.png'; ?>" alt="Show" title="Show" border="0" /></a>
                                        </td>
                                    </tr>

                                    <?php
                                    $i = $i + 1;
                                    $amount_sub = $amount_sub + $posValue->amount_sub_total;
                                    $discount_sub = $discount_sub + $discount;
                                    $vat_sub = $vat_sub + $posValue->vat_total;
                                    $grand_total = $grand_total + $posValue->amount_grand_total;
                                endforeach;
                                ?>
                                <tr>
                                    <td colspan="4" align="right"><strong>Total (&pound;) :&nbsp;&nbsp;<strong></td>
                                                <td align="left"><strong><?php echo number_format($amount_sub, 2); ?></strong></td>
                                                <td align="left"><strong><?php echo number_format($discount_sub, 2); ?></strong></td>
                                                <td align="left"><strong><?php echo number_format($vat_sub, 2); ?></strong></td>
                                                <td align="left"><strong><?php echo number_format($grand_total, 2); ?></strong></td>
                                                <td>&nbsp;</td>
                                                </tr>

                                            <?php else:
                                                ?>
                                                <tr><div id="message-red"><td colspan="8" class="red-left">No Sell Available Yet .. </td></div></tr>
                                            <?php endif; ?>
                                            </table> 
                                            <?php echo CHtml::endForm() ?>
                                            </div>




                                            </td>
                                            </tr>
                                            </tbody></table>
                                            <div id="feedback_bar"></div>
                                            </div>
                                            </div>

                                            <script language="javascript">
                                                function confirmSubmit() {
                                                    var agree = confirm("Are you sure to delete this record?");
                                                    if (agree)
                                                        return true;
                                                    else
                                                        return false;
                                                }
                                            </script>
