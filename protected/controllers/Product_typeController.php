<?php
class Product_TypeController extends CController
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
	  if($user->item_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;
		
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:

		$criteria = new CDbCriteria();
		
		$count = Product_Type::model()->count($criteria);
		$pages = new CPagination($count);
		// elements per page
		$pages->pageSize = 50;
		$pages->applyLimit($criteria);
		
		$criteria->order = 'id DESC';
		$models = Product_Type::model()->findAll($criteria);
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
	  if($user->item_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	
		$model = new Product_Type();
		$data = Yii::app()->request->getPost('Product_Type');
		if($data)
		{
		$model->setAttributes($data);
		if($model->save()){
		
/*		    
            // test Note
            $model2 = new CDbCriteria();
			$model2->limit = 1;
			$model2->offset = 1;
			$model2->order = "id DESC";
			$Products = Snippet::model()->findAll($model2);
*/			
		Yii::app()->user->setFlash('saveMessage','Item Type Saved Successfully....<a href="'.Yii::app()->request->baseUrl.'/index.php/product_type/add">Add New</a> &nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/index.php/product_type">View All</a>');
		$this->refresh();
		 }
		}
		$this->render('add', array('model' => $model,));
     endif;		
	}

	public function actionEdit($id){
	
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->item_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:	

		$model = Product_Type::model()->findByPk($id);
		if(!$model)
		throw new CHttpException(404);
		$data = Yii::app()->request->getPost('Product_Type');
		if($data)
		{
		$model->setAttributes($data);
		if($model->save()){	
			Yii::app()->user->setFlash('saveMessage','Item Type Modified Successfully...&nbsp;&nbsp;<a href="'.Yii::app()->request->baseUrl.'/index.php/product_type">View All</a>');
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
	  if($user->item_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:	
	    $typeExt  = new CDbCriteria( array( 'condition' => "product_type_id = '$id'",) ); 
        $typeVal = Product::model()->findAll( $typeExt );

        if (count($typeVal)):
			Yii::app()->user->setFlash('saveMessage','Sorry! this item type is use in one or more items.Please delete items first.');
		     $this->redirect(array('product_type/index'));
        else:
				$model = Product_Type::model()->findByPk($id);
				$model->delete(); 
			    Yii::app()->user->setFlash('saveMessage','Item type deleted successfully.');
		        $this->redirect(array('product_type/index'));
        endif;
	endif;	
	}
	
	public function actionView($id)
	{
	
	  //privileges Check with message
	  $username = Yii::app()->user->name;
	  $cond     = new CDbCriteria( array( 'condition' => "username = '$username'",) );					 
	  $Users    = Users::model()->findAll( $cond );
	  if(count($Users)): foreach($Users as $user):
	  if($user->item_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;

	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	
	$model = Product_Type::model()->findByPk($id);
	if(!$model)
	throw new CException(404);
	$this->render('view', array('model' => $model,));
	
	 endif;
	}
}

