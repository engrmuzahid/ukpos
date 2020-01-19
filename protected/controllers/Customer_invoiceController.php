<?php
class Customer_InvoiceController extends CController
{
	public $layout='backend';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */

	
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
	  if($user->sale_prev != 1):
		Yii::app()->user->setFlash('saveMessage','Sorry, No access to this page.');										 
		$this->redirect(array('super/index'));
	  endif; endforeach; endif;
		
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	    $username   = Yii::app()->user->name;
		
		if($_POST['customer_id'] && empty($_POST['invoice_no']))
		 {	
		  
		    $customer_id = $_POST['customer_id'];
		    
			$models = Sell_Product::model()->findAllBySql("select DISTINCT(a.product_code), b.customer_id FROM sell_order_product a , sell_order b WHERE a.invoice_no = b.invoice_no && b.customer_id={$customer_id} ORDER BY b.id DESC LIMIT 25");
    		
			$this->render('index', array('model' => $models,'customer_id'=>$customer_id));
	     }		  
			 else {
				   $this->render('index', array('model' => $model));
				   }		 
     endif;		
	}
        
        
        public function actionGetProducts() {
            $customer_id = $_POST['customer_id'];
            
            $sql = "SELECT sop.product_code, sop.amount, sop.product_name FROM (
                SELECT a.* FROM sell_order_product a, sell_order b WHERE a.invoice_no = b.invoice_no && b.customer_id={$customer_id} ORDER BY a.id DESC) AS sop
                GROUP BY sop.product_code ORDER BY sop.id DESC LIMIT 50";

            //$models = Sell_Product::model()->findAllBySql("select a.product_code, a.amount, a.product_name FROM sell_order_product a , sell_order b WHERE a.invoice_no = b.invoice_no && b.customer_id={$customer_id} GROUP BY a.product_code ORDER BY b.id DESC LIMIT 25");
                $models = Sell_Product::model()->findAllBySql($sql);
            $products = array();
            $k = 1;
            foreach($models as $model) {
                $products[$k]['product_code'] = $model->product_code;
                $products[$k]['p_price'] = $model->amount;
                $products[$k]['product_name'] = $model->product_name;
                $k++;
            }
            echo json_encode($products);
        }

// suspended sell list
	public function actionAdd()
	{	
		
	if(Yii::app()->user->name == 'Guest'):
    	$this->redirect(array('site/login'));
	else:
	    $user_id    = Yii::app()->user->name;	
	    
		//$command = Yii::app()->db->createCommand();
		//$command->delete('sell_tempory', "user_id = '$user_id'");
		
                $customer_id = $_POST['customer_id'];
		// Search checkbox in post array
		foreach($_POST as $key => $value)
		{
			// If checkbox found
			if(substr($key, 0, 9) == 'checkbox_')
			{
				
				
				
				$cond = new CDbCriteria( array( 'condition' => "id = '$value'",) ); 					 
				$models = Product::model()->findAll($cond);
				if(count($models)):
				  foreach($models as $data):
				  $product_code  = $data->product_code;
				  $vat           = $data->vat;
				  $quantity      = 1;
				  $amount        = $data->sell_price;					
					$command = Yii::app()->db->createCommand();
					$command->insert('sell_tempory', array(
									'user_id'             => $user_id,
									'product_code'        => $product_code,
									'p_price'             => $amount,
									'quantity'            => $quantity,
									'vat'                 => $vat,
								));
								
				  endforeach; endif;
				  

			}				
		}
		
          $this->redirect(Yii::app()->baseUrl.'/b2b_sell/add?customer_id='.$customer_id);
	 endif;
	}

	public function actionView($id)
	{
		
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

