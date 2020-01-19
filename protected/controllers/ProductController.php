<?php

class ProductController extends CController {

    public $layout = 'backend';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;
    public $fullcategoryName;

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
            // Search checkbox in post array
            foreach ($_POST as $key => $value) {
                // If checkbox found
                if (substr($key, 0, 9) == 'checkbox_') {

                    $itemExt = new CDbCriteria(array('condition' => "id = '$value'",));
                    $itemVal = Product::model()->findAll($itemExt);

                    if (count($itemVal)): foreach ($itemVal as $itemVal): $item_code = $itemVal->product_code;
                        endforeach;
                    endif;

                    $sellExt = new CDbCriteria(array('condition' => "product_code = '$item_code'",));
                    $sellVal = Sell_Product::model()->findAll($sellExt);

//                  $b2bsellExt = new CDbCriteria(array('condition' => "product_code = '$item_code'",));
//                  $b2bsellVal = B2b_Sell_Product::model()->findAll($b2bsellExt);

                    $purchaseExt = new CDbCriteria(array('condition' => "product_code = '$item_code'",));
                    $purchaseVal = Purchase_Product::model()->findAll($purchaseExt);

                    if (count($sellVal) or count($b2bsellVal) or count($purchaseVal)):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry! this Item is use in one or more sell or purchase invoices.Please delete invoices first.');
                        $this->redirect(array('product/index'));
                    else:
                        $model = Product::model()->findByPk($value);
                        $model->delete();
                        Yii::app()->user->setFlash('saveMessage', 'Item deleted successfully.');
                        $this->redirect(array('product/index'));
                    endif;
                }
            }

            $criteria = new CDbCriteria();

