<?php
  $username = Yii::app()->user->name;
  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
  $Users    = Users::model()->findAll( $cond );
?>
	<table id="menubar_container">

		<tbody><tr id="menubar_navigation">
		    <?php if(count($Users)): foreach($Users as $user): ?>
           
			<td class="menu_item menu_item_home">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/super"><img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/header_logo.png" alt=""></a>
			</td>
			 <?php  if($user->customer_prev == 1): ?>
						<td class="menu_item menu_item_customers">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/customer">Customers</a>
			</td>
			 <?php endif; if($user->item_prev == 1): ?>
						<td class="menu_item menu_item_items">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/product">Items</a>
			</td>
			 <?php endif; if($user->stock_prev == 1): ?>
						<td class="menu_item menu_item_item_kits">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/stock_in/report">Stock</a>
			</td>
			 <?php endif; if($user->supplier_prev == 1): ?>
						<td class="menu_item menu_item_suppliers">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/supplier">Suppliers</a>
			</td>
			 <?php endif; if($user->report_prev == 1): ?>
						<td class="menu_item menu_item_reports">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/sell/report">Reports</a>
			</td>
			 <?php endif; if($user->receiving_prev == 1): ?>
						<td class="menu_item menu_item_receivings">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/purchase/add">Receivings</a>
			</td>
			<?php endif; if($user->sale_prev == 1): ?>
			<td class="menu_item menu_item_sales">
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/b2b_sell/retail">Sell</a>
			</td>
			 <?php endif; if($user->employee_prev == 1): ?>
						<td class="menu_item menu_item_employees">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/user">Employees</a>
			</td>
			 <?php endif; if($user->b2b_prev == 1): ?>
			<td class="menu_item menu_item_config">
				<a href="<?php echo Yii::app()->request->baseUrl.'/b2b_sell/order'; ?>">B2B</a>
			</td>
			 <?php endif; if($user->store_config_prev == 1): ?>
						<td class="menu_item menu_item_giftcards">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/company">Store Config</a>
			</td>
			 <?php endif; endforeach; endif; ?>
		</tr>

	</tbody></table>
