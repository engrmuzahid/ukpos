<?php
  $username = Yii::app()->user->name;
  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
  $Users    = Users::model()->findAll( $cond );
?>

<h3>Welcome to POS Admin Panel, click a module below to get started!</h3>
<?php if(Yii::app()->user->hasFlash('saveMessage')): ?>
<div class="message">
	<?php echo Yii::app()->user->getFlash('saveMessage'); ?>
</div>
<?php endif; ?>   

<div id="home_module_list">
   <?php if(count($Users)): foreach($Users as $user): ?>
	 <?php  if($user->customer_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/customer">
			<img src = "<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/customers.png" alt="Menubar Image" border="0">
			<span>Customers</span>
		</a>
		- <span>Add, Update, Delete, and Search customers</span>
	</div>
            
	 <?php endif; if($user->item_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/product">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/items.png" alt="Menubar Image" border="0">
			<span>Items</span>
		</a>
		- <span>Add, Update, Delete, and Search items</span>
	</div>
	 <?php endif; if($user->supplier_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/supplier">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/suppliers.png" alt="Menubar Image" border="0">
			<span>Suppliers</span>
		</a>
		- <span>Add, Update, Delete, and Search suppliers</span>
	</div>
	 <?php endif; if($user->report_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/sell/report">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/reports.png" alt="Menubar Image" border="0">
			<span>Reports</span>
		</a>
		- <span>View and generate reports</span>
	</div>
	 <?php endif; if($user->receiving_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/purchase/add">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/receivings.png" alt="Menubar Image" border="0">
			<span>Receivings</span>
		</a>
		- <span>Process Purchase orders</span>
	</div>
	 <?php endif; if($user->sale_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/b2b_sell/retail">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/sales.png" alt="Menubar Image" border="0">
			<span>Sales</span>
		</a>
		- <span>Process sales and returns</span>
	</div>
	 <?php endif; if($user->employee_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/customer/receiable_report_pre">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/employees.png" alt="Menubar Image" border="0">
			<span>Receivable Report</span>
		</a>
		- <span>For Previous Customer</span>
	</div>
	 <?php endif; if($user->store_config_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/company">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/config.png" alt="Menubar Image" border="0">
			<span>Store Config</span>
		</a>
		- <span>Change the store's configuration</span>
	</div>
	 <?php endif; if($user->stock_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/stock_in/report">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/icons/stock.png" alt="Menubar Image" border="0">
			<span>Stock</span>
		</a>
		- <span>Stock Management</span>
	</div>
	 <?php endif; if($user->b2b_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl.'/online_order'; ?>">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/online_order.png" alt="Online order Image" border="0">
			
			<span>Online Orders</span>
		</a>
		- <span>Online Order Management</span>		
	</div>
    
        <div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl.'/b2b_sell/sell'; ?>">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/old_b2b.png" alt="Menubar Image" border="0">
			<span>OLD Sell</span>
		</a>
		- <span>Old Sell</span>		
	</div>
    
        <?php endif; if($user->sale_prev == 1): ?>
		<div class="module_item">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/sell/add">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/public/images/old_sell.png" alt="Menubar Image" border="0">
			<span>Sales</span>
		</a>
		- <span>Old Sales</span>
	</div>
        
	<?php endif; endforeach; endif; ?>
</div>
