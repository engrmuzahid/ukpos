<?php
class Customer_TypeController extends CController
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
	  if($user->customer_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

		$criteria = new CDbCriteria();
		
		$count = Customer_Type::model()->count($criteria);
		$pages = new CPagination($count);
		// elements per page
		$pages->pageSize = 50;
		$pages->applyLimit($criteria);
		
		$criteria->order = 'id DESC';
		$models = Customer_Type::model()->findAll($criteria);
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
	  if($user->customer_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

		$model = new Customer_Type();
		$data = Yii::app()->request->getPost('Customer_Type');
		if($data)
		{
		$model->setAttributes($data);
		if($model->save()){
		Yii::app()->user->setFlash('saveMessage','Customer Type Saved Successfully....<a href="'.Yii::app()->request->baseUrl.'/index.php/customer_type/add">Add New</a> &nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/index.php/customer_type">View All</a>');
		$this->refresh();
		 }
		}
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
	  if($user->customer_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

		$model = Customer_Type::model()->findByPk($id);
		if(!$model)
		throw new CHttpException(404);
		$data = Yii::app()->request->getPost('Customer_Type');
		if($data)
		{
		$model->setAttributes($data);
		if($model->save()){	
			Yii::app()->user->setFlash('saveMessage','Customer Type Modified Successfully...&nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/index.php/customer_type">View All</a>');
			$this->refresh();
		   }	
		}
		$this->render('edit', array('model' => $model,));
	endif;	
	}
	
	public function actionDelete($id){

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:	
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->customer_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

		$model = Customer_Type::model()->findByPk($id);
		$model->delete(); 
		$this->redirect(array('customer_type/index'));
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
	  if($user->customer_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	$model = Customer_Type::model()->findByPk($id);
	if(!$model)
	throw new CException(404);
	$this->render('view', array('model' => $model,));
	
	 endif;
	}
}

