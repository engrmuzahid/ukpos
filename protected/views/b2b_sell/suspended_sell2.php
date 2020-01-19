<script type="text/javascript">
$(document).ready(function()
{
    init_table_sorting();
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
});

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{
			sortList: [[1,0]],
			headers:
			{
				0: { sorter: false},
				3: { sorter: false}
			}
		});
	}
}
</script>


<table id="title_bar">
	<tbody>
    <tr>
		<td id="title_icon">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/giftcards.png" alt="title icon">
		</td>
		<td id="title">Point of Sell</td>
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
			<div id="table_holder">
            
			<table class="tablesorter" id="sortable_table" style="width:100%">
            <?php  if(count($models)): ?>
            <thead>
            <tr>
                <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                <th width="10%">Invoice No</th>
                <th width="20%">Date</th>
                <th width="20%">Cusomer Name</th>
                <th width="10%">Payment By</th>
                <th width="10%">Discount</th>
                <th width="10%">Total Amount</th>
                <th class="rightmost header">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach($models as $posValue): 				
					$customer_type = $posValue->customer_type;
					if($customer_type == "regular"):
						$customer_name = $posValue->customer_name;
					else:
					$customer_id = $posValue->customer_id;
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 					 
                      $customers = Customer::model()->findAll( $q1 );
					if(count($customers)): foreach($customers as $customer): $customer_name = $customer->customer_name; endforeach; else:  $customer_name = ""; endif;
					endif;
             ?>
            <tr>
                <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
					<td><?php echo $posValue->invoice_no; ?></td>
					<td><?php echo date('M d, Y', strtotime($posValue->order_date)); ?></td>
					<td><?php echo $customer_name; ?></td>
                    <td><?php  echo $posValue->payment_mode; ?></td>
                    <td><?php  echo $posValue->discount; ?></td>
                    <td><?php  echo 'TK '.$posValue->amount_grand_total; ?></td>
                    <td width="15%" style="margin-left:10px;">
                     <a href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/view/'.$posValue->invoice_no; ?>" title="Show">Show</a> | 
                    <!-- <a href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/edit/'.$posValue->invoice_no; ?>" class="edit_icon" title="Edit"></a>-->
                     <a  onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/delete/'.$posValue->invoice_no; ?>"  title="Delete">Delete</a>
                    </td>
            </tr>
             <?php endforeach; endif; ?>
           </tbody>
           </table>
          </div>
		</td>
	</tr>
</tbody></table>
<div id="feedback_bar"></div>
</div>
</div>
    <script language="javascript">
    function confirmSubmit() {
    var agree=confirm("Are you sure to delete this record?");
    if (agree)
         return true;
    else
         return false;
    }
    </script>
