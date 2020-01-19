<?php

class BankController extends CController {

    public $layout = 'backend';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to access 'index' and 'view' actions.
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated users to access all actions
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->bank_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();

            $models = Bank_Info::model()->findAll($criteria);
            $this->render('index', array('models' => $models));

        endif;
    }

    public function actionShowdetails($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->bank_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $bank_transection = Yii::app()->db->createCommand()
                            ->select('bank_transaction.*,transaction_purpose.purpose_description')
                            ->from('bank_transaction')
                            ->join("transaction_purpose", 'bank_transaction.purpose_id = transaction_purpose.id')
                            ->where("bank_transaction.bank_id = '$id'")->queryAll();
                $data['bank_id'] = $id;
                   $data['models'] = $bank_transection;
            

            $this->render('showdetails',$data);

        endif;
    }

      public function actionAddtansection($bank_id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->bank_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

//            if ($_POST) {
//                // code for search product
//                $username = Yii::app()->user->name;
//
//
//                // code for reinsert datagride value
//                $product_cod = $_POST['product_code22'];
//                $product_name = $_POST['product_name'];
//                $quantity = $_POST['quantity'];
//                $price = $_POST['price'];
//                $discount = $_POST['discount'];
//                $vat = $_POST['vat'];
//
//            }

            $data['transaction_purpose'] = Yii::app()->db->createCommand()->select('*')->from('transaction_purpose')->queryAll();
            $data['bank_id'] = $bank_id;
            $this->render('add',$data);
            
             endif;
    }

  
    
}
