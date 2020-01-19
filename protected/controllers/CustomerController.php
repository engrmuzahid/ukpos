<?php

class CustomerController extends CController {

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
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();

            $criteria->condition = "status = 'approved'";
            $filter_day = null;
            if (isset($_GET['filter_day'])) {
                $criteria->condition .= " AND order_day='{$_GET['filter_day']}' ";
                $filter_day = $_GET['filter_day'];
            }

            $customer_type = null;
            if (isset($_GET['customer_type'])) {
                $criteria->condition .= " AND customer_type='{$_GET['customer_type']}' ";
                $customer_type = $_GET['customer_type'];
            }

            $count = Customer::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);

            $sms_balance = Yii::app()->db->createCommand("Select * from sms_balance")->queryRow();
            $criteria->order = 'id DESC';
            $models = Customer::model()->findAll($criteria);
            $this->render('index', array('sms_balance' => $sms_balance, 'models' => $models, 'total' => $count, 'pages' => $pages, 'filter_day' => $filter_day, 'customer_type' => $customer_type));
        endif;
    }

    public function actionDoneChecking() {
        $customer_id = $_REQUEST['customer_id'];
        $model = Customer::model()->findByPk($customer_id);
        if ($model->checkingDone == 1) {
            $newFlag = 0;
        } else {
            $newFlag = 1;
        }
        $model->checkingDone = $newFlag;
        $model->save();
        //$model->update(array('checkingDone'=>$newFlag));
        echo $newFlag == 1 ? 'CHECKED' : 'N-CHECKED';
    }

    public function actionClearChecking() {
        Customer::model()->updateAll(array('checkingDone' => 0));
    }

    public function actionEditchaque() {


        if ($_POST) {
            if (@$_POST['id']) {
                $cond = 'id = ' . $_POST['id'];
            }
            $model = Yii::app()->db->createCommand()
                            ->where($cond)
                            ->from('chaque_payments')->queryRow();

            $this->renderPartial('change_payment_form', array('model' => $model,));
        }
    }

    public function actioninteditchaque() {


        if ($_POST) {
            $cond = 'id = ' . $_POST['id'];

            $model = Yii::app()->db->createCommand()
                    ->update('chaque_payments', array("is_confirm" => $_POST['is_confirm'], "confirm_date" => $_POST['confirm_date'], "notes" => $_POST['notes']), $cond);



            $data['start_date'] = $_POST['start_date'];
            $data['end_date'] = $_POST['end_date'];

            $cond = 'chaque_payments.total_amount > 0 AND chaque_payments.is_confirm != 1 AND account_receive.receive_mode = 1';
            if (@$_POST['start_date']) {
                $cond .= ' AND chaque_payments.confirm_date >= "' . date("Y-m-d", strtotime($_POST['start_date'])) . '"';
            }
            if (@$_POST['end_date']) {
                $cond .= ' AND chaque_payments.confirm_date <= "' . date("Y-m-d", strtotime($_POST['end_date'])) . '"';
            }
            $data['model'] = Yii::app()->db->createCommand()
                            ->select("SUM(account_receive.amount) as amount,account_receive.customer_id ,chaque_payments.confirm_date,chaque_payments.id,chaque_payments.receive_date,chaque_payments.notes")
                            ->order('chaque_payments.receive_date desc')
                            ->rightJoin('chaque_payments', 'account_receive.chaque_payment_id = chaque_payments.id')
                            ->group('account_receive.chaque_payment_id')
                            ->where($cond)
                            ->from('account_receive')->queryAll();

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

                $cond = 'chaque_payments.total_amount > 0 AND chaque_payments.is_supplier = 0 AND chaque_payments.is_confirm != 1 AND account_receive.receive_mode = 1';
                if (@$_POST['start_date']) {
                    $cond .= ' AND chaque_payments.confirm_date >= "' . date("Y-m-d", strtotime($_POST['start_date'])) . '"';
                }
                if (@$_POST['end_date']) {
                    $cond .= ' AND chaque_payments.confirm_date <= "' . date("Y-m-d", strtotime($_POST['end_date'])) . '"';
                }
                $data['model'] = Yii::app()->db->createCommand()
                                ->select("SUM(account_receive.amount) as amount,account_receive.customer_id ,chaque_payments.confirm_date,chaque_payments.id,chaque_payments.receive_date,chaque_payments.notes")
                                ->order('chaque_payments.confirm_date desc')
                                ->rightJoin('chaque_payments', 'account_receive.chaque_payment_id = chaque_payments.id')
                                ->group('account_receive.chaque_payment_id')
                                ->where($cond)
                                ->from('account_receive')->queryAll();

                $this->render('checked_payment', $data);
            } else {

                $this->render('checked_payment_form');
            }
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
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Customer();
            $data = Yii::app()->request->getPost('Customer');

//            if(Yii::app()->request->getPost()){
//                $data = Yii::app()->request->getPost();
//                $customer_type = $data['Customer']['customer_type'];           
//            }
//            $customer_type = $data['customer_type'];
//            print_r($customer_type);  
            //  print_r($data);

            if ($data) {
                $model->setAttributes($data);
                $as = CUploadedFile::getInstance($model, 'customer_photo');
                if (!empty($as)): $model->customer_photo = $as;
                endif;
                if ($model->save()) {
                    if (!empty($as)):
                        $image_path = Yii::getPathOfAlias('webroot') . '/public/photos/customer/' . $model->customer_photo;
                        $model->customer_photo->saveAs($image_path);
                    endif;
                    Yii::app()->user->setFlash('saveMessage', 'Customer Information Saved Successfully....<a href="' . Yii::app()->request->baseUrl . '/index.php/customer/add">Add New</a> &nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/customer">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('add', array('model' => $model));
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
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;
            $model = Customer::model()->findByPk($id);
            if (!$model)
                throw new CHttpException(404);
            $data = Yii::app()->request->getPost('Customer');
            if ($data) {
                $model->setAttributes($data);
                $as = CUploadedFile::getInstance($model, 'customer_photo');
                if (!empty($as)): $model->customer_photo = $as;
                endif;

                if ($model->save()) {
                    if (!empty($as)):
                        $image_path = Yii::getPathOfAlias('webroot') . '/public/photos/customer/' . $model->customer_photo;
                        $model->customer_photo->saveAs($image_path);
                    endif;
                    Yii::app()->user->setFlash('saveMessage', 'Customer Information Modified Successfully...&nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/customer">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('edit', array('model' => $model,));
        endif;
    }

    public function actionRetailedit($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = Customer::model()->findByPk($id);
            if (!$model)
                throw new CHttpException(404);
            $data = Yii::app()->request->getPost('Customer');
            if ($data) {
                $model->setAttributes($data);
                $as = CUploadedFile::getInstance($model, 'customer_photo');
                if (!empty($as)): $model->customer_photo = $as;
                endif;

                if ($model->save()) {
                    if (!empty($as)):
                        $image_path = Yii::getPathOfAlias('webroot') . '/public/photos/customer/' . $model->customer_photo;
                        $model->customer_photo->saveAs($image_path);
                    endif;
                    Yii::app()->user->setFlash('saveMessage', 'Customer Information Modified Successfully...&nbsp;&nbsp;<a href="' . Yii::app()->request->baseUrl . '/index.php/customer">View All</a>');
                    $this->refresh();
                }
            }
            $this->render('retailedit', array('model' => $model,));
        endif;
    }

    public function actionSearch() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $model = new Customer();
            if ($_POST) {
                $customer_name = $_POST['customer_name'];

                $cond = '';
                if (!empty($cond) && !empty($customer_name)): $cond .= " && customer_name like '%$customer_name%'";
                elseif (empty($cond) && !empty($customer_name)): $cond .= " customer_name like '%$customer_name%'";
                endif;
                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $criteria->order = 'id DESC';
                $model = Customer::model()->findAll($criteria);
                $this->render('search', array('models' => $model, "customer_name" => $customer_name));
            }
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
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;


            $sellExt = new CDbCriteria(array('condition' => "customer_id = '$id'",));
            $sellVal = Sell::model()->findAll($sellExt);

            $payExt = new CDbCriteria(array('condition' => "customer_id = '$id'",));
            $payVal = Account_Received::model()->findAll($payExt);


            if (count($sellVal) or count($payVal)):
                Yii::app()->user->setFlash('saveMessage', 'Sorry! this Customer is available in one or more sell or accounts..');
                $this->redirect(array('customer/index'));
            else:
                $model = Customer::model()->findByPk($id);
                $model->delete();
                Yii::app()->user->setFlash('saveMessage', 'Customer deleted successfully.');
                $this->redirect(array('customer/index'));
            endif;

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
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();
            $criteria->condition = "id = '$id'";
            $models = Customer::model()->findAll($criteria);
            $this->render('view', array('models' => $models));



        endif;
    }

    public function actionRetailview($id) {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();
            $criteria->condition = "id = '$id'";
            $models = Customer::model()->findAll($criteria);
            $this->render('retailview', array('models' => $models,));

        endif;
    }

    public function actionPending() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $criteria = new CDbCriteria();

            $count = Customer::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);
            $criteria->condition = "status = 'pending'";
            $criteria->order = 'id DESC';
            $models = Customer::model()->findAll($criteria);
            $this->render('pending', array('models' => $models, 'pages' => $pages,));

        endif;
    }

    // cash transection report

    public function actionReceiable_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Account_Received();

            if ($_POST) {
                $customer_id = $_POST['customer_id'];

                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;
                $cond = "status = 0 && cash_sell=0";
                if (!empty($start_date) && !empty($end_date)): $cond .= " && order_date >= '$start_date' && order_date <= '$end_date'";
                elseif (!empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
                elseif (empty($start_date) && !empty($end_date)): $cond .= " && order_date <= '$end_date'";
                endif;
                if (!empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                endif;
                if (empty($customer_id)): $cond .= " && customer_id != ''";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Sell::model()->findAll($cond2);

                $sells = array();
                $amountSummary = array();
                foreach ($model as $result) {
                    $sells[$result->customer_id][] = $result;
                    if (!isset($amountSummary[$result->customer_id]['total'])) {
                        $amountSummary[$result->customer_id]['total'] = $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] = $result->paid_amount;
                    } else {
                        $amountSummary[$result->customer_id]['total'] += $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] += $result->paid_amount;
                    }
                }

                $data['model'] = $sells;
                $data['accountSummary'] = $amountSummary;

                $data['customer_id'] = $customer_id;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                $this->render('account_receiable_report', $data);
            } else {

                $this->render('account_receiable_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionReceiable_Report_pre() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Account_Received();

            if ($_POST) {
                $customer_id = $_POST['customer_id'];

                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;
                $cond = "status = 0 && cash_sell=0";
                if (!empty($start_date) && !empty($end_date)): $cond .= " && order_date >= '$start_date' && order_date <= '$end_date'";
                elseif (!empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
                elseif (empty($start_date) && !empty($end_date)): $cond .= " && order_date <= '$end_date'";
                endif;
                if (!empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                endif;
                if (empty($customer_id)): $cond .= " && customer_id != ''";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Sell::model()->findAll($cond2);

                $sells = array();
                $amountSummary = array();
                foreach ($model as $result) {
                    $sells[$result->customer_id][] = $result;
                    if (!isset($amountSummary[$result->customer_id]['total'])) {
                        $amountSummary[$result->customer_id]['total'] = $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] = $result->paid_amount;
                    } else {
                        $amountSummary[$result->customer_id]['total'] += $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] += $result->paid_amount;
                    }
                }

                $data['model'] = $sells;
                $data['accountSummary'] = $amountSummary;

                $data['customer_id'] = $customer_id;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                $this->render('account_receiable_report', $data);
            } else {

                $this->render('account_receiable_report_pre_form', array('model' => $model,));
            }
        endif;
    }

    public function actionEmail_Config() {

        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR . 'PHPMailerAutoload.php');

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "sylhetpos@gmail.com";
        $mail->Password = "Think140";

        return $mail;
    }

    public function actionSend_Email() {

        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR . 'PHPMailerAutoload.php');

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "sylhetpos@gmail.com";
        $mail->Password = "Think140";
        $mail->setFrom('from@example.com', 'First Last');
        $mail->addReplyTo('replyto@example.com', 'First Last');

        $mail->addAddress('muzahid_cse@live.com', 'John Doe');
        $mail->Subject = 'PHPMailer GMail SMTP test';
        $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

        $mail->AltBody = 'This is a plain-text message body';
        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'MPDF57' . DIRECTORY_SEPARATOR . 'mpdf.php');
        $invoice_no = '26071577';
        $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
        $models = Sell::model()->findAll($cond);
        $model_products = Sell_Product::model()->findAll($cond);
        $html = $this->renderPartial('pdfview', array('models' => $models, 'model_products' => $model_products,), TRUE);
        $mpdf = new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->Output($invoice_no . '.pdf', 'F');

        $mail->addAttachment('images/phpmailer_mini.png');
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    public function actionSend_Receiable_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);

            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;



            $invoice_ids = implode(",", $_POST['invoice_number']);

            $_customers = Yii::app()->db->createCommand()
                    ->select('cus.id')
                    ->from('customer as cus')
                    ->leftJoin('sell_order as sell', "sell.customer_id = cus.id")
                    ->where(array('in', 'invoice_no', $_POST['invoice_number']))
                    ->queryAll();
// print_r($customer['email_address']);
//  exit();

            $customers = array();


            foreach ($_customers as $_customer) {
                $customers[$_customer['id']] = $_customer['id'];
            }

            require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'NativeMail' . DIRECTORY_SEPARATOR . 'nativemail.php');


            foreach ($customers as $customer) {

                $Customer = Customer::model()->findAllByPk($customer);
                if (!$Customer[0]['email_address'])
                    continue;

                $customer_invoices = Yii::app()->db->createCommand("SELECT invoice_no FROM sell_order WHERE customer_id = $customer AND invoice_no IN ($invoice_ids)")->queryAll();

                $mail = new NativeMail("info@sylhetshop.co.uk", "Sylhet Shop", $Customer[0]['email_address'], "Account Invoice", "<h3>Dear Customer,<br> Please find attached invoice(s).</h3>");

                foreach ($customer_invoices as $customer_invoice) {
                    $attach_file = $this->create_pdf($customer_invoice['invoice_no']);
                    $mail->setAttachment($attach_file, $customer_invoice['invoice_no'] . '.pdf');
                }

                $mail->send();

                foreach ($customer_invoices as $customer_invoice) {
                    @unlink('invoices/' . $customer_invoice['invoice_no'] . '.pdf');
                }
                $message = "";
            }

        endif;
    }

    public function create_pdf($invoice_no) {
        print_r($invoice_no);
        require_once(getcwd() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'mpdf' . DIRECTORY_SEPARATOR . 'mpdf.php');

        $cond = new CDbCriteria(array('condition' => "invoice_no = '$invoice_no'",));
        $models = Sell::model()->findAll($cond);
        $model_products = Sell_Product::model()->findAll($cond);

        $html = $this->renderPartial('create_pdf', array('models' => $models, 'model_products' => $model_products,), TRUE);

        $mpdf = new mPDF();

        $mpdf->WriteHTML($html);
        $mpdf->Output('invoices/' . $invoice_no . '.pdf', 'F');
        return getcwd() . DIRECTORY_SEPARATOR . 'invoices' . DIRECTORY_SEPARATOR . $invoice_no . '.pdf';
    }

    public function actionCash_Receiable_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Account_Received();

            if ($_POST) {
                $customer_id = $_POST['customer_id'];

                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;

                $cond = "status = 0 && cash_sell=1";

                if (!empty($start_date) && !empty($end_date)): $cond .= " && order_date >= '$start_date' && order_date <= '$end_date'";
                elseif (!empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
                elseif (empty($start_date) && !empty($end_date)): $cond .= " && order_date <= '$end_date'";
                endif;
                if (!empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                endif;
                if (empty($customer_id)): $cond .= " && customer_id != ''";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Sell::model()->findAll($cond2);

                $sells = array();
                $amountSummary = array();
                foreach ($model as $result) {
                    $sells[$result->customer_id][] = $result;
                    if (!isset($amountSummary[$result->customer_id]['total'])) {
                        $amountSummary[$result->customer_id]['total'] = $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] = $result->paid_amount;
                    } else {
                        $amountSummary[$result->customer_id]['total'] += $result->amount_grand_total;
                        $amountSummary[$result->customer_id]['paid'] += $result->paid_amount;
                    }
                }

                $data['model'] = $sells;
                $data['accountSummary'] = $amountSummary;

                $data['customer_id'] = $customer_id;
                $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                $this->render('account_receiable_report', $data);
            } else {
                $this->render('account_receiable_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionReceived_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Account_Received();

            if ($_POST) {
                $customer_id = $_POST['customer_id'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;
                $cond = '';

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && receive_date >= '$start_date' && receive_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " receive_date >= '$start_date' && receive_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && receive_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " receive_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                elseif (empty($cond) && !empty($customer_id)): $cond .= " customer_id = '$customer_id'";
                endif;
                if (!empty($cond) && empty($customer_id)): $cond .= " && customer_id != ''";
                elseif (empty($cond) && empty($customer_id)): $cond .= " customer_id != ''";
                endif;
                if ($cond == '')
                    $cond .= ' amount > 0';
                else
                    $cond .= ' && amount > 0';

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $cond2->order = "receive_date desc";
                $model = Account_Received::model()->findAll($cond2);
                $this->render('account_received_report', array('model' => $model,));
            }
            else {
                $this->render('account_received_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionReceive_add($id = NULL) {


        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $user = Users::model()->find($cond);
            if ($user):
                if ($user->accounts_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endif;

            $username = Yii::app()->user->name;


            if (!empty($_POST) && !empty($_POST['customer_id']) && $_POST['receive_mode'] != '') {

                $user_id = Yii::app()->user->name;
                $invoice_no = $_POST['invoice_no'];
                $customer_id = $_POST['customer_id'];
                $receive_date = $_POST['receive_date'];
                $receive_mode = $_POST['receive_mode'];
                $amount = $_POST['amount'];
                $discount = (float) $_POST['discount'];

                $amount_grand_total = (float) $_POST['amount_grand_total'] - $discount;
                $paid_amount = $_POST['paid_amount'];
                $paid_total = $paid_amount + $amount;
                if ($paid_total == $amount_grand_total): $status = 1;
                else: $status = 0;
                endif;

                $created = date('Y-m-d', time());
                $chaque_payment_id = 0;
                if ($receive_mode == 1) {

                    $isconfirm = 0;
                    $confirm_date = date("Y-m-d", strtotime($_POST['confirm_date']));
                    $comm = Yii::app()->db->createCommand();
                    $comm->insert('chaque_payments', array(
                        'receive_date' => isset($_POST['receive_date']) ? $receive_date : "0000:00:00",
                        'total_amount' => $_POST['amount'],
                        'notes' => $_POST['notes'],
                        'confirm_date' => $confirm_date,
                        'is_supplier' => 0,
                        'is_confirm' => 0
                    ));
                    $chaque_payment_id = Yii::app()->db->getLastInsertID();
                }

                $command = Yii::app()->db->createCommand();
                $cond = "invoice_no = '$invoice_no'";

                $command->insert('account_receive', array(
                    'invoice_no' => $invoice_no,
                    'customer_id' => $customer_id,
                    'receive_date' => $receive_date,
                    'receive_mode' => $receive_mode,
                    'amount' => $amount,
                    'chaque_payment_id' => $chaque_payment_id
                ));

                if ($status == 1 && @$_POST['cash_sell'] == 1) {
                    $customer_id = 0;
                }

                $crt = new CDbCriteria();
                $crt->condition = "invoice_no = '$invoice_no'";
                $sell_order = Sell::model()->find($crt);
                $command->update('sell_order', array('user_id' => $user_id, 'customer_id' => $customer_id, 'amount_grand_total' => $amount_grand_total, 'paid_amount' => $paid_total, 'status' => $status, 'discount_ratio' => $sell_order->discount_ratio + $discount), $cond);

                Yii::app()->user->setFlash('saveMessage', 'Payment Received Successfully....');
                $this->refresh();
            } else {
                $in_id = @$_POST['invoice_no'];
                if (!empty($in_id)): $id = $in_id;
                else: $id = $id;
                endif;
                $criteria = new CDbCriteria();
                $criteria->condition = "invoice_no = '$id'";
                $criteria->order = 'id DESC';
                $model = Sell::model()->findAll($criteria);
                $model2 = Sell_Product::model()->findAll($criteria);
                $this->render('receive_add', array('model' => $model, 'model2' => $model2, 'invoice_no' => $id,));
            }
        endif;
    }

    public function actionReceive_bulk_add() {

        if (!empty($_POST) && !empty($_POST['customer_id']) && $_POST['receive_mode'] != '') {
            $invoice_nos = explode(",", $_POST['invoice_no']);
            $customer_id = $_POST['customer_id'];
            $receive_date = $_POST['receive_date'];
            $receive_mode = $_POST['receive_mode'];
            $discount = (float) $_POST['discount'];
            $total_amount = $_POST['amount'];
            $model = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('sell_order')
                    ->where(array('in', 'invoice_no', $invoice_nos))
                    ->queryAll();
            $inc = 1;
            $chaque_payment_id = 0;
            foreach ($model as $inv) {
                $invoice = (object) $inv;
                $user_id = Yii::app()->user->name;
                $invoice_no = $invoice->invoice_no;
                $paid_amount = $invoice->paid_amount;

                $amount_grand_total = (float) $invoice->amount_grand_total - $paid_amount;

                if ($amount_grand_total > 0 && $total_amount > 0) {
                    if ($amount_grand_total < $total_amount || $amount_grand_total == $total_amount) {
                        $paid_total = $amount_grand_total;
                        $status = 1;
                        $discount = 0.0;
                    } else {
                        $paid_total = $total_amount;
                        $status = 0;
                        $discount = (float) $_POST['discount'];
                    }
                    $total_amount -= $paid_total;
                }


                $created = date('Y-m-d', time());
                $command = Yii::app()->db->createCommand();
                $cond = "invoice_no = '$invoice_no'";


                if ($receive_mode == 1 && $inc == 1) {

                    $isconfirm = 0;
                    $receive_date = date("Y-m-d", strtotime($_POST['receive_date']));
                    $confirm_date = date("Y-m-d", strtotime($_POST['confirm_date']));
                    $comm = Yii::app()->db->createCommand();
                    $comm->insert('chaque_payments', array(
                        'receive_date' => isset($_POST['receive_date']) ? $receive_date : "0000:00:00",
                        'total_amount' => $_POST['amount'],
                        'notes' => $_POST['notes'],
                        'confirm_date' => isset($_POST['confirm_date']) ? $confirm_date : "0000:00:00",
                        'is_confirm' => 0
                    ));
                    $chaque_payment_id = Yii::app()->db->getLastInsertID();
                }

                $command = Yii::app()->db->createCommand();
                $cond = "invoice_no = '$invoice_no'";

                $command->insert('account_receive', array(
                    'invoice_no' => $invoice_no,
                    'customer_id' => $customer_id,
                    'receive_date' => $receive_date,
                    'receive_mode' => $receive_mode,
                    'amount' => $paid_total,
                    'chaque_payment_id' => $chaque_payment_id
                ));



                $crt = new CDbCriteria();
                $crt->condition = "invoice_no = '$invoice_no'";
                $sell_order = Sell::model()->find($crt);
                if ($paid_amount > 0) {
                    $command->update('sell_order', array('user_id' => $user_id, 'customer_id' => $customer_id, 'amount_grand_total' => $invoice->amount_grand_total, 'paid_amount' => ($paid_total + $paid_amount), 'status' => $status, 'discount_ratio' => $sell_order->discount_ratio + $discount), $cond);
                } else {
                    $command->update('sell_order', array('user_id' => $user_id, 'customer_id' => $customer_id, 'amount_grand_total' => $invoice->amount_grand_total, 'paid_amount' => $paid_total, 'status' => $status, 'discount_ratio' => $sell_order->discount_ratio + $discount), $cond);
                }

                $inc++;
            }
            Yii::app()->user->setFlash('saveMessage', 'Invoice : ' . $_POST['invoice_no'] . ' payment Received Successfully....');
            $this->render('bluk_receive', array('model' => array(), 'model2' => array(), 'invoices' => ''));
        } else {
            Yii::app()->user->setFlash('saveMessage', 'Payment Received Successfully....');
            $this->render('bluk_receive', array('model' => array(), 'model2' => array(), 'invoices' => ''));
        }
    }

    public function actionBulk_receive() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $user = Users::model()->find($cond);
            if ($user):
                if ($user->accounts_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endif;

            $username = Yii::app()->user->name;


            $model = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('sell_order')
                    ->where(array('in', 'invoice_no', $_POST['invoice_number']))
                    ->queryAll();

            $model2 = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('sell_order_product')
                    ->where(array('in', 'invoice_no', $_POST['invoice_number']))
                    ->queryAll();

            $this->render('bluk_receive', array('model' => $model, 'model2' => $model2, 'invoices' => implode(",", $_POST['invoice_number'])));

        endif;
    }

    public function actionBulk_print() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $user = Users::model()->find($cond);
            if ($user):
                if ($user->accounts_prev != 1):
                    Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                    $this->redirect(array('super/index'));
                endif;
            endif;

            $username = Yii::app()->user->name;
            $model = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('sell_order')
                    ->where(array('in', 'invoice_no', $_POST['invoice_number']))
                    ->order("order_date DESC")
                    ->queryAll();

            $this->renderPartial('bluk_print', array('model' => $model, 'invoices' => implode(",", $_POST['invoice_number'])));


        endif;
    }

    public function actionCashTrans_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Cash_In_Hands();

            if ($_POST) {
                $status = $_POST['status'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $cond = '';

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && transaction_date >= '$start_date' && transaction_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " transaction_date >= '$start_date' && transaction_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && transaction_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " transaction_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($status)): $cond .= " && status = '$status'";
                elseif (empty($cond) && !empty($status)): $cond .= " status = '$status'";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Cash_In_Hands::model()->findAll($cond2);


                $this->render('cash_transaction_report', array('model' => $model,));
            }
            else {
                $this->render('cash_transaction_report_form', array('model' => $model,));
            }
        endif;
    }

    // new update for B2B
    public function actionB2breport() {

        Driver::model()->findAll();

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Sell();
            if (count($_POST)) {
                $cond = "customer_id != '' && customer_id != 0";
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $customer_id = $_POST['customer_id'];

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= "&& order_date >= '$start_date' && order_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= "order_date >= '$start_date' && order_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && order_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date)): $cond .= "order_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($customer_id)): $cond .= " && customer_id = '$customer_id'";
                elseif (empty($cond) && !empty($customer_id)): $cond .= "customer_id = '$customer_id'";
                endif;

                $criteria = new CDbCriteria();
                $criteria->condition = $cond;
                $criteria->order = 'id ASC';
                $model = Sell::model()->findAll($criteria);

                $data['drivers'] = Driver::model()->findAll();
                $data['cars'] = CarDetails::model()->findAll();
                $data['model'] = $model;


                $this->render('b2b_sell_report', $data);
            }
            else {
                $this->render('b2b_sell_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionDelivery_report() {

        if (Yii::app()->user->name == 'Guest') {
            $this->redirect(array('site/login'));
        } else {
            if ($_POST) {
                $data['driver'] = Driver::model()->findByPk($_POST['driver_id']);
                $data['car'] = CarDetails::model()->findByPk($_POST['car_id']);
                $cond = "";
                $invoices = "";
                foreach ($_POST as $key => $value) {
                    if (substr($key, 0, 9) == 'checkbox_') {
                        $command = Yii::app()->db->createCommand();
                        $command->insert('car_driver', array(
                            'driver_id' => $_POST['driver_id'],
                            'car_id' => $_POST['car_id'],
                            'date' => date("d-m-y", strtotime("NOW"))
                        ));

                        if (($cond != "") && !empty($value)): $cond .= " || invoice_no = '$value'";
                            $invoices .= ', ' . $value;
                        elseif (($cond == "") && !empty($value)): $cond .= "invoice_no = '$value'";
                            $invoices .= $value;
                        endif;
                    }
                }
                $data['invoices'] = $invoices;
                $data['reports'] = Yii::app()->db->createCommand("SELECT *,SUM(amount_grand_total) As customer_amount FROM sell_order WHERE invoice_no IN  (" . $invoices . ") group by customer_id")
                        ->queryAll();

                $this->renderPartial('delivery_report', $data);
            }
        }
    }

    public function actionB2b_list() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            if ($_POST):

                $cond = '';
                $invoices = '';
                $orders = array();
                // Search checkbox in post array
                foreach ($_POST as $key => $value) {
                    // If checkbox found
                    if (substr($key, 0, 9) == 'checkbox_') {
                        // Unactivate Content based on checkbox value (id)
                        $command = Yii::app()->db->createCommand();
                        $command->update('sell_order', array('print_status' => 1,), "invoice_no = '$value'");

                        if (!empty($cond) && !empty($value)): $cond .= " || invoice_no = '$value'";
                            $invoices .= ', ' . $value;
                        elseif (empty($cond) && !empty($value)): $cond .= "invoice_no = '$value'";
                            $invoices .= $value;
                        endif;

                        $orders[] = Yii::app()->db->createCommand("select c.business_name, c.customer_name, c.business_street1, c.business_street2, c.business_city, c.business_state, c.business_post_code, c.business_country, 
                                      sop.product_code, sum(sop.quantity) AS quantity, sop.amount, sop.invoice_no, sop.product_name
                                      FROM sell_order_product sop 
                                      JOIN sell_order so ON so.invoice_no = sop.invoice_no 
                                      JOIN customer c ON c.id = so.customer_id 
                                      WHERE sop.invoice_no='$value' GROUP BY sop.product_code")->queryAll();
                    }
                }


                if (!empty($cond)): $cond .= " && product_code = product_code";
                else: $cond .= "product_code = product_code";
                endif;
                $model = Sell_Product::model()->findAllBySql("select product_code, sum(quantity) AS quantity, amount, product_name FROM sell_order_product WHERE {$cond} GROUP BY product_code");

                $this->render('b2b_sell_item_list', array('model' => $model, 'invoices' => $invoices, 'orders' => $orders));
            endif;
        endif;
    }

    public function actionGenerate_b2b_list() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            if ($_POST):
                $invoices = $_POST['invoices'];
                $product_name = $_POST['product_name'];
                $quantity = $_POST['quantity'];
                $comment = $_POST['comment'];
                $q_total = $_POST['q_total'];

                $eInvoices = explode(",", $invoices);
                foreach ($eInvoices as $invoice) {
                    $invoice = trim($invoice);

                    $orders[] = Yii::app()->db->createCommand("select c.business_name, c.customer_name, c.business_street1, c.business_street2, c.business_city, c.business_state, c.business_post_code, c.business_country, 
                                      sop.product_code, sum(sop.quantity) AS quantity, sop.amount, sop.invoice_no, sop.product_name
                                      FROM sell_order_product sop 
                                      JOIN sell_order so ON so.invoice_no = sop.invoice_no 
                                      JOIN customer c ON c.id = so.customer_id 
                                      WHERE sop.invoice_no='$invoice' GROUP BY sop.product_code")->queryAll();
                }


                $this->render('b2b_sell_item_list2', array('invoices' => $invoices, 'product_name' => $product_name, 'comment' => $comment, 'quantity' => $quantity, 'q_total' => $q_total, 'orders' => $orders));
            endif;
        endif;
    }

    public function actionBankTrans_Report() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $model = new Cash_In_Banks();

            if ($_POST) {
                $status = $_POST['status'];

                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                if (!empty($start_date)): $start_date = date('Y-m-d', strtotime($_POST['start_date']));
                endif;
                if (!empty($end_date)): $end_date = date('Y-m-d', strtotime($_POST['end_date']));
                endif;

                $bank_id = $_POST['d_bank_id'];
                $account_no = $_POST['d_account_no'];

                $cond = '';

                if (!empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " && transaction_date >= '$start_date' && transaction_date <= '$end_date'";
                elseif (empty($cond) && !empty($start_date) && !empty($end_date)): $cond .= " transaction_date >= '$start_date' && transaction_date <= '$end_date'";
                endif;
                if (!empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " && transaction_date = '$start_date'";
                elseif (empty($cond) && !empty($start_date) && empty($end_date)): $cond .= " transaction_date = '$start_date'";
                endif;
                if (!empty($cond) && !empty($status)): $cond .= " && status = '$status'";
                elseif (empty($cond) && !empty($status)): $cond .= " status = '$status'";
                endif;
                if (!empty($cond) && !empty($bank_id)): $cond .= " && bank_id = '$bank_id'";
                elseif (empty($cond) && !empty($bank_id)): $cond .= " bank_id = '$bank_id'";
                endif;
                if (!empty($cond) && !empty($account_no)): $cond .= " && account_no = '$account_no'";
                elseif (empty($cond) && !empty($account_no)): $cond .= " account_no = '$account_no'";
                endif;

                $cond2 = new CDbCriteria(array('condition' => $cond,));
                $model = Cash_In_Banks::model()->findAll($cond2);
                $this->render('bank_transaction_report', array('model' => $model,));
            }
            else {
                $this->render('bank_transaction_report_form', array('model' => $model,));
            }
        endif;
    }

    public function actionDebtcollection() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

           $data['model'] = new Account_Received();
           $customers = Yii::app()->db->createCommand()
                            ->select('*')
                            ->where("is_alive > 0")
                            ->order('customer_name')
                            ->from('customer')->queryAll();

            $data['customers'] = $customers;

            if ($_POST) {
                $end_date = $_POST['end_date'];
                $cond = "t.amount_grand_total > t.paid_amount ";

                if($_POST['customer_id']){
                     $cond = "t.amount_grand_total > t.paid_amount && t.customer_id =".$_POST['customer_id'];
                }
                $cond2 = new CDbCriteria(array('condition' => $cond));
                $model = Sell::model()->findAll($cond2);

                $sells = array();
                $amountSummary = array();

                foreach ($model as $result) {
                    if ($end_date) {

                        $due_date = Yii::app()->db->createCommand()
                                        ->select('account_payable.*')
                                        ->order('note_date DESC')
                                        ->where("note_type ='payment' AND customer_id = " . $result->customer_id . " AND payment_date <= '" . date("Y-m-d", strtotime($end_date)) . "'")
                                        ->from('account_payable')->queryRow();
                        //  print_r($due_date->query());exit;

                        if ($due_date['payment_date']) {
                            $sells[$result->customer_id][] = $result;
                            $amountSummary[$result->customer_id]['payment_date'] = $due_date['payment_date'];
                            if (!isset($amountSummary[$result->customer_id]['total'])) {
                                $amountSummary[$result->customer_id]['total'] = $result->amount_grand_total;
                                $amountSummary[$result->customer_id]['paid'] = $result->paid_amount;
                            } else {
                                $amountSummary[$result->customer_id]['total'] += $result->amount_grand_total;
                                $amountSummary[$result->customer_id]['paid'] += $result->paid_amount;
                            }
                        }
                    } else {
                        $sells[$result->customer_id][] = $result;
                        $due_date = Yii::app()->db->createCommand()
                                        ->select('account_payable.*')
                                        ->order('note_date DESC')
                                        ->where("note_type ='payment' AND customer_id = " . $result->customer_id)
                                        ->from('account_payable')->queryRow();
                        $amountSummary[$result->customer_id]['payment_date'] = $due_date['payment_date'];
                        if (!isset($amountSummary[$result->customer_id]['total'])) {
                            $amountSummary[$result->customer_id]['total'] = $result->amount_grand_total;
                            $amountSummary[$result->customer_id]['paid'] = $result->paid_amount;
                        } else {
                            $amountSummary[$result->customer_id]['total'] += $result->amount_grand_total;
                            $amountSummary[$result->customer_id]['paid'] += $result->paid_amount;
                        }
                    }
                }


                $data['model'] = $sells;
                $data['accountSummary'] = $amountSummary;

//                $data['customer_id'] = $customer_id;
                //  $data['start_date'] = $start_date;
                $data['end_date'] = $end_date;

                $this->render('debt_collection', $data);
            } else {

                $this->render('debt_collection_form', $data);
            }
        endif;
    }

    public function actionDebtreport() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;
            if ($_POST['customer_id']) {
                $customers = Yii::app()->db->createCommand()
                                ->select('SUM(paid_amount) as amount,SUM(amount_grand_total) as grand_total,cus.customer_name,cus.id,cus.contact_no1')
                                ->leftJoin("customer as cus", "sell.customer_id = cus.id")
                                ->group("cus.id")
                                ->where("sell.amount_grand_total > sell.paid_amount && sell.customer_id = ".$_POST['customer_id'])
                                ->order("grand_total DESC")
                                ->from('sell_order as sell')->queryAll();
            } else {

                $customers = Yii::app()->db->createCommand()
                                ->select('SUM(paid_amount) as amount,SUM(amount_grand_total) as grand_total,cus.customer_name,cus.id,cus.contact_no1')
                                ->leftJoin("customer as cus", "sell.customer_id = cus.id")
                                ->group("cus.id")
                                ->where("sell.amount_grand_total > sell.paid_amount && sell.customer_id > 0 && cus.is_alive > 0")
                                ->order("grand_total DESC")
                                ->from('sell_order as sell')->queryAll();
            }

            $_customers = array();
            $weekly_income = $cus_count = $acc_balance = $total_sell = $total_due = $cash_sell_balance = $weekly_cash_sell = $weekly_acc_sell = 0;
            foreach ($customers as $customer) {
                $customer_id = $customer['id'];
                $_customers[$customer_id]['name'] = $customer['customer_name'];
                $_customers[$customer_id]['phone'] = $customer['contact_no1'] ? $customer['contact_no1'] : "";
                $_customers[$customer_id]['mainbalance'] = $customer['grand_total'] - $customer['amount'];
                $cash_sell = Yii::app()->db->createCommand()
                                ->select('SUM(paid_amount) as amount,SUM(amount_grand_total) as grand_total')
                                ->where("sell.customer_id = '" . $customer_id . "' && sell.amount_grand_total > sell.paid_amount && sell.cash_sell > 0")
                                ->from('sell_order as sell')->queryRow();

                $_customers[$customer_id]['cash_sell'] = $cash_sell ? ($cash_sell['grand_total'] - $cash_sell['amount']) : 0;

                $acc_sell = Yii::app()->db->createCommand()
                                ->select('SUM(paid_amount) as amount,SUM(amount_grand_total) as grand_total')
                                ->where("sell.customer_id = '" . $customer_id . "' && sell.amount_grand_total > sell.paid_amount && sell.cash_sell = 0")
                                ->from('sell_order as sell')->queryRow();
                $_customers[$customer_id]['acc_sell'] = $acc_sell ? ($acc_sell['grand_total'] - $acc_sell['amount']) : 0;

                $_weekly_cash_sell = Yii::app()->db->createCommand()
                                ->select('SUM(paid_amount) as amount,SUM(amount_grand_total) as grand_total')
                                ->where("order_date >= '" . date("Y-m-d", strtotime("-7 day")) . "' && sell.customer_id = '" . $customer_id . "' && sell.amount_grand_total > sell.paid_amount && sell.cash_sell > 0")
                                ->from('sell_order as sell')->queryRow();

                $_customers[$customer_id]['weekly_cash_sell'] = $_weekly_cash_sell ? ($_weekly_cash_sell['grand_total'] - $_weekly_cash_sell['amount']) : 0;

                $_weekly_acc_sell = Yii::app()->db->createCommand()
                                ->select('SUM(paid_amount) as amount,SUM(amount_grand_total) as grand_total')
                                ->where("order_date >= '" . date("Y-m-d", strtotime("-7 day")) . "' && sell.customer_id = '" . $customer_id . "' && sell.amount_grand_total > sell.paid_amount && sell.cash_sell = 0")
                                ->from('sell_order as sell')->queryRow();
                $_customers[$customer_id]['weekly_acc_sell'] = $_weekly_acc_sell ? ($_weekly_acc_sell['grand_total'] - $_weekly_acc_sell['amount']) : 0;


                $last_rec = Yii::app()->db->createCommand()
                                ->select('*')
                                ->where("customer_id = '" . $customer_id . "' && amount > 0")
                                ->order("receive_date DESC")->from('account_receive')->queryRow();
                $_customers[$customer_id]['last_rec'] = $last_rec ? ($last_rec) : array();

                $_weekly_income = Yii::app()->db->createCommand()
                                ->select('SUM(amount) as tamount')
                                ->where("receive_date >= '" . date("Y-m-d", strtotime("-7 day")) . "' && customer_id > '0' && customer_id = '" . $customer_id . "'")
                                ->from('account_receive')->queryRow();
                $_customers[$customer_id]['weekly_income'] = $_weekly_income ? ($_weekly_income['tamount']) : 0;



                $cus_count++;

                $weekly_cash_sell += $_customers[$customer_id]['weekly_cash_sell'];
                $weekly_acc_sell += $_customers[$customer_id]['weekly_acc_sell'];
                $total_due += $_customers[$customer_id]['mainbalance'];
                $acc_balance += $_customers[$customer_id]['acc_sell'];
                $cash_sell_balance += $_customers[$customer_id]['cash_sell'];
                $weekly_income += $_customers[$customer_id]['weekly_income'];
            }

            $data['cus_count'] = $cus_count;
            $data['total_due'] = $total_due;
            $data['acc_balance'] = $acc_balance;
            $data['cash_sell_balance'] = $cash_sell_balance;
            $data['weekly_income'] = $weekly_income;

            $data['weekly_cash_sell'] = $weekly_cash_sell;
            $data['weekly_acc_sell'] = $weekly_acc_sell;
            $data['customers'] = $_customers;

            $this->render('debt_report', $data);
        endif;
    }

    public function actionDebtreportFrom() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;
            $customers = Yii::app()->db->createCommand()
                            ->select('*')
                            ->where("is_alive > 0")
                            ->order('customer_name')
                            ->from('customer')->queryAll();

            $data['customers'] = $customers;

            $this->render('debt_report_from', $data);
        endif;
    }

    public function actionProduct_list_by_customer() {

        $datas['customer_id'] = $customer_id = Yii::app()->request->getPost('customer_id');
        $datas['q'] = $q = strtolower(Yii::app()->request->getPost('product'));
        $datas['result'] = Yii::app()->db->createCommand()
                        ->select('product.product_code, sell_order_product.amount, product.product_name')
                        ->from('sell_order_product')
                        ->join('product', 'product.product_code = sell_order_product.product_code')
                        ->Join('sell_order', 'sell_order_product.invoice_no = sell_order.invoice_no')
                        ->where("sell_order.customer_id = '$customer_id' AND (sell_order_product.product_name LIKE '%$q%' OR product.product_name LIKE '%$q%' )")
                        ->order('sell_order_product.id ASC')->group('sell_order_product.product_code')
                        ->limit(5)->query();

        if (count($datas['result']) > 0) {

            $this->renderPartial('customerpreviousorder', $datas);
        } else {
            echo "<h1 style='color:red;padding:40px;'> No Item found.</h1>";
        }
    }

    public function actionCustomernotes() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            $customer_id = Yii::app()->request->getPost('customer_id');


            $data['customer_notes'] = Yii::app()->db->createCommand()
                            ->select('account_payable.*')
                            ->order('note_date DESC')
                            ->where("customer_id = " . $customer_id)
                            ->from('account_payable')->queryAll();
            $this->renderPartial('customer_note', $data);


        endif;
    }

    public function actionAdd_note() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $user_id = "";
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    $user_id = $user->id;
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;

            if ($_POST['Note']) {

                $command = Yii::app()->db->createCommand();
                $command->insert('account_payable', array(
                    "user_id" => $user_id,
                    'customer_id' => $_POST['Note']['customer_id'],
                    'notes' => $_POST['Note']['notes'],
                    'payment_date' => $_POST['Note']['payment_date']
                ));


                echo "DONE";
            } else {
                echo 'Pease add Comments.';
            }
        endif;
    }

    public function actionCustomerSendEmail() {

        require_once(getcwd() . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR . 'PHPMailerAutoload.php');
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "muzahid.ginilab@gmail.com";
        $mail->Password = "Monjachai123!@#";
        $mail->setFrom('from@example.com', 'First Last');
        $mail->addReplyTo('replyto@syhetshop.co.uk', 'First Last');
        $mail->addAddress('muzahid_cse@live.com', 'John Doe');
        $mail->Subject = 'PHPMailer GMail SMTP test';

        $customerId = Yii::app()->request->getPost('customerId');
        $customer = Yii::app()->db->createCommand()
                        ->select('SUM(paid_amount) as amount,SUM(amount_grand_total) as grand_total,cus.*')
                        ->leftJoin("customer as cus", "sell.customer_id = cus.id")
                        ->where("sell.customer_id = '" . $customerId . "' && sell.amount_grand_total > sell.paid_amount && sell.cash_sell > 0")
                        ->from('sell_order as sell')->queryRow();

        $message = '<h3>Dear Mr/Mrs. ' . $customer->customer_name . ',</h3>'
                . '<h3>Your Due Account : &pound;' . number_format(($customer->grand_total - $customer->amount), 2) . '</h3>'
                . '<p>Thanks again.</p><p>Kind Regards<br><h3>Sylhet Cash & Carry</h3><br></p>';

        $mail->msgHTML($message);
        $mail->AltBody = $message;

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    public function actionCustomerEmailFrm() {


        $customerId = Yii::app()->request->getPost('customerId');

        $data['customer'] = Yii::app()->db->createCommand()
                        ->select('SUM(sell.paid_amount) as amount,SUM(sell.amount_grand_total) as grand_total,sell.order_date,cus.*')
                        ->leftJoin("customer as cus", "sell.customer_id = cus.id")
                        ->where("sell.customer_id = '" . $customerId . "' && sell.amount_grand_total > sell.paid_amount")
                        ->from('sell_order as sell')->queryRow();

        $last_rec = Yii::app()->db->createCommand()
                        ->select('receive_date')
                        ->where("customer_id = '" . $customerId . "' && amount > 0")
                        ->order("receive_date DESC")->from('account_receive')->queryRow();
        $data['last_receive_date'] = $last_rec ? date("d-m-Y", strtotime($last_rec['receive_date'])) : "";


        $this->renderPartial('debt_report_email_frm', $data);
    }

    public function actionAdddebtreort() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $user_id = "";
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    $user_id = $user->id;
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;
            $command = Yii::app()->db->createCommand();
            $command->insert('account_payable', array(
                "user_id" => $user_id,
                'customer_id' => $_POST['customer_id'],
                'notes' => $_POST['emailText'],
                'payment_date' => ""
            ));

        endif;
    }

    public function actionCustomerSendSms() {

        $customerId = Yii::app()->request->getPost('customerId');

        $data['customer'] = Yii::app()->db->createCommand()
                        ->select('*')
                        ->where("id = '" . $customerId . "' ")
                        ->from('customer')->queryRow();
        $data['sms_balance'] = Yii::app()->db->createCommand("Select * from sms_balance")->queryRow();
        $data['amount'] = Yii::app()->request->getPost('amount');

        $this->renderPartial('debt_report_sms_frm', $data);
    }

    public function actionSendSmsToCustomer() {
        //textmarketer
//        $username = urlencode('5dw32');
//        $password = urlencode('g6g26');
        //routesms
        $username = 'gini-tomafood';
        $password = 'tomafood';


        if (substr(trim($_POST['number']), 0, 1) == '0') {
            $numbers = '44' . substr(trim($_POST['number']), 1);
        }

        $sender = $_POST['sender'];
        $message = $_POST['smsText'];

        require_once(getcwd() . DIRECTORY_SEPARATOR . 'public/RouteSender.php');

        $routesms = new RouteSender('121.241.242.114', '8080', $username, $password, $sender, $message, $numbers, 0, 1);
        $result = $routesms->Submit();
//        print_r($result);
//        exit();
        $sent = "";
        $error = '';
        $response = explode("|", $result);

        if ($response[0] == '1701') {
            $sent = "DONE";
            $command = Yii::app()->db->createCommand();
            $cond = 'id = ' . $_POST['balance_id'];

            $command->update('sms_balance', array(
                "debit" => (double) $_POST['sms_count'] + (double) $_POST['balance']
                    ), $cond);
        } else {
            $error .= isset($response[1]) ? $response[1] : $response;
        }

        if ($error != '') {
            echo $error;
        }
        echo $sent;
    }

    public function actionCustomerbulkSms() {

        $ids = Yii::app()->request->getPost('Phone');
        $data['customers'] = Yii::app()->db->createCommand()
                        ->select('id,customer_name,contact_no1,contact_no2')
                        ->where(['in', 'id', $ids])
                        ->from('customer')->queryAll();


        $data['sms_balance'] = Yii::app()->db->createCommand("Select * from sms_balance")->queryRow();
        $this->renderPartial('bulk_sms_frm', $data);
    }

    public function actionSendbulkSms() {

        $ids = Yii::app()->request->getPost('Phone');
        $username = 'gini-tomafood';
        $password = 'tomafood';

        foreach ($_POST['number'] as $key => $number) {
            if (substr($number, 0, 1) == '0')
                $sms_data['customer_mobile'][$key] = '44' . substr($number, 1);
        }
        $numbers = implode(",", $sms_data['customer_mobile']);

        $sender = $_POST['sender'];
        $message = $_POST['smsText'];

        require_once(getcwd() . DIRECTORY_SEPARATOR . 'public/RouteSender.php');

        $routesms = new RouteSender('121.241.242.114', '8080', $username, $password, $sender, $message, $numbers, 0, 1);
        $result = $routesms->Submit();


        $responses = explode(",", $result);
        $sent = 0;
        $error = '';
        foreach ($responses as $resp) {
            $response = explode("|", $resp);
            if ($response[0] == '1701') {
                $sent++;
            } else {
                $error .= isset($response[1]) ? $response[1] : $resp;
            }
        }
        if ($error != '') {
            echo "Error occured while sending sms - " . $error;
        }
        echo "DONE";
    }

    public function actionPrintCustomer() {

        if (Yii::app()->user->name == 'Guest'):
            $this->redirect(array('site/login'));
        else:
            //privileges Check with message
            $username = Yii::app()->user->name;
            $cond = new CDbCriteria(array('condition' => "username = '$username'",));
            $Users = Users::model()->findAll($cond);
            if (count($Users)): foreach ($Users as $user):
                    if ($user->customer_prev != 1):
                        Yii::app()->user->setFlash('saveMessage', 'Sorry, No access to this page.');
                        $this->redirect(array('super/index'));
                    endif;
                endforeach;
            endif;
            $id = $_REQUEST['cusID'];
            $model = Customer::model()->findByPk($id);
            $this->renderPartial('printview', array('model' => $model));
        endif;
    }

}
