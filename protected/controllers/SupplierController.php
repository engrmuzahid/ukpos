<?php

class SupplierController extends CController {

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

    public function actionSupplier_List() {
        $supplierid = $_POST['supplier_id'];
        if ($supplierid) {
            $b = 0;
            $criteria = new CDbCriteria(
                    array('condition' =>
                'supplier_id = "$supplierid"',
                'status = "$b',
            ));
            $models4 = Purchase::model()->findAll(array($criteria, 'order' => 'chalan_id'));
        } else {
            $models4 = Purchase::model()->findAll(array('order' => 'chalan_id'));
        }
        $supplierlists = CHtml::listData($models4, 'chalan_id', 'chalan_id');
        $output = CHtml::dropDownList('chalan_id', 'chalan_id', $supplierlists, array('empty' => 'Select Supplier Invoice', 'style' => 'width:150px;height:25px;border:1px solid #CCC;'));
        echo $output;
    }

    public function actionIndex() {
        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->supplier_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $criteria = new CDbCriteria();

            $count = Supplier::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);

            $criteria->order = 'id DESC';
            $models = Supplier::model()->findAll($criteria);
            $this->render('index', array('models' => $models, 'pages' => $pages,));

        endif;
    }

    public function actionAdd() {
        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->supplier_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = new Supplier();
            $data = Yii::app()->request->getPost('Supplier');
            if ($data) {
                $model->setAttributes($data);

                if ($model->save()) {
                    Yii::app()->user->setFlash('saveMessage', 'Supplier Information Saved Successfully....<a href="' . Yii::app()->request->baseUrl . '/index.php/supplier/add">Add New</a> &nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/supplier">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('add', array('model' => $model,));
        endif;
    }

    public function actionEdit($id) {
        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->supplier_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = Supplier::model()->findByPk($id);
            if (!$model)
                throw new CHttpException(404);
            $data = Yii::app()->request->getPost('Supplier');
            if ($data) {
                $model->setAttributes($data);

                if ($model->save()) {

                    Yii::app()->user->setFlash('saveMessage', 'Supplier Information Modified Successfully...&nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/supplier">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('edit', array('model' => $model,));
        endif;
    }

    public function actionDelete($id) {
        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->supplier_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $purchaseExt = new CDbCriteria(array('condition' => "supplier_id = '$id'",));
            $purchaseVal = Purchase::model()->findAll($purchaseExt);

            $payExt = new CDbCriteria(array('condition' => "supplier_id = '$id'",));
            $payVal = Supplier_Payment::model()->findAll($payExt);


            if (count($purchaseVal) or count($payVal)):
                Yii::app()->user->setFlash('saveMessage', 'Sorry! this Supplier is available in one or more receiving records or accounts..');
                $this->redirect(array('supplier/index'));
            else:
                $model = Supplier::model()->findByPk($id);
                $model->delete();
                Yii::app()->user->setFlash('saveMessage', 'Supplier deleted successfully.');
                $this->redirect(array('supplier/index'));
            endif;

        endif;
    }

    public function actionView($id) {
        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->supplier_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $criteria = new CDbCriteria();
            $criteria->condition = "id = '$id'";
            $models = Supplier::model()->findAll($criteria);
            $this->render('view', array('models' => $models,));

        endif;
    }

    public function actionPayable_Report() {
        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->supplier_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = new Account_Received();

            if ($_POST) {
                $cond = "status = 0";

                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($start_date));
                else: $start_date = "";
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($end_date));
                else: $end_date = "";
                endif;

                $supplier_id = $_POST['supplier_id'];
                $chalan_id = $_POST['chalan_id'];
                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && purchase_date >= '$start_date' && purchase_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " purchase_date >= '$start_date' && purchase_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && purchase_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " purchase_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($supplier_id)): $cond .= " && supplier_id = '$supplier_id'";
                elseif (empty($cond) && !empty($supplier_id)): $cond .= " supplier_id = '$supplier_id'";
                endif;
                if (!empty($cond) && !empty($chalan_id)): $cond .= " && chalan_id = '$chalan_id'";
                elseif (empty($cond) && !empty($chalan_id)): $cond .= " chalan_id = '$chalan_id'";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Purchase::model()->findAll($cond2);
                $this->render('account_payable_report', array('model' => $model,));
            }
            else {
                $this->render('account_payable_report_form', array('model' => $model,));
            }
        endif;
    }

    
    public function actionPrint_Report() {

        $invoice_ids = implode(",", json_decode($_POST['invoice_ids']));
        $customer_ids = json_decode($_POST['customer_ids']); 
        
        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'NativeMail' . DIRECTORY_SEPARATOR . 'nativemail.php');
 
            $Customer = Customer::model()->findAllByPk($customer_ids[0]);
            
            $customer_invoices = Yii::app()->db->createCommand("SELECT * FROM sell_order WHERE customer_id = $customer_ids[0] AND invoice_no IN ($invoice_ids)")->queryAll();            
            
            $this->renderPartial('bluk_print', array('model' => $customer_invoices,$invoice_ids ));
    }

    
    public function actionDeletePurchase() {
        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->supplier_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest') {
            echo 'No Permission';
            exit();
        }

        $chalan_id = $_REQUEST['chalan_id'];
        $criteria = new CDbCriteria();
        $criteria->condition = "chalan_id = '$chalan_id'";
        Purchase_Product::model()->deleteAll($criteria);
        Purchase::model()->deleteAll($criteria);
        echo "DONE";
    }

    public function actioninteditchaque() {


        if ($_POST) {
            $cond = 'id = ' . $_POST['id'];

            $model = Yii::app()->db->createCommand()
                    ->update('chaque_payments', array("is_confirm" => $_POST['is_confirm'], "confirm_date" => $_POST['confirm_date'], "notes" => $_POST['notes']), $cond);

            $cond = 'chaque_payments.total_amount > 0 AND supplier_payment.payment_mode = 1';

            if (@$_POST['start_date']) {
                $cond .= ' AND chaque_payments.confirm_date >= "' . date("Y-m-d", strtotime($_POST['start_date'])) . '"';
            }

            if (@$_POST['end_date']) {
                $cond .= ' AND chaque_payments.confirm_date <= "' . date("Y-m-d", strtotime($_POST['end_date'])) . '"';
            }

            $data['model'] = Yii::app()->db->createCommand()
                            ->select("SUM(supplier_payment.amount) as amount,supplier_payment.supplier_id,chaque_payments.confirm_date,chaque_payments.id,chaque_payments.receive_date,chaque_payments.notes")
                            ->order('chaque_payments.receive_date desc')
                            ->rightJoin('chaque_payments', 'supplier_payment.chaque_payment_id = chaque_payments.id')
                            ->group('supplier_payment.chaque_payment_id')
                            ->where($cond)
                            ->from('supplier_payment')->queryAll();

            $this->render('checked_payment', $data);
        }
    }

    public function actionCheque_payment() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)):
                foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;
            if ($_POST) {
                $data['start_date'] = $_POST['start_date'];
                $data['end_date'] = $_POST['end_date'];
                $supplier_id = $_POST['supplier_id'];
                $cond = 'chaque_payments.total_amount > 0 AND  supplier_payment.payment_mode = 1';

                if (@$_POST['start_date']) {
                    $cond .= ' AND chaque_payments.confirm_date >= "' . date("Y-m-d", strtotime($_POST['start_date'])) . '"';
                }

                if (@$_POST['end_date']) {
                    $cond .= ' AND chaque_payments.confirm_date <= "' . date("Y-m-d", strtotime($_POST['end_date'])) . '"';
                }

                if (!empty($cond) && !empty($supplier_id)) {
                    $cond .= " && supplier_payment.supplier_id = '$supplier_id'";
                }

                $data['model'] = Yii::app()->db->createCommand()
                                ->select("SUM(supplier_payment.amount) as amount,supplier_payment.supplier_id,chaque_payments.confirm_date,chaque_payments.id,chaque_payments.receive_date,chaque_payments.notes,chaque_payments.is_confirm")
                                ->rightJoin('chaque_payments', 'supplier_payment.chaque_payment_id = chaque_payments.id')
                                ->group('supplier_payment.chaque_payment_id')
                                ->where($cond)
                                ->order('chaque_payments.confirm_date desc')
                                ->from('supplier_payment')->queryAll();

                $this->render('checked_payment', $data);
            } else {
                $this->render('checked_payment_form');
            }
        endif;
    }

    public function actionPay_add($id = NULL) {
        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->accounts_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $username = Yii::app()->user->name;


            if ($_POST) {

                $chalan_id = $_POST['chalan_id'];
                $supplier_id = $_POST['supplier_id'];
                $payment_date = $_POST['payment_date'];
                $payment_mode = $_POST['payment_mode'];
                $amount = $_POST['amount'];
                $discount = (float) $_POST['discount'];

                $price_grand_total = $_POST['price_grand_total'] - $discount;
                $paid_amount = $_POST['paid_amount'];
                $paid_total = $paid_amount + $amount;

                if ($paid_total == $price_grand_total):
                    $status = 1;
                else:
                    $status = 0;
                endif;

                $bank_comm = Yii::app()->db->createCommand();
                $bank_comm->insert('bank_transaction', array(
                    'bank_id' => $_POST['bank_id'],
                    'purpose_id' => 2,
                    'amount' => $_POST['amount'],
                    'is_saving' => 0,
                    'type' => "cheque",
                    'user_name' => $username,
                    'date' => date("Y-m-d", strtotime($_POST['confirm_date'])),
                ));
                $bank_transaction_id = Yii::app()->db->getLastInsertID();


                $chaque_payment_id = 0;
                if ($payment_mode == 1) {
                    $confirm_date = date("Y-m-d", strtotime($_POST['confirm_date']));
                    $comm = Yii::app()->db->createCommand();
                    $comm->insert('chaque_payments', array(
                        'receive_date' => $payment_date,
                        'total_amount' => $_POST['amount'],
                        'notes' => $_POST['notes'],
                        'confirm_date' => $confirm_date,
                        'is_supplier' => 1,
                        'is_confirm' => 1
                    ));
                    $chaque_payment_id = Yii::app()->db->getLastInsertID();
                }

                $command = Yii::app()->db->createCommand();
                $cond = "chalan_id = '$chalan_id'";

                $command->insert('supplier_payment', array(
                    'chalan_id' => $chalan_id,
                    'supplier_id' => $supplier_id,
                    'payment_date' => $payment_date,
                    'payment_mode' => $payment_mode,
                    'amount' => $amount,
                    'sp_notes' => isset($_POST['notes']) ? $_POST['notes'] : "",
                    'chaque_payment_id' => $chaque_payment_id
                ));
                $criteria = new CDbCriteria();
                $criteria->condition = "chalan_id = '$chalan_id'";
                $purchase = Purchase::model()->findAll($criteria);

                $purchase_update = Yii::app()->db->createCommand();
                $purchase_update->update('purchase', array('paid_amount' => $paid_total, 'status' => $status, 'price_grand_total' => $price_grand_total, 'discount' => $purchase[0]['discount'] + $discount), $cond);
                Yii::app()->user->setFlash('saveMessage', 'Payment Completed Successfully....<a href="' . Yii::app()->request->baseUrl . '/supplier/payable_report">  Back </a>');
                $this->render('pay_add', array());
            } else {
                //  $in_id = $_GET['chalan_id'];
                if ($_REQUEST['chalan_id']):
                    $id = $_REQUEST['chalan_id'];
                else:
                    $id = $id;
                endif;
                // $id =$_GET['chalan_id'];

                $criteria = new CDbCriteria();
                $criteria->condition = "chalan_id = '$id'";
                $criteria->order = 'id DESC';
                $model = Purchase::model()->findAll($criteria);
                $model2 = Purchase_Product::model()->findAll($criteria);
                $this->render('pay_add', array('model' => $model, 'model2' => $model2,));
            }
        endif;
    }

    public function actionPaid_Report() {
        //privileges Check with message
        $username = Yii::app()->user->name;
        $cond = new CDbCriteria(array('condition' => "username = '$username'",));
        $Users = Users::model()->findAll($cond);
        if (count($Users)): foreach ($Users as $user):
                if ($user->supplier_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endforeach;
        endif;

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:

            $model = new Account_Received();

            if ($_POST) {
                $cond = '';
                $supplier_id = $_POST['supplier_id'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];

                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($start_date));
                else: $start_date = "";
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($end_date));
                else: $end_date = "";
                endif;

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && payment_date >= '$start_date' && payment_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " payment_date >= '$start_date' && payment_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && payment_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " payment_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($supplier_id)): $cond .= " && supplier_id = '$supplier_id'";
                elseif (empty($cond) && !empty($supplier_id)): $cond .= " supplier_id = '$supplier_id'";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $cond2->order = 'payment_date DESC';
                $model = Supplier_Payment::model()->findAll($cond2);
                $this->render('account_paid_report', array('model' => $model,));
            }
            else {
                $this->render('account_paid_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionPurchase_Return() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)):
                foreach ($Users as $user):
                    if ($user->receiving_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $username = Yii::app()->user->name;

            Yii::app()->user->setFlash('saveMessage', 'Page under constraction.');
            $this->redirect(array('super/index'));
//            if (@$_POST['chalan_id'] && empty($_POST['chalan_id3'])) {
//                $chalan_id = $_POST['chalan_id'];
//                $command = Yii::app()->db->createCommand();
//                $command->insert('invoice_track2', array(
//                    'chalan_id' => $chalan_id,
//                ));
//                $this->render('purchase_return');
//            } elseif (!empty($_POST) && !empty($_POST['chalan_id3'])) {
//
//                $user_id = Yii::app()->user->name;
//                $chalan_id = $_POST['chalan_id3'];
//                $return_date = $_POST['return_date'];
//                $reason = $_POST['reason'];
//
//                $product_code = $_POST['product_code22'];
//                $quantity = $_POST['quantity'];
//                $price = $_POST['price'];
//
//                if (!empty($product_code)):
//                    for ($p = 0; $p < sizeof($product_code); $p++):
//                        $product_code2 = $product_code[$p];
//                        $quantity2 = $quantity[$p];
//                        $product_price2 = $price[$p];
//                        $price_total2 = $product_price2 * $quantity2;
//
//                        $cos = "product_code = '$product_code2'";
//                        $cond = new CDbCriteria(array('condition' => "product_code = '$product_code2'",));
//                        $stockExValues = Stock::model()->findAll($cond);
//
//                        foreach ($stockExValues as $stockExValue): $quantity_stock = $stockExValue->product_balance;
//                        endforeach;
//
//                        $command = Yii::app()->db->createCommand();
//                        $command->insert('purchase_return', array(
//                            'chalan_id' => $chalan_id,
//                            'return_date' => $return_date,
//                            'product_code' => $product_code2,
//                            'quantity' => $quantity2,
//                            'amount' => $product_price2,
//                            'reason' => $reason,
//                            'user_id' => $user_id,
//                        ));
//
//                        $command->update('stock', array('product_balance' => $quantity_stock - $quantity2), $cos);
//                        $criteria2 = new CDbCriteria();
//                        $criteria2->condition = "chalan_id = '$chalan_id'";
//                        $criteria2->order = 'id DESC';
//                        $criteria2->limit = 1;
//                        $sellmain = Purchase::model()->findAll($criteria2);
//                        if (count($sellmain)): foreach ($sellmain as $sellmain): $sell_id = $sellmain->id;
//                                $paid_amount = $sellmain->paid_amount;
//                            endforeach;
//                        endif;
//                        $command = Yii::app()->db->createCommand();
//                        $command->update('purchase', array('paid_amount' => $paid_amount + $price_total2,), "id = '$sell_id'");
//
//                    endfor;
//                endif;
//                $model_sRtemporary = new Purchase_Return_Tempory();
//                $model_sRtemporary->deleteAll("user_id = '$user_id'");
//
//                $model_Rdtemporary = new Invoice_Track2();
//                $model_Rdtemporary->deleteAll();
//
//                Yii::app()->user->setFlash('saveMessage', 'Purchase Return Completed Successfully....');
//                $this->refresh();
//            }
//            else {
//                $this->render('purchase_return', array('model' =>array()));
//            }
        endif;
    }

    public function actionPurchase_Return_Report() {

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

            $model = new Sell_Return();

            if ($_POST) {
                $cond = '';
                $chalan_id = $_POST['chalan_id'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];

                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($start_date));
                else: $start_date = "";
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($end_date));
                else: $end_date = "";
                endif;

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && return_date >= '$start_date' && return_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " return_date >= '$start_date' && return_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && return_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " return_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($chalan_id)): $cond .= " && chalan_id = '$chalan_id'";
                elseif (empty($cond) && !empty($chalan_id)): $cond .= " chalan_id = '$chalan_id'";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Purchase_Return::model()->findAll($cond2);
                $this->render('purchase_return_report', array('model' => $model,));
            }
            else {
                $this->render('purchase_return_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionPurchaseEntry() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $username = Yii::app()->user->name;
            $product_code2 = $_POST['product_code2'];
            $model = new Product();
            $criteria = new CDbCriteria();
            $criteria->condition = "product_code = '$product_code2' OR product_name = '$product_code2'";
            $criteria->order = 'id DESC';
            $models = Product::model()->findAll($criteria);

            if ($models):
                foreach ($models as $model):

                    $product_code = $model->product_code;
                endforeach;
            endif;

            $qty = $_POST['qty'];
            $chalan_id = $_POST['chalan_id2'];

            $cond2 = new CDbCriteria(array('condition' => "chalan_id = '$chalan_id'",));
            $models = Purchase_Product::model()->findAll($cond2);
            foreach ($models as $model):
                $product_code2 = $model->product_code;
                if ($product_code2 == $product_code):
                    $match = "yes";
                    $match_quantity = $model->quantity;
                    break;
                else: $match = "no";
                    $match_quantity = "";
                endif;
            endforeach;

            if ($match == "yes" && $match_quantity >= $qty):
                $cond = "user_id = '$username' && product_code = '$product_code'";
                $q1 = new CDbCriteria(array('condition' => $cond,));
                $dataExists = Purchase_Return_Tempory::model()->findAll($q1);

                if (count($dataExists)):
                    $command = Yii::app()->db->createCommand();
                    $model_Rdtemporary = new Purchase_Return_Tempory();
                    $model_Rdtemporary->deleteAll($cond);
                    $command->insert('purchase_return_tempory', array(
                        'user_id' => $username,
                        'product_code' => $product_code,
                        'quantity' => $qty,
                    ));
                else:
                    $command = Yii::app()->db->createCommand();
                    $command->insert('purchase_return_tempory', array(
                        'user_id' => $username,
                        'product_code' => $product_code,
                        'quantity' => $qty,
                    ));
                endif;
                $this->redirect(array('supplier/purchase_return'));
            else:
                $path = Yii::app()->request->baseUrl . '/supplier/purchase_return';
                echo "<script type=\"text/javascript\">alert('This product is not available in your Shipment or given quantity is much more from Purchase quantity !!');" . "window.location ='" . $path . "';</script>";
            endif;

        endif;
    }

    public function actionPRemove($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $model = Purchase_Return_Tempory::model()->findByPk($id);
            $model->delete();
            $this->redirect(array('supplier/purchase_return'));
        endif;
    }

}
