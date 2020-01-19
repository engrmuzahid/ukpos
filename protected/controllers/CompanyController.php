<?php
class CompanyController extends CController
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
	  if($user->store_config_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

		$criteria = new CDbCriteria();
		
		$count = Company::model()->count($criteria);
		$pages = new CPagination($count);
		// elements per page
		$pages->pageSize = 50;
		$pages->applyLimit($criteria);
		
		$criteria->order = 'id DESC';
		$models = Company::model()->findAll($criteria);
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
	  if($user->store_config_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

		$model = new Company();
		$data = Yii::app()->request->getPost('Company');
                
                $customer_mandatory = $data['customer_mandatory'];
                $customer_eu = $data['eu'];
                $price_overwrite = $data['payment_check'];
                
		if($data)
		{
		$model->setAttributes($data);
		$as = CUploadedFile::getInstance($model,'company_logo');
        if(!empty($as)): $model->company_logo = $as; endif;

		if($model->save()){
		
		   if(!empty($as)):
			$image_path = Yii::getPathOfAlias('webroot').'/public/photos/company/'.$model->company_logo; 
			$model->company_logo->saveAs($image_path);
			endif;

		Yii::app()->user->setFlash('saveMessage','Company Information Saved Successfully....<a href="'.Yii::app()->request->baseUrl.'/company">View Company</a>');
		$this->refresh();
		 }
		}
		$this->render('add', array('model' => $model, 'customer_mandatory' => $customer_mandatory, 'customer_eu' => $customer_eu, 'price_overwrite' => $price_overwrite));
                exit;
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
	  if($user->store_config_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

		$model = Company::model()->findByPk($id);
		if(!$model)
		throw new CHttpException(404);
		$data = Yii::app()->request->getPost('Company');
                
                $select_data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('company')
                    ->queryRow();
                
                //print_r($customer_mandatory);
                
		if($data)
		{
		$model->setAttributes($data);
		
		$as = CUploadedFile::getInstance($model,'company_logo');
        if(!empty($as)): $model->company_logo = $as; endif;

		if($model->save()){	
		   if(!empty($as)):
			$image_path = Yii::getPathOfAlias('webroot').'/public/photos/company/'.$model->company_logo; 
			$model->company_logo->saveAs($image_path);
			endif;

			Yii::app()->user->setFlash('saveMessage','Item Category Modified Successfully...&nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/company">View All</a>');
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
	  if($user->store_config_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

		$model = Company::model()->findByPk($id);
		$model->delete(); 
		$this->redirect(array('company/index'));
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
	  if($user->store_config_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	$model = Company::model()->findByPk($id);
	if(!$model)
	throw new CException(404);
	$this->render('view', array('model' => $model,));
	
	 endif;
	}
}

