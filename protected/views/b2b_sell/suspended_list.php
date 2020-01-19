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
		<td id="title">
                    Suspended B2B Sell List
                    
                    <div style="float: right">
                        <select name="suspend_date" style="height: 30px; min-width: 150px" id="filter_day">
                            <option value="">Suspend Day</option>
                            <option value="MON" <?php echo $filter_day == 'MON' ? 'selected' : '' ?>>Monday</option>
                            <option value="TUE" <?php echo $filter_day == 'TUE' ? 'selected' : '' ?>>Tuesday</option>
                            <option value="WED" <?php echo $filter_day == 'WED' ? 'selected' : '' ?>>Wednesday</option>
                            <option value="THU" <?php echo $filter_day == 'THU' ? 'selected' : '' ?>>Thursday</option>
                            <option value="FRI" <?php echo $filter_day == 'FRI' ? 'selected' : '' ?>>Friday</option>
                            <option value="SAT" <?php echo $filter_day == 'SAT' ? 'selected' : '' ?>>Saturday</option>
                            <option value="SUN" <?php echo $filter_day == 'SUN' ? 'selected' : '' ?>>Sunday</option>
                        </select>
                    </div>
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
                    <td><a href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/unsuspend/'.$posValue->id; ?>" class="buttonGreen" title="Unsuspend">Unsuspend</a></td>
                    <td><a href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/view_receipt/'.$posValue->id; ?>" target="_blank" class="buttonGreen" title="Receipt">Receipt</a></td>
                    <td><a  onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/b2b_sell/delete3/'.$posValue->id; ?>" class="buttonGreen" title="Delete">Delete</a></td>
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
    
    $(document).ready(function(){
        $("#filter_day").change(function(e){
            if($(this).val() != "")
                location = '<?php echo Yii::app()->baseUrl ?>/b2b_sell/suspended/?filter_day='+$(this).val();
            else location = '<?php echo Yii::app()->baseUrl ?>/b2b_sell/suspended/';
        });
    });
    </script>
