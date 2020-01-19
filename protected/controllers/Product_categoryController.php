<?php

//

class Product_CategoryController extends CController {

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

        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->item_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $criteria = new CDbCriteria(array('condition' => "parent_id = 0",));

            $count = Product_Category::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);

            $criteria->order = 'id DESC';
            $criteria->condition = 'parent_id = 0';
            $models = Product_Category::model()->findAll($criteria);
            $this->render('index', array('models' => $models, 'pages' => $pages,));

        endif;
    }

    public function actionSubcategory($id) {

        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->item_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $criteria = new CDbCriteria(array('condition' => "parent_id = $id",));

            $count = Product_Category::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);

            $criteria->order = 'id DESC';
            $criteria->condition = 'parent_id = '.$id;
            $models = Product_Category::model()->findAll($criteria);
            $this->render('index', array('models' => $models, 'pages' => $pages,));

        endif;
    }

    public function actionAdd() {

        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->item_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = new Product_Category();
            $data = Yii::app()->request->getPost('Product_Category');
            if ($data) {
                $model->setAttributes($data);
                $uploadedFile = CUploadedFile::getInstance($model, 'image');
                if ($uploadedFile) {
                    $fileName = time() . "-{$uploadedFile}";  // random number + file name
                    $model->image = $fileName;
                }

                if ($model->save()) {
                    if ($uploadedFile) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../images/categories/' . $fileName);
                    }

                    /* 		    
                      // test Note
                      $model2 = new CDbCriteria();
                      $model2->limit = 1;
                      $model2->offset = 1;
                      $model2->order = "id DESC";
                      $Products = Snippet::model()->findAll($model2);
                     */
                    Yii::app()->user->setFlash('saveMessage', 'Item Category Saved Successfully....<a href="' . Yii::app()->request->baseUrl . '/index.php/product_category/add">Add New</a> &nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/product_category">View All</a>');
                    $this->refresh();
                }
            }


            $product_list = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('product_category')->queryAll();

            $this->render('add', array('model' => $model, 'product_list' => $product_list,));
        endif;
    }

    public function actionEdit($id) {

        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->item_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = Product_Category::model()->findByPk($id);
            if (!$model)
                throw new CHttpException(404);
            $data = Yii::app()->request->getPost('Product_Category');
            if ($data) {
                $model->setAttributes($data);
                $uploadedFile = CUploadedFile::getInstance($model, 'image');
                if ($uploadedFile) {
                    $fileName = time() . "-{$uploadedFile}";  // random number + file name
                    $model->image = $fileName;
                }

                if ($model->save()) {
                    if ($uploadedFile) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../images/categories/' . $fileName);
                    }

                    Yii::app()->user->setFlash('saveMessage', 'Item Category Modified Successfully...&nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/product_category">View All</a>');
                    $this->refresh();
                }
            }

            $product_list = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('product_category')->queryAll();

//            $_currency_id = Yii::app()->db->createCommand()
//                            ->select('product_category.*')
//                            ->join('product_category', 'currency.id = company.currency_id')                           
//                            ->from('product_category')->queryRow();

            $this->render('edit', array('model' => $model, 'product_list' => $product_list,));
        endif;
    }

    public function actionDelete($id) {

        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->item_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $catExt = new CDbCriteria(array('condition' => "product_category_id = '$id'",));
            $catVal = Product_Type::model()->findAll($catExt);

            if (count($catVal)):
                Yii::app()->user->setFlash('saveMessage', 'Sorry! This category is use in one or more item types.Please delete types first.');
                $this->redirect(array('product_category/index'));
            else:
                $model = Product_Category::model()->findByPk($id);
                $model->delete();
                Yii::app()->user->setFlash('saveMessage', 'Category deleted successfully.');
                $this->redirect(array('product_category/index'));
            endif;

        endif;
    }

    public function actionView($id) {

        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->item_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = Product_Category::model()->findByPk($id);
            if (!$model)
                throw new CException(404);
            $this->render('view', array('model' => $model,));

        endif;
    }

}