            $count = Product::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);

            $criteria->order = 'id DESC';
            $models = Product::model()->findAll($criteria);
            $this->render('index', array('models' => $models, 'pages' => $pages,));

        endif;
    }

    //setFetchMode(PDO::FETCH_OBJ);

    public function actionChanged() {

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

            // Search checkbox in post array
            foreach ($_POST as $key => $value) {
                // If checkbox found
                if (substr($key, 0, 9) == 'checkbox_') {



                    //$itemVal->product_code
                    Yii::app()->db->createCommand()
                            ->delete('change_product', "product_code='$value'");
                }
            }


            $_products = Yii::app()->db->createCommand()
                    ->setFetchMode(PDO::FETCH_OBJ)
                    ->select('change_product.update_time, product.*')
                    ->from('change_product')->join('product', 'product.product_code = change_product.product_code')
                    ->queryAll();

            $this->render('change_product', array('model' => $_products));

        endif;
    }

    public function actionExpiring() {

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


            $today = date('Y-m-d');
            $next_month = date('Y-m-d', mktime(0, 0, 0, date('m') + 1));

            $criteria_expired = new CDbCriteria();
            $criteria_expired->condition = "expire_date != '' AND expire_date <= '$today'";
            $count_expired = Product::model()->count($criteria_expired);

            $criteria_expiring = new CDbCriteria();
            $criteria_expiring->condition = "expire_date != '' AND expire_date > '$today' AND expire_date <= '$next_month'";
            $count_expiring += Product::model()->count($criteria_expired);

            $count = $count_expired > $count_expiring ? $count_expired : $count_expiring;

            $pages = new CPagination($count);
//            // elements per page
//            $pages->pageSize = 1;
//            //if($count_expired > $count_expiring)
//                $pages->applyLimit($criteria_expired);
//            //else
//                $pages->applyLimit($criteria_expiring);

            $criteria_expired->order = 'id DESC';
            $criteria_expiring->order = 'id DESC';

            $product_expired = Product::model()->findAll($criteria_expired);
            $product_expiring = Product::model()->findAll($criteria_expiring);

            $this->render('expire', array('product_expired' => $product_expired, 'product_expiring' => $product_expiring, 'pages' => $pages,));

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

            $model = new Product();
            $data = Yii::app()->request->getPost('Product');
            if ($data) {

                $data['expire_date'] = date('9999-31-12');
                $model->setAttributes($data);
                $model->product_category_id = $_POST['product_category_id'];
                $uploadedFile = CUploadedFile::getInstance($model, 'image');
                if ($uploadedFile) {
                    $fileName = "{$model->product_code}-{$uploadedFile}";  // random number + file name
                    $model->image = $fileName;
                }

                if ($model->save()) {
                    if ($uploadedFile) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../images/products/' . $fileName);
                    }
                    Yii::app()->user->setFlash('saveMessage', 'Item Saved Successfully....<a href="' . Yii::app()->request->baseUrl . '/product/add">Add New</a> &nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/product">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('add', array('model' => $model));
        endif;
    }

    public function getFullcategoryName($id, $str = array()) {

        $product_category = Yii::app()->db->createCommand()
                        ->select('*')
                        ->where("id = '$id'")
                        ->from('product_category')->queryRow();
        $str[$product_category['id']] = $product_category['category_name'];

        if ($product_category['parent_id'] > 0) {
            $this->getFullcategoryName($product_category['parent_id'], $str);
        } else {
            $this->fullcategoryName = implode("->", array_reverse($str));
            //  return  implode("->", array_reverse($str));
        }
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
            $model = Product::model()->findByPk($id);
            $this->getFullcategoryName($model['product_category_id']);
            $screens = Yii::app()->db->createCommand()
                            ->select('*')
                            ->order('sort_order')
                            ->from('screens')->queryAll();

            $condition = new CDbCriteria(array('condition' => "product_id = '$id'",));
            $screens_id = Screen_products::model()->find($condition);
            $product_screen_id = $screens_id ? $screens_id['screen_id'] : 0;
            if (!$model)
                throw new CHttpException(404);

            $data = Yii::app()->request->getPost('Product');
            if ($data) {

                if ($data['expire_date'] != '')
                    $data['expire_date'] = date('9999-31-12');
                $model->setAttributes($data);
                $model->product_category_id = $_POST['product_category_id'];
                $uploadedFile = CUploadedFile::getInstance($model, 'image');
                if ($uploadedFile) {
                    $fileName = "{$model->product_code}-{$uploadedFile}";  // random number + file name
                    $model->image = $fileName;
                }
                if ($model->save()) {
                    if ($uploadedFile) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../images/products/' . $fileName);
                    }

                    $product_id = $model->id;
                    if ($model->is_boucher == 1) {
                        $cond = new CDbCriteria(array('condition' => "product_id = '$product_id'",));

                        $modal1 = Screen_products::model()->find($cond);
                        if (!$modal1) {
                            $Screen = new Screen_products();
                            $Screen->setAttribute('product_id', $product_id);
                            $Screen->setAttribute('screen_id', $_POST['screen_id']);
                            $Screen->setAttribute('color', $_POST['color']);
                            $Screen->setAttribute('sort_order', $_POST['sort_order']);
                            $Screen->save();
                        } else {

                            $modal1->setAttribute('product_id', $product_id);
                            $modal1->setAttribute('screen_id', $_POST['screen_id']);
                            $modal1->setAttribute('color', $_POST['color']);
                            $modal1->setAttribute('sort_order', $_POST['sort_order']);
                            $modal1->save();
                        }
                    }
                    Yii::app()->user->setFlash('saveMessage', 'Item  Modified Successfully...&nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/product">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('edit', array('model' => $model, 'fullCategoryName' => $this->fullcategoryName, 'screens' => $screens, "screen_id" => $product_screen_id));
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

            $itemExt = new CDbCriteria(array('condition' => "id = '$id'",));
            $itemVal = Product::model()->findAll($itemExt);

            if (count($itemVal)): foreach ($itemVal as $itemVal): $item_code = $itemVal->product_code;
                endforeach;
            endif;

            $sellExt = new CDbCriteria(array('condition' => "product_code = '$item_code'",));
            $sellVal = Sell_Product::model()->findAll($sellExt);


            $purchaseExt = new CDbCriteria(array('condition' => "product_code = '$item_code'",));
            $purchaseVal = Purchase_Product::model()->findAll($purchaseExt);

            if (count($sellVal) || count($purchaseVal)):
                Yii::app()->user->setFlash('saveMessage', 'Sorry! this Item is use in one or more sell or purchase invoices.Please delete invoices first.');
                $this->redirect(array('product/index'));
            else:
                $model = Product::model()->findByPk($id);
                $model->delete();
                Yii::app()->user->setFlash('saveMessage', 'Item deleted successfully.');
                $this->redirect(array('product/index'));
            endif;

        endif;
    }

    public function actionProduct_List() {

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

            $model = new Product();
            $data = Yii::app()->request->getPost('Product');
            if (!empty($data)) {
                $product_category_id = $_POST['product_category_id'];
                $product_type_id = $data['product_type_id'];
                $product_brand_id = $data['product_brand_id'];

                $cond = '';
                if (!empty($cond) && !empty($product_category_id)): $cond .= " && product_category_id = '$product_category_id'";
                elseif (empty($cond) && !empty($product_category_id)): $cond .= "product_category_id = '$product_category_id'";
                endif;
                if (!empty($cond) && !empty($product_type_id)): $cond .= " && product_type_id = '$product_type_id'";
                elseif (empty($cond) && !empty($product_type_id)): $cond .= "product_type_id = '$product_type_id'";
                endif;
                if (!empty($cond) && !empty($product_brand_id)): $cond .= " && product_brand_id = '$product_brand_id'";
                elseif (empty($cond) && !empty($product_brand_id)): $cond .= "product_brand_id = '$product_brand_id'";
                endif;

                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $criteria->order = 'id DESC';
                $model = Product::model()->findAll($criteria);
                $this->render('product_list', array('model' => $model,));
            }
            else {
                $this->render('product_list_form', array('model' => $model,));
            }
        endif;
    }

    public function actionSearch() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = new Product();
            if ($_POST) {
                $product_name = $_POST['product_name'];

                $cond = '';
                if (!empty($cond) && !empty($product_name)): $cond .= " && product_name like '$product_name%'";
                elseif (empty($cond) && !empty($product_name)): $cond .= " product_name like '$product_name%'";
                endif;
                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $criteria->order = 'id DESC';
                $model = Product::model()->findAll($criteria);


                $count = Product::model()->count($criteria);
                $pages = new CPagination($count);
                // elements per page
                $pages->pageSize = 50;
                $pages->applyLimit($criteria);


                $this->render('search_list', array('models' => $model, 'pages' => $pages,));
            }
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

            $model = Product::model()->findByPk($id);
            if (!$model)
                throw new CException(404);
            $this->render('view', array('model' => $model,));

        endif;
    }

    public function actionBulkbarcode() {

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
            $ps = array();
            // Search checkbox in post array
            foreach ($_POST as $key => $value) {
                // If checkbox found
                if (substr($key, 0, 9) == 'checkbox_') {
                    // Unactivate Content based on checkbox value (id)
                    $ps[] = $value;
                }
            }

            $this->render('bulkbcode', array('ps' => $ps));
        endif;
    }

    public function actionBcode($id) {

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
            $cond = new CDbCriteria(array('condition' => "id = '$id'",));
            $models = Product::model()->findAll($cond);
            $this->render('bcode', array('models' => $models));
        endif;
    }

    public function actionBar_Generator() {

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

            $model = new Sell();
            if (count($_POST)) {
//                $product_type = $_POST['product_type'];
//                $product_brand = $_POST['product_brand'];
                $product_code = $_POST['product_code'];
                $barcode_no = $_POST['barcode_no'];

                $criteria = new CDbCriteria();
                $criteria->condition = " product_code = '$product_code'";
                $criteria->order = 'id ASC';

                $model = Product::model()->findAll($criteria);
                $this->render('barcode_report', array('model' => $model, 'barcode_no' => $barcode_no,));
            } else {
                $this->render('barcode_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionWholesaleEdit($id) {

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
            $model = Product::model()->findByPk($id);
            if (!$model)
                throw new CHttpException(404);
            $data = Yii::app()->request->getPost('Product');
            if ($data) {

                $model->setAttributes($data);
                if ($model->save()) {
                    Yii::app()->user->setFlash('saveMessage', 'Item  Modified Successfully...&nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/product">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('wholesale_edit', array('model' => $model));
        endif;
    }

    function actionShowScreen($id) {

        $criteria = new CDbCriteria;
        $criteria->select = 'DISTINCT t.*';   // ,sc.name as screen_name
        $criteria->join = ' LEFT JOIN `screen_products` AS `sp` ON t.id = sp.product_id';
        $criteria->condition = "t.is_boucher = 1 AND sp.screen_id =$id";
        $criteria->order = 'sp.sort_order DESC';
        $models = Product::model()->findAll($criteria);


        if ($id == 1) {
            $this->renderPartial('show_screen_products_for_checken', array('models' => $models));
        } elseif ($id == 2) {
            $this->renderPartial('show_screen_products_for_meat', array('models' => $models));
        } else {
            $this->renderPartial('show_screen_products_for_fish', array('models' => $models));
        }
        // $this->renderPartial('show_screen_products', array('models' => $models));
    }

    function actionScreenProduct($id) {

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
            $criteria = new CDbCriteria;
            $criteria->select = 'DISTINCT t.*';   //,sc.name as screen_name
            $criteria->join = ' LEFT JOIN `screen_products` AS `sp` ON t.id = sp.product_id';
            $criteria->condition = "t.is_boucher = 1 AND sp.screen_id =$id";
            $criteria->order = 'sp.sort_order DESC';
            $models = Product::model()->findAll($criteria);

            $this->render('products_by_screen', array('models' => $models, 'screen_name' => array(),));
        endif;
    }

    function actionScreen_products() {
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
            $criteria = new CDbCriteria;
            $criteria->select = 'DISTINCT t.*';   // ,sc.name as screen_name
            $criteria->join = ' LEFT JOIN `screen_products` AS `sp` ON t.id = sp.product_id';
            $criteria->condition = "t.is_boucher = 1";

            $count = Product::model()->count($criteria);
            $pages = new CPagination($count);

            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);

            $criteria->order = 'id DESC';
            $models = Product::model()->findAll($criteria);
            $this->render('screen_products', array('models' => $models, 'pages' => $pages,));
        endif;
    }

    function actionScreens() {
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
            $criteria = new CDbCriteria();
            $count = Screens::model()->count($criteria);
            $criteria->order = 'id ASC';
            $data['screens'] = Screens::model()->findAll($criteria);
            $this->render('screens', $data);
        endif;
    }

    function actionAddScreen() {
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

            $criteria = new CDbCriteria();

            $count = Screens::model()->count($criteria);
            $criteria->order = 'sort_order DESC';
            $data['screens'] = Screens::model()->findAll($criteria);
            $this->render('screens', $data);
        endif;
    }

    public function actionEditScreenProduct($id) {

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
            $dataa = array();

            $dataa['product'] = Yii::app()->db->createCommand()
                            ->select('*')
                            ->where("id = '$id'")
                            ->from('screen_products')->queryRow();

            if (!$dataa['product'])
                throw new CHttpException(404);

            $data = Yii::app()->request->getPost('Product');
            if ($data) {
                $id = $data['id'];
                $cond = new CDbCriteria(array('condition' => "id = '$id'",));
                $modal = Screen_products::model()->find($cond);
                if ($modal) {

                    $modal->setAttribute('screen_id', $data['screen_id']);
                    $modal->setAttribute('color', $data['color']);
                    $modal->setAttribute('sort_order', $data['sort_order']);
                    if ($modal->save()) {
                        Yii::app()->user->setFlash('saveMessage', 'Item  Modified Successfully...&nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/product/screenProduct/' . $data['screen_id'] . '">View All</a>');
                        $this->refresh();
                    }
                }
            }


            $dataa['screens'] = Yii::app()->db->createCommand()
                            ->select('*')
                            ->order('sort_order')
                            ->from('screens')->queryAll();


            $this->render('editScreenProduct', $dataa);
        endif;
    }

    public function actionProduct_report() {

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

//               $today = date("Y-m-d", strtotime("-7 days"));
//            $_products = Yii::app()->db->createCommand()
//                            ->select('count(sell_order_product.id) as countProduct,product.product_name,product.product_code,product.id')
//                            ->join('sell_order_product', 'sell_order_product.invoice_no = sell_order.invoice_no')
//                            ->join('product', 'product.product_code = sell_order_product.product_code')
//                            ->where("sell_order.order_date > '" . $today . "'")
//                            ->order('sell_order.order_date DESC')
//                               ->group('sell_order_product.product_code')
//                            ->from('sell_order')->limit(3)->queryAll();
//
//            print_r($_products);
//            exit();
//            $_products = Yii::app()->db->createCommand()
//                            ->select('count(id) as countProduct,product_code')
//                            ->order('countProduct DESC')
//                            ->group('product_code')
//                            ->from('sell_order_product')->limit(20)->queryAll();
// 
//            $data['products'] =   $_products;
//            
//               $products = Yii::app()->db->createCommand()
//                            ->select('count(id) as countProduct,product_code')
//                            ->order('countProduct ASC')
//                            ->group('product_code')
//                            ->from('sell_order_product')->limit(20)->queryAll();
// 
//            $data['lowproducts'] =   $products;
            $this->render('product_report');

        endif;
    }

    function actionProduct_sync() {
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
            
            $this->render('product_sync', array('models' => array()));
        endif;
    }

}
