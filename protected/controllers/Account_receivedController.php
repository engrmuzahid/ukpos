<?php
class Account_ReceivedController extends CController
{
	public $layout='backend';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	

	public function actionIndex()
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;
		
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:

		$criteria = new CDbCriteria();
		
		$count = Account_Received::model()->count($criteria);
		$pages = new CPagination($count);
		// elements per page
		$pages->pageSize = 50;
		$pages->applyLimit($criteria);
		
		$criteria->order = 'id DESC';
		$models = Account_Received::model()->findAll($criteria);
		$this->render('index', array('models' => $models, 'pages' => $pages,));
	
	endif;
	}
	
	public function actionHome()
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;
		
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:

		$criteria = new CDbCriteria();
		
		$cashmodels = Cash_In_Hand::model()->findAll();		
		$this->render('home', array('cashmodels' => $cashmodels));
	
	endif;
	}
	
	public function actionAdd()
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	    $username   = Yii::app()->user->name;
		
		if($_POST['invoice_no'] && empty($_POST['customer_id']))
		 {	
		  
		    $invoice_no = $_POST['invoice_no'];
			$criteria = new CDbCriteria();
			$criteria->condition = "invoice_no = '$invoice_no'";
			$criteria->order = 'id DESC';
			$model  = Sell::model()->findAll($criteria);
			$model2 = Sell_Product::model()->findAll($criteria);
    		$this->render('add', array('model' => $model, 'model2' => $model2,));
	     }		  
		  elseif (!empty($_POST) && !empty($_POST['customer_id'])) {
				
				$user_id = Yii::app()->user->name;
				$invoice_no         = $_POST['invoice_no'];
				$customer_id        =  $_POST['customer_id'];
				$receive_date       =  $_POST['receive_date'];
				$receive_mode       =  $_POST['receive_mode'];
				$r_bank_name        =  $_POST['r_bank_name'];
				$r_cheque_no        =  $_POST['r_cheque_no'];
				$r_cheque_date      =  $_POST['r_cheque_date'];
				$d_bank_id          =  $_POST['d_bank_id'];
				$d_account_no       =  $_POST['d_account_no'];
				$amount             =  $_POST['amount'];
				
				$amount_grand_total =  $_POST['amount_grand_total'];
				$paid_amount        =  $_POST['paid_amount'];
				$paid_total         =  $paid_amount + $amount;
				if($paid_total      == $amount_grand_total): $status = "paid"; else: $status = "due"; endif;
			    $created            = date('Y-m-d', time());

				if($receive_mode == 'cash'):				 
					 $criteria2 = new CDbCriteria();
					 $criteria2->order = 'id DESC';
					 $criteria2->limit = 1;
					 $cash_values = Cash_In_Hand::model()->findAll($criteria2);					 
                     if(count($cash_values)):
						 foreach($cash_values as $cash_value): $cash_amount = $cash_value->amount; $cash_id = $cash_value->id; endforeach;
						  $command = Yii::app()->db->createCommand();
						  $command->update('cash_in_hand', array( 'amount' => $cash_amount + $amount,), "id = '$cash_id'");
					  else:
						  $command = Yii::app()->db->createCommand();
						  $command->insert('cash_in_hand', array('amount' => $amount));
					  endif;
					  
					     $command->insert('cash_in_hand_transaction', array(
									'transaction_date' => 	$receive_date,
									'status'           => 	'debit',
									'amount'           => 	$amount,
						          ));

					elseif($receive_mode == 'bank'):
					$cond1 = "bank_id = '$d_bank_id' && account_no = '$d_account_no'";
	
					 $criteria2 = new CDbCriteria();
					 $criteria2->condition = $cond1;
					 $criteria2->order = 'id DESC';
					 $criteria2->limit = 1;
					 $bank_values = Cash_In_Bank::model()->findAll($criteria2);
					
					 if(count($bank_values)):
						  foreach($bank_values as $bank_value): $bank_amount = $bank_value->balance; endforeach;
						  $command = Yii::app()->db->createCommand();
						  $command->update('cash_in_bank', array( 'balance' => $bank_amount + $amount,), $cond1);
					  else:
						  $command = Yii::app()->db->createCommand();
						  $command->insert('cash_in_bank', array( 'bank_id' => $d_bank_id, 'account_no' => $d_account_no, 'balance' => $amount));
					  endif;
					   
					     $command->insert('cash_in_bank_transaction', array(
									'transaction_date' => 	$receive_date,
									'bank_id'          => 	$d_bank_id,
									'account_no'       => 	$d_account_no,
									'status'           => 	'debit',
									'amount'           => 	$amount,
						          ));
				   endif;
				 
				  $command = Yii::app()->db->createCommand();
				    $cond = "invoice_no = '$invoice_no'";
					
					$command->insert('account_receive', array(
									'invoice_no' 	       => 	$invoice_no,
									'customer_id'          =>   $customer_id,
									'receive_date'         => 	$receive_date,
									'receive_mode'         => 	$receive_mode,
									'r_bank_name'          => 	$r_bank_name,
									'r_cheque_no'          => 	$r_cheque_no,
									'r_cheque_date'        => 	$r_cheque_date,
									'd_bank_id'            => 	$d_bank_id,
									'd_account_no'         => 	$d_account_no,
									'amount'               => 	$amount,
									'created'              =>   $created					
								));
				  $command->update('sell_order', array( 'paid_amount' => $paid_total, 'status' => $status,), $cond);
								
				Yii::app()->user->setFlash('saveMessage','Payment Received Successfully....<a href="'.Yii::app()->request->baseUrl.'/account_received/add">Receive Payment Again</a> &nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/account_received">View All</a>');
				$this->refresh();
			   }	
			 else {
				   $this->render('add', array('model' => $model,));
				   }		 
     endif;		
	}

	public function actionEdit($id){
	  
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:	

		$model = Account_Received::model()->findByPk($id);
		if(!$model)
		throw new CHttpException(404);
		$data = Yii::app()->request->getPost('Account_Received');
		if($data)
		{
		$model->setAttributes($data);

		if($model->save()){	
			
			Yii::app()->user->setFlash('saveMessage','Stock in Information Modified Successfully...&nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/index.php/stock_in">View All</a>');
			$this->refresh();
		   }	
		}
		$this->render('edit', array('model' => $model,));
	endif;	
	}
	
	public function actionDelete($id){
	
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:	
		$model  = Account_Received::model()->findByPk($id);
		$model->delete(); 
		$this->redirect(array('account_received/index'));
	endif;	
	}
  

  public function actionReceiable_Report()
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	
		$model = new Account_Received();
		
		if($_POST)
		{
         $customer_id      = $_POST['customer_id'];
         $start_date       = $_POST['start_date'];
         $end_date         = $_POST['end_date'];
		 $cond = "status = 'due'";	
	    
		if(!empty($start_date) && !empty($end_date)): $cond .= " && order_date >= '$start_date' && order_date <= '$end_date'"; elseif(!empty($start_date) && empty($end_date)): $cond .= "order_date = '$start_date'"; endif; 
	    if(!empty($customer_id)): $cond .= " && customer_id = '$customer_id'"; endif; 
			  
			  $cond2     = new CDbCriteria( array( 'condition' => $cond,) ); 					 
			  $model     = Sell::model()->findAll( $cond2 );
		 $this->render('account_receiable_report', array('model' => $model,));
		}
		else{ 
		$this->render('account_receiable_report_form', array('model' => $model,));
		}
     endif;		
   }
 
  public function actionReceived_Report()
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	
		$model = new Account_Received();
		
		if($_POST)
		{
         $customer_id      = $_POST['customer_id'];
         $start_date       = $_POST['start_date'];
         $end_date         = $_POST['end_date'];
		 $cond = '';	
	    
		if(!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && receive_date >= '$start_date' && receive_date <= '$end_date'"; elseif(empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " receive_date >= '$start_date' && receive_date <= '$end_date'"; endif;
		if(!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && receive_date = '$start_date'"; elseif(empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " receive_date = '$start_date'";  endif; 
	    if(!empty($cond) && !empty($customer_id)): $cond .= " && customer_id = '$customer_id'"; elseif(empty($cond) && !empty($customer_id)): $cond .= " customer_id = '$customer_id'"; endif; 

			  $cond2     = new CDbCriteria( array( 'condition' => $cond,) ); 					 
			  $model     = Account_Received::model()->findAll( $cond2 );
		 $this->render('account_received_report', array('model' => $model,));
		}
		else{ 
		$this->render('account_received_report_form', array('model' => $model,));
		}
     endif;		
   }
 
  public function actionCashTrans_Report()
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
		$model = new Cash_In_Hands();
		
		if($_POST)
		{
         $status           = $_POST['status'];
         $start_date       = $_POST['start_date'];
         $end_date         = $_POST['end_date'];
		 $cond = '';	
	
			if(!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && transaction_date >= '$start_date' && transaction_date <= '$end_date'"; elseif(empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " transaction_date >= '$start_date' && transaction_date <= '$end_date'"; endif;
			if(!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && transaction_date = '$start_date'"; elseif(empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " transaction_date = '$start_date'";  endif; 
			if(!empty($cond) && !empty($status)): $cond .= " && status = '$status'"; elseif(empty($cond) && !empty($status)): $cond .= " status = '$status'"; endif; 
	
		   $cond2     = new CDbCriteria( array( 'condition' => $cond,) ); 					 
		   $model     = Cash_In_Hands::model()->findAll( $cond2 );
		   $this->render('cash_transaction_report', array('model' => $model,));
		}
		else{ 
		$this->render('cash_transaction_report_form', array('model' => $model,));
		}
     endif;		
   }
 
  public function actionBankTrans_Report()
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	
		$model = new Cash_In_Banks();
		
		if($_POST)
		{
         $status           = $_POST['status'];
         $start_date       = $_POST['start_date'];
         $end_date         = $_POST['end_date'];
         $bank_id          = $_POST['d_bank_id'];
         $account_no       = $_POST['d_account_no'];
		 
		 $cond = '';	
	
			if(!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && transaction_date >= '$start_date' && transaction_date <= '$end_date'"; elseif(empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " transaction_date >= '$start_date' && transaction_date <= '$end_date'"; endif;
			if(!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && transaction_date = '$start_date'"; elseif(empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " transaction_date = '$start_date'";  endif; 
			if(!empty($cond) && !empty($status)): $cond .= " && status = '$status'"; elseif(empty($cond) && !empty($status)): $cond .= " status = '$status'"; endif; 
			if(!empty($cond) && !empty($bank_id)): $cond .= " && bank_id = '$bank_id'"; elseif(empty($cond) && !empty($bank_id)): $cond .= " bank_id = '$bank_id'";  endif; 
			if(!empty($cond) && !empty($account_no)): $cond .= " && account_no = '$account_no'"; elseif(empty($cond) && !empty($account_no)): $cond .= " account_no = '$account_no'"; endif; 

		   $cond2     = new CDbCriteria( array( 'condition' => $cond,) ); 					 
		   $model     = Cash_In_Banks::model()->findAll( $cond2 );
		   $this->render('bank_transaction_report', array('model' => $model,));
		}
		else{ 
		$this->render('bank_transaction_report_form', array('model' => $model,));
		}
     endif;		
   }

 public function actionEntry(){
			
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	    $username     = Yii::app()->user->name;	   
		$product_category_id = $_POST['product_category'];
		$product_type_id = $_POST['product_type'];
		$product_id      = $_POST['product_id'];
		$p_price         = $_POST['p_price'];
	    $qty             = $_POST['qty'];		
			   
			    $cond = "username = '$username' && product_id = '$product_id' && product_type_id = '$product_type_id' && product_category_id = '$product_category_id'";				
				$q1 = new CDbCriteria( array( 'condition' => $cond,) );					 
				$dataExists     = Received_Delivery_Tempory::model()->findAll( $q1 );
			
			if(count($dataExists)):
				$command = Yii::app()->db->createCommand();
				$model_Rdtemporary = new Received_Delivery_Tempory();
				$model_Rdtemporary->deleteAll($cond); 
				$command->insert('receivd_delivery_tempory', array(
                                'username'            => $username,
								'product_id'          => $product_id,
								'product_type_id'     => $product_type_id,
								'product_category_id' => $product_category_id,
								'p_price'             => $p_price,
								'quantity'            => $qty,
							));								
			  else:
				$command = Yii::app()->db->createCommand();
				$command->insert('receivd_delivery_tempory', array(
                                'username'            => $username,
								'product_id'          => $product_id,
								'product_type_id'     => $product_type_id,
								'product_category_id' => $product_category_id,
								'p_price'             => $p_price,
								'quantity'            => $qty,
							));								
			 endif;
		   		  
		     $this->redirect(array('Account_Received/add'));		   
		
	endif;	
	}
	
	public function actionRemove($id){
			
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
		$model = Received_Delivery_Tempory::model()->findByPk($id);
		$model->delete(); 
		$this->redirect(array('Account_Received/add'));
	endif;	
	}

	public function actionView($id)
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
		$criteria = new CDbCriteria();		
		$criteria->condition = "id = '$id'";
		$models = Account_Received::model()->findAll($criteria);
		$this->render('view', array('models' => $models,));
	
	 endif;
	}
}

