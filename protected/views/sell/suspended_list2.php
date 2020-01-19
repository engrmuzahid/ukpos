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
		<td id="title">Suspended Point of Sell List</td>
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
                <th class="leftmost" width="25%">Suspended No</th>
                <th width="15%">Date</th>
                <th width="20%">Cusomer Name</th>
                <th width="15%">Unsuspend</th>
                <th width="15%">Sales Receipt</th>
                <th width="10%" class="rightmost header">Delete</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach($models as $posValue): 				
					$customer_id = $posValue->customer_id;
					$customer_name = "";
					if(!empty($customer_id)): 
					  $q1 = new CDbCriteria( array( 'condition' => "id = '$customer_id'",) ); 					 
                      $customers = Customer::model()->findAll( $q1 );
					if(count($customers)): foreach($customers as $customer): $customer_name = $customer->customer_name; endforeach; else:  $customer_name = ""; endif;
					endif;
             ?>
            <tr>
					<td><?php echo $posValue->id; ?></td>
					<td><?php echo date('M d, Y', strtotime($posValue->order_date)); ?></td>
					<td><?php echo $customer_name; ?></td>
                    <td><a href="<?php echo Yii::app()->request->baseUrl.'/index.php/sell/unsuspend2/'.$posValue->id; ?>" class="buttonGreen" title="Unsuspend">Unsuspend</a></td>
                    <td><a href="<?php echo Yii::app()->request->baseUrl.'/index.php/sell/view_receipt/'.$posValue->id; ?>" target="_blank" class="buttonGreen" title="Receipt">Receipt</a></td>
                    <td><a  onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/sell/delete3/'.$posValue->id; ?>" class="buttonGreen" title="Delete">Delete</a></td>
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
