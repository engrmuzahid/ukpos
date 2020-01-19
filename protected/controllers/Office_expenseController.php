<?php
class Office_ExpenseController extends CController
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
		
		$count = Office_Expense::model()->count($criteria);
		$pages = new CPagination($count);
		// elements per page
		$pages->pageSize = 50;
		$pages->applyLimit($criteria);
		
		$criteria->order = 'id DESC';
		$models = Office_Expense::model()->findAll($criteria);
		$this->render('index', array('models' => $models, 'pages' => $pages,));
	
	endif;
	}
	
	public function actionAdd()
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

				if($_POST):
				
				$expense_type_id     =  $_POST['expense_type_id'];
				$expense_name_id     =  $_POST['expense_name_id'];
				$expense_date        =  $_POST['expense_date'];
				$voucher_no          =  $_POST['voucher_no'];
                $expense_by          =  $_POST['expense_by'];
                $amount              =  $_POST['amount'];
                $expense_description =  $_POST['expense_description'];
                $payment_mode        =  $_POST['payment_mode'];
				$bank_id             =  $_POST['bank_id'];
                $account_no          =  $_POST['account_no'];
                $cheque_no           =  $_POST['cheque_no'];
                $cheque_date         =  $_POST['cheque_date'];
                $cheque_type         =  $_POST['cheque_type'];
				
				if($payment_mode == 'cash'):				 
				 $criteria2 = new CDbCriteria();
				 $criteria2->order = 'id DESC';
				 $criteria2->limit = 1;
				 $cash_values = Cash_In_Hand::model()->findAll($criteria2);
				 
				 foreach($cash_values as $cash_value): $cash_amount = $cash_value->amount; $cash_id = $cash_value->id; endforeach;
				  $command = Yii::app()->db->createCommand();
                  $command->update('cash_in_hand', array( 'amount' => $cash_amount - $amount,), "id = '$cash_id'");
					  
				 $command->insert('cash_in_hand_transaction', array(
							'transaction_date' => 	$expense_date,
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
								'transaction_date' => 	$expense_date,
								'bank_id'          => 	$bank_id,
								'account_no'       => 	$account_no,
								'status'           => 	'credit',
								'amount'           => 	$amount,
							  ));								  
				 endif;
				 
				
				$command = Yii::app()->db->createCommand();
				$command->insert('office_expense', array(
				                    'expense_type_id' => 	$expense_type_id,
									'expense_name_id' => 	$expense_name_id,
									'expense_date'    => 	$expense_date,
									'voucher_no'      => 	$voucher_no,
				                    'expense_by'      => 	$expense_by,
									'amount'          => 	$amount,
									'expense_description'   => 	$expense_description,
									'payment_mode'    => 	$payment_mode,
				                    'bank_id'         => 	$bank_id,
									'account_no'      => 	$account_no,
									'cheque_no'       => 	$cheque_no,
									'cheque_date'     => 	$cheque_date,
									'cheque_type'     => 	$cheque_type,
									'created'         =>    date('Y-m-d  H:i:s', time()),
								));
			 
				Yii::app()->user->setFlash('saveMessage','Office Expense Information Saved Successfully....<a href="'.Yii::app()->request->baseUrl.'/office_expense/add">Add New</a> &nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/office_expense">View All</a>');
				$this->refresh();
			 endif;				
			 
    		$this->render('add', array('model' => $model,));
     endif;		
	}

	public function actionEdit($id){
	

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

		$model  = new Office_Expense();
		$model2 = new Cash_In_Bank();
		$model3 = new Cash_In_Hand();
		$model = Office_Expense::model()->findByPk($id);
		if(!$model)
		throw new CHttpException(404);
		$data = Yii::app()->request->getPost('Office_Expense');
		if($data)
		{
		$model->setAttributes($data);

		if($model->save()){	
			
			Yii::app()->user->setFlash('saveMessage','Office Expense Information Modified Successfully...&nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/office_expense">View All</a>');
			$this->refresh();
		   }	
		}
		$this->render('edit', array('model' => $model,));
	endif;	
	}
	

  public function actionReport()
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

		$model = new Office_Expense();
		
		if($_POST)
		{
		$cond = '';	
         $expense_type_id  = $_POST['expense_type_id'];
         $expense_name_id  = $_POST['expense_name_id'];
		 $start_date       = $_POST['start_date'];
         $end_date         = $_POST['end_date'];

	    if(!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && expense_date >= '$start_date' && expense_date <= '$end_date'"; elseif(empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " expense_date >= '$start_date' && expense_date <= '$end_date'"; endif; 
	    if(!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && expense_date = '$start_date'"; elseif(empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " expense_date = '$start_date'"; endif; 
	    if(!empty($cond) && !empty($expense_type_id)): $cond .= " && expense_type_id = '$expense_type_id'"; elseif(empty($cond) && !empty($expense_type_id)): $cond .= " expense_type_id = '$expense_type_id'"; endif; 
	    if(!empty($cond) && !empty($expense_name_id)): $cond .= " && expense_name_id = '$expense_name_id'"; elseif(empty($cond) && !empty($expense_name_id)): $cond .= " expense_name_id = '$expense_name_id'"; endif; 

		 $criteria = new CDbCriteria();
		 $criteria->condition = $cond;
		 $model = Office_Expense::model()->findAll($criteria);
		 $this->render('report', array('model' => $model,));
		}
		else{ 
		$this->render('report_form', array('model' => $model,));
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
			 echo "<font color='#FF5918'>Total Cash Balance = $cash_amount</font>";
			 else:
			 echo "<font color='#FF5918'>Total Cash Balance = 0</font>";
			 endif;
    }

	public function actionView($id)
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
		$criteria->condition = "id = '$id'";
		$models = Office_expense::model()->findAll($criteria);
		$this->render('view', array('models' => $models,));
	
	 endif;
	}
}

