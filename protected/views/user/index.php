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
		<td id="title"><?php echo CHtml::link('Users', array('index'))?></td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		 <td id="commands">
          	<?php $this->renderPartial('/company/_menu') ?>
            </td>
           
		<td style="width: 10px;"></td>        
		<td id="item_table">
			  <?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
                <div class="message">
                    <?php echo Yii::app()->user->getFlash('saveMessage'); ?>
                </div>
             <?php endif; ?> 
			<div id="table_holder">
            
			<table class="tablesorter" id="sortable_table">
            <?php  if(count($models)): ?>
            <thead>
            <tr>
                <th class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                <th>Full Name</th>
                <th>Station</th>
                <th>User Id</th>
                <th>Email Address</th>
                <th>Privileges</th>
                <th class="rightmost header">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach($models as $model):
				      $station_id = $model->station_id;
				     $prev = "";
					  $customer_prev      = $model->customer_prev;
				      $item_prev          = $model->item_prev;
				      $stock_prev         = $model->stock_prev;
				      $supplier_prev      = $model->supplier_prev;
				      $report_prev        = $model->report_prev;
				      $receiving_prev     = $model->receiving_prev;
				      $sale_prev          = $model->sale_prev;
				      $employee_prev      = $model->employee_prev;
					  $accounts_prev      = $model->accounts_prev;
				      $store_config_prev  = $model->store_config_prev;
					  $bank_prev          = $model->bank_prev;
                      $b2b_prev           = $model->b2b_prev;

                       if(!empty($prev) && $customer_prev == 1 ): $prev .= ", Customer "; elseif(empty($prev) && $customer_prev == 1 ): $prev .= " Customer "; endif; 
                       if(!empty($prev) && $item_prev == 1 ): $prev .= ", Item "; elseif(empty($prev) && $item_prev == 1 ): $prev .= " Item "; endif; 
					   if(!empty($prev) && $stock_prev == 1): $prev .= ", Stock "; elseif(empty($prev) && $stock_prev == 1): $prev .= " Stock "; endif;
                       if(!empty($prev) && $supplier_prev == 1 ): $prev .= ", Supplier "; elseif(empty($prev) && $supplier_prev == 1 ): $prev .= " Supplier "; endif; 
					   if(!empty($prev) && $report_prev == 1): $prev .= ", Reports "; elseif(empty($prev) && $report_prev == 1): $prev .= " Reports "; endif;
					   if(!empty($prev) && $receiving_prev == 1): $prev .= ", Receivings "; elseif(empty($prev) && $receiving_prev == 1): $prev .= " Receivings "; endif;
                       if(!empty($prev) && $sale_prev == 1 ): $prev .= ", Sales "; elseif(empty($prev) && $sale_prev == 1 ): $prev .= " Sales "; endif; 
					   if(!empty($prev) && $employee_prev == 1): $prev .= ", Employee  "; elseif(empty($prev) && $employee_prev == 1): $prev .= " Employee "; endif;
					   if(!empty($prev) && $accounts_prev == 1): $prev .= ", Accounts "; elseif(empty($prev) && $accounts_prev == 1): $prev .= " Accounts "; endif;
					   if(!empty($prev) && $store_config_prev == 1): $prev .= ", Store Config  "; elseif(empty($prev) && $store_config_prev == 1): $prev .= " Store Config "; endif;
					   if(!empty($prev) && $bank_prev == 1): $prev .= ", Bank "; elseif(empty($prev) && $bank_prev == 1): $prev .= " Bank "; endif;
					   if(!empty($prev) && $b2b_prev == 1): $prev .= ", B2B "; elseif(empty($prev) && $b2b_prev == 1): $prev .= " B2B "; endif;

					  $q1 = new CDbCriteria( array( 'condition' => "id = '$station_id'",) );					 
					  $Stations       = Station::model()->findAll( $q1 );

			 ?>
            <tr>
                <td width="5%"><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
                	<td><?php echo ucwords($model->full_name); ?></td>
                    <td><?php if(count($Stations)): foreach($Stations as $Station): echo $Station->station_name; endforeach; endif; ?></td>
                    <td><?php echo $model->username; ?></td>
                    <td><?php echo $model->email; ?></td>
                    <td><?php echo $prev; ?></td>
                    
                    <td width="10%" style="margin-left:10px;">
					<a href="<?php echo Yii::app()->request->baseUrl.'/user/edit/'.$model->id; ?>" title="Edit"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/edit.png'; ?>" alt="Edit" title="Edit" border="0" /></a> |
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/user/delete/'.$model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a>
					</td>
            </tr>
             <?php endforeach; endif; ?>
           </tbody>
           </table>
          </div>
		  <div id="pagination"><?php $this->widget('CLinkPager', array('pages' => $pages,)); ?></div>
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

