<?php
class Stock_OutController extends CController
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
	  if($user->stock_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;
		
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:

		$criteria = new CDbCriteria();
		
		$count = Stock_Out::model()->count($criteria);
		$pages = new CPagination($count);
		// elements per page
		$pages->pageSize = 50;
		$pages->applyLimit($criteria);
		
		$criteria->order = 'id DESC';
		$models = Stock_Out::model()->findAll($criteria);
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
	  if($user->stock_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
				$model = new Stock_Out();
				$model2 = new Stock();
				$username     = Yii::app()->user->name;	

				$product_code      =  $_POST['product_code22'];
				$quantity          =  $_POST['quantity'];
                $stock_out_date    =  $_POST['stock_out_date'];
                $reason            =  $_POST['reason'];

				if(!empty($product_code)):				
			    for($p=0; $p < sizeof($product_code); $p++):
					$product_code2     =	$product_code[$p];
					$quantity2         =	$quantity[$p];
				    $cos = "product_code = '$product_code2'";
				    $cond = new CDbCriteria( array( 'condition' => "product_code = '$product_code2'",) ); 
                    $stockExValues = Stock::model()->findAll( $cond );
				
				  if(count($stockExValues)):					
					foreach($stockExValues as $stockExValue): $quantity_stock = $stockExValue->product_balance - $quantity2; endforeach;
					
                      $command = Yii::app()->db->createCommand();
					  $command->insert('stock_out', array(
										'stock_out_date'           => 	$stock_out_date,	
										'product_code'             => 	$product_code2,
										'quantity'                 => 	$quantity2,
										'reason'                   => 	$reason,
										'user_id'                  => 	$username,
			                        ));
                      $command->update('stock', array( 'product_balance' => $quantity_stock,), $cos);
     			 endif;
			 endfor;
			 
				$model_stockTempory = new Stock_Tempory();
				$model_stockTempory->deleteAll(); 

				Yii::app()->user->setFlash('saveMessage','Stock Out Completed Successfully....<a href="'.Yii::app()->request->baseUrl.'/index.php/stock_out/add">Stock Out Again</a> &nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/index.php/stock_out">View All</a>');
				$this->refresh();
			 endif;				
			 
    		$this->render('add', array('model' => $model,));
     endif;		
	}
	
	public function actionDelete($id){
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->stock_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:	
		$model = Stock_Out::model()->findByPk($id);
		 
		 $product_code = $model['product_code'];  $quantity1= $model['quantity'];
		
		$cond = new CDbCriteria( array( 'condition' => "product_code = '$product_code'",) ); 
		$stockValues = Stock::model()->findAll( $cond );
		
		if(count($stockValues)): foreach($stockValues as $data2):
		 $stock_id = $data2->id; $product_balance = $data2->product_balance;
		 endforeach; endif;

        $cond2 = "id = '$stock_id'";		
		$command = Yii::app()->db->createCommand();
		$command->update('stock', array( 'product_balance' => $product_balance - $quantity1,), $cond2);
		$model->delete(); 
		$this->redirect(array('stock_out/index'));
	endif;	
	}

  public function actionReport()
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->stock_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	
		$model = new Stock_Out();
		$data = Yii::app()->request->getPost('Stock_Out');
		if($_POST)
		{
         $start_date       = $_POST['start_date'];
         $end_date         = $_POST['end_date'];

			$model = new Product();
			$product_code = $_POST['product_code'];
			$criteria = new CDbCriteria();
			$criteria->condition = "product_code = '$product_code' OR product_name = '$product_code'";
			$criteria->order = 'id DESC';
			$models = Product::model()->findAll($criteria);		
			$product_code = "";
			if(count($models)):       
			foreach($models as $model):		
				$product_code         = $model->product_code;
			 endforeach;
			 endif;
			 $cond = '';	
		 
		if(!empty($cond) && !empty($product_code)): $cond .= " && product_code = '$product_code'"; elseif(empty($cond) && !empty($product_code)): $cond .= "product_code = '$product_code'"; endif; 
		if(!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && stock_out_date >= '$start_date' && stock_out_date <= '$end_date'"; elseif(empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " stock_out_date >= '$start_date' && stock_out_date <= '$end_date'"; endif;
		if(!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && stock_out_date = '$start_date'"; elseif(empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " stock_out_date = '$start_date'";  endif; 

		 $criteria = new CDbCriteria();
		 $criteria->condition = $cond;
		 $criteria->order = 'id ASC';
		 $model = Stock_Out::model()->findAll($criteria);
		 $this->render('stock_out_report', array('model' => $model,));
		}
		else{ 
		$this->render('stock_out_report_form', array('model' => $model,));
		}
     endif;		
   }

 public function actionEntry(){
			
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:	
	    $user_id = Yii::app()->user->name;
		$model = new Product();
		$product_code = $_POST['product_code'];
		$criteria = new CDbCriteria();
		$criteria->condition = "product_code = '$product_code' OR product_name = '$product_code'";
		$criteria->order = 'id DESC';
		$models = Product::model()->findAll($criteria);
		       
	    foreach($models as $model):		
		$product_code  = $model->product_code;
		endforeach;

			   
			    $cond  = "product_code = '$product_code'";				
				$q1    = new CDbCriteria( array( 'condition' => $cond,) );					 
				$dataExists = Stock_Tempory::model()->findAll( $q1 );
			
			if(count($dataExists)):
								
			  else:
				$command = Yii::app()->db->createCommand();
				$command->insert('stock_tempory', array(
								'product_code'  => $product_code,
								'user_id'       => $user_id,
							));
			 endif;

		$this->redirect(array('stock_out/add'));
	endif;	
	}
	
	public function actionRemove($id){
			
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
		$model = Stock_Tempory::model()->findByPk($id);
		$model->delete(); 
		$this->redirect(array('stock_out/add'));
	endif;	
	}

	public function actionView($id)
	{
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->stock_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
		$criteria = new CDbCriteria();		
		$criteria->condition = "id = '$id'";
		$models = Stock_Out::model()->findAll($criteria);
		$this->render('view', array('models' => $models,));
	
	 endif;
	}
}

