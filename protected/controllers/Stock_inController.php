<?php

class Stock_InController extends CController {

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
                    if ($user->stock_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();

            $count = Stock_In::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);

            $criteria->order = 'id DESC';
            $models = Stock_In::model()->findAll($criteria);
            $this->render('index', array('models' => $models, 'pages' => $pages,));

        endif;
    }

    public function actionAdd() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->stock_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Stock_In();
            $model2 = new Stock();
            $username = Yii::app()->user->name;

            $product_type = $_POST['product_type'];
            $product_category = $_POST['product_category'];
            $product_brand = $_POST['product_brand'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $stock_in_date = $_POST['stock_in_date'];
            if (!empty($product_id)):
                for ($p = 0; $p < sizeof($product_id); $p++):

                    $product_type2 = $product_type[$p];
                    $product_category2 = $product_category[$p];
                    $product_brand2 = $product_brand[$p];
                    $product_id2 = $product_id[$p];
                    $quantity2 = $quantity[$p];
                    $cos = "product_type = '$product_type2' && product_category = '$product_category2'  && product_brand = '$product_brand2' && product_id = '$product_id2'";
                    $cond = new CDbCriteria(array('condition' => "product_type = '$product_type2' && product_category = '$product_category2' && product_brand = '$product_brand2' && product_id = '$product_id2'",));
                    $stockExValues = Stock::model()->findAll($cond);

                    if (count($stockExValues)):
                        foreach ($stockExValues as $stockExValue): $quantity_stock = $quantity2 + $stockExValue->product_balance;
                        endforeach;

                        $command = Yii::app()->db->createCommand();
                        $command->insert('stock_in', array(
                            'stock_in_date' => $stock_in_date,
                            'product_type' => $product_type2,
                            'product_category' => $product_category2,
                            'product_brand' => $product_brand2,
                            'product_id' => $product_id2,
                            'quantity' => $quantity2,
                        ));
                        $command->update('stock', array('product_balance' => $quantity_stock,), $cos);

                    else:

                        $command = Yii::app()->db->createCommand();
                        $command->insert('stock', array(
                            'product_type' => $product_type2,
                            'product_category' => $product_category2,
                            'product_brand' => $product_brand2,
                            'product_id' => $product_id2,
                            'product_balance' => $quantity2,
                        ));

                        $command->insert('stock_in', array(
                            'stock_in_date' => $stock_in_date,
                            'product_type' => $product_type2,
                            'product_category' => $product_category2,
                            'product_brand' => $product_brand2,
                            'product_id' => $product_id2,
                            'quantity' => $quantity2,
                        ));
                    endif;
                endfor;

                $model_stockTempory = new Stock_Tempory();
                $model_stockTempory->deleteAll();
                Yii::app()->user->setFlash('saveMessage', 'Stock In Information Saved Successfully....<a href="' . Yii::app()->request->baseUrl . '/index.php/stock_in/add">Add New</a> &nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/stock_in">View All</a>');
                // call function to empty cart	
                $this->refresh();
            endif;

            $this->render('add', array('model' => $model,));
        endif;
    }

    public function actionEdit($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->stock_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = Stock_In::model()->findByPk($id);
            if (!$model)
                throw new CHttpException(404);
            $data = Yii::app()->request->getPost('Stock_In');
            if ($data) {
                $model->setAttributes($data);

                if ($model->save()) {

                    Yii::app()->user->setFlash('saveMessage', 'Stock in Information Modified Successfully...&nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/stock_in">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('edit', array('model' => $model,));
        endif;
    }

    public function actionDelete($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->stock_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = Stock_In::model()->findByPk($id);

            $product_type = $model['product_type'];
            $product_category = $model['product_category'];
            $product_brand = $model['product_brand'];
            $product_id = $model['product_id'];
            $quantity1 = $model['quantity'];

            $cond = new CDbCriteria(array('condition' => "product_type = '$product_type' && product_category = '$product_category' && product_brand = '$product_brand' && product_id = '$product_id'",));
            $stockValues = Stock::model()->findAll($cond);

            if (count($stockValues)): foreach ($stockValues as $data2):
                    $stock_id = $data2->id;
                    $product_balance = $data2->product_balance;
                endforeach;
            endif;

            $cond2 = "id = '$stock_id'";
            $command = Yii::app()->db->createCommand();
            $command->update('stock', array('product_balance' => $product_balance - $quantity1,), $cond2);
            $model->delete();
            $this->redirect(array('stock_in/index'));
        endif;
    }

    public function actionIn_report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->stock_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Stock_In();
            if ($_POST) {
                $product_category = $_POST['product_category'];
                $product_type = $_POST['product_type'];
                $product_brand = $_POST['product_brand'];
                $product_id = $_POST['product_id'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];

                $cond = '';
                if (!empty($cond) && !empty($product_category)): $cond .= " && product_category = '$product_category'";
                elseif (empty($cond) && !empty($product_category)): $cond .= "product_category = '$product_category'";
                endif;
                if (!empty($cond) && !empty($product_type)): $cond .= " && product_type = '$product_type'";
                elseif (empty($cond) && !empty($product_type)): $cond .= "product_type = '$product_type'";
                endif;
                if (!empty($cond) && !empty($product_brand)): $cond .= " && product_brand = '$product_brand'";
                elseif (empty($cond) && !empty($product_brand)): $cond .= "product_brand = '$product_brand'";
                endif;
                if (!empty($cond) && !empty($product_id)): $cond .= " && product_id = '$product_id'";
                elseif (empty($cond) && !empty($product_id)): $cond .= "product_id = '$product_id'";
                endif;
                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && stock_in_date >= '$start_date' && stock_in_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " stock_in_date >= '$start_date' && stock_in_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && stock_in_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " stock_in_date = '$start_date'";
                endif;

                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $criteria->order = 'id DESC';
                $model = Stock_In::model()->findAll($criteria);
                $this->render('stock_in_report', array('model' => $model,));
            }
            else {
                $this->render('stock_in_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionReport() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->stock_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Stock();
            if ($_POST) {
                $model = new Product();
                $product_code = $_POST['product_code'];
                $criteria = new CDbCriteria();
                $criteria->condition = "product_code = '$product_code' OR product_name = '$product_code'";
                $criteria->order = 'id DESC';
                $models = Product::model()->findAll($criteria);
                $product_code = "";
                if (count($models)):
                    foreach ($models as $model):
                        $product_code = $model->product_code;
                    endforeach;
                endif;
                $cond = '';

                if (!empty($cond) && !empty($product_code)): $cond .= " && product_code = '$product_code'";
                elseif (empty($cond) && !empty($product_code)): $cond .= "product_code = '$product_code'";
                endif;

                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $criteria->order = 'id DESC';
                $model = Stock::model()->findAll($criteria);
                $this->render('stock_report', array('model' => $model,));
            }
            else {
                $this->render('stock_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionMin_Stockout_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->report_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();

            $count = Stock::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);


            $model = Stock::model()->findAll($criteria);
            $this->render('min_stockout_report', array('model' => $model, 'pages' => $pages));
        endif;
    }

    public function actionEntry() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = new Product();
            $product_code = trim($_POST['product_code']);
            $criteria = new CDbCriteria();
            $criteria->condition = "product_code = '$product_code' OR product_name = '$product_code'";
            $criteria->order = 'id DESC';
            $models = Product::model()->findAll($criteria);

            foreach ($models as $model):
                $product_category = $model->product_category_id;
                $product_type = $model->product_type_id;
                $product_brand = $model->product_brand_id;
                $product_id = $model->product_id;
            endforeach;


            $cond = "product_category = '$product_category_id' && product_type = '$product_type_id'  && product_brand = '$product_brand_id' && product_id = '$product_id'";
            $q1 = new CDbCriteria(array('condition' => $cond,));
            $dataExists = Stock_Tempory::model()->findAll($q1);

            if (count($dataExists)):

            else:
                $command = Yii::app()->db->createCommand();
                $command->insert('stock_tempory', array(
                    'product_id' => $product_id,
                    'product_type' => $product_type,
                    'product_category' => $product_category,
                    'product_brand' => $product_brand,
                ));
            endif;

            $this->redirect(array('stock_in/add'));
        endif;
    }

    public function actionRemove($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $model = Stock_Tempory::model()->findByPk($id);
            $model->delete();
            $this->redirect(array('stock_in/add'));
        endif;
    }

    public function actionView($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->stock_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();
            $criteria->condition = "id = '$id'";
            $models = Stock_In::model()->findAll($criteria);
            $this->render('view', array('models' => $models,));

        endif;
    }

}

