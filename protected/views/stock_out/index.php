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
		<td id="title"><?php echo CHtml::link('Stock Out', array('add'))?></td>
	</tr>
  </tbody>
</table>

<table id="contents">
	<tbody><tr>
		<td id="commands">
			<div id="new_button">
				<a href="<?php echo Yii::app()->request->baseUrl.'/stock_in/report'; ?>" class="none new">Stock Report</a>
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_out'; ?>" class="none new">Stock Out</a>    
    			<a href="<?php echo Yii::app()->request->baseUrl.'/stock_out/report'; ?>" class="none new">Stock Out Report</a>                  
			</div>
		</td>
		<td style="width: 10px;"></td>        
		<td id="item_table">
			<div id="table_holder">
            
			<table class="tablesorter" id="sortable_table" style="width:100%">
                <?php  if(count($models)): 
					 
				?>
				<tr>
                   <th width="5%" class="leftmost"><input type="checkbox" name="select_all" id="select_all" onclick="checkAll()" /></th>
                    <th width="15%" scope="col">Date</th>
                    <th width="15%" scope="col">Item Code</th>
                    <th width="30%" scope="col">Item Name</th>
                    <th width="10%" scope="col">Qty</th>
                    <th width="15%" scope="col">Reason</th>
                    <th width="10%" scope="col">&nbsp;</th>
				</tr>
                <?php $i=1; foreach($models as $model): 
				      $product_code     = $model->product_code;

					  $q1 = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 

                      $Products       = Product::model()->findAll( $q1 );
					  $product_name = "";  
					  if(count($Products)): foreach($Products as $Products): $product_name = $Products->product_name; endforeach; endif;
				 ?>
				<tr style="font-family:Verdana; font-size:11px;">
					<td><input type="checkbox" name="<?php echo 'checkbox_'.$model->id; ?>" id="<?php echo 'checkbox_'.$model->id; ?>" value="<?php echo $model->id; ?>"  /></td>
					<td><?php echo date('M d, Y', strtotime($model->stock_out_date)); ?></td>
                    <td><?php echo $product_code; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $model->quantity; ?></td>
                    <td><?php echo $model->reason; ?></td>
                    <td style="margin-left:10px;">
					<a onclick="return confirmSubmit()" href="<?php echo Yii::app()->request->baseUrl.'/index.php/stock_out/delete/'.$model->id; ?>" title="Delete"><img src="<?php echo Yii::app()->request->baseUrl.'/public/images/delete.png'; ?>" alt="Delete" title="Delete" border="0" /></a>
                    </td>
				</tr>
                <?php $i = $i + 1; endforeach; endif; ?>
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
