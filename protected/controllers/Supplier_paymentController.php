<?php
class Supplier_PaymentController extends CController
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
	
		
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->accounts_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

		$criteria = new CDbCriteria();
		
		$count = Supplier_Payment::model()->count($criteria);
		$pages = new CPagination($count);
		// elements per page
		$pages->pageSize = 50;
		$pages->applyLimit($criteria);
		
		$criteria->order = 'id DESC';
		$models = Supplier_Payment::model()->findAll($criteria);
		$this->render('index', array('models' => $models, 'pages' => $pages,));
	
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
		
		if($_POST['chalan_id'] && empty($_POST['supplier_id']))
		 {	
		  
		    $chalan_id = $_POST['chalan_id'];
			$criteria = new CDbCriteria();
			$criteria->condition = "chalan_id = '$chalan_id'";
			$criteria->order = 'id DESC';
			$model  = Purchase::model()->findAll($criteria);
			$model2 = Purchase_Product::model()->findAll($criteria);
    		$this->render('add', array('model' => $model, 'model2' => $model2,));
	     }		  
		  elseif (!empty($_POST) && !empty($_POST['supplier_id'])) {				

				$chalan_id          = $_POST['chalan_id'];
				$supplier_id        =  $_POST['supplier_id'];
				$payment_date       =  $_POST['payment_date'];
				$payment_mode       =  $_POST['payment_mode'];
				$bank_id            =  $_POST['bank_id'];
				$account_no         =  $_POST['account_no'];
				$cheque_no          =  $_POST['cheque_no'];
				$cheque_date        =  $_POST['cheque_date'];
				$cheque_type        =  $_POST['cheque_type'];
				$amount             =  $_POST['amount'];
				
				$price_grand_total  =  $_POST['price_grand_total'];
				$paid_amount        =  $_POST['paid_amount'];
				$paid_total         =  $paid_amount + $amount;
				if($paid_total == $price_grand_total): $status = "paid"; else: $status = "due"; endif;
			    $created            = date('Y-m-d', time());
				
				
				if($payment_mode == 'cash'):				 
					 $criteria2 = new CDbCriteria();
					 $criteria2->order = 'id DESC';
					 $criteria2->limit = 1;
					 $cash_values = Cash_In_Hand::model()->findAll($criteria2);
					 
					 foreach($cash_values as $cash_value): $cash_amount = $cash_value->amount; $cash_id = $cash_value->id; endforeach;
					  $command = Yii::app()->db->createCommand();
					  $command->update('cash_in_hand', array( 'amount' => $cash_amount - $amount,), "id = '$cash_id'");
					  
					 $command->insert('cash_in_hand_transaction', array(
								'transaction_date' => 	$payment_date,
								'status'           => 	'credit',
								'amount'           => 	$amount,
							  ));

					elseif($payment_mode == 'bank'):
					$cond1 = "bank_id = '$bank_id' && account_no = '$account_no'";
					$cond2 = "bank_id = '$bank_id' && account_no = '$account_no' && id = '$cheque_no'";
	
					 $criteria2 = new CDbCriteria();
					 $criteria2->condition = $cond1;
					 $criteria2->order = 'id DESC';
					 $criteria2->limit = 1;
					 $bank_values = Cash_In_Bank::model()->findAll($criteria2);
					 
					 foreach($bank_values as $bank_value): $bank_amount = $bank_value->balance; endforeach;
					  $command = Yii::app()->db->createCommand();
					  $command->update('cash_in_bank', array( 'balance' => $bank_amount - $amount,), $cond1);
					  $command->update('bank_cheque', array( 'status' => 'used',), $cond2);
					  
					  $command->insert('cash_in_bank_transaction', array(
									'transaction_date' => 	$payment_date,
									'bank_id'          => 	$bank_id,
									'account_no'       => 	$account_no,
									'status'           => 	'credit',
									'amount'           => 	$amount,
						          ));								  
				 endif;
				 
				  $command = Yii::app()->db->createCommand();
				    $cond = "chalan_id = '$chalan_id'";
					
					$command->insert('supplier_payment', array(
									'chalan_id' 	       => 	$chalan_id,
									'supplier_id'          =>   $supplier_id,
									'payment_date'         => 	$payment_date,
									'payment_mode'         => 	$payment_mode,
									'bank_id'              => 	$bank_id,
									'account_no'           => 	$account_no,
									'cheque_no'            => 	$cheque_no,
									'cheque_date'          => 	$cheque_date,
									'cheque_type'          => 	$cheque_type,
									'amount'               => 	$amount,
									'created'              =>   $created					
								));
				$command->update('purchase', array( 'paid_amount' => $paid_total, 'status' => $status,), $cond);								
				Yii::app()->user->setFlash('saveMessage','Payment Completed Successfully....<a href="'.Yii::app()->request->baseUrl.'/supplier_payment/add">Payment Supplier Again</a> &nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/supplier_payment">View All</a>');
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

		$model = Supplier_Payment::model()->findByPk($id);
		if(!$model)
		throw new CHttpException(404);
		$data = Yii::app()->request->getPost('Supplier_Payment');
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
		$model  = Supplier_Payment::model()->findByPk($id);
		$model->delete(); 
		$this->redirect(array('supplier_payment/index'));
	endif;	
	}
  

  public function actionPayable_Report()
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
		 $cond = "status = 'due'";	
         $supplier_id      = $_POST['supplier_id'];
         $start_date       = $_POST['start_date'];
         $end_date         = $_POST['end_date'];
         $chalan_id        = $_POST['chalan_id'];

		if(!empty($start_date) && !empty($end_date)): $cond .= " && purchase_date >= '$start_date' && purchase_date <= '$end_date'"; elseif(!empty($start_date) && empty($end_date)): $cond .= "purchase_date = '$start_date'"; endif; 
	    if(!empty($supplier_id)): $cond .= " && supplier_id = '$supplier_id'"; endif; 
	    if(!empty($chalan_id)): $cond .= " && chalan_id = '$chalan_id'"; endif; 

			  $cond2     = new CDbCriteria( array( 'condition' => $cond,) ); 					 
			  $model     = Purchase::model()->findAll( $cond2 );
		      $this->render('account_payable_report', array('model' => $model,));
		}
		else{ 
		$this->render('account_payable_report_form', array('model' => $model,));
		}
     endif;		
   }
 
  public function actionPaid_Report()
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
		 $cond = '';	
         $supplier_id      = $_POST['supplier_id'];
         $start_date       = $_POST['start_date'];
         $end_date         = $_POST['end_date'];

		if(!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && payment_date >= '$start_date' && payment_date <= '$end_date'"; elseif(empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " payment_date >= '$start_date' && payment_date <= '$end_date'"; endif;
		if(!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && payment_date = '$start_date'"; elseif(empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " payment_date = '$start_date'";  endif; 
	    if(!empty($cond) && !empty($supplier_id)): $cond .= " && supplier_id = '$supplier_id'"; elseif(empty($cond) && !empty($supplier_id)): $cond .= " supplier_id = '$supplier_id'"; endif; 

			  $cond2     = new CDbCriteria( array( 'condition' => $cond,) ); 					 
			  $model     = Supplier_Payment::model()->findAll( $cond2 );
		 $this->render('account_paid_report', array('model' => $model,));
		}
		else{ 
		$this->render('account_paid_report_form', array('model' => $model,));
		}
     endif;		
   }

    
	function actionCash_Balance() {
			 $criteria = new CDbCriteria();
			 $criteria->order = 'id DESC';
			 $criteria->limit = 1;
			 $cash_values = Cash_In_Hand::model()->findAll($criteria);
			 if(count($cash_values)):
			 foreach($cash_values as $cash_value): $cash_amount = $cash_value->amount; endforeach;
			 echo "<font color='#FF5918'>Total Cash Balance = ".number_format($cash_amount,2)."</font>";
			 else:
			 echo "<font color='#FF5918'>Total Cash Balance = 0</font>";
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
		$models = Supplier_Payment::model()->findAll($criteria);
		$this->render('view', array('models' => $models,));
	
	 endif;
	}
}

