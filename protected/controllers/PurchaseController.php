<?php

class PurchaseController extends CController {

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
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();

            $count = Purchase::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);
            $criteria->order = 'id DESC';
            $models = Purchase::model()->findAll($criteria);
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
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Purchase();
            $data = Yii::app()->request->getPost('Purchase');
            $username = Yii::app()->user->name;

            if ($data) {
                $model->setAttributes($data);
                $model->price_grand_total = $_POST['price_grand_total'];
                $model->status = 0;
                $model->user_id = $username;
                $chalan_id = $model->chalan_id;
                $purchase_date = $model->purchase_date;
                if ($model->save()) {
                    $model2 = new Stock();
                    $product_code = $_POST['product_code22'];
                    $quantity = $_POST['quantity'];
                    $product_price = $_POST['price'];
                    $sell_price = $_POST['s_price'];
                    $wholesale_price = $_POST['wholesale_price'];
                    $descriotion = $_POST['description'];
                    $profit = $_POST['profit'];
                    $vat = $_POST['vat'];
                    $criteria2 = new CDbCriteria();
                    $criteria2->order = 'id DESC';
                    $criteria2->limit = 1;
                    $purchase_values = Purchase::model()->findAll($criteria2);
                    foreach ($purchase_values as $purchase_value): $purchase_id = $purchase_value->id;
                    endforeach;

                    for ($p = 0; $p < sizeof($product_code); $p++):

                        $product_code2 = $product_code[$p];
                        $quantity2 = $quantity[$p];
                        $product_price2 = $product_price[$p];
                        $sell_price2 = $sell_price[$p];
                        $wholesale_price2 = $wholesale_price[$p];
                        $description2 = $descriotion[$p];
                        $profit2 = $profit[$p];
                        $vat2 = $vat[$p];
                        $vat_on_purchase = number_format(($vat2 / 100) * $product_price2, 2);
                        $vat_on_profit = (number_format(($profit2 / 100) * $product_price2, 2) / 100) * $vat2;

                        $itemCond = "product_code = '$product_code2'";
                        $product_ = Product::model()->find($itemCond);
                        if ($product_->purchase_cost != $product_price2 || $product_->sell_price != $sell_price2 || $product_->other_cost != $profit2 || $product_->vat != $vat2) {
                            $command_ = Yii::app()->db->createCommand();
                            $command_->delete("change_product", $itemCond);

                            $command_ = Yii::app()->db->createCommand();
                            $command_->insert('change_product', array(
                                'product_code' => $product_code2,
                                'update_time' => date('Y-m-d H:i:s')
                            ));
                        }
                        $command44 = Yii::app()->db->createCommand();
                        $command44->update('product', array('purchase_cost' => $product_price2, 'sell_price' => $sell_price2, 'wholesale_price' => $wholesale_price2,
                            'description' => $description2, 'other_cost' => $profit2, 'vat' => $vat2,
                            'vat_on_purchase' => $vat_on_purchase, 'vat_on_profit' => $vat_on_profit
                                ), $itemCond);


                        $cos = "product_code = '$product_code2'";
                        $cond = new CDbCriteria(array('condition' => "product_code = '$product_code2'",));
                        $stockExValues = Stock::model()->findAll($cond);

                        if (count($stockExValues)):
                            foreach ($stockExValues as $stockExValue): $quantity_stock = $quantity2 + $stockExValue->product_balance;
                            endforeach;

                            $command = Yii::app()->db->createCommand();
                            $command->insert('purchase_product', array(
                                'chalan_id' => $chalan_id,
                                'purchase_id' => $purchase_id,
                                'purchase_date' => $purchase_date,
                                'product_code' => $product_code2,
                                'quantity' => $quantity2,
                                'product_price' => $product_price2,
                                'product_profit' => $profit2,
                                'product_vat' => $vat2,
                                'sell_price' => $sell_price2,
                                'wholesale_price' => $wholesale_price2,
                                'en_sl' => $p + 1,
                            ));


                            $command->update('stock', array('product_balance' => $quantity_stock,), $cos);

                        else:

                            $command = Yii::app()->db->createCommand();

                            $command->insert('purchase_product', array(
                                'chalan_id' => $chalan_id,
                                'purchase_id' => $purchase_id,
                                'purchase_date' => $purchase_date,
                                'product_code' => $product_code2,
                                'quantity' => $quantity2,
                                'product_price' => $product_price2,
                                'sell_price' => $sell_price2,
                                'wholesale_price' => $wholesale_price2,
                                'product_profit' => $profit2,
                                'product_vat' => $vat2,
                                'en_sl' => $p + 1,
                            ));


                            $command->insert('stock', array(
                                'product_code' => $product_code2,
                                'product_balance' => $quantity2,
                            ));
                        endif;

                        $command44 = Yii::app()->db->createCommand();
                        $command44->update('product', array('purchase_date' => $purchase_date), "product_code = '$product_code2'");

                    endfor;

                    Yii::app()->user->setFlash('saveMessage', 'Product Receive Completed....<a href="' . Yii::app()->request->baseUrl . '/purchase/add">Add New</a> &nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/purchase">View All</a>');
                    $model_Ptemporary = new Purchase_Tempory();
                    $model_Ptemporary->deleteAll("user_id = '$username'");
                    $this->refresh();
                }
            }
            $this->render('add', array('model' => $model,));
        endif;
    }

    public function actionAddBox() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Purchase();
            $data = Yii::app()->request->getPost('Purchase');
            $username = Yii::app()->user->name;

            if ($data) {
                $model->setAttributes($data);
                $model->price_grand_total = $_POST['price_grand_total'];
                $model->status = 0;
                $model->user_id = $username;
                $chalan_id = $model->chalan_id;
                $purchase_date = $model->purchase_date;
                if ($model->save()) {
                    $model2 = new Stock();
                    $product_code = $_POST['product_code22'];
                    $quantity = $_POST['quantity'];
                    $product_price = $_POST['price'];
                    $sell_price = $_POST['s_price'];
                    $descriotion = $_POST['description'];
                    $profit = $_POST['profit'];
                    $vat = $_POST['vat'];
                    $criteria2 = new CDbCriteria();
                    $criteria2->order = 'id DESC';
                    $criteria2->limit = 1;
                    $purchase_values = Purchase::model()->findAll($criteria2);
                    foreach ($purchase_values as $purchase_value): $purchase_id = $purchase_value->id;
                    endforeach;

                    for ($p = 0; $p < sizeof($product_code); $p++):

                        $product_code2 = $product_code[$p];
                        $quantity2 = $quantity[$p];
                        $product_price2 = $product_price[$p];
                        $sell_price2 = $sell_price[$p];
                        $description2 = $descriotion[$p];
                        $profit2 = $profit[$p];
                        $vat2 = $vat[$p];
                        $vat_on_purchase = number_format(($vat2 / 100) * $product_price2, 2);
                        $vat_on_profit = (number_format(($profit2 / 100) * $product_price2, 2) / 100) * $vat2;

                        $itemCond = "product_code = '$product_code2'";
                        $product_ = Product::model()->find($itemCond);
                        if ($product_->purchase_cost != $product_price2 || $product_->sell_price != $sell_price2 || $product_->other_cost != $profit2 || $product_->vat != $vat2) {
                            $command_ = Yii::app()->db->createCommand();
                            $command_->delete("change_product", $itemCond);

                            $command_ = Yii::app()->db->createCommand();
                            $command_->insert('change_product', array(
                                'product_code' => $product_code2,
                                'update_time' => date('Y-m-d H:i:s')
                            ));
                        }
                        $command44 = Yii::app()->db->createCommand();
                        $command44->update('product', array('purchase_cost' => $product_price2, 'sell_price' => $sell_price2,
                            'description' => $description2, 'other_cost' => $profit2, 'vat' => $vat2,
                            'vat_on_purchase' => $vat_on_purchase, 'vat_on_profit' => $vat_on_profit
                                ), $itemCond);


                        $cos = "product_code = '$product_code2'";
                        $cond = new CDbCriteria(array('condition' => "product_code = '$product_code2'",));
                        $stockExValues = Stock::model()->findAll($cond);

                        if (count($stockExValues)):
                            foreach ($stockExValues as $stockExValue): $quantity_stock = $quantity2 + $stockExValue->product_balance;
                            endforeach;

                            $command = Yii::app()->db->createCommand();
                            $command->insert('purchase_product', array(
                                'chalan_id' => $chalan_id,
                                'purchase_id' => $purchase_id,
                                'purchase_date' => $purchase_date,
                                'product_code' => $product_code2,
                                'quantity' => $quantity2,
                                'product_price' => $product_price2,
                                'product_profit' => $profit2,
                                'product_vat' => $vat2,
                                'sell_price' => $sell_price2,
                                'en_sl' => $p + 1,
                            ));


                            $command->update('stock', array('product_balance' => $quantity_stock,), $cos);

                        else:

                            $command = Yii::app()->db->createCommand();

                            $command->insert('purchase_product', array(
                                'chalan_id' => $chalan_id,
                                'purchase_id' => $purchase_id,
                                'purchase_date' => $purchase_date,
                                'product_code' => $product_code2,
                                'quantity' => $quantity2,
                                'product_price' => $product_price2,
                                'sell_price' => $sell_price2,
                                'product_profit' => $profit2,
                                'product_vat' => $vat2,
                                'en_sl' => $p + 1,
                            ));


                            $command->insert('stock', array(
                                'product_code' => $product_code2,
                                'product_balance' => $quantity2,
                            ));
                        endif;

                        $command44 = Yii::app()->db->createCommand();
                        $command44->update('product', array('purchase_date' => $purchase_date), "product_code = '$product_code2'");

                    endfor;

                    Yii::app()->user->setFlash('saveMessage', 'Product Receive Completed....<a href="' . Yii::app()->request->baseUrl . '/purchase/add">Add New</a> &nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/purchase">View All</a>');
                    $model_Ptemporary = new Purchase_Tempory();
                    $model_Ptemporary->deleteAll("user_id = '$username'");
                    $this->refresh();
                }
            }
            $this->render('addBox', array('model' => $model,));
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
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            // code for delete previous record
            $model = Purchase::model()->findByPk($id);
            $data = Yii::app()->request->getPost('Purchase');

            if ($data) {
                $model->setAttributes($data);
                $pre_id = $model->id;
                $pre_purchase_id = $model->purchase_id;
                $pre_chalan_id = $model->chalan_id;
                $pre_purchase_date = $model->purchase_date;
                $pre_note = $model->note;
                $pre_supplier_id = $model->supplier_id;
                $model->save();

                $cond22 = new CDbCriteria(array('condition' => "purchase_id = '$model->id'",));
                $purchaseProductValues = Purchase_Product::model()->findAll($cond22);
                if (count($purchaseProductValues)):
                    foreach ($purchaseProductValues as $purchaseProduct):

                        $product_code = $purchaseProduct->product_code;
                        $quantity1 = $purchaseProduct->quantity;

                        $cond = new CDbCriteria(array('condition' => "product_code = '$product_code'",));
                        $stockValues = Stock::model()->findAll($cond);

                        if (count($stockValues)): foreach ($stockValues as $data2):
                                $stock_id = $data2->id;
                                $product_balance = $data2->product_balance;
                            endforeach;
                        endif;

                        $cond2 = "id = '$stock_id'";

                        $command = Yii::app()->db->createCommand();
                        $command->update('stock', array('product_balance' => $product_balance - $quantity1,), $cond2);
                    endforeach;
                endif;
                $cond3 = "purchase_id = '$id'";
                $command->delete('purchase_product', $cond3);
                $model->delete();
                // end delete operation
                // start code for insert

                $username = Yii::app()->user->name;
                $product_code = $_POST['product_code'];
                $quantity = $_POST['quantity'];
                $product_price = $_POST['price'];

                $price_grand_total = 0;
                for ($p = 0; $p < sizeof($product_code); $p++):
                    $quantity2 = $quantity[$p];
                    $product_price2 = $product_price[$p];
                    $sub_total = $product_price2 * $quantity2;
                    $price_grand_total = $price_grand_total + $sub_total;
                endfor;

                $command = Yii::app()->db->createCommand();
                $command->insert('purchase', array(
                    'id' => $pre_id,
                    'purchase_id' => $pre_purchase_id,
                    'chalan_id' => $pre_chalan_id,
                    'purchase_date' => $pre_purchase_date,
                    'note' => $pre_note,
                    'price_grand_total' => $price_grand_total,
                    'supplier_id' => $pre_supplier_id,
                    'status' => 0,
                    'user_id' => $username,
                ));


                $purchase_id = $pre_id;
                $chalan_id = $pre_chalan_id;

                for ($p = 0; $p < sizeof($product_code); $p++):

                    $product_code2 = $product_code[$p];
                    $quantity2 = $quantity[$p];
                    $product_price2 = $product_price[$p];

                    $cos = "product_code = '$product_code2'";
                    $cond = new CDbCriteria(array('condition' => "product_code = '$product_code2'",));
                    $stockExValues = Stock::model()->findAll($cond);

                    if (count($stockExValues)):
                        foreach ($stockExValues as $stockExValue): $quantity_stock = $quantity2 + $stockExValue->product_balance;
                        endforeach;

                        $command = Yii::app()->db->createCommand();
                        $command->insert('purchase_product', array(
                            'chalan_id' => $chalan_id,
                            'purchase_id' => $purchase_id,
                            'purchase_date' => $pre_purchase_date,
                            'product_code' => $product_code2,
                            'quantity' => $quantity2,
                            'product_price' => $product_price2,
                            'en_sl' => $p + 1,
                        ));

                        $command->update('stock', array('product_balance' => $quantity_stock,), $cos);

                    else:

                        $command = Yii::app()->db->createCommand();

                        $command->insert('purchase_product', array(
                            'chalan_id' => $chalan_id,
                            'purchase_id' => $purchase_id,
                            'purchase_date' => $pre_purchase_date,
                            'product_code' => $product_code2,
                            'quantity' => $quantity2,
                            'product_price' => $product_price2,
                            'en_sl' => $p + 1,
                        ));

                        $command->insert('stock', array(
                            'product_code' => $product_code2,
                            'product_balance' => $quantity2,
                        ));
                    endif;
                endfor;

                Yii::app()->user->setFlash('saveMessage', 'Product Receive  Modified Completed....<a href="' . Yii::app()->request->baseUrl . '/purchase">View All</a>');
                $this->refresh();
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
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = Purchase::model()->findByPk($id);

            $cond22 = new CDbCriteria(array('condition' => "purchase_id = '$id'",));
            $purchaseValues = Purchase_Product::model()->findAll($cond22);

            if (count($purchaseValues)):
                foreach ($purchaseValues as $purchaseValue):

                    $product_code = $purchaseValue->product_code;
                    $quantity1 = $purchaseValue->quantity;

                    $cond = new CDbCriteria(array('condition' => "product_code = '$product_code'",));
                    $stockValues = Stock::model()->findAll($cond);

                    if (count($stockValues)): foreach ($stockValues as $data2):
                            $stock_id = $data2->id;
                            $product_balance = $data2->product_balance;
                        endforeach;
                    endif;

                    $cond2 = "id = '$stock_id'";

                    $command = Yii::app()->db->createCommand();
                    $command->update('stock', array('product_balance' => $product_balance - $quantity1,), $cond2);
                endforeach;
            endif;
            $cond3 = "purchase_id = '$id'";
            $command->delete('purchase_product', $cond3);
            $model->delete();
            $this->redirect(array('purchase/index'));
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
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Purchase();
            $supplier_id = $_POST['supplier_id'];
            $start_date2 = $_POST['start_date'];
            $end_date2 = $_POST['end_date'];

            if (!empty($start_date2)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
            else: $start_date = "";
            endif;
            if (!empty($end_date2)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
            else: $end_date = "";
            endif;

            if ($_POST) {
                $cond = '';
                if (!empty($cond) && !empty($supplier_id)): $cond .= " && supplier_id = '$supplier_id'";
                elseif (empty($cond) && !empty($supplier_id)): $cond .= "supplier_id = '$supplier_id'";
                endif;
                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && purchase_date >= '$start_date' && purchase_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " purchase_date >= '$start_date' && purchase_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && purchase_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= "purchase_date = '$start_date'";
                endif;

                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $model = Purchase::model()->findAll($criteria);
                $this->render('purchase_report', array('model' => $model,));
            }
            else {
                $this->render('purchase_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionProduct_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Purchase_Product();

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
                $criteria->order = 'id ASC';
                $model = Purchase_Product::model()->findAll($criteria);
                $this->render('purchase_product_report', array('model' => $model,));
            }
            else {
                $this->render('purchase_product_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionEntry() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $user_id = Yii::app()->user->name;

            // code for reinsert datagride value
            $product_code22 = @$_POST['product_code22'];
            $quantity22 = @$_POST['quantity'];
            $price22 = @$_POST['price'];
            $sell_price = @$_POST['s_price'];
            $profit = @$_POST['profit'];
            $vat = @$_POST['vat'];
            $description = @$_POST['description'];
            $wholesale_price = @$_POST['wholesale_price'];
            if (!empty($product_code22)):

                for ($p = 0; $p < sizeof($product_code22); $p++):

                    $product_code2 = $product_code22[$p];
                    $quantity2 = $quantity22[$p];
                    $price2 = $price22[$p];
                    $sell_price2 = $sell_price[$p];
                    $profit2 = $profit[$p];
                    $vat2 = $vat[$p];
                    $wholesale_price2 = $wholesale_price[$p];
                    $description = $_POST['description'][$p];

                    if (!empty($sell_price2) || !empty($description)):
                        $command44 = Yii::app()->db->createCommand();
                        $command44->update('product', array('purchase_cost' => $price2, 'sell_price' => $sell_price2, 'other_cost' => $profit2, 'vat' => $vat2, 'description' => $description, 'wholesale_price' => $wholesale_price2), "product_code = '$product_code2'");
                    endif;
                    $update_cond = "user_id = '$user_id' && product_code = '$product_code2'";
                    $update1 = new CDbCriteria(array('condition' => $update_cond,));
                    $itemExists = Purchase_Tempory::model()->findAll($update1);

                    if (count($itemExists)):

                        $command = Yii::app()->db->createCommand();
                        $command->update('purchase_tempory', array('p_price' => $price2, 'sell_price' => $sell_price2, 'vat' => $vat2, 'profit' => $profit2, 'quantity' => $quantity2, 'description' => $description, 'wholesale_price' => $wholesale_price2), $update_cond);

                    else:
                        $command = Yii::app()->db->createCommand();
                        $command->insert('purchase_tempory', array(
                            'user_id' => $user_id,
                            'product_code' => $product_code2,
                            'p_price' => $price2,
                            'sell_price' => $sell_price2,
                            'quantity' => $quantity2,
                            'profit' => $profit2,
                            'vat' => $vat2,
                            'description' => $description,
                            'wholesale_price' => $wholesale_price2
                        ));
                    endif;
                endfor;
            endif;

            // end temporary reinsert

            $model = new Product();
            $product_code = $_POST['product_id'];
            $qty = $_POST['qty'];
            $criteria = new CDbCriteria();
            $criteria->condition = "product_code = '$product_code'";
            $model = Product::model()->find($criteria);

            if ($model):

                $product_code = $model->product_code;
                $p_price = $model->purchase_cost;
                $p_profit = $model->other_cost;
                $p_vat = $model->vat;
                $sell_price = $model->sell_price;
                $wholesale_price = $model->wholesale_price;
                $description = $model->description;


                $cond = "user_id = '$user_id' && product_code = '$product_code'";
                $q1 = new CDbCriteria(array('condition' => $cond,));
                $dataExists = Purchase_Tempory::model()->findAll($q1);

                if (count($dataExists)):
                    foreach ($dataExists as $data):
                        $pre_qty = $data->quantity;
                    endforeach;
                    $qty = $pre_qty + $qty;

                    $command = Yii::app()->db->createCommand();
                    $command->update('purchase_tempory', array('p_price' => $p_price, 'quantity' => $qty,), $cond);

                else:
                    $command = Yii::app()->db->createCommand();
                    $command->insert('purchase_tempory', array(
                        'user_id' => $user_id,
                        'product_code' => $product_code,
                        'p_price' => $p_price,
                        'sell_price' => $sell_price,
                        'quantity' => $qty,
                        'profit' => $p_profit,
                        'vat' => $p_vat,
                        'description' => $description,
                        'wholesale_price' => $wholesale_price
                    ));
                endif;
            endif;
            $this->redirect(array('purchase/add'));

        endif;
    }

    public function actionEntryBox() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $user_id = Yii::app()->user->name;

            // code for reinsert datagride value
            $product_code22 = @$_POST['product_code22'];
            $quantity22 = @$_POST['quantity'];
            $price22 = @$_POST['price'];
            $sell_price = @$_POST['s_price'];
            $profit = @$_POST['profit'];
            $vat = @$_POST['vat'];
            if (!empty($product_code22)):

                for ($p = 0; $p < sizeof($product_code22); $p++):

                    $product_code2 = $product_code22[$p];
                    $quantity2 = $quantity22[$p];
                    $price2 = $price22[$p];
                    $sell_price2 = $sell_price[$p];
                    $profit2 = $profit[$p];
                    $vat2 = $vat[$p];
                    $description = $_POST['description'][$p];

                    if (!empty($sell_price2) || !empty($description)):
                        $command44 = Yii::app()->db->createCommand();
                        $command44->update('product', array('purchase_cost' => $price2, 'sell_price' => $sell_price2, 'other_cost' => $profit2, 'vat' => $vat2, 'description' => $description), "product_code = '$product_code2'");
                    endif;
                    $update_cond = "user_id = '$user_id' && product_code = '$product_code2'";
                    $update1 = new CDbCriteria(array('condition' => $update_cond,));
                    $itemExists = Purchase_Tempory::model()->findAll($update1);

                    if (count($itemExists)):

                        $command = Yii::app()->db->createCommand();
                        $command->update('purchase_tempory', array('p_price' => $price2, 'sell_price' => $sell_price2, 'vat' => $vat2, 'profit' => $profit2, 'quantity' => $quantity2,), $update_cond);

                    else:
                        $command = Yii::app()->db->createCommand();
                        $command->insert('purchase_tempory', array(
                            'user_id' => $user_id,
                            'product_code' => $product_code2,
                            'p_price' => $price2,
                            'sell_price' => $sell_price2,
                            'quantity' => $quantity2,
                            'profit' => $profit2,
                            'vat' => $vat2
                        ));
                    endif;
                endfor;
            endif;

            // end temporary reinsert

            $model = new Product();
            $product_code = $_POST['product_id'];
            $qty = $_POST['qty'];
            $criteria = new CDbCriteria();
            $criteria->condition = "product_code = '$product_code'";
            $model = Product::model()->find($criteria);

            if ($model):

                $product_code = $model->product_code;
                $p_price = $model->purchase_cost;
                $p_profit = $model->other_cost;
                $p_vat = $model->vat;
                $sell_price = $model->sell_price;


                $cond = "user_id = '$user_id' && product_code = '$product_code'";
                $q1 = new CDbCriteria(array('condition' => $cond,));
                $dataExists = Purchase_Tempory::model()->findAll($q1);

                if (count($dataExists)):
                    foreach ($dataExists as $data):
                        $pre_qty = $data->quantity;
                    endforeach;
                    $qty = $pre_qty + $qty;

                    $command = Yii::app()->db->createCommand();
                    $command->update('purchase_tempory', array('p_price' => $p_price, 'quantity' => $qty,), $cond);

                else:
                    $command = Yii::app()->db->createCommand();
                    $command->insert('purchase_tempory', array(
                        'user_id' => $user_id,
                        'product_code' => $product_code,
                        'p_price' => $p_price,
                        'sell_price' => $sell_price,
                        'quantity' => $qty,
                        'profit' => $p_profit,
                        'vat' => $p_vat
                    ));
                endif;
            endif;
            $this->redirect(array('purchase/addBox'));

        endif;
    }

    public function actionRemove($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $model = Purchase_Tempory::model()->findByPk($id);
            $model->delete();
            $this->redirect(array('purchase/add'));
        endif;
    }

    public function actionRemoveBox($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $model = Purchase_Tempory::model()->findByPk($id);
            $model->delete();
            $this->redirect(array('purchase/addBox'));
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
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();
            $criteria->condition = "id = '$id'";
            $models = Purchase::model()->findAll($criteria);
            $this->render('view', array('models' => $models,));

        endif;
    }

    public function actionView2($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();
            $criteria->condition = "chalan_id = '$id'";
            $criteria->limit = '1';
            $models = Purchase::model()->findAll($criteria);
            $this->render('view', array('models' => $models,));

        endif;
    }

}
